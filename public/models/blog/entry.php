<?php

//変数を設定

$blog_entry = array();
$blog_category = array();
$blog_entrys = array();
$blog_entry_rankings = array();
$blog_categorys2 = array();
$blog_categorys3 = array();
$random_blog_categorys = array();
$blog_categorys_entrys = array();
$shuffle_blog_categorys = array();
$blog_category_master = array();
$blog_category_masters0 = array();

$date = new DateTime();
$date->setTimeZone(new DateTimeZone('Asia/Tokyo'));
$date->modify('+1 day');
$today = $date->format('Y-m-d H:i:s');


$end_path_arr = array();
$end_path_arr = end($path_arr);


//URLからデータを取り出し

if (startsWith($request_path,'/'.$client_code.'/entry')) {
	$new_entry_code2 = str_replace('.html','',$end_path_arr);

	$new_entry_code = urldecode($new_entry_code2);
}else{
	$new_entry_code_slug2 = str_replace('.html','',$end_path_arr);

	$new_entry_code_slug = urldecode($new_entry_code_slug2);
}


//blog_entry_codeかslugかを判定
if (startsWith($request_path,'/'.$client_code.'/entry')) {
	$sql = "SELECT * FROM blog_entry WHERE blog_id = :blog_id AND client_id = :client_id AND status =:status AND posting_date <= :posting_date AND blog_entry_code = :blog_entry_code ";
	$stmt = $pdo->prepare($sql);
	$params = array(
		":blog_id" => $blog_id,
		":client_id" => $client['id'],
		":status" => 1,
		":posting_date" => $today,
		":blog_entry_code" =>$new_entry_code
	);
	$stmt->execute($params);
	$blog_entry = $stmt->fetch();


}else{

	$sql = "SELECT * FROM blog_entry WHERE blog_id = :blog_id AND client_id = :client_id  AND status = :status AND posting_date <= :posting_date AND slug =:slug ";
	$stmt = $pdo->prepare($sql);
	$params = array(
		":blog_id" => $blog_id,
		":client_id" => $client['id'],
		":status" => 1,
		":posting_date" => $today,
		":slug" => $new_entry_code_slug
	);
	$stmt->execute($params);
	$blog_entry = $stmt->fetch();

}

// 記事が非公開の時
if ($blog_entry['status'] !=1) {
	$err['status'] = '記事は非公開です';
}

//カテゴリーを取得

$sql = "SELECT * FROM blog_category WHERE blog_id = :blog_id AND client_id = :client_id AND blog_entry_id =:blog_entry_id ";
$stmt = $pdo->prepare($sql);
$params = array(
	":blog_id" => $blog_id,
	":client_id" => $client['id'],
	":blog_entry_id" => $blog_entry['blog_entry_code']
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
		":client_id" => $client['id'],
		":id" => $val['blog_category_master_id']
	);
	$stmt->execute($params);
	$blog_category_masters0[$val['blog_category_master_id']] = $stmt->fetch();



	//error_log($val['blog_category_master_id'],3,"./error.log");
}


//$sql = "SELECT * FROM blog_category_master WHERE blog_id = :blog_id AND client_id = :client_id AND id = :id ";
//$stmt = $pdo->prepare($sql);
//$params = array(
//	":blog_id" => $blog_id,
//	":client_id" => $client['id'],
//	":id" => $blog_category['blog_category_master_id']
//);
//$stmt->execute($params);
//$blog_category_master = $stmt->fetch();

//カテゴリーが一致する記事を４つ取得

if (!empty($blog_categorys0)){

$sql = "SELECT * FROM blog_category WHERE blog_id = :blog_id AND client_id = :client_id AND blog_category_master_id = :blog_category_master_id ";
$stmt = $pdo->prepare($sql);
$params = array(
	":blog_id" => $blog_id,
	":client_id" => $client['id'],
	":blog_category_master_id" => $blog_categorys0[0]['blog_category_master_id'],
);
$stmt->execute($params);
$blog_categorys3 = $stmt->fetchAll();

shuffle($blog_categorys3);

$blog_categorys3 = array_filter($blog_categorys3);

$random_blog_categorys = array_slice($blog_categorys3 , 0, 4);


foreach ($random_blog_categorys as $val4){

	$sql = "SELECT * FROM blog_entry WHERE blog_entry_code = :blog_entry_code AND status =:status AND posting_date <= :posting_date ";
	$stmt = $pdo->prepare($sql);
	$params = array(
		":blog_entry_code" => $val4['blog_entry_id'],
		":status" => 1,
		":posting_date" => $today
	);
	$stmt->execute($params);
	$blog_categorys_entrys[$val4['blog_entry_id']] = $stmt->fetch();

}

}

