<?php

$page_title = "ブログ記事作成";
$page_base_head_tag_template = "head_blog_entry.php";
$page_base_body_tag_template = "body_blog_entry.php";

if(isset($_GET['id'])) {
	$id = $_GET['id'];
}

$blog_entry = array();
$blog_entry2 = array();
$blog_category_masters = array();
$category_id = array();
$blog_category_master = array();

$sql = "select * from blog_category_master where blog_id = :blog_id and client_id = :client_id ";
$stmt = $pdo->prepare($sql);
$params = array(
	":blog_id" => $blog_id,
	":client_id" => $user['id']
);
$stmt->execute($params);

foreach ($stmt->fetchAll() as $row) {
	array_push($blog_category_masters, $row);
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	// CSRF対策
	setToken();

	if(isset($id)){
		$sql = "select * from blog_entry where blog_entry_code = :blog_entry_code and client_id = :client_id limit 1";
		$stmt = $pdo->prepare($sql);
		$params = array(
			":blog_entry_code" => $id,
			":client_id" => $user['id']
		);
		$stmt->execute($params);
		$blog_entry = $stmt->fetch();

		$title = $blog_entry['title'];
		$slug = $blog_entry['slug'];
		$contents = $blog_entry['contents'];
		$posting_date =   $blog_entry['posting_date'];
		$seo_description = $blog_entry['seo_description'];
		$seo_keywords = $blog_entry['seo_keywords'];
		$status = $blog_entry['status'];
	}

} else {
	checkToken();

	$sql = "select * from blog_entry where client_id = :client_id limit 1";
	$stmt = $pdo->prepare($sql);
	$params = array(
		":client_id" => $user['id']
	);
	$stmt->execute($params);
	$blog_entry2 = $stmt->fetch();

	$title = $_POST['title'];
	$contents = $_POST['contents'];
	$posting_date = $_POST['posting_date'];
	$seo_description = $_POST['seo_description'];
	$seo_keywords = $_POST['seo_keywords'];

	$category_id = $_POST["category_id"];

	foreach((array) $blog_category_masters as $val){
		$checked["category_id"][$val['blog_category_code']]=" ";
	}

	if(isset($_POST["category_id"])){
	 	foreach((array) $_POST["category_id"] as $val){
			$checked["category_id"][$val]=" checked";
		}
	}

	if($_POST['status'] ){
		$status = 1;
	} else {
		$status = 2;
	};

	$slug = $_POST['slug'];

	$err = array();
	$complete_msg = "";
	//client_id,blog_idを確認
	$sql = "select * from blog_entry_code_sequence where blog_id = :blog_id and client_id = :client_id limit 1";
		$stmt = $pdo->prepare($sql);
		$params = array(
			":blog_id" => $blog_id,
			":client_id" => $user['id']
		);
		$stmt->execute($params);
		$blog_entry_code_sequence = $stmt->fetch();

	$default_err = array();

	$file_upload_array_default = file_upload('eye_catch_image', $default_err);

	if($file_upload_array_default['file'] ==''){
		$blog_entry['eye_catch_image'] = $blog_entry2['eye_catch_image'];
		$blog_entry['eye_catch_image_ext'] = $blog_entry2['eye_catch_image_ext'];
	} else {
		$blog_entry['eye_catch_image'] = $file_upload_array_default['file'];
		$blog_entry['eye_catch_image_ext'] = $file_upload_array_default['ext'];
	}

	// タイトル名が空
	if ($title == '') {
		$err['title'] = 'タイトル名を入力して下さい。';
	} else {
		// 文字数チェック
		if (strlen(mb_convert_encoding($title, 'SJIS', 'UTF-8')) > 200) {
			$err['title'] = 'タイトル名は200バイト以内で入力して下さい。';
		}
	}

	//スラッグの重複を確認
	$sql = "select * from blog_entry where blog_id =:blog_id and slug = :slug  limit 1";
		$stmt = $pdo->prepare($sql);
		$params = array(
			":blog_id" => $blog_id,
			":slug" => $slug
		);
		$stmt->execute($params);
		$blog_entry_slug = $stmt->fetch();
		$slug2 = $blog_entry_slug['slug'];

	//スラッグが空
	if ($slug == '') {
		$slug = '';
	} else {
		// 文字数チェック
		if (strlen(mb_convert_encoding($slug, 'SJIS', 'UTF-8')) > 50) {
			$err['blog_category_slug'] = 'スラッグは50バイト以内で入力して下さい。';
		} else {
			// スラッグが重複
			if(!isset($id)){
				if ($slug2 !='') {
					$err['slug'] = '別のスラッグを入力してください。';
				}
			}
		}
	}

	// 記事が空
	if ($contents == '') {
		$err['contents'] = '記事を入力して下さい。';
	} else {
		// 文字数チェック
		if (strlen(mb_convert_encoding($contents, 'SJIS', 'UTF-8')) > 500) {
			$err['contents'] = '記事は500バイト以内で入力して下さい。';
		}
	}

	// SEO説明文が空
	if ($seo_description == '') {
		$err['seo_description'] = 'SEO説明文を入力して下さい。';
	} else {
		// 文字数チェック
		if (strlen(mb_convert_encoding($title, 'SJIS', 'UTF-8')) > 500) {
			$err['seo_description'] = 'SEO説明文は500バイト以内で入力して下さい。';
		}
	}

	// SEOキーワードが空
	if ($seo_keywords == '') {
		$err['seo_keywords'] = 'SEOキーワードを入力して下さい。';
	} else {
		// 文字数チェック
		if (strlen(mb_convert_encoding($title, 'SJIS', 'UTF-8')) > 200) {
			$err['seo_keywords'] = 'SEOキーワードは200バイト以内力して下さい。';
		}
	}

		//client_id,blog_idを確認
		$sql = "select * from blog_entry_code_sequence where blog_id = :blog_id and client_id = :client_id limit 1";
			$stmt = $pdo->prepare($sql);
			$params = array(
				":blog_id" => $blog_id,
				":client_id" => $user['id']
			);
			$stmt->execute($params);
			$blog_entry_code_sequence = $stmt->fetch();

		if(!isset($id)){
			//ブログカテゴリーコードのシーケンスがなかった場合
			if ($blog_entry_code_sequence['sequence'] == '') {
				$sql = "insert into blog_entry_code_sequence
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
				$blog_entry_code = 1;
			} else {
				$sql = "update blog_entry_code_sequence
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
					":sequence" => $blog_entry_code_sequence['sequence'] + 1
				);
				$stmt->execute($params);

				$blog_entry_code = $blog_entry_code_sequence['sequence'] + 1;
			}
		}

	if (empty($err)) {

		if(!isset($id)) {
			// 登録処理
			$sql = "insert into blog_entry
					(blog_entry_code, title, contents, posting_date, seo_description, seo_keywords, status, slug, client_id, blog_id, eye_catch_image, eye_catch_image_ext, created_at, updated_at)
					values
					(:blog_entry_code, :title, :contents, :posting_date, :seo_description, :seo_keywords, :status, :slug, :client_id, :blog_id, :eye_catch_image, :eye_catch_image_ext, now(), now())";
			$stmt = $pdo->prepare($sql);
			$params = array(
				":blog_entry_code" =>$blog_entry_code,
				":title" => $title,
				":contents" => $contents,
				":posting_date" => $posting_date,
				":seo_description" => $seo_description,
				":seo_keywords" => $seo_keywords,
				":status" => $status,
				":slug" => $slug,
				":client_id" => $user['id'],
				":blog_id" => $blog_id,
				":eye_catch_image" => $blog_entry['eye_catch_image'],
				":eye_catch_image_ext" => $blog_entry['eye_catch_image_ext']
			);
			$stmt->execute($params);


			$sql = "select * from blog_entry order by id desc limit 1";
				$stmt = $pdo->prepare($sql);
				$stmt->execute();
				$blog_entry3 = $stmt->fetch();

			foreach((array)$category_id as $val){
				$sql = "select * from blog_category_master where blog_id =:blog_id and client_id =:client_id and blog_category_code =:blog_category_code limit 1";
					$stmt = $pdo->prepare($sql);
					$params = array(
						":blog_id" => $blog_id,
						":client_id" => $user['id'],
						":blog_category_code" => $val
					);
					$stmt->execute($params);

					$blog_category_master[$val] = $stmt->fetch();



				$sql = "insert into blog_category
						(status, client_id, blog_id, blog_entry_id, blog_category_master_id, created_at, updated_at)
						values
						(:status, :client_id, :blog_id, :blog_entry_id, :blog_category_master_id, now(), now())";
				$stmt = $pdo->prepare($sql);
				$params = array(
					":status" => $status,
					":client_id" => $user['id'],
					":blog_id" => $blog_id,
					":blog_entry_id" => $blog_entry3['id'],
					":blog_category_master_id" => $blog_category_master[$val]['id']
				);
				$stmt->execute($params);
			}

			$complete_msg = "登録されました。\n";
		} else {
			$sql = "update blog_entry
					set
					title=:title,
					contents=:contents,
					posting_date=:posting_date,
					seo_description=:seo_description,
					seo_keywords=:seo_keywords,
					status=:status,
					slug=:slug,
					eye_catch_image=:eye_catch_image,
					eye_catch_image_ext=:eye_catch_image_ext,
					updated_at = now()
					where
					client_id = :client_id and
					blog_entry_code = :blog_entry_code";
			$stmt = $pdo->prepare($sql);
			$params = array(
				":title" => $title,
				":contents" => $contents,
				":posting_date" => $posting_date,
				":seo_description" => $seo_description,
				":seo_keywords" => $seo_keywords,
				":status" => $status,
				":slug" => $slug,
				":eye_catch_image" => $blog_entry['eye_catch_image'],
				":eye_catch_image_ext" => $blog_entry['eye_catch_image_ext'],
				":client_id" => $user['id'],
				":blog_entry_code" => $id
			);
			$stmt->execute($params);

			$sql = "select * from blog_entry where client_id = :client_id and blog_entry_code = :blog_entry_code limit 1";
				$stmt = $pdo->prepare($sql);
				$params = array(
					":client_id" => $user['id'],
					":blog_entry_code" => $id
				);
				$stmt->execute($params);
				$blog_entry3 = $stmt->fetch();


			foreach((array)$category_id as $val){

				$sql = "select * from blog_category_master where blog_id =:blog_id and client_id =:client_id and blog_category_code =:blog_category_code limit 1";
					$stmt = $pdo->prepare($sql);
					$params = array(
						":blog_id" => $blog_id,
						":client_id" => $user['id'],
						":blog_category_code" => $val
					);
					$stmt->execute($params);

					$blog_category_master[$val] = $stmt->fetch();

				$sql = "update blog_category
						set
						status = :status,
						client_id =:client,
						blog_id =:blog_id,
						blog_entry_id =:blog_entry_id,
						blog_category_master_id =:blog_category_master_id,
						updated_at = now()
						where
						client_id = :client_id and
						blog_id = :blog_id";
				$stmt = $pdo->prepare($sql);
				$params = array(
					":status" => $status,
					":client_id" => $user['id'],
					":blog_id" => $blog_id,
					":blog_entry_id" =>$blog_entry3['id'],
					":blog_category_master_id" =>$blog_category_master[$val]['id'],
				);
				$stmt->execute($params);
			}


			$complete_msg = "登録されました。\n";
		}
	}
}
?>
<?php include(TEMPLATE_PATH."/template_head.php"); ?>

