<?php

//id取得
if(isset($_GET['id'])) {
	$id = $_GET['id'];
}

if(isset($_GET['ccode'])){
	$ccode = $_GET['ccode'];
}

//変数を設定
$blog_entry = array();
$blog_entrys = array();
$blog_categorys = array();
$blog_category = array();
$blog_entry_rankings = array();
$blog_categorys2 = array();
$blog_category2 = array();

//日付を取得
//$date = new DateTime();
//$date->setTimeZone(new DateTimeZone('Asia/Tokyo'));
//$today = $date->format('Y-m-d');

$date = new DateTime();
$date->setTimeZone(new DateTimeZone('Asia/Tokyo'));
$date->modify('+1 day');
$today = $date->format('Y-m-d H:i:s');

//検索のパラメーターの判定
if(!isset($_GET['q'])){

	if($path_arr[2] !='category'){
		//ブログの登録している記事を取得
		$sql = "SELECT * FROM blog_entry WHERE blog_id = :blog_id AND client_id = :client_id AND status =:status AND posting_date <= :posting_date ";
		$stmt = $pdo->prepare($sql);
		$params = array(
			":blog_id" => $blog_id,
			":client_id" => $client['id'],
			":status" => 1,
			":posting_date" => $today
		);
		$stmt->execute($params);
		$blog_entrys = $stmt->fetchAll();

	}else{
		//カテゴリーのslugが有るかどうか判定
		if(endsWith($path_arr[3],'html')||isset($ccode)) {

			//カテゴリー取得
			if(isset($ccode)){
				$new_category_code =$ccode;
			}else{
				$new_category_code = str_replace('.html','',$path_arr[3]);
			}
			$new_blog_category_master =array();
			$new_blog_categorys =array();

			$sql = "SELECT * FROM blog_category_master WHERE blog_id = :blog_id AND client_id = :client_id AND blog_category_code =:blog_category_code ";
			$stmt = $pdo->prepare($sql);
			$params = array(
				":blog_id" => $blog_id,
				":client_id" => $client['id'],
				":blog_category_code" => $new_category_code
			);
			$stmt->execute($params);
			$new_blog_category_master = $stmt->fetch();

			$sql = "SELECT * FROM blog_category WHERE blog_id = :blog_id AND client_id = :client_id AND blog_category_master_id =:blog_category_master_id ";
			$stmt = $pdo->prepare($sql);
			$params = array(
				":blog_id" => $blog_id,
				":client_id" => $client['id'],
				":blog_category_master_id" => $new_blog_category_master['id']
			);
			$stmt->execute($params);
			$new_blog_categorys = $stmt->fetchAll();

			if(isset($new_blog_categorys)){
				foreach ($new_blog_categorys as $val2){

					$sql = "SELECT * FROM blog_entry WHERE blog_id = :blog_id AND client_id = :client_id AND status =:status AND blog_entry_code = :blog_entry_code AND posting_date <= :posting_date ";
					$stmt = $pdo->prepare($sql);
					$params = array(
						":blog_id" => $blog_id,
						":client_id" => $client['id'],
						":status" =>1,
						":blog_entry_code" => $val2['blog_entry_id'],
						":posting_date" => $today
					);
					$stmt->execute($params);
					$blog_entrys[$val2['blog_entry_id']] = $stmt->fetch();

				}

				//error_log($blog_entrys,3,"./error.log");

			}

		}else{
			$new_category_code = $path_arr[3];

			$new_blog_category_master =array();
			$new_blog_categorys =array();

			$sql = "SELECT * FROM blog_category_master WHERE blog_id = :blog_id AND client_id = :client_id AND blog_category_slug =:blog_category_slug ";
			$stmt = $pdo->prepare($sql);
			$params = array(
				":blog_id" => $blog_id,
				":client_id" => $client['id'],
				":blog_category_slug" => $new_category_code
			);
			$stmt->execute($params);
			$new_blog_category_master = $stmt->fetch();

			$sql = "SELECT * FROM blog_category WHERE blog_id = :blog_id AND client_id = :client_id AND blog_category_master_id =:blog_category_master_id ";
			$stmt = $pdo->prepare($sql);
			$params = array(
				":blog_id" => $blog_id,
				":client_id" => $client['id'],
				":blog_category_master_id" => $new_blog_category_master['id']
			);
			$stmt->execute($params);
			$new_blog_categorys = $stmt->fetchAll();

			foreach ($new_blog_categorys as $val2){

				$sql = "SELECT * FROM blog_entry WHERE blog_entry_code = :blog_entry_code AND status =:status AND posting_date <= :posting_date ";
				$stmt = $pdo->prepare($sql);
				$params = array(
					":blog_entry_code" => $val2['blog_entry_id'],
					":status" => 1,
					":posting_date" => $today
				);
				$stmt->execute($params);
				$blog_entrys[$val2['blog_entry_id']] = $stmt->fetch();
			}
		}


	}



	//検索機能
}else{

	$search_keyword = $_GET['q'];

	$search_value = $search_keyword;

	$sql = "SELECT * FROM blog_entry WHERE  blog_id = :blog_id AND client_id = :client_id AND status =:status AND posting_date <= :posting_date AND (title LIKE '%$search_keyword%' OR contents LIKE '%$search_keyword%' ) ORDER BY id  ";
	$stmt = $pdo->prepare($sql);
	$params = array(
		":blog_id" => $blog_id,
		":client_id" => $client['id'],
		":status" => 1,
		":posting_date" => $today
	);
	$stmt->execute($params);
	$blog_entrys = $stmt->fetchAll();

}