//カテゴリーにslugが有るかどうか判定
if(isset($blog_category_master['blog_category_code'])){

	$blog_category_code = $blog_category_master['blog_category_code'];
}elseif(isset($blog_category_master['blog_category_slug'])){

	$blog_category_code = $blog_category_master['blog_category_slug'];

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

	<meta name="description" content="<?php echo $blog_entry['seo_description']; ?>">
	<meta name="keywords" content="<?php echo $blog_entry['seo_keywords']; ?>" />
	<meta name="author" content="<?php echo $blog["blog_author_name"]; ?>">

	<link rel="icon" type="image/vnd.microsoft.icon" href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=favicon">
	<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=favicon">
	<link rel="apple-touch-icon" sizes="180x180" href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=favicon180">

	<?php if (startsWith($request_path,'/'.$client_code.'/entry')) :?>
		<link rel="canonical" href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/entry/<?php echo h($blog_entry['blog_entry_code']); ?>.html" />
	<?php else : ?>
		<link rel="canonical" href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/<?php echo h($blog_entry['slug']); ?>.html" />
	<?php endif; ?>

	<link rel="alternate" type="application/rss+xml" title="<?php echo $blog["title"]; ?> &raquo; フィード" href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/feed/" />

	<meta property="og:locale" content="ja_JP" />
	<meta property="og:site_name" content="<?php echo $blog["blog_title"]; ?>" />
	<meta property="og:title" content="<?php echo $blog_entry['title']; ?>" />
	<meta property="og:description" content="<?php echo $blog_entry['seo_description']; ?>" />

	<?php if (startsWith($request_path,'/'.$client_code.'/entry')) :?>
		<meta property="og:url" content="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/entry/<?php echo h($blog_entry['blog_entry_code']); ?>.html" />
	<?php else : ?>
		<meta property="og:url" content="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/<?php echo h($blog_entry['slug']); ?>.html" />
	<?php endif; ?>

	<meta property="og:type" content="article" />
	<meta property="og:image" content="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=eyecatch&e=<?php echo h($blog_entry['blog_entry_code']); ?>" />

	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:site" content="@" />
	<meta name="twitter:title" content="<?php echo $blog_entry['title']; ?>" />
	<meta name="twitter:description" content="<?php echo $blog_entry['sel_description']; ?>" />
	<meta name="twitter:image" content="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=eyecatch&e=<?php echo h($blog_entry['blog_entry_code']); ?>" />

	<meta property="fb:admins" content="" />
	<meta property="fb:app_id" content="" />

	<meta property="article:published_time" content="<?php echo h($blog_entry['posting_date']); ?>" />
	<meta property="article:modified_time" content="<?php echo h($blog_entry['updated_at']); ?>" />

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

		<div class="m-l-10 m-r-10 <?php if ($err['status'] != '') echo 'has-error'; ?>" >
			<span class="help-block"><?php if ( isset($err['status'])) echo h($err['status']); ?></span>
		</div>

		<div class="blog-post panel">
			<div class="blog-post-posting-date">
				<i class="fa fa-clock-o"></i> <?php echo h($blog_entry['posting_date']); ?>&nbsp;&nbsp;&nbsp;
				<i class="fa fa-refresh"></i> <?php echo h($blog_entry['created_at']); ?>						</div>

				<h1 class="blog-post-title"><?php echo $blog_entry['title']; ?></h1>

				<p class="blog-post-category-area" style="margin-bottom:40px;text-align:center;">
					<?php if (!isset($err['status'])):?>
						<?php if (isset($blog_category_masters0)):?>
								<?php foreach ($blog_category_masters0 as $val): ?>

										<?php if (empty($val['blog_category_slug']))  : ?>
											<a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/category/<?php echo h($val['blog_category_code']); ?>.html"><span class="blog-list-category-name"><i class="fa fa-folder-open"></i> <?php echo h($val['category_name']);?></span></a>
										<?php else : ?>
											<a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/category/<?php echo h($val['blog_category_slug']); ?>"><span class="blog-list-category-name"><i class="fa fa-folder-open"></i> <?php echo h($val['category_name']);?></span></a>
										<?php endif; ?>

								<?php endforeach ;?>
						<?php endif ;?>

					<?php endif ;?>
							</p>

							<?php if(isset($blog_entry['eye_catch_image'])) :?>

								<figure class="blog-post-eyecatch-img">
									<img src="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=eyecatch&e=<?php echo h($blog_entry['blog_entry_code']); ?>" alt="<?php echo $blog_entry['title']; ?>" class="img-responsive" />
								</figure>

							<?php elseif($blog_entry['status']!==1):?>

								<figure class="blog-post-eyecatch-img">
								</figure>

							<?php else:?>

								<figure class="blog-post-eyecatch-img">
									<img src="<?php echo get_base64_header_string($blog['blog_default_eye_catch_image_ext']) ?><?php echo base64_encode($blog['blog_default_eye_catch_image']);?>"  class="img-responsive width-full m-b-5" />
								</figure>

							<?php endif;?>

							<p style="blog-post-contents;margin-top:40px;"><?php echo $blog_entry['contents']; ?></p>




							<!--
							<div class="entry-pager">



							<div class="entry-pager-previous">
							<a href="http://b.blog-system-5884.localhost/client_code/how-to-web-programmer.html">【次の記事】 初心者がプログラミングを学ぶには、何から勉強すれば良いか？ <i class="fa fa-angle-right"></i></a>
						</div>


					</div>
				-->


				<?php if (empty($blog_categorys_entrys)): ?>
					<span class="relation-entry"></span>
				<?php else : ?>
					<span class="relation-entry">おすすめ記事</span>
				<?php endif; ?>
				<div class="row">

					<?php foreach ($blog_categorys_entrys as $val3): ?>
						<div class="col-md-3 col-sm-6 blog-entry-relation-area">

							<?php if (empty($val3['slug'])): ?>
								<a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/entry/<?php echo h($val3['blog_entry_code']) ; ?>.html" title="<?php echo $val3['title'] ; ?>">
								<?php else : ?>
									<a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/<?php echo h($val3['slug']) ; ?>.html" title="<?php echo $val3['title'] ; ?>">
									<?php endif; ?>
									<div class="blog-entry-relation-eyecatch-area">

										<figure class="blog-entry-relation-eyecatch">
											<img src="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=eyecatch&e=<?php echo h($val3['blog_entry_code']) ; ?>" alt="<?php echo $val3['title'] ; ?>" class="img-responsive" />
										</figure>

										<p class="relation-posting-date"><?php echo date('Y-m-d',strtotime(h($val3['posting_date']))); ?></p>
										<p class="relation-entry-title"><?php echo $val3['title']; ?></p>
									</div>
								</a>
							</div>
						<?php endforeach; ?>


					</div>


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
							<form action="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/" method="GET">
								<input type="text" class="form-control" name="q" id="q" placeholder="記事を検索" value="<?php if(isset($search_keyword)) echo h($search_keyword); ?>">
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

												<?php if (empty($val['eye_catch_image'])):?>

													<figure class="sidebar-popular-list-entry-eyecatch">
														<img src="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=eyecatch_top; ?>" class="img-responsive" alt="" />
													</figure>

												<?php else :?>

													<figure class="sidebar-popular-list-entry-eyecatch">
														<img src="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=eyecatch&e=<?php echo h($val['blog_entry_code']); ?>" class="img-responsive" alt="" />
													</figure>

												<?php endif; ?>

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

											<?php if (empty($val['blog_category_slug']))  : ?>
												<li class="sidebar-category-name"><a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/category/<?php echo h($val['blog_category_code']); ?>.html"> <?php echo h($val['category_name']); ?> (<?php echo $count2[$val['id']]['cnt2'] ;?>)</a></li>
											<?php else : ?>
												<li class="sidebar-category-name"><a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/category/<?php echo h($val['blog_category_slug']); ?>"> <?php echo h($val['category_name']); ?> (<?php echo $count2[$val['id']]['cnt2'] ;?>)</a></li>
											<?php endif; ?>

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
