<?php

$blog = array();
$blog2 = array();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	// CSRF対策
	setToken();

	$sql = "select * from  blog where  client_id =:client_id limit 1";
	$stmt = $pdo->prepare($sql);
	$params = array(
		":client_id" => $user['id']
	);
	$stmt->execute($params);
	$blog = $stmt->fetch();

} else {
	checkToken();

	$sql = "select * from  blog where  client_id =:client_id limit 1";
	$stmt = $pdo->prepare($sql);
	$params = array(
		":client_id" => $user['id']
	);
	$stmt->execute($params);
	$blog2 = $stmt->fetch();

	$blog['blog_title'] = $_POST['blog_title'];
	$blog['blog_description'] = $_POST['blog_description'];
	$blog['blog_keywords'] = $_POST['blog_keywords'];
	$blog['blog_author_name'] = $_POST['blog_author_name'];
	$blog['analytics_ua_code'] = $_POST['analytics_ua_code'];

	$header_err = array();
	$favicon_err = array();
	$favicon180_err = array();
	$default_err = array();

	// ファイルアップロード
	$file_upload_array_header = file_upload('blog_header_image', $header_err);

	if($file_upload_array_header['file'] ==''){
		$blog['blog_header_image']=$blog2['blog_header_image'];
		$blog['blog_header_image_ext']=$blog2['blog_header_image_ext'];
	} else {
		$blog['blog_header_image'] = $file_upload_array_header['file'];
		$blog['blog_header_image_ext'] = $file_upload_array_header['ext'];
	}

	$file_upload_array_favicon = file_upload('blog_favicon_image', $favicon_err);

	if($file_upload_array_favicon['file'] ==''){
		$blog['blog_favicon_image'] = $blog2['blog_favicon_image'];
		$blog['blog_favicon_image_ext'] = $blog2['blog_favicon_image_ext'];
	} else {
		$blog['blog_favicon_image'] = $file_upload_array_favicon['file'];
		$blog['blog_favicon_image_ext'] = $file_upload_array_favicon['ext'];
	}

	$file_upload_array_favicon180 = file_upload('blog_favicon180_image', $favicon180_err);

	if($file_upload_array_favicon180['file'] ==''){
		$blog['blog_favicon180_image'] = $blog2['blog_favicon180_image'];
		$blog['blog_favicon180_image_ext'] = $blog2['blog_favicon180_image_ext'];
	} else {
		$blog['blog_favicon180_image'] = $file_upload_array_favicon180['file'];
		$blog['blog_favicon180_image_ext'] = $file_upload_array_favicon180['ext'];
	}

	$file_upload_array_default = file_upload('blog_default_eye_catch_image', $default_err);

	if($file_upload_array_default['file'] ==''){
		$blog['blog_default_eye_catch_image'] = $blog2['blog_default_eye_catch_image'];
		$blog['blog_default_eye_catch_image_ext'] = $blog2['blog_default_eye_catch_image_ext'];
	} else {
		$blog['blog_default_eye_catch_image'] = $file_upload_array_default['file'];
		$blog['blog_default_eye_catch_image_ext'] = $file_upload_array_default['ext'];
	}

	// タイトル名が空
	if ($blog['blog_title'] == '') {
		$err['blog_title'] = 'タイトル名を入力して下さい。';
	} else {
		// 文字数チェック
		if (strlen(mb_convert_encoding($blog['blog_title'], 'SJIS', 'UTF-8')) > 200) {
			$err['blog_title'] = 'ブログタイトル名は200バイト以内で入力して下さい。';
		}
	}

	// ブログ説明が空
	if ($blog['blog_description'] == '') {
		$err['blog_description'] = 'ブログ説明を入力して下さい。';
	} else {
		// 文字数チェック
		if (strlen(mb_convert_encoding($blog['blog_description'], 'SJIS', 'UTF-8')) > 500) {
			$err['blog_description'] = 'ブログ説明は1000バイト以内で入力して下さい。';
		}
	}

	// ブログキーワードが空
	if ($blog['blog_keywords'] == '') {
		$err['blog_keywords'] = 'キーワードを入力して下さい。';
	} else {
		// 文字数チェック
		if (strlen(mb_convert_encoding($blog['blog_keywords'], 'SJIS', 'UTF-8')) > 500) {
			$err['blog_keywords'] = 'キーワードは100バイト以内で入力して下さい。';
		}
	}

	// 著者名が空
	if ($blog['blog_author_name'] == '') {
		$err['blog_author_name'] = '著者名を入力して下さい。';
	}

	//アナリティクストラッキングＩＤ が空
	if ($blog['analytics_ua_code'] == '') {
		$err['analytics_ua_code'] = 'アナリティクストラッキングＩＤを入力して下さい。';
	} else {
		// 文字数チェック
		if (strlen(mb_convert_encoding($blog['analytics_ua_code'], 'SJIS', 'UTF-8')) > 50) {
			$err['analytics_ua_code'] = 'アナリティクストラッキングＩＤは50バイト以内で入力して下さい。';
		}
	}

	if (empty($err) && empty($header_err) && empty($favicon_err) && empty($favicon180_err) && empty($default_err)) {
		$sql = "update blog
				set
				blog_title =:blog_title,
				blog_description =:blog_description,
				blog_keywords =:blog_keywords,
				blog_author_name =:blog_author_name,
				blog_header_image = :blog_header_image,
				blog_header_image_ext = :blog_header_image_ext,
				blog_favicon_image = :blog_favicon_image,
				blog_favicon_image_ext = :blog_favicon_image_ext,
				blog_favicon180_image = :blog_favicon180_image,
				blog_favicon180_image_ext = :blog_favicon180_image_ext,
				blog_default_eye_catch_image = :blog_default_eye_catch_image,
				blog_default_eye_catch_image_ext = :blog_default_eye_catch_image_ext,
				analytics_ua_code = :analytics_ua_code,
				updated_at = now()
				where
				client_id=:client_id " ;
				$stmt = $pdo->prepare($sql);
				$stmt->bindValue(':client_id', (int)$user['id'], PDO::PARAM_INT);
				$stmt->bindValue(':blog_title', $blog['blog_title'], PDO::PARAM_STR);
				$stmt->bindValue(':blog_description', $blog['blog_description'], PDO::PARAM_STR);
				$stmt->bindValue(':blog_keywords', $blog['blog_keywords'], PDO::PARAM_STR);
				$stmt->bindValue(':blog_author_name', $blog['blog_author_name'], PDO::PARAM_STR);
				$stmt->bindValue(':blog_header_image', $blog['blog_header_image'], PDO::PARAM_LOB);
				$stmt->bindValue(':blog_header_image_ext', $blog['blog_header_image_ext'], PDO::PARAM_STR);
				$stmt->bindValue(':blog_favicon_image', $blog['blog_favicon_image'], PDO::PARAM_LOB);
				$stmt->bindValue(':blog_favicon_image_ext', $blog['blog_favicon_image_ext'], PDO::PARAM_STR);
				$stmt->bindValue(':blog_favicon180_image', $blog['blog_favicon180_image'], PDO::PARAM_LOB);
				$stmt->bindValue(':blog_favicon180_image_ext', $blog['blog_favicon180_image_ext'], PDO::PARAM_STR);
				$stmt->bindValue(':blog_default_eye_catch_image', $blog['blog_default_eye_catch_image'], PDO::PARAM_LOB);
				$stmt->bindValue(':blog_default_eye_catch_image_ext', $blog['blog_default_eye_catch_image_ext'], PDO::PARAM_STR);
				$stmt->bindValue(':analytics_ua_code', $blog['analytics_ua_code'], PDO::PARAM_STR);
				$stmt->execute();
	}

	$sql = "select * from  blog where  client_id =:client_id limit 1";
	$stmt = $pdo->prepare($sql);
	$params = array(
		":client_id" => $user['id']
	);
	$stmt->execute($params);
	$blog = $stmt->fetch();
}
?>

