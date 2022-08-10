<?php

$page_base_head_tag_template = "head_blog_entry.php";
$page_base_body_tag_template = "body_blog_entry.php";

$blog_entry_rankings = array();
$blog_categorys2 = array();
$blog_entry = array();
$client_code = array();

$date = new DateTime();
$date->setTimeZone(new DateTimeZone('Asia/Tokyo'));
$date->modify('+1 day');
$today = $date->format('Y-m-d H:i:s');

//client_codeを取得
$sql = "SELECT * FROM client WHERE id = :id LIMIT 1";
$stmt = $pdo->prepare($sql);
$params = array(
	":id" => $user['id']
);
$stmt->execute($params);
$client = $stmt->fetch();
$client_code = $client['client_code'];


//id取得
if (!empty($_REQUEST['id'])) {
$blog_entry_code = $_REQUEST['id'];
}


// 初めて画面にアクセスした時の処理
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	// CSRF対策
	setToken();

	$title = '';
	$contents = '';

} else {

	$title = $_POST['title'];
	$contents = $_POST['contents'];

	if(isset($blog_entry_code)){
		//登録している記事の各項目をデータベースから取得
		$sql = "SELECT * FROM blog_entry WHERE blog_entry_code = :blog_entry_code AND client_id = :client_id LIMIT 1";
		$stmt = $pdo->prepare($sql);
		$params = array(
			":blog_entry_code" => $blog_entry_code,
			":client_id" => $user['id']
		);
		$stmt->execute($params);
		$blog_entry2 = $stmt->fetch();

	}

	//アイキャッチ画像を取得

	$default_err = array();


	$file_upload_array_default = file_upload('eye_catch_image', $default_err);

	if($file_upload_array_default['file'] ==''){

		if(isset($blog_entry2['eye_catch_image_ext'])){

			$blog_entry['eye_catch_image'] = $blog_entry2['eye_catch_image'];
			$blog_entry['eye_catch_image_ext'] = $blog_entry2['eye_catch_image_ext'];
		}else{

			$blog_entry['eye_catch_image'] = $blog['blog_default_eye_catch_image'];
			$blog_entry['eye_catch_image_ext'] = $blog['blog_default_eye_catch_image_ext'];

		}


	} else {
		$blog_entry['eye_catch_image'] = fread($file_upload_array_default['file'], filesize($_FILES['eye_catch_image']['tmp_name']));
		$blog_entry['eye_catch_image_ext'] = $file_upload_array_default['ext'];

	}


}


//カテゴリーを取得

$sql = "SELECT * FROM blog_category WHERE blog_id = :blog_id AND client_id = :client_id AND blog_entry_id =:blog_entry_id ";
$stmt = $pdo->prepare($sql);
$params = array(
	":blog_id" => $blog_id,
	":client_id" => $user['id'],
	":blog_entry_id" => $blog_entry2['blog_entry_code']
);
$stmt->execute($params);
$blog_categorys0 = $stmt->fetchAll();

//カテゴリーマスター取得

//if(!empty($blog_categorys0)){}
foreach ($blog_categorys0 as $val){

$sql = "SELECT * FROM blog_category_master WHERE blog_id = :blog_id AND client_id = :client_id AND id = :id";
$stmt = $pdo->prepare($sql);
$params = array(
	":blog_id" => $blog_id,
	":client_id" => $user['id'],
	":id" => $val['blog_category_master_id']
);
$stmt->execute($params);
$blog_category_masters0[$val['blog_category_master_id']] = $stmt->fetch();

}


//人気記事ランキング

$sql = "SELECT * FROM blog_entry WHERE blog_id = :blog_id AND client_id = :client_id AND status =:status AND posting_date <= :posting_date ORDER BY view_count DESC LIMIT 10";
$stmt = $pdo->prepare($sql);
$params = array(
	":blog_id" => $blog_id,
	":client_id" => $client['id'],
	":status" => 1,
	":posting_date" => $today
);
$stmt->execute($params);
$blog_entry_rankings = $stmt->fetchAll();


//カテゴリー１覧取得

$sql = "SELECT * FROM blog_category_master WHERE blog_id = :blog_id AND client_id = :client_id";
$stmt = $pdo->prepare($sql);
$params = array(
	":blog_id" => $blog_id,
	":client_id" => $client['id']
);
$stmt->execute($params);
$blog_categorys2 = $stmt->fetchAll();

?>


<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?php echo $blog_entry['title']; ?></title>

	<link rel="icon" type="image/vnd.microsoft.icon" href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=favicon">
	<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=favicon">
	<link rel="apple-touch-icon" sizes="180x180" href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=favicon180">


	<link rel='dns-prefetch' href='//maxcdn.bootstrapcdn.com' />
	<link rel='dns-prefetch' href='//ajax.googleapis.com' />
	<link rel='dns-prefetch' href='//connect.facebook.net' />

	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/style.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>

<body>

	<div class="container">

		<div class="blog-header-img">
			<a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/"><img src="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=blog_header" alt="<?php echo $blog['blog_title']; ?>" class="img-responsive" /></a>
		</div>


		<!--			<div class="breadcrumb pc-only" style="overflow:hidden;">



		<div class="" style="float:right;">
		<a href="http://b.blog-system-5884.localhost/client_code/how-to-web-programmer.html">【次の記事】 初心者がプログラミングを学ぶには、何から勉強すれば良いか？<i class="fa fa-angle-double-right"></i></a>
	</div>


</div>
-->

