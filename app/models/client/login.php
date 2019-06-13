<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // 初めて画面にアクセスした時の処理

	// 自動ログイン情報があるかどうかCookieをチェック
	if (isset($_COOKIE['BLOG_SYSTEM'])) {
		// 自動ログイン情報があればキーを取得
		$auto_login_key = $_COOKIE['BLOG_SYSTEM'];

		// 自動ログインキーをDBに照合
		$sql = "select * from client_auto_login where c_key = :c_key and expire >= :expire limit 1";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(":c_key" => $auto_login_key, "expire" => date('Y-m-d H:i:s')));
		$row = $stmt->fetch();

		if ($row) {
			// 照合成功、自動ログイン
			$user = getUserbyUserId($row['client_id'], $pdo);
			// セッションハイジャック対策
			session_regenerate_id(true);
			$_SESSION['USER'] = $user;

			// HOME画面に遷移する。
			header('Location:'.SITE_URL);
			exit;
		}
	}
	// CSRF対策
	setToken();
} else {
    // フォームからサブミットされた時の処理
	checkToken();
    // 入力されたメールアドレス、パスワード、自動ログインチェックを受け取り、変数に入れる。
	$mail_address = $_POST['mail_address'];
	$password = $_POST['password'];
	if (isset($_POST["auto_login"])) {
    	$auto_login = $_POST['auto_login'];
	}

	// 入力チェックを行う。
	$err = array();
	// [メールアドレス]未入力チェック
	if ($mail_address == '') {
		$err['mail_address'] = 'メールアドレスを入力して下さい。';
	} else {
		// [メールアドレス]形式チェック
		if (!filter_var($mail_address, FILTER_VALIDATE_EMAIL)) {
			$err['mail_address'] = 'メールアドレスが不正です。';
		} else {
			// [メールアドレス]存在チェック
			if (!checkEmail($mail_address, $pdo)) {
				$err['mail_address'] = 'このメールアドレスが登録されていません。';
			}
		}
	}

	// [パスワード]未入力チェック
	if ($password == '') {
		$err['password'] = 'パスワードを入力して下さい。';
	} else {
    	if ($mail_address && $password) {
    		// メールアドレスとパスワードが正しくない
    		$user = getUser($mail_address, $password, $pdo);
      		if (!$user) {
        		$err['password'] = 'パスワードが正しくありません。';
    		}
    	}
	}

	// もし$err配列に何もエラーメッセージが保存されていなかったら
	if (empty($err)) {
		// セッションハイジャック対策
		session_regenerate_id(true);
		// ログインに成功したのでセッションにユーザデータを保存する。
		$_SESSION['USER'] = $user;
		// 自動ログイン情報を一度クリアする。
		if (isset($_COOKIE['BLOG_SYSTEM'])) {
			$auto_login_key = $_COOKIE['BLOG_SYSTEM'];
			// Cookie情報をクリア
			setcookie('BLOG_SYSTEM', '', time()-86400, '/');
			// DB情報をクリア
			$sql = "delete from client_auto_login where c_key = :c_key";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array(":c_key" => $auto_login_key));
		}
		// 自動ログインを希望の場合はCookieとDBに情報を登録する。
		if ($auto_login) {
			// 自動ログインキーを生成
			$auto_login_key = sha1(uniqid(mt_rand(), true));
			// Cookie登録処理
			setcookie('BLOG_SYSTEM', $auto_login_key, time()+3600*24*365, '/');
			// DB登録処理
			$sql = "insert into client_auto_login
					(client_id, c_key, expire, created_at, updated_at)
					values
					(:client_id, :c_key, :expire, now(), now())";
			$stmt = $pdo->prepare($sql);
			$params = array(
				":client_id" => $user['id'],
				":c_key" => $auto_login_key,
				":expire" => date('Y-m-d H:i:s', time()+3600*24*365)
			);
			$stmt->execute($params);
		}
		// HOME画面に遷移する。
		header('Location:'.SITE_URL.'/blog/');
		exit;
	}
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="ja" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="ja">
<!--<![endif]-->

	<head>
		<meta charset="utf-8" />
<title>ログイン | BLOG SYSTEM</title>

