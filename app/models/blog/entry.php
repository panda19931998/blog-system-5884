<?php
$page_title = "ブログ記事作成";
$page_base_head_tag_template = "head_blog_entry.php";
$page_base_body_tag_template = "body_blog_entry.php";



//id取得
if(isset($_GET['id'])) {
	$id = $_GET['id'];
}

$status = '';

$blog_entry = array();
$blog_entry2 = array();
$blog_category_masters = array();
$category_id = array();
$blog_category_master = array();

$blog_entry_eye_catch['eye_catch_image'] ='';
$blog_entry_eye_catch['eye_catch_image_ext'] ='';


//ブログの登録しているカテゴリーを取得の準備
$sql = "SELECT * FROM blog_category_master WHERE blog_id = :blog_id AND client_id = :client_id ";
$stmt = $pdo->prepare($sql);
$params = array(
	":blog_id" => $blog_id,
	":client_id" => $user['id']
);
$stmt->execute($params);
$blog_category_masters = $stmt->fetchAll();

//カテゴリーのチェックを登録したものにあらかじめチェックを入れる
foreach((array) $blog_category_masters as $val){
	$checked["category_id"][$val['blog_category_code']]=" ";
}

// 初めて画面にアクセスした時の処理
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	// CSRF対策
	setToken();