<div class="row">

	<div id="main" class="col-md-8 col-sm-8 col-xs-12 blog-main">



		<div class="blog-post panel">
			<div class="blog-post-posting-date">
			</div>

			<h1 class="blog-post-title"><?php echo $title; ?></h1>

			<p class="blog-post-category-area" style="margin-bottom:40px;text-align:center;">
			<?php if (!isset($err['status'])):?>
				<?php //if (empty($blog_category_masters0))  : ?>
					<?php// echo "未分類"; ?>
				<?php //else : ?>
					<?php foreach ($blog_category_masters0 as $val): ?>

					<?php if (empty($val['blog_category_slug']))  : ?>
						<a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/category/<?php echo h($val['blog_category_code']); ?>.html"><span class="blog-list-category-name"><i class="fa fa-folder-open"></i> <?php echo h($val['category_name']);?></span></a>
					<?php else : ?>
						<a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/category/<?php echo h($val['blog_category_slug']); ?>"><span class="blog-list-category-name"><i class="fa fa-folder-open"></i> <?php echo h($val['category_name']);?></span></a>
					<?php endif; ?>

					<?php endforeach ;?>
				<?php //endif; ?>
			<?php //else :?>

			<?php endif ;?>
			</p>

			<figure class="blog-post-eyecatch-img">

				<?php if ($blog_entry['eye_catch_image_ext'] ==''): ?>
				<?php else: ?>
					<img src="<?php echo get_base64_header_string($blog_entry['eye_catch_image_ext']) ?><?php echo base64_encode($blog_entry['eye_catch_image']);?>"  class="img-responsive width-full m-b-5" />

				<?php endif; ?>
			</figure>


			<p style="blog-post-contents;margin-top:40px;"><?php echo $contents; ?></p>




			<!--
			<div class="entry-pager">



			<div class="entry-pager-previous">
			<a href="http://b.blog-system-5884.localhost/client_code/how-to-web-programmer.html">【次の記事】 初心者がプログラミングを学ぶには、何から勉強すれば良いか？ <i class="fa fa-angle-right"></i></a>
		</div>


	</div>
-->



</div>


</div>

<div id="sidebar" class="col-md-4 col-sm-4 col-xs-12 blog-sidebar">


	<div class="sidebar-module">
		<div class="panel">
			<div class="panel-body">


				<figure class="sidebar-profile-image">
					<img src="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=profile" class="img-responsive img-circle" alt="" style="width:150px" />
				</figure>


				<div style="padding:10px;margin-top:10px;text-align:center;">
					<span style="font-size:1.4em;font-weight:bold;"><?php echo $blog['blog_author_name']; ?></span>
				</div>
				<div>
					<div class="sidebar-profile">
						<?php echo $blog['blog_author_profile']; ?>
					</div>
					<div class="sidebar-sns" style="margin-top:10px;">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="sidebar-module">
		<div class="panel">
			<div class="panel-body">
				<form action="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>" method="GET">
					<input type="text" class="form-control" name="q" id="q" placeholder="記事を検索">
				</form>
			</div>
		</div>
	</div>

	<div class="sidebar-module">
		<div class="panel">
			<div class="panel-heading">
				<h2 class="panel-title"><i class="fa fa-trophy"></i> 人気記事ランキング</h2>
			</div>
			<div class="panel-body">


				<?php foreach ($blog_entry_rankings as $val): ?>

					<?php if(empty($val['slug'])) : ?>
						<a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/entry/<?php echo h($val['blog_entry_code']); ?>.html" title="<?php echo $val['blog_title']; ?>">
						<?php else : ?>
							<a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/<?php echo h($val['slug']); ?>.html" title="<?php echo $val['blog_title']; ?>">
							<?php endif; ?>
							<ul class="sidebar-list">
								<li class="sidebar-list-left">


									<figure class="sidebar-popular-list-entry-eyecatch">
										<img src="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=eyecatch&e=<?php echo h($val['blog_entry_code']); ?>" class="img-responsive" alt="" />
									</figure>


									<p>1</p>
								</li>
								<li class="sidebar-list-right">
									<div class="sidebar-popular-list-entry-title">
										<?php echo $val['title']; ?>										</div>
										<div class="sidebar-popular-list-entry-views">
											<?php echo h($val['view_count']); ?> Views
										</div>
									</li>
								</ul>
							</a>

						<?php endforeach; ?>



					</div>
				</div>
			</div>

			<div class="sidebar-module">
				<div class="panel">
					<div class="panel-heading">
						<h2 class="panel-title"><i class="fa fa-folder-open"></i> カテゴリー</h2>
					</div>
					<div class="panel-body">
						<ul class="sidebar-category-list">


							<?php foreach ($blog_categorys2 as $val): ?>
								<?php
								$sql = "SELECT COUNT(*) AS cnt2 FROM blog_category WHERE blog_id = :blog_id AND client_id = :client_id AND blog_category_master_id =:blog_category_master_id";
								$stmt = $pdo->prepare($sql);
								$params = array(
									":blog_id" => $blog_id,
									":client_id" => $client['id'],
									":blog_category_master_id" => $val['id']
								);
								$stmt->execute($params);
								$count2[$val['id']] = $stmt ->fetch();
								?>

								<li class="sidebar-category-name"><a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/category/<?php echo h($val['blog_category_code']); ?>.html"> <?php echo h($val['category_name']); ?> (<?php echo $count2[$val['id']]['cnt2'] ;?>)</a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>


		</div>
	</div>

</div>


<footer class="blog-footer">
	<!--<p class="blog-footer-left">プログラミング入門講座情報サイト</p>-->
	<p class="blog-footer-right">&copy; SENSE SHARE</p>
	<p><a href="#"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span>上に戻る</a></p>
</footer>