<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
<meta content="Blog System Demonstration" name="description" />
<meta content="SENSE SHARE" name="author" />
<!-- ================== BEGIN BASE CSS STYLE ================== -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
<link href="<?php echo CONTENTS_SERVER_URL ?>/assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
<link href="<?php echo CONTENTS_SERVER_URL ?>/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo CONTENTS_SERVER_URL ?>/assets/plugins/font-awesome/css/all.min.css" rel="stylesheet" />
<link href="<?php echo CONTENTS_SERVER_URL ?>/assets/plugins/animate/animate.min.css" rel="stylesheet" />
<link href="<?php echo CONTENTS_SERVER_URL ?>/assets/css/default/style.min.css" rel="stylesheet" />
<link href="<?php echo CONTENTS_SERVER_URL ?>/assets/css/default/style-responsive.min.css" rel="stylesheet" />
<link href="<?php echo CONTENTS_SERVER_URL ?>/assets/css/default/theme/default.css" rel="stylesheet" id="theme" />
<!-- ================== END BASE CSS STYLE ================== -->

<!-- ================== BEGIN BASE JS ================== -->
<script src="<?php echo CONTENTS_SERVER_URL ?>/assets/plugins/pace/pace.min.js"></script>
<!-- ================== END BASE JS ================== -->

<link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo CONTENTS_SERVER_URL ?>/assets/img/favicon.ico">
<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="<?php echo CONTENTS_SERVER_URL ?>/assets/img/favicon.ico">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo CONTENTS_SERVER_URL ?>/assets/img/apple-touch-icon-180x180.png">

<!-- ================== BEGIN PAGE LEVEL CSS STYLE ================== -->
<!-- ================== END PAGE LEVEL CSS STYLE ================== -->

<style>
.border-top {border-top: 1px solid #dcdcdc!important;}
.border-bottom {border-bottom: 1px solid #dcdcdc!important;}
.border-left {border-left: 1px solid #dcdcdc!important;}
.border-right {border-right: 1px solid #dcdcdc!important;}
</style>
	</head>

	<body class="pace-top bg-white">

		<!-- begin #page-loader -->
<div id="page-loader" class="fade show"><span class="spinner"></span></div>
<!-- end #page-loader -->

		<!-- begin #page-container -->
		<div id="page-container" class="fade">

			<!-- begin login -->
			<div class="login login-with-news-feed">
				<!-- begin news-feed -->
				<div class="news-feed">
					<div class="news-image" style="background-image: url(<?php echo CONTENTS_SERVER_URL ?>/assets/img/login-bg/login-bg-11.jpg)"></div>
					<div class="news-caption">
						<h4 class="caption-title"><b>BLOG SYSTEM</b></h4>
						<p>
							Blog System Demonstration						</p>
					</div>
				</div>
				<!-- end news-feed -->

				<!-- begin right-content -->
				<div class="right-content">
					<!-- begin login-header -->
					<div class="login-header">
						<div class="brand">
							<span class="logo"></span> <b>BLOG</b> Login
							<small>Blog System Demonstration</small>
						</div>
						<div class="icon">
							<i class="fa fa-sign-in"></i>
						</div>
					</div>
					<!-- end login-header -->

					<!-- begin login-content -->
					<div class="login-content">
						<form method="POST" class="margin-bottom-0">
							<div class="form-group m-b-15  <?php if ($err['mail_address'] != '') echo 'has-error'; ?>">
								<input id="mail_address" name="mail_address" type="text" class="form-control form-control-lg " placeholder="メールアドレス" value="<?php if(isset($err['mail_address'])) echo h($mail_address); ?>" />
								<span class="help-block"><?php  if(isset($err['mail_address'])) echo h($err['mail_address']); ?></span>
								<div class="invalid-feedback"></div>
							</div>
							<div class="form-group m-b-15 <?php if ($err['password'] != '') echo 'has-error'; ?>">
								<input id="password" name="password" type="password" class="form-control form-control-lg " placeholder="パスワード" value="" />
								<span class="help-block"><?php  if(isset($err['password'])) echo h($err['password']); ?></span>
								<div class="invalid-feedback"></div>
							</div>
							<div class="form-group checkbox-css m-b-30">
								<input type="checkbox" id="auto_login" name="auto_login" value="1" />
								<label for="auto_login">
									ログイン情報を記憶する
								</label>
							</div>
							<div class="form-group">
								<input type="submit" value="ログイン" class="btn btn-primary btn-block">
							</div>
							<hr />
							<p class="text-center text-grey-darker">
								&copy;2019 SENSE SHARE All Rights Reserved.							</p>
							<input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
						</form>
					</div>
					<!-- end login-content -->
				</div>
				<!-- end right-container -->
			</div>
			<!-- end login -->
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
		<script src="<?php echo CONTENTS_SERVER_URL ?>/assets/js/theme/default.min.js"></script>
		<script src="<?php echo CONTENTS_SERVER_URL ?>/assets/js/apps.min.js"></script>
		<!-- ================== END BASE JS ================== -->

		<script>
			$(document).ready(function() {
				App.init();
			});
		</script>




	</body>
</html>
