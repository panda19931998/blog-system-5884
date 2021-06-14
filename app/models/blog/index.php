<?php

// パンくずリスト設定
$breadcrumb_list = array();
$breadcrumb_list[0]['title'] = 'HOME';
$breadcrumb_list[0]['url'] = SITE_URL;
$breadcrumb_list[1]['title'] = '記事一覧';
$breadcrumb_list[1]['url'] = '';

$blog_entrys = array();

if (isset($_GET['search_keyword'])) {
	$search_keyword = h($_GET['search_keyword']);
	$search_value = $search_keyword;

} else {
	$search_keyword = '';
	$search_value = '';
}

$sql = "SELECT * FROM blog_entry WHERE (title LIKE '%$search_keyword%' OR contents LIKE '%$search_keyword%' OR slug LIKE '%$search_keyword%' OR seo_description  LIKE '%$search_keyword%' OR seo_keywords LIKE '%$search_keyword%' ) ORDER BY id AND blog_id = :blog_id ";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(":blog_id" =>$blog_id ));
$blog_entrys = $stmt->fetchAll();

unset($pdo);
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


					<?php if (!$blog_entrys): ?>
					<div class="alert" id="message">記事が登録されていません。</div>
					<?php else: ?>
					<div class="panel-body panel-form">
						<table class="table table-bordered table-valign-middle m-b-0">
							<thead>
								<tr class="bg-inverse">
									<th class="width-70 text-center text-white"></th>
									<th class="text-center text-white">記事ＩＤ</th>
									<th class="width-300 text-center text-white">タイトル</th>
									<th class="width-80 text-center text-white">パス</th>
									<th class="width-150 text-center text-white">閲覧数</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($blog_entrys as $blog_entry): ?>
								<tr id="<?php echo h($blog_entry['blog_entry_code']);?>">
									<td class="text-center">
										<span class="label label-success"><?php if($blog_entry['status'] = 1) echo "公開中" ?></span>
									</td>
									<td><?php echo $blog_entry['id'];?></td>
									<td><?php echo $blog_entry['title'];?></td>
									<td><a href="/blog/demo/<?php echo $blog_entry['slug'];?>.html" class="btn btn-primary"><?php echo $blog_entry['slug'];?>.html</a></td>
									<td><center><?php echo $blog_entry['view_count'];?></center></td>
									<td class="text-center">
										<a href="/blog/entry/?id=<?php echo h($blog_entry['blog_entry_code']);?>" class="btn btn-primary">編集</a>
										<a href="javascript:void(0);" class="btn btn-danger" onclick="var ok=confirm('削除しても宜しいですか?');if (ok) location.href='/blog/delete/?id=<?php echo h($blog_entry['blog_entry_code']);?>'; return false;">削除</a>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<?php endif; ?>
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