<?php include(TEMPLATE_PATH."/template_head.php"); ?>
<!-- begin #content -->
<div id="content" class="content">
				<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li class="breadcrumb-item"><a href="https://demo.flu-x.net">HOME</a></li>
	<li class="breadcrumb-item active">ブログ基本設定</li>
</ol>
<!-- end breadcrumb -->

				<!-- begin page-header -->
				<h1 class="page-header">ブログ基本設定</h1>
				<!-- end page-header -->

<form method="POST" class="form-horizontal form-bordered" id="mainForm" enctype="multipart/form-data">
	<!-- begin panel -->
	<div class="panel panel-inverse">
		<!-- begin panel-body -->
		<div class="panel-body panel-form">
			<div class="form-group row <?php if ($err['blog_title'] != '') echo 'has-error'; ?>">
				<label class="col-md-2 col-form-label">ブログタイトル（22-32文字）</label>
				<div class="col-md-10">
					<input name="blog_title" type="text" class="form-control " value="<?php echo $blog['blog_title']; ?>" /><span class="help-block"><?php if ( isset($err['blog_title'])) echo h($err['blog_title']); ?></span>
					<div class="invalid-feedback"></div>
				</div>
			</div>

			<div class="form-group row <?php if ($err['blog_description'] != '') echo 'has-error'; ?>">
				<label class="col-md-2 col-form-label">ブログの説明（80-120文字）</label>
				<div class="col-md-10">
					<textarea class="form-control " name="blog_description" rows="10"><?php echo $blog['blog_description']; ?></textarea><span class="help-block"><?php if ( isset($err['blog_description'])) echo h($err['blog_description']); ?></span>
					<div class="invalid-feedback"></div>
				</div>
			</div>

			<div class="form-group row <?php if ($err['blog_keywords'] != '') echo 'has-error'; ?>">
				<label class="col-md-2 col-form-label">ブログのキーワード（50文字以内）</label>
				<div class="col-md-10">
					<input name="blog_keywords" type="text" class="form-control " value="<?php echo $blog['blog_keywords']; ?>" /><span class="help-block"><?php if ( isset($err['blog_keywords'])) echo h($err['blog_keywords']); ?></span>
					<div class="invalid-feedback"></div>
				</div>
			</div>

			<div class="form-group row <?php if ($err['blog_author_name'] != '') echo 'has-error'; ?>">
				<label class="col-md-2 col-form-label">投稿者名</label>
				<div class="col-md-10">
					<input name="blog_author_name" type="text" class="form-control " value="<?php echo $blog['blog_author_name']; ?>" /><span class="help-block"><?php if ( isset($err['blog_author_name'])) echo h($err['blog_author_name']); ?></span>
					<div class="invalid-feedback"></div>
				</div>
			</div>

			<div class="form-group row <?php if ($err['analytics_ua_code'] != '') echo 'has-error'; ?>">
				<label class="col-md-2 col-form-label">Google Analyticsコード</label>
				<div class="col-md-10">
					<input name="analytics_ua_code" type="text" class="form-control " value="<?php echo $blog['analytics_ua_code']; ?>" /><span class="help-block"><?php if ( isset($err['analytics_ua_code'])) echo h($err['analytics_ua_code']); ?></span>
					<div class="invalid-feedback"></div>
				</div>
			</div>

			<div class="form-group row <?php if ($header_err['blog_header_image'] != '') echo 'has-error'; ?>">
				<label class="col-md-2 col-form-label">ヘッダーイメージ（1200px*260px）</label>
				<div class="col-md-10">
					<img src="<?php echo get_base64_header_string($blog['blog_header_image_ext']) ?><?php echo base64_encode($blog['blog_header_image']);?>" alt="" class="width-full m-b-10 img-responsive">
					<input name="blog_header_image" type="file" class="form-control " value="" alt="" class="width-full m-b-10 img-responsive" /><span class="help-block"><?php if ( isset($header_err['blog_header_image'])) echo h($header_err['blog_header_image']); ?></span>
					<div class="invalid-feedback"></div>
				</div>
			</div>

			<div class="form-group row <?php if ($favicon_err['blog_favicon_image'] != '') echo 'has-error'; ?>">
				<label class="col-md-2 col-form-label">favicon.ico</label>
				<div class="col-md-10">
					<img src="<?php echo get_base64_header_string($blog['blog_favicon_image_ext']) ?><?php echo base64_encode($blog['blog_favicon_image']);?>" alt="" class="width-full m-b-10 img-responsive">
					<input name="blog_favicon_image" type="file" class="form-control " value="" /><span class="help-block"><?php if ( isset($favicon_err['blog_favicon_image'])) echo h($favicon_err['blog_favicon_image']); ?></span>
					<div class="invalid-feedback"></div>
				</div>
			</div>

			<div class="form-group row <?php if ($favicon180_err['blog_favicon180_image'] != '') echo 'has-error'; ?>">
				<label class="col-md-2 col-form-label">apple-touch-icon-180x180.png</label>
				<div class="col-md-10">
					<img src="<?php echo get_base64_header_string($blog['blog_favicon180_image_ext']) ?><?php echo base64_encode($blog['blog_favicon180_image']);?>" alt="" class="width-full m-b-10 img-responsive">
					<input name="blog_favicon180_image" type="file" class="form-control " value="" /><span class="help-block"><?php if ( isset($favicon180_err['blog_favicon180_image'])) echo h($favicon180_err['blog_favicon180_image']); ?></span>
					<div class="invalid-feedback"></div>
				</div>
			</div>

			<div class="form-group row <?php if ($default_err['blog_default_eye_catch_image'] != '') echo 'has-error'; ?>">
				<label class="col-md-2 col-form-label">デフォルトアイキャッチ画像（1200px*630px）</label>
				<div class="col-md-10">
					<img src="<?php echo get_base64_header_string($blog['blog_default_eye_catch_image_ext']) ?><?php echo base64_encode($blog['blog_default_eye_catch_image']);?>" alt="" class="width-full m-b-10 img-responsive">
					<input name="blog_default_eye_catch_image" type="file" class="form-control " value="" /><span class="help-block"><?php if ( isset($default_err['blog_default_eye_catch_image'])) echo h($default_err['blog_default_eye_catch_image']); ?></span>
					<div class="invalid-feedback"></div>
				</div>
			</div>
		</div>
		<!-- end panel-body -->
	</div>
	<!-- end panel -->

	<!-- begin wrapper -->
	<div class="wrapper bg-silver text-right">
		<a href="https://demo.flu-x.net"><button type="button" class="btn btn-white p-l-40 p-r-40 m-r-5">キャンセル</button></a>
		<button type="submit" class="btn btn-primary p-l-40 p-r-40" onclick="mainForm.submit();">登録</button>
	</div>
	<!-- end wrapper -->

	<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
	<input type="hidden" name="FLUXDEMOTOKEN" value="5242b5559dd5b4d6dab80752269122553cd944da" />
	<input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
</form>

			</div>
			<!-- end #content -->

<?php include(TEMPLATE_PATH."/template_bottom.php"); ?>