<!-- end #sidebar -->

<!-- begin #content -->
<div id="content" class="content">
				<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li class="breadcrumb-item"><a href="http://blog-system-5884.localhost/">HOME</a></li>
	<li class="breadcrumb-item"><a href="http://blog-system-5884.localhost/blog/">記事一覧</a></li>
	<li class="breadcrumb-item active">ブログ記事作成</li>
</ol>
<!-- end breadcrumb -->

<!-- begin page-header -->
<h1 class="page-header">ブログ記事作成</h1>
<!-- end page-header -->

<form method="POST" class="form-horizontal form-bordered" id="mainform" enctype="multipart/form-data">

	<div class="vertical-box inbox">
		<div class="vertical-box-column bg-white">
			<!-- begin wrapper -->
			<div class="wrapper bg-silver border-bottom">
				<span class="btn-group m-r-5">
					<div class="input-group date" id="datetimepicker1">
						<div class="input-group-addon">
							<span class="f-s-11">投稿日時</span>
						</div>
						<input type="text" name="posting_date" class="form-control " placeholder="投稿日時" value=" <?php if (isset($posting_date)) { echo $posting_date;} else { echo date("Y/m/d H:i:s");} ?>"<span class="help-block"><?php if ( isset($err['posting_date'])) echo h($err['posting_date']); ?></span>
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
					</div>
				</span>

				<span class="pull-right">
					<input type="checkbox" id="status" name="status" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="公開" data-off="下書き" <?php if ($status == 1)  echo 'checked' ; ?> />
					<a href="#" class="m-l-10" data-click="preview"><button type="button" class="btn btn-white p-l-40 p-r-40 m-r-5">プレビュー</button></a>
					<button type="submit" class="btn btn-primary p-l-40 p-r-40">登録</button>
				</span>
			</div>
			<!-- end wrapper -->

			<!-- begin scrollbar -->
			<div data-scrollbar="true" data-height="100%" class="p-15">
				<!-- begin email subject -->
				<div class="email-subject <?php if ($err['title'] != '') echo 'has-error'; ?>">
					<input type="text" name="title" class="form-control form-control-lg " placeholder="記事タイトル（22-32文字）" value="<?php if(isset($title)) echo h($title); ?>" /><span class="help-block"><?php if ( isset($err['title'])) echo h($err['title']); ?></span>
					<div class="invalid-feedback"></div>
				</div>
				<!-- end email subject -->

				<!-- begin email content -->
				<div class="email-content p-t-15 <?php if ($err['contents'] != '') echo 'has-error'; ?>">
					<textarea class="summernote form-control " name="contents" ><?php if(isset($contents)) echo h($contents); ?></textarea><span class="help-block"><?php if ( isset($err['contents'])) echo h($err['contents']); ?></span>
					<div class="invalid-feedback"></div>
				</div>
				<!-- end email content -->
			</div>
			<!-- end scrollbar -->
		</div>

		<div class="vertical-box-column bg-silver width-300 border-left">
			<!-- begin wrapper -->
			<div class="wrapper bg-silver text-center border-bottom　<?php if ($default_err['eye_catch_image']!= '') echo 'has-error'; ?>>">
				<div class="image-preview m-b-4 " </div>

				<label class="m-t-1 m-b-1">
					<span class="btn btn-inverse p-l-40 p-r-40 btn-sm">
						<i class="fa fa-image"></i> アイキャッチ画像
						<input type="file" name="eye_catch_image" value="<?php if(isset($blog_entry['eye_catch_image'])) echo h($blog_entry['eye_catch_image']); ?>" style="display:none"><span class="help-block"><?php if ( isset($default_err['eye_catch_image'])) echo h($default_err['eye_catch_image']); ?></span>

					</span>
				</label>
			</div>
			<!-- end wrapper -->

			<!-- begin wrapper -->
			<div class="wrapper p-0">
				<div class="nav-title"><b>SLUG</b></div>
				<div class="m-l-10 m-r-10 <?php if ($err['slug'] != '') echo 'has-error'; ?>" >
					<input type="text" class="form-control " name="slug" placeholder="" value="<?php if(isset($slug)) echo h($slug); ?>" /><span class="help-block"><?php if ( isset($err['slug'])) echo h($err['slug']); ?></span>
					<div class="invalid-feedback"></div>
				</div>

				<div class="nav-title m-t-10"><b>SEO DESCRIPTION</b><div id="seo_description_text_count" class="text_count pull-right"></div></div>
				<div class="m-l-10 m-r-10 <?php if ($err['seo_description'] != '') echo 'has-error'; ?>" >
					<textarea class="textarea form-control " name="seo_description" id="seo_description" placeholder="SEOディスクリプション（80-120文字）" rows="6" ><?php if(isset($seo_description)) echo h($seo_description); ?></textarea><span class="help-block"><?php if ( isset($err['seo_description'])) echo h($err['seo_description']); ?></span>
					<div class="invalid-feedback"></div>
				</div>

				<div class="nav-title m-t-10"><b>SEO KEYWORDS</b></div>
				<div class="m-l-10 m-r-10 <?php if ($err['seo_keywords'] != '') echo 'has-error'; ?>" >
					<input type="text" class="form-control " name="seo_keywords" placeholder="SEOキーワード（カンマ区切りで複数指定可）" value="<?php if(isset($seo_keywords)) echo h($seo_keywords); ?>" /><span class="help-block"><?php if ( isset($err['seo_keywords'])) echo h($err['seo_keywords']); ?></span>
					<div class="invalid-feedback"></div>
				</div>

				<div class="nav-title m-t-10 " ><b>CATEGORIES</b></div>
				<ul id="category_area" class="nav nav-inbox <?php if ($err['category_id'] != '') echo 'has-error'; ?>" style="text-align:left">
				<span class="help-block "><?php if ( isset($err['category_id'])) echo h($err['category_id']); ?></span>
				<?php foreach ($blog_category_masters as $val): ?>
					<li class="checkbox checkbox-css m-l-15 m-b-5">
						<input type="checkbox" id="category_<?php echo h($val['blog_category_code']); ?>" name="category_id[]" value="<?php echo h($val['blog_category_code']); ?>" <?php echo $checked["category_id"][$val['blog_category_code']]; ?>/>
						<label for="category_<?php echo h($val['blog_category_code']); ?>">
							<?php echo h($val['category_name']); ?>
						</label>
					</li>
				<?php endforeach; ?>
 				</ul>
				<div class="m-t-20 m-l-10 m-r-10 m-b-10">
					<div class="input-group">
						<input type="text" class="form-control" id="new_category_name" name="new_category_name" placeholder="新規カテゴリー">
						<div class="input-group-append">
							<button type="button" class="btn btn-white dropdown-toggle no-caret" onclick="create_category();">追加</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end wrapper -->
		</div>
	</div>

	<input type="hidden" name="code" value="" />
	<input type="hidden" name="mode" value="save" />
	<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
	<input type="hidden" name="FLUXDEMOTOKEN" value="fb101adcbf182caee4e77515ddcb8acc39818d47" />
	<input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
</form>

</div>
<!-- end #content -->

			<!-- begin #footer -->

<!-- end #footer -->

			<!-- begin scroll to top btn -->
<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
<!-- end scroll to top btn -->
</div>
		<!-- end page container -->
<?php include(TEMPLATE_PATH."/template_bottom.php"); ?>
