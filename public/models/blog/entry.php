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

$date = new DateTime();
$date->setTimeZone(new DateTimeZone('Asia/Tokyo'));
$today = $date->format('Y-m-d');

$end_path_arr = array();
$end_path_arr = end($path_arr);

//URLからデータを取り出し
if(endsWith($end_path_arr,'html')) {

	$new_entry_code = str_replace('.html','',$end_path_arr);

}else{

	$new_entry_code = $end_path_arr;

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
		":slug" => $new_entry_code
	);
	$stmt->execute($params);
	$blog_entry = $stmt->fetch();


}

//カテゴリーを取得

$sql = "SELECT * FROM blog_category WHERE blog_id = :blog_id AND client_id = :client_id AND blog_entry_id =:blog_entry_id ";
$stmt = $pdo->prepare($sql);
$params = array(
	":blog_id" => $blog_id,
	":client_id" => $client['id'],
	":blog_entry_id" => $blog_entry['id']
);
$stmt->execute($params);
$blog_category = $stmt->fetch();


$sql = "SELECT * FROM blog_category_master WHERE blog_id = :blog_id AND client_id = :client_id AND id = :id ";
$stmt = $pdo->prepare($sql);
$params = array(
	":blog_id" => $blog_id,
	":client_id" => $client['id'],
	":id" => $blog_category['blog_category_master_id']
);
$stmt->execute($params);
$blog_category_master = $stmt->fetch();

//カテゴリーが一致する記事を４つ取得

$sql = "SELECT * FROM blog_category WHERE blog_id = :blog_id AND client_id = :client_id AND blog_category_master_id = :blog_category_master_id AND blog_entry_id!= :blog_entry_id";
$stmt = $pdo->prepare($sql);
$params = array(
	":blog_id" => $blog_id,
	":client_id" => $client['id'],
	":blog_category_master_id" => $blog_category['blog_category_master_id'],
	":blog_entry_id" => $blog_entry['id']
);
$stmt->execute($params);
$blog_categorys3 = $stmt->fetchAll();

shuffle($blog_categorys3);

$random_blog_categorys = array_slice($blog_categorys3 , 0, 4);


foreach ($random_blog_categorys as $val4){

	$sql = "SELECT * FROM blog_entry WHERE id = :id AND status =:status AND posting_date <= :posting_date ";
	$stmt = $pdo->prepare($sql);
	$params = array(
		":id" => $val4['blog_entry_id'],
		":status" => 1,
		":posting_date" => $today
	);
	$stmt->execute($params);
	$blog_categorys_entrys[$val4['blog_entry_id']] = $stmt->fetch();

}



//カテゴリーにslugが有るかどうか判定
if(isset($blog_category_master['blog_category_code'])){

	$blog_category_code = $blog_category_master['blog_category_code'];
}else{

	$blog_category_code = $blog_category_master['blog_category_slug'];

}


//人気記事ランキング

