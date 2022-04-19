
<!DOCTYPE html>
<html lang="ja">
	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>僕がいつもプログラムをどんな方法（流れ）で作成しているのか？</title>

		<meta name="description" content="僕は普段から何かアイデアを思いつくと、それをささっとアプリやWebサービスとして作ってしまいます。このページでは、僕がいつもプログラムをどんな感じで作っているのかをご紹介しようと思います。">
		<meta name="keywords" content="プログラム,作成,方法,流れ" />
		<meta name="author" content="ハルジオン">

		<link rel="icon" type="image/vnd.microsoft.icon" href="http://b.blog-system-5884.localhost/client_code/image/?i=favicon">
		<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="http://b.blog-system-5884.localhost/client_code/image/?i=favicon">
		<link rel="apple-touch-icon" sizes="180x180" href="http://b.blog-system-5884.localhost/client_code/image/?i=favicon180">

		<link rel="canonical" href="http://b.blog-system-5884.localhost/client_code/workflow.html" />

		<link rel="alternate" type="application/rss+xml" title="初心者でも自宅で楽しく学べるハルジオン式プログラミング入門 &raquo; フィード" href="http://b.blog-system-5884.localhost/client_code/feed/" />

		<meta property="og:locale" content="ja_JP" />
		<meta property="og:site_name" content="初心者でも自宅で楽しく学べるハルジオン式プログラミング入門" />
		<meta property="og:title" content="僕がいつもプログラムをどんな方法（流れ）で作成しているのか？" />
		<meta property="og:description" content="僕は普段から何かアイデアを思いつくと、それをささっとアプリやWebサービスとして作ってしまいます。このページでは、僕がいつもプログラムをどんな感じで作っているのかをご紹介しようと思います。" />
		<meta property="og:url" content="http://b.blog-system-5884.localhost/client_code/workflow.html" />
		<meta property="og:type" content="article" />
		<meta property="og:image" content="http://b.blog-system-5884.localhost/client_code/image/?i=eyecatch&e=12" />

		<meta name="twitter:card" content="summary_large_image" />
		<meta name="twitter:site" content="@" />
		<meta name="twitter:title" content="僕がいつもプログラムをどんな方法（流れ）で作成しているのか？" />
		<meta name="twitter:description" content="僕は普段から何かアイデアを思いつくと、それをささっとアプリやWebサービスとして作ってしまいます。このページでは、僕がいつもプログラムをどんな感じで作っているのかをご紹介しようと思います。" />
		<meta name="twitter:image" content="http://b.blog-system-5884.localhost/client_code/image/?i=eyecatch&e=12" />

		<meta property="fb:admins" content="" />
		<meta property="fb:app_id" content="" />

		<meta property="article:published_time" content="2012-10-12T23:04:00Z" />
		<meta property="article:modified_time" content="2020-04-08T01:29:29Z" />

		<link rel='dns-prefetch' href='//maxcdn.bootstrapcdn.com' />
		<link rel='dns-prefetch' href='//ajax.googleapis.com' />
		<link rel='dns-prefetch' href='//connect.facebook.net' />

		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

		<link href="http://b.blog-system-5884.localhost/client_code/style.css" rel="stylesheet">

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
				<a href="http://b.blog-system-5884.localhost/client_code/"><img src="http://b.blog-system-5884.localhost/client_code/image/?i=blog_header" alt="初心者でも自宅で楽しく学べるハルジオン式プログラミング入門" class="img-responsive" /></a>
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
							<i class="fa fa-clock-o"></i> 2012.10.12&nbsp;&nbsp;&nbsp;
							<i class="fa fa-refresh"></i> 2020.04.08						</div>

						<h1 class="blog-post-title">僕がいつもプログラムをどんな方法（流れ）で作成しているのか？</h1>

						<p class="blog-post-category-area" style="margin-bottom:40px;text-align:center;">


							<a href="http://b.blog-system-5884.localhost/client_code/category/27.html"><span class="blog-list-category-name"><i class="fa fa-folder-open"></i> プログラマーを知る</span></a>


						</p>


						<figure class="blog-post-eyecatch-img">
							<img src="http://b.blog-system-5884.localhost/client_code/image/?i=eyecatch&e=12" alt="僕がいつもプログラムをどんな方法（流れ）で作成しているのか？" class="img-responsive" />
						</figure>


						<p style="blog-post-contents;margin-top:40px;"><div>僕は普段から何かアイデアを思いつくと、</div><div>それをささっとアプリやWebサービスとして作ってしまいます。</div><div><br></div><div>このページでは、僕がいつもプログラムを</div><div>どんな感じで作っているのかをご紹介しようと思います。<br></div><div><br></div><div><h2 id="index1" class="lead01">アイデアは突如生まれる</h2><br></div><div>僕は最近は人に頼まれてプログラムを作ることは少なく</div><div>自分が使うツールとか、思い立ったサービスとかを</div><div>作るためにもっぱらプログラムを書くのですが、</div><div>そのアイデアは突如として生まれます。</div><div><br></div><div>大体がシャワーを浴びているときなんですが</div><div><br></div><div><font size="5">「あ、こんなWebサービスあったら面白いかも！」</font>とか</div><div><font size="5">「これ自動化すれば作業が楽になるな」</font></div><div><br></div><div>という感じで、作るプログラムのアイデアが生まれます。</div><div><br></div><div><h2 id="index2" class="lead01">まずは頭の中のイメージを画面に書き起こす</h2><br></div><div>アイデアが生まれた直後は、内容を文章でメモっておくだけなんですが</div><div>いざ作るときは、まず<font size="5">「画面」</font>を考えます。</div><div><br></div><div>白紙のノートや、書斎のホワイトボードに<br></div><div>思うがままにこれから作るプログラムの</div><div>画面イメージを書いていきます。</div><div><span style="font-size: medium;"><br></span></div><div><span style="font-size: medium;"><div class="alert alert-warning shortcode-alert"><i class="fa fa-comments-o"></i> まずログイン画面があって、、、</span><span style="font-size: medium;"></div></span><br></div><div><span style="font-size: medium;"><div class="alert alert-warning shortcode-alert"><i class="fa fa-comments-o"></i> </span><span style="font-size: medium;">ここの画面にはこのデータを一覧表示して、、、</span><span style="font-size: medium;"></div></span><br></div><div><span style="font-size: medium;"><div class="alert alert-warning shortcode-alert"><i class="fa fa-comments-o"></i> </span><span style="font-size: medium;">ここの部分で検索できるようにして、、、</span><span style="font-size: medium;"></div></span><br></div><div><span style="font-size: medium;"><div class="alert alert-warning shortcode-alert"><i class="fa fa-comments-o"></i> </span><span style="font-size: medium;">ここではメールを送信して、、、</span><span style="font-size: medium;"></div></span><br></div><div>みたいな感じで画面構成を考えていきます。<br></div><div><br></div><div><h2 id="index3" class="lead01">データベースの構成をざっくり考える</h2><br></div><div>画面構成が大体できたら、</div><div>それらの画面で必要になるデータを格納するための</div><div><br></div><div><font size="5">テーブル構成</font>を考えていきます。</div><div><br></div><div>最近はMySQLを使うことが多いです。<br></div><div>phpMyAdminが使いやすいので。</div><div><br></div><div>テーブル構成がざっと決まったら<br></div><div>（大体あとから調整が入るのでここでは大雑把に作ります）</div><div>DDL作って、DBに流し込みます。</div><div><br></div><div><h2 id="index4" class="lead01">実際の処理を実装していく</h2><br></div><div>画面とデータベースが決まったら、考えた画面構成に沿って</div><div>実際の処理（動き）を<font size="5">PHP</font>を使って実装していきます。</div><div><br></div><div>とはいえ、全てをゼロからプログラミングしていく訳ではなく</div><div>基本的な機能（例えばログインや一覧表示、登録処理や削除処理など）は</div><div><span style="font-weight: 700;">どのアプリでも共通する部分が多いため、</span></div><div><br></div><div>過去に自分で作ったソースコード資産から</div><div>コピーして持ってくるだけで基本的な枠組みはすぐに完成します。</div><div><br></div><div>これで、考えた画面構成に沿って<br></div><div>基本データが入出力する基本構造が出来るので</div><div>あとは各画面の今回のアプリの独自機能をプログラミングしていく、</div><div>といった流れです。</div><div><br></div><div>それほど機能数の多くないプログラムなら</div><div>アイデアから1-2日でリリースすることも結構あります。</div><div>自分用なら細かい実装は後からつけたり出来ますからね。</div><div><br></div><div>UIなんかは、最近はBootStrapが便利なので<br></div><div>実装に時間を使えます。</div><div><br></div><div><h2 id="index5" class="lead01">アイデアは熱いうちに作り上げる</h2><br></div><div>こんな感じで、思い立ったアイデアは</div><div>気持ちの熱いうちに作り上げてしまいます。</div><div>（結構時間おくと面倒くさくなっちゃうんですよね・・・^^;）</div><div><br></div><div>日の目を見ずにボツになったアプリも数多くあります。</div><div><br></div><div><h2 id="index6" class="lead01">自分のアイデアを形に出来る能力を身につけよう！</h2><br></div><div>今回の内容は専門的な用語も多くあるため、</div><div>初心者の方には訳が分からない部分もあったかと思いますが</div><div>講座では、初心者の方にまず簡単なアプリ作成を通して</div><div>上記のような流れを実体験してもらいながらスキルを学んでいきます。</div><div><br></div><div>上に書いたような内容はすぐに理解出来るようになりますので<br></div><div>スキルを身につけて、アイデアをどんどん形にしていきましょう！</div><div><br></div></p>




						<!--
						<div class="entry-pager">



							<div class="entry-pager-previous">
								<a href="http://b.blog-system-5884.localhost/client_code/how-to-web-programmer.html">【次の記事】 初心者がプログラミングを学ぶには、何から勉強すれば良いか？ <i class="fa fa-angle-right"></i></a>
							</div>


						</div>
						-->


						<span class="relation-entry">おすすめ記事</span>
						<div class="row">


							<div class="col-md-3 col-sm-6 blog-entry-relation-area">


								<a href="http://b.blog-system-5884.localhost/client_code/web-programmer-work.html" title="Webプログラマーの仕事内容(業務内容)ってどんなことをするの？">
								<div class="blog-entry-relation-eyecatch-area">


									<figure class="blog-entry-relation-eyecatch">
										<img src="http://b.blog-system-5884.localhost/client_code/image/?i=eyecatch&e=10" alt="Webプログラマーの仕事内容(業務内容)ってどんなことをするの？" class="img-responsive" />
									</figure>


									<p class="relation-posting-date">2012.09.04</p>
									<p class="relation-entry-title">Webプログラマーの仕事内容(業務内容)ってどんなことをするの？</p>
								</div>
								</a>



							</div>


							<div class="col-md-3 col-sm-6 blog-entry-relation-area">


								<a href="http://b.blog-system-5884.localhost/client_code/crud.html" title="Web開発のキホン「CRUD」をわかりやすく解説">
								<div class="blog-entry-relation-eyecatch-area">


									<figure class="blog-entry-relation-eyecatch">
										<img src="http://b.blog-system-5884.localhost/client_code/image/?i=eyecatch&e=218" alt="Web開発のキホン「CRUD」をわかりやすく解説" class="img-responsive" />
									</figure>


									<p class="relation-posting-date">2020.04.24</p>
									<p class="relation-entry-title">Web開発のキホン「CRUD」をわかりやすく解説</p>
								</div>
								</a>



							</div>



						</div>


					</div>


				</div>

				<div id="sidebar" class="col-md-4 col-sm-4 col-xs-12 blog-sidebar">


					<div class="sidebar-module">
						<div class="panel">
							<div class="panel-body">


								<figure class="sidebar-profile-image">
									<img src="http://b.blog-system-5884.localhost/client_code/image/?i=profile" class="img-responsive img-circle" alt="" style="width:150px" />
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
								<form action="http://b.blog-system-5884.localhost/client_code" method="GET">
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


								<a href="http://b.blog-system-5884.localhost/client_code/workflow.html" title="僕がいつもプログラムをどんな方法（流れ）で作成しているのか？">
								<ul class="sidebar-list">
									<li class="sidebar-list-left">


										<figure class="sidebar-popular-list-entry-eyecatch">
											<img src="http://b.blog-system-5884.localhost/client_code/image/?i=eyecatch&e=12" class="img-responsive" alt="" />
										</figure>


										<p>1</p>
									</li>
									<li class="sidebar-list-right">
										<div class="sidebar-popular-list-entry-title">
											僕がいつもプログラムをどんな方法（流れ）で作成しているのか？										</div>
										<div class="sidebar-popular-list-entry-views">
											127 Views
										</div>
									</li>
								</ul>
								</a>


								<a href="http://b.blog-system-5884.localhost/client_code/how-to-web-programmer.html" title="初心者がプログラミングを学ぶには、何から勉強すれば良いか？">
								<ul class="sidebar-list">
									<li class="sidebar-list-left">


										<figure class="sidebar-popular-list-entry-eyecatch">
											<img src="http://b.blog-system-5884.localhost/client_code/image/?i=eyecatch&e=11" class="img-responsive" alt="" />
										</figure>


										<p>2</p>
									</li>
									<li class="sidebar-list-right">
										<div class="sidebar-popular-list-entry-title">
											初心者がプログラミングを学ぶには、何から勉強すれば良いか？										</div>
										<div class="sidebar-popular-list-entry-views">
											36 Views
										</div>
									</li>
								</ul>
								</a>


								<a href="http://b.blog-system-5884.localhost/client_code/web-programmer-work.html" title="Webプログラマーの仕事内容(業務内容)ってどんなことをするの？">
								<ul class="sidebar-list">
									<li class="sidebar-list-left">


										<figure class="sidebar-popular-list-entry-eyecatch">
											<img src="http://b.blog-system-5884.localhost/client_code/image/?i=eyecatch&e=10" class="img-responsive" alt="" />
										</figure>


										<p>3</p>
									</li>
									<li class="sidebar-list-right">
										<div class="sidebar-popular-list-entry-title">
											Webプログラマーの仕事内容(業務内容)ってどんなことをするの？										</div>
										<div class="sidebar-popular-list-entry-views">
											21 Views
										</div>
									</li>
								</ul>
								</a>


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


									<li class="sidebar-category-name"><a href="http://b.blog-system-5884.localhost/client_code/category/27.html"> プログラマーを知る (3)</a></li>


									<li class="sidebar-category-name"><a href="http://b.blog-system-5884.localhost/client_code/category/28.html"> プログラマーになる方法 (2)</a></li>


									<li class="sidebar-category-name"><a href="http://b.blog-system-5884.localhost/client_code/category/35.html"> プログラマーのメリット (0)</a></li>


									<li class="sidebar-category-name"><a href="http://b.blog-system-5884.localhost/client_code/category/36.html"> プログラマー (0)</a></li>


									<li class="sidebar-category-name"><a href="http://b.blog-system-5884.localhost/client_code/category/37.html"> プログラミング (0)</a></li>


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
