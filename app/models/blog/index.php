<?php
// パンくずリスト設定
$breadcrumb_list = array();
$breadcrumb_list[0]['title'] = 'HOME';
$breadcrumb_list[0]['url'] = SITE_URL;
 ?>

<?php include(TEMPLATE_PATH."/template_head.php"); ?>
			<!-- begin panel -->
			<!-- begin #content -->
<div id="content" class="content">
		<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<?php include(TEMPLATE_PATH."/breadcrumb.php"); ?>
	</ol>
<!-- end breadcrumb -->

	<!-- begin page-header -->
	<h1 class="page-header">記事一覧</h1>
	<!-- end page-header -->

	<form method="GET" id="mainform">

	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-md-12">
	<!-- begin result-container -->
			<div class="result-container">

				<!-- begin input-group -->
				<div class="input-group input-group-lg m-b-20">
					<input type="text" id="search_keyword" name="search_keyword" class="form-control input-white" placeholder="検索キーワードを入力してください。" value="" />
					<div class="input-group-append">
						<button type="submit" class="btn btn-primary"><i class="fa fa-search fa-fw"></i></button>
					</div>
				</div>
				<!-- end input-group -->
			<!-- begin dropdown -->
				<div class="dropdown pull-left">
					<a href="#" class="btn btn-white btn-white-without-border dropdown-toggle" data-toggle="dropdown">
						Filters by
					</a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="?search_filter=1&page=1">公開中</a></li>
						<li><a href="?search_filter=2&page=1">非公開</a></li>
					</ul>
				</div>
			<!-- end dropdown -->

				<div class="width-150 pull-right m-b-10">
					<a href="/blog/entry/" class="btn btn-inverse btn-block">新規作成</a>
				</div>

			<!-- begin panel -->
				<div class="panel" style="clear:both">
					<div class="panel-body panel-form">
						<table class="table table-bordered table-valign-middle m-b-0">
							<thead>
								<tr class="bg-inverse">
									<th class="width-70 text-center text-white"></th>
									<th class="width-70 text-center text-white">記事ID</th>
									<th class="text-center text-white">タイトル</th>
									<th class="width-300 text-center text-white">パス</th>
									<th class="width-80 text-center text-white">閲覧数</th>
									<th class="width-150 text-center text-white"></th>
								</tr>
							</thead>
							<tbody>
								<tr id="item_272">
									<td class="text-center">
										<span class="label label-success">公開中</span>
									</td>
									<td class="text-center">
										2
									</td>
									<td>
										僕がいつもプログラムをどんな方法（流れ）で作成しているのか？<br>
										<small><i class="fa fa-clock"></i> 2019.02.05&nbsp;&nbsp;<i class="fa fa-sync-alt"></i> 2019.02.04</small>
									</td>
									<td><a href="https://b.flu-x.net/demo/workflow.html" target="_blank">/workflow.html</a></td>
									<td class="text-center">50</td>

									<td class="text-center">
										<a href="/blog/entry/?code=272" class="btn btn-primary">編集</a>
										<a href="#" class="btn btn-danger" data-id="272" data-click="delete-confirm">削除</a>
									</td>
								</tr>
								<tr id="item_273">
									<td class="text-center">
										<span class="label label-success">公開中</span>
									</td>
									<td class="text-center">
										3
									</td>
									<td>
										初心者がプログラミングを学ぶには、何から勉強すれば良いか？<br>
										<small><i class="fa fa-clock"></i> 2018.06.01&nbsp;&nbsp;<i class="fa fa-sync-alt"></i> 2019.02.04</small>
									</td>
									<td><a href="https://b.flu-x.net/demo/how-to-web-programmer.html" target="_blank">/how-to-web-programmer.html</a></td>
									<td class="text-center">99</td>

									<td class="text-center">
										<a href="/blog/entry/?code=273" class="btn btn-primary">編集</a>
										<a href="#" class="btn btn-danger" data-id="273" data-click="delete-confirm">削除</a>
									</td>
								</tr>
								<tr id="item_271">
									<td class="text-center">
										<span class="label label-success">公開中</span>
									</td>
									<td class="text-center">
										1
									</td>
									<td>
										Webプログラマーの仕事内容(業務内容)ってどんなことをするの？<br>
										<small><i class="fa fa-clock"></i> 2018.06.01&nbsp;&nbsp;<i class="fa fa-sync-alt"></i> 2018.06.01</small>
									</td>
									<td><a href="https://b.flu-x.net/demo/web-programmer-work.html" target="_blank">/web-programmer-work.html</a></td>
									<td class="text-center">32</td>

									<td class="text-center">
										<a href="/blog/entry/?code=271" class="btn btn-primary">編集</a>
										<a href="#" class="btn btn-danger" data-id="271" data-click="delete-confirm">削除</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			<!-- end panel -->
			</div>
		<!-- end result-container -->
		</div>
	<!-- end col-12 -->
	</div>
<!-- end row -->
	</form>

</div>
<!-- end #content -->

</div>
			<!-- end panel -->
			<?php include(TEMPLATE_PATH."/template_bottom.php"); ?>