$sql = "SELECT * FROM blog_entry WHERE blog_id = :blog_id AND client_id = :client_id ORDER BY view_count DESC LIMIT 10";
$stmt = $pdo->prepare($sql);
$params = array(
	":blog_id" => $blog_id,
	":client_id" => $client['id']
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

	<title><?php echo h($blog_entry['title']); ?></title>

	<meta name="description" content="<?php echo h($blog_entry['seo_description']); ?>">
	<meta name="keywords" content="<?php echo h($blog_entry['seo_keywords']); ?>" />
	<meta name="author" content="<?php echo h($blog["blog_author_name"]); ?>">

	<link rel="icon" type="image/vnd.microsoft.icon" href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=favicon">
	<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=favicon">
	<link rel="apple-touch-icon" sizes="180x180" href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=favicon180">

	<?php if (startsWith($request_path,'/'.$client_code.'/entry')) :?>
		<link rel="canonical" href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/entry/<?php echo h($blog_entry['blog_entry_code']); ?>.html" />
	<?php else : ?>
		<link rel="canonical" href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/<?php echo h($blog_entry['slug']); ?>.html" />
	<?php endif; ?>

	<link rel="alternate" type="application/rss+xml" title="<?php echo h($blog["title"]); ?> &raquo; フィード" href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/feed/" />

	<meta property="og:locale" content="ja_JP" />
	<meta property="og:site_name" content="<?php echo h($blog["blog_title"]); ?>" />
	<meta property="og:title" content="<?php echo h($blog_entry['title']); ?>" />
	<meta property="og:description" content="<?php echo h($blog_entry['seo_description']); ?>" />

	<?php if (startsWith($request_path,'/'.$client_code.'/entry')) :?>
		<meta property="og:url" content="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/entry/<?php echo h($blog_entry['blog_entry_code']); ?>.html" />
	<?php else : ?>
		<meta property="og:url" content="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/<?php echo h($blog_entry['slug']); ?>.html" />
	<?php endif; ?>

	<meta property="og:type" content="article" />
	<meta property="og:image" content="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=eyecatch&e=<?php echo h($blog_entry['blog_entry_code']); ?>" />

	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:site" content="@" />
	<meta name="twitter:title" content="<?php echo h($blog_entry['title']); ?>" />
	<meta name="twitter:description" content="<?php echo h($blog_entry['sel_description']); ?>" />
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
			<a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/"><img src="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=blog_header" alt="<?php echo h($blog['blog_title']); ?>" class="img-responsive" /></a>
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
				<i class="fa fa-clock-o"></i> <?php echo h($blog_entry['posting_date']); ?>&nbsp;&nbsp;&nbsp;
				<i class="fa fa-refresh"></i> <?php echo h($blog_entry['created_at']); ?>						</div>

				<h1 class="blog-post-title"><?php echo h($blog_entry['title']); ?></h1>

				<p class="blog-post-category-area" style="margin-bottom:40px;text-align:center;">

					<?php if (empty($blog_category_master['category_name']))  : ?>
						<a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/category/<?php echo h($blog_category_code); ?>.html"><span class="blog-list-category-name"><i class="fa fa-folder-open"></i> 未分類</span></a>
					<?php else : ?>
						<a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/category/<?php echo h($blog_category_code); ?>.html"><span class="blog-list-category-name"><i class="fa fa-folder-open"></i> <?php echo h($blog_category_master['category_name']);?></span></a>
					<?php endif; ?>

				</p>

				<figure class="blog-post-eyecatch-img">
					<img src="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=eyecatch&e=<?php echo h($blog_entry['blog_entry_code']); ?>" alt="<?php echo h($blog_entry['title']); ?>" class="img-responsive" />
				</figure>



				<p style="blog-post-contents;margin-top:40px;"><?php echo h($blog_entry['contents']); ?></p>




				<!--
				<div class="entry-pager">



				<div class="entry-pager-previous">
				<a href="http://b.blog-system-5884.localhost/client_code/how-to-web-programmer.html">【次の記事】 初心者がプログラミングを学ぶには、何から勉強すれば良いか？ <i class="fa fa-angle-right"></i></a>
			</div>


		</div>
	-->


	<span class="relation-entry">おすすめ記事</span>
	<div class="row">

		<?php foreach ($blog_categorys_entrys as $val3): ?>
			<div class="col-md-3 col-sm-6 blog-entry-relation-area">

				<?php if (empty($val3['slug'])): ?>
					<a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/entry/<?php echo h($val3['blog_entry_code']) ; ?>.html" title="<?php echo h($val3['title']) ; ?>">
					<?php else : ?>
						<a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/<?php echo h($val3['slug']) ; ?>.html" title="<?php echo h($val3['title']) ; ?>">
						<?php endif; ?>
						<div class="blog-entry-relation-eyecatch-area">

							<figure class="blog-entry-relation-eyecatch">
								<img src="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=eyecatch&e=<?php echo h($val3['blog_entry_code']) ; ?>" alt="<?php echo h($val3['title']) ; ?>" class="img-responsive" />
							</figure>

							<p class="relation-posting-date"><?php echo date('Y-m-d',strtotime(h($val3['posting_date']))); ?></p>
							<p class="relation-entry-title"><?php echo h($val3['title']); ?></p>
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
					<span style="font-size:1.4em;font-weight:bold;">ハルジオン</span>
				</div>
				<div>
					<div class="sidebar-profile">
						Webプログラマー暦22年、2児の父。<br />
						<br />
						IT企業でWebプログラマーを15年ほどやっており、在職時は新人プログラマーの採用や育成なども担当。<br />
						<br />
						現在はその経験を活かして独立し、ネットを通じて多くの新人プログラマーを育成しています。<br />
						<br />
						日々思いついたアイデアをプログラミングで実現させ、ラーニングシステムやメルマガ配信システムなども全て自作。ほとんどの事務作業をプログラミングにより自動化し、より多くの時間を新しいアプリの開発や、家族との時間に充てています。<br />
						<br />
						僕の学んだノウハウを皆さんに伝授し、面白いアプリを一緒に開発していけるような仲間を世界中に作っていくことが目標です。<br />
						<br />
						具体的な方法に興味があれば、是非メルマガを読んでみて下さい。 <br />
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
						<a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/entry/<?php echo h($val['blog_entry_code']); ?>.html" title="<?php echo h($val['blog_title']); ?>">
						<?php else : ?>
							<a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/<?php echo h($val['slug']); ?>.html" title="<?php echo h($val['blog_title']); ?>">
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
										<?php echo h($val['title']); ?>										</div>
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
