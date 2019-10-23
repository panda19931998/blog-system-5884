<?php

// パンくずリスト設定
$breadcrumb_list = array();
$breadcrumb_list[0]['title'] = 'HOME';
$breadcrumb_list[0]['url'] = SITE_URL.'/blog/';
$breadcrumb_list[1]['title'] = 'ブログカテゴリー登録';
$breadcrumb_list[1]['url'] = 'http://blog-system-5884.localhost/blog/category_entry/';

if(isset($_GET['id'])) {
$id = $_GET['id'];
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	// CSRF対策
	setToken();

	if(isset($id)){
		$sql = "select * from blog_category_master where blog_category_code = :blog_category_code and client_id = :client_id limit 1";
		$stmt = $pdo->prepare($sql);
		$params = array(
			":blog_category_code" => $id,
			":client_id" => $user['id']
		);
		$stmt->execute($params);
		$blog_category_master = $stmt->fetch();

		$category_name = $blog_category_master['category_name'];
		$blog_category_slug = $blog_category_master['blog_category_slug'];
		$sort_order = $blog_category_master['sort_order'];
	}
} else {
	checkToken();

	$category_name = $_POST['category_name'];
	$blog_category_slug = $_POST['blog_category_slug'];
	$sort_order = $_POST['sort_order'];

	$err = array();
	$complete_msg = "";
	//client_id,blog_idを確認
	$sql = "select * from blog_category_code_sequence where blog_id = :blog_id and client_id = :client_id limit 1";
		$stmt = $pdo->prepare($sql);
		$params = array(
			":blog_id" => $blog_id,
			":client_id" => $user['id']
		);
		$stmt->execute($params);
		$blog_category_code_sequence = $stmt->fetch();

	if(!isset($id)){
		//ブログカテゴリーコードのシーケンスがなかった場合
		if ($blog_category_code_sequence['sequence'] == '') {
			$sql = "insert into blog_category_code_sequence
					(client_id, blog_id, sequence, created_at, updated_at)
					values
					(:client_id,:blog_id, :sequence, now(), now())";
			$stmt = $pdo->prepare($sql);
			$params = array(
				":client_id" =>$user['id'],
				":blog_id" => $blog_id,
				":sequence" => 1
			);
			$stmt->execute($params);
			$blog_category_code = 1;
		} else {
			$sql = "update blog_category_code_sequence
					set
					blog_id = :blog_id,
					sequence = :sequence,
					updated_at =now()
					where
					client_id = :client_id";
			$stmt = $pdo->prepare($sql);
			$params = array(
				":client_id" => $user['id'],
				":blog_id" => $blog_id,
				":sequence" => $blog_category_code_sequence['sequence'] + 1
			);
			$stmt->execute($params);

			$blog_category_code = $blog_category_code_sequence['sequence'] + 1;
		}
	}

	// 表示順序が空
	if ($sort_order == '') {
		$err['sort_order'] = '表示順序を入力して下さい。';
	}

	// カテゴリー名が空
	if ($category_name == '') {
		$err['category_name'] = 'カテゴリー名を入力して下さい。';
	} else {
		// 文字数チェック
		if (strlen(mb_convert_encoding($category_name, 'SJIS', 'UTF-8')) > 200) {
			$err['category_name'] = 'カテゴリー名は200バイト以内で入力して下さい。';
		}
	}

	//スラッグの重複を確認
	$sql = "select * from blog_category_master where blog_id =:blog_id and blog_category_slug = :blog_category_slug  limit 1";
		$stmt = $pdo->prepare($sql);
		$params = array(
			":blog_id" => $blog_id,
			":blog_category_slug" => $blog_category_slug
		);
		$stmt->execute($params);
		$blog_category_master_slug = $stmt->fetch();
		$blog_category_slug2 = $blog_category_master_slug['blog_category_slug'];

	//スラッグが空
	if ($blog_category_slug == '') {
		$blog_category_slug = '';
	} else {
		// 文字数チェック
		if (strlen(mb_convert_encoding($blog_category_slug, 'SJIS', 'UTF-8')) > 50) {
			$err['blog_category_slug'] = 'スラッグは50バイト以内で入力して下さい。';
		} else {
			// スラッグが重複
			if(!isset($id)){
				if ($blog_category_slug2 !='') {
					$err['blog_category_slug'] = '別のスラッグを入力してください。';
				}
			}
		}
	}
	if (empty($err)) {
		// 登録処理
		if(!isset($id)) {
			$sql = "insert into blog_category_master
					(blog_category_code, category_name, blog_category_slug, sort_order, client_id, blog_id, created_at, updated_at)
					values
					(:blog_category_code, :category_name, :blog_category_slug, :sort_order, :client_id, :blog_id, now(), now())";
			$stmt = $pdo->prepare($sql);
			$params = array(
				":blog_category_code" =>$blog_category_code,
				":category_name" => $category_name,
				":blog_category_slug" => $blog_category_slug,
				":sort_order" => $sort_order,
				":client_id" => $user['id'],
				":blog_id" => $blog_id
			);
			$stmt->execute($params);

			$complete_msg = "登録されました。\n";
		} else {
			$sql = "update blog_category_master
					set
					sort_order=:sort_order,
					category_name=:category_name,
					blog_category_slug=:blog_category_slug,
					updated_at = now()
					where
					client_id = :client_id and
					blog_category_code = :blog_category_code";
			$stmt = $pdo->prepare($sql);
			$params = array(
				":sort_order" => $sort_order,
				":category_name" => $category_name,
				":blog_category_slug" => $blog_category_slug,
				":client_id" => $user['id'],
				":blog_category_code" => $id
			);
			$stmt->execute($params);

			$complete_msg = "登録されました。\n";
		}
	}
}
?>