//ページネーション

$count['cnt'] = count($blog_entrys);


//ページ数を取得する。GETでページが渡ってこなかった時(最初のページ)のときは$pageに１を格納する。
if(isset($_GET['page']) && is_numeric($_GET['page'])) {
	$page = $_GET['page'];
} else {
	$page = 1;
}

//最大ページ数を取得する。
//10件ずつ表示させているので、$count['cnt']に入っている件数を10で割って小数点は切りあげると最大ページ数になる。
$max_page = ceil($count['cnt'] / 10);


if($page == 1 || $page == $max_page) {
	$range = 4;
} elseif ($page == 2 || $page == $max_page - 1) {
	$range = 3;
} else {
	$range = 2;
}

$from_record = ($page - 1) * 10 + 1;

if($page == $max_page && $count['cnt'] % 10 !== 0) {
	$to_record = ($page - 1) * 10 + $count['cnt'] % 10;
} else {
	$to_record = $page * 10;
}

$blog_entrys_slice = array_slice($blog_entrys,($page - 1) * 10 ,10 );


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



//カテゴリー取得

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

	<title><?php echo h($blog["blog_title"]); ?></title>

	<meta name="description" content="<?php echo h($blog["blog_description"]); ?>">
	<meta name="keywords" content="<?php echo h($blog["blog_keywords"]); ?>" />
	<meta name="author" content="<?php echo h($blog["blog_author_name"]); ?>">

	<link rel="icon" type="image/vnd.microsoft.icon" href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=favicon">
	<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=favicon">
	<link rel="apple-touch-icon" sizes="180x180" href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=favicon180">

	<link rel="canonical" href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/" />

	<link rel="alternate" type="application/rss+xml" title="<?php echo h($blog["title"]); ?>&raquo; フィード" href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/feed/" />

	<meta property="og:locale" content="ja_JP" />
	<meta property="og:site_name" content="<?php echo $blog["blog_title"]; ?>" />
	<meta property="og:title" content="<?php echo $blog["blog_title"]; ?>" />
	<meta property="og:description" content="<?php echo $blog["blog_description"]; ?>" />
	<meta property="og:url" content="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/workflow.html" />
	<meta property="og:type" content="website" />
	<meta property="og:image" content="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=eyecatch_top" />

	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:site" content="@" />
	<meta name="twitter:title" content="<?php echo $blog["blog_title"]; ?>" />
	<meta name="twitter:description" content="<?php echo $blog["blog_description"]; ?>" />
	<meta name="twitter:image" content="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=eyecatch_top" />

	<meta property="fb:admins" content="" />
	<meta property="fb:app_id" content="" />


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
			<a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/"><img src="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=blog_header" alt="初心者でも自宅で楽しく学べるハルジオン式プログラミング入門" class="img-responsive" /></a>
		</div>



		<div class="row blog-list">

			<div id="main" class="col-md-8 col-sm-8 col-xs-12">

				<?php foreach ($blog_entrys_slice as $val): ?>
					<?php
					//ブログの登録しているカテゴリーを取得

					$sql = "SELECT * FROM blog_category WHERE blog_id = :blog_id AND client_id = :client_id AND blog_entry_id =:blog_entry_id ";
					$stmt = $pdo->prepare($sql);
					$params = array(
						":blog_id" => $blog_id,
						":client_id" => $client['id'],
						":blog_entry_id" => $val['blog_entry_code']
					);
					$stmt->execute($params);
					$blog_categorys[$val['blog_entry_code']] = $stmt->fetchAll();


					?>

					<div class="blog-list-entry-area panel">
						<article class="blog-list-entry-content">
							<section class="">
								<p class="blog-list-entry-posting-date-area" style="text-align:center;">
									<span class="blog-list-entry-posting_date"><i class="fa fa-clock-o"></i> <?php echo h($val['created_at']); ?>&nbsp;&nbsp;&nbsp;<i class="fa fa-refresh"></i> <?php echo h($val['updated_at']); ?></span>
								</p>

								<?php if (empty($val['slug']))  : ?>
									<?php// if (isset($val['blog_entry_code']))  : ?>
										<h1 class="blog-list-entry-title"><a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/entry/<?php echo h($val['blog_entry_code']); ?>.html" title="<?php echo $val['title']; ?>"> <?php echo $val['title']; ?></a></h1>
									<?php else : ?>
										<h1 class="blog-list-entry-title"><a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/<?php echo h($val['slug']); ?>.html" title="<?php echo $val['title']; ?>"> <?php echo $val['title']; ?></a></h1>
									<?php endif; ?>

									<p class="blog-list-category-area pc-only" style="text-align:center;margin-top:20px;">

										<?php foreach ($blog_categorys[$val['blog_entry_code']] as $val6): ?>

											<?php
											//カテゴリーマスター取得
											$sql = "SELECT * FROM blog_category_master WHERE blog_id = :blog_id AND client_id = :client_id AND id = :id";
											$stmt = $pdo->prepare($sql);
											$params = array(
												":blog_id" => $blog_id,
												":client_id" => $client['id'],
												":id" => $val6['blog_category_master_id']
											);
											$stmt->execute($params);
											$val6 = $stmt->fetch();

											?>

											<a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/category/<?php echo h($val6['blog_category_code']); ?>.html"><span class="blog-list-category-name"><i class="fa fa-folder-open"></i><?php echo h($val6['category_name']); ?></span></a>

										<?php endforeach; ?>


									</p>
									<?php if (empty($val['eye_catch_image'])):?>

										<?php if (empty($val['slug'])): ?>
											<a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/entry/<?php echo h($val['blog_entry_code']); ?>.html" title="<?php echo h($val['title']); ?>"><figure class="blog-list-entry-eyecatch" style="background-image: url('http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=eyecatch_top');background-size: cover;">
											</figure></a>
										<?php else : ?>
											<a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/<?php echo h($val['slug']); ?>.html" title="<?php echo h($val['title']); ?>"><figure class="blog-list-entry-eyecatch" style="background-image: url('http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=eyecatch_top');background-size: cover;">
											</figure></a>
										<?php endif; ?>

									<?php else :?>

										<?php if (empty($val['slug'])): ?>
											<a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/entry/<?php echo h($val['blog_entry_code']); ?>.html" title="<?php echo h($val['title']); ?>"><figure class="blog-list-entry-eyecatch" style="background-image: url('http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=eyecatch&e=<?php echo h($val['blog_entry_code']); ?>');background-size: cover;">
											</figure></a>
										<?php else : ?>
											<a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/<?php echo h($val['slug']); ?>.html" title="<?php echo h($val['title']); ?>"><figure class="blog-list-entry-eyecatch" style="background-image: url('http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/image/?i=eyecatch&e=<?php echo h($val['blog_entry_code']); ?>');background-size: cover;">
											</figure></a>
										<?php endif; ?>

									<?php endif; ?>
									<div class="description"><p><?php echo h($val['seo_description']); ?></p></div>

									<?php if (empty($val['slug'])): ?>
										<div id="list-more-area"><a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/entry/<?php echo h($val['blog_entry_code']); ?>.html" title="<?php echo h($val['title']); ?>" class="btn btn-default btn-lg">記事を読む</a></div></a>
									<?php else : ?>
										<div id="list-more-area"><a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/<?php echo h($val['slug']); ?>.html" title="<?php echo $val['title']; ?>" class="btn btn-default btn-lg">記事を読む</a></div>
									<?php endif; ?>

								</section>
							</article>
						</div>


					<?php endforeach; ?>

					<div class="blog-list-pager-area">


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

												<li class="sidebar-category-name"><a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/category/<?php echo h($val['blog_category_code']); ?>.html"> <?php echo h($val['category_name']); ?> (<?php echo $count2[$val['id']]['cnt2'] ;?>)</a></li>
											<?php endforeach; ?>
										</ul>
									</div>
								</div>
							</div>


						</div>
					</div>

					<div class="pagination">
						<p class="from_to"><?php echo $count['cnt']; ?>件中 <?php echo $from_record; ?> - <?php echo $to_record;?> 件目を表示</p>
					</div>
					<div class="pagination2">

						<?php if (!($page == 1)) :?>
							<?php if (!isset($search_keyword) and !isset($new_category_code)) :?>
								<a href="?page=1" title="最初のページへ">« 最初へ</a>
								<?PHP elseif(isset($search_keyword) and !isset($new_category_code)): ?>
								<a href="?page=1&q=<?php echo $search_keyword;?>" title="最初のページへ">« 最初へ</a>

								<?PHP elseif(!isset($search_keyword) and isset($new_category_code)): ?>
								<a href="<?php //echo $new_category_code ;?>?page=1&ccode=<?php echo $new_category_code ;?>" title="最初のページへ">« 最初へ</a>
								<?PHP endif; ?>
								<?PHP endif; ?>

								<?php if ($page >= 2 ): ?>
									<?php if (!isset($search_keyword) and !isset($new_category_code)) :?>
										<a href="?page=<?php echo($page - 1); ?>" class="page_feed">&laquo;</a>
										<?PHP elseif(isset($search_keyword) and !isset($new_category_code)): ?>
										<a href="?page=<?php echo($page - 1); ?>&q=<?php echo $search_keyword;?>" tclass="page_feed">&laquo;</a>
										<?PHP elseif(!isset($search_keyword) and isset($new_category_code)): ?>
										<a href="<?php //echo $new_category_code ;?>?page=<?php echo($page - 1); ?>&ccode=<?php echo $new_category_code ;?>" tclass="page_feed">&laquo;</a>
										<?PHP endif; ?>
									<?php else : ;?>
										<span class="first_last_page"></span>
									<?php endif; ?>

									<?php for ($i = 1; $i <= $max_page; $i++) : ?>
										<?php if($i >= $page - $range && $i <= $page + $range) : ?>
											<?php if($i == $page) : ?>
												<span class="now_page_number"><?php echo $i; ?></span>
											<?php else: ?>
												<?php if (!isset($search_keyword) and !isset($new_category_code)) :?>
													<a href="?page=<?php echo $i; ?>" class="page_number"><?php echo $i; ?></a>
													<?PHP elseif(isset($search_keyword) and !isset($new_category_code)): ?>
													<a href="?page=<?php echo $i; ?>&q=<?php echo $search_keyword;?>" class="page_number"><?php echo $i; ?></a>
													<?PHP elseif(!isset($search_keyword) and isset($new_category_code)): ?>
													<a href="<?php //echo $new_category_code ;?>?page=<?php echo $i; ?>&ccode=<?php echo $new_category_code ;?>" class="page_number"><?php echo $i; ?></a>
													<?PHP endif; ?>
												<?php endif; ?>
											<?php endif; ?>
										<?php endfor; ?>


										<?php if(!($page == $max_page)) : ?>
											<?php if (!isset($search_keyword) and !isset($new_category_code)) :?>
												<a href="?page=<?php echo($page + 1); ?>" class="page_feed">&raquo;</a>
												<?PHP elseif(isset($search_keyword) and !isset($new_category_code)): ?>
												<a href="?page=<?php echo($page + 1); ?>&q=<?php echo $search_keyword;?>" class="page_feed">&raquo;</a>
												<?PHP elseif(!isset($search_keyword) and isset($new_category_code)): ?>
												<a href="<?php //echo $new_category_code ;?>?page=<?php echo($page + 1); ?>&ccode=<?php echo $new_category_code ;?>" class="page_feed">&raquo;</a>
												<?PHP endif; ?>
											<?php else : ?>
												<span class="first_last_page"></span>
											<?php endif; ?>

											<?php if (!($page == $max_page)) :?>
												<?php if (!isset($search_keyword) and !isset($new_category_code)) :?>
													<a href="?page= <?php echo $max_page ; ?>"  title="最後のページへ">最後へ »</a>
													<?PHP elseif(isset($search_keyword) and !isset($new_category_code)): ?>
													<a href="?page= <?php echo $max_page ; ?>&q=<?php echo $search_keyword;?>"  title="最後のページへ">最後へ »</a>
													<?PHP elseif(!isset($search_keyword) and isset($new_category_code)): ?>
													<a href="<?php //echo $new_category_code ;?>?page= <?php echo $max_page ; ?>&ccode=<?php echo $new_category_code ;?>"  title="最後のページへ">最後へ »</a>
													<?PHP endif; ?>
													<?PHP endif; ?>
												</div>

											</div>


											<footer class="blog-footer">
												<!--<p class="blog-footer-left">プログラミング入門講座情報サイト</p>-->
												<p class="blog-footer-right">&copy; SENSE SHARE</p>
												<p><a href="#"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span>上に戻る</a></p>
											</footer>
