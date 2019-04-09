<?php

$err = NULL;

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
		// 初めて画面にアクセスした時の処理
		// CSRF対策
		
} else {
		// フォームからサブミットされた時の処理
		checkToken();
		// 入力されたニックネーム、メールアドレス、パスワードを受け取り、変数に入れる。
    $client_name = $_POST['client_name'];
    $mail_address = $_POST['mail_address'];
    $password = $_POST['password'];
		$password2 = $_POST['password2'];
		$secret_code = $_POST['secret_code'];
    $status = 1;
	$agreement = $_POST['agreement'];
	$client_code = random(12);

    // データベースに接続する（PDOを使う）
    $pdo = connectDb();

	// 入力チェックを行う。

    // [ニックネーム]未入力チェック
    if ($client_name == '') {
				$err['client_name'] = 'ニックネームを入力して下さい。';
		} else {
				// 文字数チェック
    	if (strlen(mb_convert_encoding($client_name,'SJIS', 'UTF-8'))>30) {
    			$err['client_name'] ='ニックネームは30バイト以内で入力してください';
    	}
    }

    // [パスワード]未入力チェック
    if ($password == ''||$password2 == '') {
    	$err['password'] = 'パスワードを入力して下さい。';
    } else {
    //再入力チェック
    	if ($password != $password2) {
						$err['password'] = 'パスワードが一致しません';
				}
    }

  		// [メールアドレス]未入力チェック
    if ($mail_address == '') {
    	$err['mail_address'] = 'メールアドレスを入力して下さい。';
    } else {
		//形式チェック
    	if (!filter_var($mail_address, FILTER_VALIDATE_EMAIL)) {
						$err['mail_address'] = 'メールアドレスの形式が正しくないです。';
				} else {
    			//存在チェック
    			if (checkEmail($mail_address, $pdo)) {
								$err['mail_address']='このメールアドレスは既に登録されています。';
						}
				}
		}

		//招待コードチェック
   	if ($secret_code == '') {
   		$err['secret_code'] = '招待コードを入力して下さい。';
   	} else {
		if ($secret_code !== 'BLOG_SYSTEM') {
						$err['secret_code'] = '招待コードが正しくないです';
				}
		}
		//同意チェック
	if ($agreement) {
    // もし$err配列に何もエラーメッセージが保存されていなかったら
    if (empty($err)) {
    	// データベース（clientテーブル）に新規登録する。
			$sql = "insert into client
            (client_name, password, mail_address, client_code, created_at, updated_at)
            values
            (:client_name, :password, :mail_address, :client_code, now(), now())";
    	$stmt = $pdo->prepare($sql);

    	$stmt->bindValue(':client_name', $client_name);
    	$stmt->bindValue(':password', $password);
    	$stmt->bindValue(':mail_address', $mail_address);
		$stmt->bindValue(':client_code', $client_code);

		$flag = $stmt->execute();

		$new_client_id = $pdo->lastInsertId('client_id_seq');
		// データベース（blogテーブル）に新規登録する。
		$sql = "insert into blog
	 		(status,client_id, created_at, updated_at)
	 		values
	 		(:status,:client_id, now(), now())";
		$stmt2 = $pdo->prepare($sql);

    $stmt2->bindValue(':status', $status);
		$stmt2->bindValue(':client_id', $new_client_id);

		$flag = $stmt2->execute();

		//メール送信
		mb_send_mail(EMAIL, 'ユーザー登録完了',
      		 '名前：'.$client_name.PHP_EOL.'メールアドレス：'.$mail_address);

    	//自動ログイン
    	$user = getUser($mail_address,$password,$pdo);
		// セッションハイジャック対策
			session_regenerate_id(true);
			$_SESSION['USER'] = $user;

		unset($pdo);
      	exit;
    }
	} else {
				$err['agreement'] = '同意チェックされていません';
			}
	unset($pdo);
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>アカウント設定 | BLOG SYSTEM</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />

	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="<?php echo CONTENTS_SERVER_URL ?>/assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
	<link href="<?php echo CONTENTS_SERVER_URL ?>/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo CONTENTS_SERVER_URL ?>/assets/plugins/font-awesome/css/all.min.css" rel="stylesheet" />
	<link href="<?php echo CONTENTS_SERVER_URL ?>/assets/plugins/animate/animate.min.css" rel="stylesheet" />
	<link href="<?php echo CONTENTS_SERVER_URL ?>/assets/css/facebook/style.min.css" rel="stylesheet" />
	<link href="<?php echo CONTENTS_SERVER_URL ?>/assets/css/facebook/style-responsive.min.css" rel="stylesheet" />
	<link href="<?php echo CONTENTS_SERVER_URL ?>/assets/css/facebook/theme/default.css" rel="stylesheet" id="theme" />
	<!-- ================== END BASE CSS STYLE ================== -->

	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo CONTENTS_SERVER_URL ?>/assets/plugins/pace/pace.min.js"></script>
	<!-- ================== END BASE JS ================== -->
</head>
<body class="pace-top bg-white">
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade show"><span class="spinner"></span></div>
	<!-- end #page-loader -->

	<!-- begin #page-container -->
	<div id="page-container" class="fade">
		<!-- begin register -->
		<div class="register register-with-news-feed">
			<!-- begin news-feed -->
			<div class="news-feed">
				<div class="news-image" style="background-image: url(<?php echo CONTENTS_SERVER_URL ?>/assets/img/login-bg/login-bg-9.jpg)"></div>
				<div class="news-caption">
					<h4 class="caption-title"><b>BLOG SYSTEM</b> </h4>
					<p>
						Blog System Demonstration
					</p>
				</div>
			</div>
			<!-- end news-feed -->
			<!-- begin right-content -->
			<div class="right-content">
				<!-- begin register-header -->
				<h1 class="register-header">
					アカウント作成
					<small>Create your FLUX Account.</small>
				</h1>
				<!-- end register-header -->
				<!-- begin register-content -->
				<div class="register-content"  >
					<form  method="POST" class="margin-bottom-0">
					<div class="form-group <?php if ($err['client_name'] != '') echo 'has-error'; ?>">
						<label class="control-label">アカウント名 <span class="text-danger">*</span></label>
						<div class="row row-space-10">
							<div class="col-md-12" >
								<input type="text" name="client_name" class="form-control" value="<?php echo h($client_name); ?>" placeholder="" required />
								<span class="help-block"><?php if(isset($err['client_name'])) echo h($err['client_name']); ?></span>
							</div>
						</div>
					</div>
					<div class="form-group <?php if ($err['mail_address'] != '') echo 'has-error'; ?>">
						<label class="control-label">メールアドレス <span class="text-danger">*</span></label>
						<div class="row m-b-15">
							<div class="col-md-12" >
								<input type="text" name="mail_address" class="form-control" value="<?php if(isset($err['mail_address'])) echo h($mail_address); ?>" placeholder="" required />
								<span class="help-block"><?php if(isset($err['mail_address']))echo h($err['mail_address']); ?></span>
							</div>
						</div>
					</div>
					<div class="form-group <?php if ($err['password'] != '') echo 'has-error'; ?>">
						<label class="control-label">パスワード <span class="text-danger">*</span></label>
						<div class="row m-b-15" >
							<div class="col-md-6 m-b-15" >
							   <input type="password" class="form-control" name="password" placeholder="8文字以上" required />
							   <span class="help-block"><?php if(isset($err['password'])) echo h($err['password']); ?></span>
						   </div>
						   <div class="col-md-6 m-b-15" >
							   <input type="password" class="form-control" name="password2" placeholder="再入力" required />
						   </div>
						</div>
					</div>
					<div class="form-group <?php if ($err['secret_code'] != '') echo 'has-error'; ?>">
						<label class="control-label">招待コード <span class="text-danger">*</span></label>
						<div class="row m-b-15">
							<div class="col-md-12 ">
								<input type="text" class="form-control" name="secret_code" value="<?php echo h($secret_code); ?>" placeholder="招待コードをお持ちの方のみがご登録いただけます。" required />
								<span class="help-block"><?php if(isset($err['secret_code'])) echo h($err['secret_code']); ?></span>
							</div>
						</div>
                    </div>
				    <div class="form-group <?php if ($err['agreement'] != '') echo 'has-error'; ?>">
						<div class="checkbox checkbox-css m-b-30 ">
								<input type="checkbox" id="agreement" name="agreement" value="1" >
								<label for="agreement">
									<a href="javascript:;">利用規約</a> 及び <a href="javascript:;">プライバシーポリシー</a>に同意します。
								</label>
								<span class="help-block"><?php if(isset($err['agreement'])) echo h($err['agreement']); ?></span>
						</div>
					</div>
						<div class="register-buttons">
							<button type="submit" class="btn btn-primary btn-block btn-lg">アカウント作成</button>
						</div>
						<div class="m-t-20 m-b-40 p-b-40 text-inverse">
							すでにアカウントをお持ちの方は<a href="login_v3.html">こちら</a>
						</div>
						<hr />
						<p class="text-center">
							&copy; ©2019 SENSE SHARE All Rights Reserved.
						</p>
						<input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
					</form>
				</div>
				<!-- end register-content -->
			</div>
			<!-- end right-content -->
		</div>
		<!-- end register -->
	</div>
	<!-- end page container -->

	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo CONTENTS_SERVER_URL ?>/assets/plugins/jquery/jquery-3.3.1.min.js"></script>
	<script src="<?php echo CONTENTS_SERVER_URL ?>/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
	<script src="<?php echo CONTENTS_SERVER_URL ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!--[if lt IE 9]>
		<script src="<?php echo CONTENTS_SERVER_URL ?>/assets/crossbrowserjs/html5shiv.js"></script>
		<script src="<?php echo CONTENTS_SERVER_URL ?>/assets/crossbrowserjs/respond.min.js"></script>
		<script src="<?php echo CONTENTS_SERVER_URL ?>/assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="<?php echo CONTENTS_SERVER_URL ?>/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo CONTENTS_SERVER_URL ?>/assets/plugins/js-cookie/js.cookie.js"></script>
	<script src="<?php echo CONTENTS_SERVER_URL ?>/assets/js/theme/facebook.min.js"></script>
	<script src="<?php echo CONTENTS_SERVER_URL ?>/assets/js/apps.min.js"></script>
	<!-- ================== END BASE JS ================== -->
	<script>
			$(document).ready(function() {
				App.init();
			});
		</script>
</body>
</html>