<?php include(TEMPLATE_PATH."/template_head.php"); ?>
<!-- begin #content -->
<div id="content" class="content">
				<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<?php include(TEMPLATE_PATH."/breadcrumb.php"); ?>
</ol>
<!-- end breadcrumb -->

<!-- begin page-header -->
<h1 class="page-header">ブログカテゴリー登録</h1>
<!-- end page-header -->


<form method="POST" class="form-horizontal form-bordered" id="mainform" enctype="multipart/form-data">
	<!-- begin panel -->
	<div class="panel panel-inverse">
		<!-- begin panel-body -->
		<div class="panel-body panel-form">
			<div class="form-group row <?php if ($err['category_name'] != '') echo 'has-error'; ?>">
				<label class="col-md-2 col-form-label">カテゴリー名</label>
				<div class="col-md-10">
					<input name="category_name" type="text" class="form-control " value="<?php if(isset($category_name)) echo h($category_name); ?>" /><span class="help-block"><?php if ( isset($err['category_name'])) echo h($err['category_name']); ?></span>
					<div class="invalid-feedback"></div>
				</div>
			</div>
			<div class="form-group row <?php if ($err['blog_category_slug'] != '') echo 'has-error'; ?>">
				<label class="col-md-2 col-form-label">スラッグ</label>
				<div class="col-md-10">
					<input name="blog_category_slug" type="text" class="form-control " value="<?php if(isset($blog_category_slug)) echo h($blog_category_slug); ?>" /><span class="help-block"><?php if ( isset($err['blog_category_slug'])) echo h($err['blog_category_slug']); ?></span>
					<div class="invalid-feedback"></div>
				</div>
			</div>
			<div class="form-group row <?php if ($err['sort_order'] != '') echo 'has-error'; ?>">
				<label class="col-md-2 col-form-label">表示順序</label>
				<div class="col-md-10">
					<input name="sort_order" type="text" class="form-control " value="<?php if (isset($sort_order)) echo h($sort_order); ?>" /><span class="help-block"><?php if ( isset($err['sort_order'])) echo h($err['sort_order']); ?></span>
					<div class="invalid-feedback"></div>
				</div>
			</div>

		</div>
		<!-- end panel-body -->
	</div>
	<!-- end panel -->

	<!-- begin wrapper -->
	<div class="wrapper bg-silver text-right">
		<a href="/blog/category/"><button type="button" class="btn btn-white p-l-40 p-r-40 m-r-5">キャンセル</button></a>
		<button type="submit" class="btn btn-primary p-l-40 p-r-40" onclick="mainform.submit();">登録</button>
	</div>
	<!-- end wrapper -->

	<input type="hidden" name="code" value="" />
	<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
	<input type="hidden" name="FLUXDEMOTOKEN" value="b954cbe308fc29566ee7dcf09b65bcf807fd0e97" />
	<input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
</form>

</div>
<!-- end #content -->


<?php include(TEMPLATE_PATH."/template_bottom.php"); ?>