//	$_SESSION['blog_entry_code']='';

	if(isset($id)){
		//登録している記事の各項目をデータベースから取得
		$sql = "SELECT * FROM blog_entry WHERE blog_entry_code = :blog_entry_code AND client_id = :client_id LIMIT 1";
		$stmt = $pdo->prepare($sql);
		$params = array(
			":blog_entry_code" => $id,
			":client_id" => $user['id']
		);
		$stmt->execute($params);
		$blog_entry = $stmt->fetch();


		if(isset($blog_entry['eye_catch_image'])){

			$blog_entry_eye_catch['eye_catch_image'] = $blog_entry['eye_catch_image'];
			$blog_entry_eye_catch['eye_catch_image_ext'] = $blog_entry['eye_catch_image_ext'];

		}else{

			$blog_entry_eye_catch['eye_catch_image'] = $blog['blog_default_eye_catch_image'];
			$blog_entry_eye_catch['eye_catch_image_ext'] = $blog['blog_default_eye_catch_image_ext'];

		}


		$title = $blog_entry['title'];
		$slug = $blog_entry['slug'];
		$contents = $blog_entry['contents'];
		$posting_date =   $blog_entry['posting_date'];
		$seo_description = $blog_entry['seo_description'];
		$seo_keywords = $blog_entry['seo_keywords'];
		$status = $blog_entry['status'];

	}

} else {
	// フォームからサブミットされた時の処理
	$new_category_name = $_POST['category_name'];
	//カテゴリー名を取得していないときの処理
	if(!isset($new_category_name)){

		checkToken();

		//blog_entry_code取得
		if(!empty($_POST['code'])){

			$start_blog_entry_code = $_POST['code'];

		}


		$err = array();
		$complete_msg = "";

		//登録した記事の各項目を取得
		if($start_blog_entry_code!=''){
			//登録している記事の各項目をデータベースから取得
			$sql = "SELECT * FROM blog_entry WHERE blog_entry_code = :blog_entry_code AND client_id = :client_id LIMIT 1";
			$stmt = $pdo->prepare($sql);
			$params = array(
				":blog_entry_code" => $start_blog_entry_code,
				":client_id" => $user['id']
			);
			$stmt->execute($params);
			$blog_entry2 = $stmt->fetch();
		}

//error_log($start_blog_entry_code,3,"./error.log");
		$title = $_POST['title'];
		$contents = $_POST['contents'];
		$posting_date = $_POST['posting_date'];
		$seo_description = $_POST['seo_description'];
		$seo_keywords = $_POST['seo_keywords'];
		$slug = $_POST['slug'];
		$category_id = $_POST['category_id'];

		if(isset($_POST['status'])){
			$status = 1;
		} else {
			$status = 2;
		};

		//カテゴリーのチェックを登録したものにあらかじめチェックを入れる
		foreach((array) $blog_category_masters as $val){
			$checked["category_id"][$val['blog_category_code']]=" ";
		}

		if(isset($_POST["category_id"])){
			foreach((array) $_POST["category_id"] as $val){
				$checked["category_id"][$val]=" checked";
			}
		}



		//client_id,blog_idを確認
		$sql = "SELECT * FROM blog_entry_code_sequence WHERE blog_id = :blog_id AND client_id = :client_id LIMIT 1";
		$stmt = $pdo->prepare($sql);
		$params = array(
			":blog_id" => $blog_id,
			":client_id" => $user['id']
		);
		$stmt->execute($params);
		$blog_entry_code_sequence = $stmt->fetch();

		$default_err = array();

		$blog_entry_eye_catch['eye_catch_image'] ='';
		$blog_entry_eye_catch['eye_catch_image_ext'] ='';

		$file_upload_array_default = file_upload('eye_catch_image', $default_err);


		if($file_upload_array_default['file'] ==''){

			if (isset($blog_entry2['eye_catch_image'])) {
				// 画像が存在するときの処理

				$blog_entry_eye_catch['eye_catch_image'] = $blog_entry2['eye_catch_image'];
				$blog_entry_eye_catch['eye_catch_image_ext'] = $blog_entry2['eye_catch_image_ext'];

			} else {
				//画像が存在しない時の処理

				$blog_entry_eye_catch['eye_catch_image'] = $blog['blog_default_eye_catch_image'];
				$blog_entry_eye_catch['eye_catch_image_ext'] = $blog['blog_default_eye_catch_image_ext'];

			}
		} else {

			$blog_entry_eye_catch['eye_catch_image'] = fread($file_upload_array_default['file'], filesize($_FILES['eye_catch_image']['tmp_name']));
			$blog_entry_eye_catch['eye_catch_image_ext'] = $file_upload_array_default['ext'];

		}

		//error_log($file_upload_array_default['file'],3,"./error.log");
		//error_log($file_upload_array_default['size'],3,"./error.log");
		//error_log($blog_entry['eye_catch_image'],3,"./error.log");
		//error_log($blog_entry['eye_catch_image_ext'],3,"./error.log");


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
		$sql = "SELECT * FROM blog_entry WHERE blog_id =:blog_id AND slug = :slug  LIMIT 1";
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
			if (strlen(mb_convert_encoding($seo_description, 'SJIS', 'UTF-8')) > 500) {
				$err['seo_description'] = 'SEO説明文は500バイト以内で入力して下さい。';
			}
		}

		// SEOキーワードが空
		if ($seo_keywords == '') {
			$err['seo_keywords'] = 'SEOキーワードを入力して下さい。';
		} else {
			// 文字数チェック
			if (strlen(mb_convert_encoding($seo_keywords, 'SJIS', 'UTF-8')) > 200) {
				$err['seo_keywords'] = 'SEOキーワードは200バイト以内で入力して下さい。';
			}
		}

		//client_id,blog_idを確認
		$sql = "SELECT * FROM blog_entry_code_sequence WHERE blog_id = :blog_id AND client_id = :client_id LIMIT 1";
		$stmt = $pdo->prepare($sql);
		$params = array(
			":blog_id" => $blog_id,
			":client_id" => $user['id']
		);
		$stmt->execute($params);
		$blog_entry_code_sequence = $stmt->fetch();

		if(!isset($id)&& $start_blog_entry_code ==''){

				//ブログカテゴリーコードのシーケンスがなかった場合
				if ($blog_entry_code_sequence['sequence'] == '') {
					$sql = "INSERT INTO blog_entry_code_sequence
					(client_id, blog_id, sequence, created_at, updated_at)
					VALUES
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
					//シーケンスがあった場合
					$sql = "UPDATE blog_entry_code_sequence
					SET
					blog_id = :blog_id,
					sequence = :sequence,
					updated_at =now()
					WHERE
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
		}else{
			if($start_blog_entry_code!=''){

			$blog_entry_code = $start_blog_entry_code;

			}

		}

error_log($start_blog_entry_code,3,"./error.log");
//error_log($blog_entry_code,3,"./error.log");
		if (empty($err)) {

			if(!isset($id) && $start_blog_entry_code ==''){


				// 登録処理
				$sql = "INSERT INTO blog_entry
				(blog_entry_code, title, contents, posting_date, seo_description, seo_keywords, status, slug, client_id, blog_id, eye_catch_image, eye_catch_image_ext, created_at, updated_at)
				VALUES
				(:blog_entry_code, :title, :contents, :posting_date, :seo_description, :seo_keywords, :status, :slug, :client_id, :blog_id, :eye_catch_image, :eye_catch_image_ext, now(), now())";
				$stmt = $pdo->prepare($sql);

				$stmt->bindValue(':blog_entry_code', $blog_entry_code, PDO::PARAM_STR);
				$stmt->bindValue(':title', $title, PDO::PARAM_STR);
				$stmt->bindValue(':contents', $contents, PDO::PARAM_STR);
				$stmt->bindValue(':posting_date', $posting_date, PDO::PARAM_STR);
				$stmt->bindValue(':seo_description', $seo_description, PDO::PARAM_STR);
				$stmt->bindValue(':seo_keywords', $seo_keywords, PDO::PARAM_STR);
				$stmt->bindValue(':status', $status, PDO::PARAM_STR);
				$stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
				$stmt->bindValue(':client_id', (int)$user['id'], PDO::PARAM_INT);
				$stmt->bindValue(':blog_id', (int)$blog_id, PDO::PARAM_INT);
				$stmt->bindValue(':eye_catch_image', $blog_entry_eye_catch['eye_catch_image'], PDO::PARAM_LOB);
				$stmt->bindValue(':eye_catch_image_ext', $blog_entry_eye_catch['eye_catch_image_ext'], PDO::PARAM_STR);
				$stmt->execute();



				//カテゴリー登録処理
				$sql = "SELECT * FROM blog_entry ORDER BY id DESC LIMIT 1";
				$stmt = $pdo->prepare($sql);
				$stmt->execute();
				$blog_entry3 = $stmt->fetch();

				foreach((array)$category_id as $val){
					$sql = "SELECT * FROM blog_category_master WHERE blog_id =:blog_id and client_id =:client_id and blog_category_code =:blog_category_code limit 1";
					$stmt = $pdo->prepare($sql);
					$params = array(
						":blog_id" => $blog_id,
						":client_id" => $user['id'],
						":blog_category_code" => $val
					);
					$stmt->execute($params);

					$blog_category_master[$val] = $stmt->fetch();

					$sql = "INSERT INTO blog_category
					(status, client_id, blog_id, blog_entry_id, blog_category_master_id, created_at, updated_at)
					VALUES
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

				if($start_blog_entry_code!=''){
					$id =$start_blog_entry_code;
				}


				//登録した各項目を更新
				$sql = "UPDATE blog_entry
				SET
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
				WHERE
				client_id = :client_id AND
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
					":eye_catch_image" => $blog_entry_eye_catch['eye_catch_image'],
					":eye_catch_image_ext" => $blog_entry_eye_catch['eye_catch_image_ext'],
					":client_id" => $user['id'],
					":blog_entry_code" => $id
				);
				$stmt->execute($params);

				//カテゴリーを更新
				$sql = "SELECT * FROM blog_entry WHERE client_id = :client_id AND blog_entry_code = :blog_entry_code LIMIT 1";
				$stmt = $pdo->prepare($sql);
				$params = array(
					":client_id" => $user['id'],
					":blog_entry_code" => $id
				);
				$stmt->execute($params);
				$blog_entry3 = $stmt->fetch();

				foreach((array)$category_id as $val){

					$sql = "SELECT * FROM blog_category_master WHERE blog_id =:blog_id AND client_id =:client_id AND blog_category_code =:blog_category_code LIMIT 1";
					$stmt = $pdo->prepare($sql);
					$params = array(
						":blog_id" => $blog_id,
						":client_id" => $user['id'],
						":blog_category_code" => $val
					);
					$stmt->execute($params);

					$blog_category_master[$val] = $stmt->fetch();

					$sql = "UPDATE blog_category
					SET
					status = :status,
					client_id =:client,
					blog_id =:blog_id,
					blog_entry_id =:blog_entry_id,
					blog_category_master_id =:blog_category_master_id,
					updated_at = now()
					WHERE
					client_id = :client_id AND
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

		//登録している記事の各項目をデータベースから取得
		$sql = "SELECT * FROM blog_entry ORDER BY id DESC LIMIT 1";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$blog_entry = $stmt->fetch();

	}else{
		//新しいカテゴリー名を取得しているときの処理
		// カテゴリー登録処理
		$sql = "SELECT * FROM blog_category_code_sequence WHERE blog_id = :blog_id AND client_id = :client_id LIMIT 1";
		$stmt = $pdo->prepare($sql);
		$params = array(
			":blog_id" => $blog_id,
			":client_id" => $user['id']
		);
		$stmt->execute($params);
		$blog_category_code_sequence = $stmt->fetch();


		//ブログカテゴリーコードのシーケンスがなかった場合
		if ($blog_category_code_sequence['sequence'] == '') {
			$sql = "INSERT INTO blog_category_code_sequence
			(client_id, blog_id, sequence, created_at, updated_at)
			VALUES
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
			//ブログカテゴリーコードのシーケンスがあった場合
			$sql = "UPDATE blog_category_code_sequence
			SET
			blog_id = :blog_id,
			sequence = :sequence,
			updated_at =now()
			WHERE
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

		//新しいブログカテゴリー登録処理
		$sql = "INSERT INTO blog_category_master
		(client_id, blog_id, blog_category_code, category_name, created_at, updated_at)
		VALUES
		(:client_id, :blog_id, :blog_category_code, :category_name, now(), now())";
		$stmt = $pdo->prepare($sql);
		$params = array(
			":client_id" => $user['id'],
			":blog_id" => $blog_id,
			":blog_category_code" => $blog_category_code,
			":category_name" => $new_category_name
		);
		$stmt->execute($params);

		//登録処理の確認
		$sth = $pdo -> query($sql);
		$count = $stmt-> rowCount();

		if($count = 1){
			$status = 1;
		} else {
			$status = 2;
		};

		$data['status'] = $status;
		$data['blog_category_code'] = $blog_category_code ;

		//body_blog_entryにデータを送る
		header("Content-type: application/json; charset=UTF-8");
		echo json_encode($data);
		exit;

	}

}

// パンくずリスト設定
$breadcrumb_list = array();
$breadcrumb_list[0]['title'] = 'HOME';
$breadcrumb_list[0]['url'] = SITE_URL;
$breadcrumb_list[1]['title'] = 'ブログ記事作成';
$breadcrumb_list[1]['url'] = '';

?>
<?php include(TEMPLATE_PATH."/template_head.php"); ?>

<!-- end #sidebar -->

<!-- begin #content -->
<div id="content" class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<?php include(TEMPLATE_PATH."/breadcrumb.php"); ?>
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
							<?php if(isset($posting_date)):?>
								<input type="text" name="posting_date" class="form-control " placeholder="投稿日時" value="<?php echo h($posting_date) ;?>" /><span class="help-block"><?php if ( isset($err['posting_date'])) echo h($err['posting_date']); ?></span>
							<?php else:?>
								<input type="text" name="posting_date" class="form-control " placeholder="投稿日時" value="<?php echo date("Y/m/d H:i:s");?>" /><span class="help-block"><?php if ( isset($err['posting_date'])) echo h($err['posting_date']); ?></span>
							<?php endif;?>
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
					<div class="image-preview m-b-4"><img src="<?php echo get_base64_header_string($blog_entry_eye_catch['eye_catch_image_ext']) ?><?php echo base64_encode($blog_entry_eye_catch['eye_catch_image']);?>"  class="img-responsive width-full m-b-5" />
					</div>




					<?php// echo fclose(fread($blog_entry_eye_catch['eye_catch_image'])); ?>



					<label class="m-t-1 m-b-1">
						<span class="btn btn-inverse p-l-40 p-r-40 btn-sm">
							<i class="fa fa-image"></i> アイキャッチ画像
							<input type="file" name="eye_catch_image" value="<img src="<?php echo get_base64_header_string($blog_entry_eye_catch['eye_catch_image_ext']) ?><?php echo base64_encode($blog_entry_eye_catch['eye_catch_image']);?>"  class="img-responsive width-full m-b-5"  style="display:none"><span class="help-block"><?php if ( isset($default_err['eye_catch_image'])) echo h($default_err['eye_catch_image']); ?></span>
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
<?php error_log($blog_entry_code,3,"./error.log"); ?>
		<input type="hidden" name="code" value="<?php if(isset($blog_entry_code)) echo h($blog_entry_code);?>" />
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
