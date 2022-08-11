<?php

// パンくずリスト設定
$breadcrumb_list = array();
$breadcrumb_list[0]['title'] = 'HOME';
$breadcrumb_list[0]['url'] = SITE_URL;
$breadcrumb_list[1]['title'] = '記事一覧';
$breadcrumb_list[1]['url'] = '';

$blog_entrys = array();

//client_code取得
$sql = "SELECT * FROM client WHERE id = :id ";
$stmt = $pdo->prepare($sql);
$params = array(
	":id" => $user['id']
);
$stmt->execute($params);
$blog_entry_client_code = $stmt->fetch();
$client_code = $blog_entry_client_code['client_code'];

if(!(isset($_GET['search_filter']))&&!(isset($_GET['search_keyword']))){

    $search_filter = '';
	$search_keyword = '';

	$sql = "SELECT * FROM blog_entry WHERE client_id = :client_id ";
	$stmt = $pdo->prepare($sql);
	$params = array(
		":client_id" => $user['id']
	);
	$stmt->execute($params);
	$blog_entrys = $stmt->fetchAll();

}elseif(isset($_GET['search_filter'])&&!(isset($_GET['search_keyword'])) ){
	$search_filter = $_GET['search_filter'];
	$search_keyword ='';

	$sql = "SELECT * FROM blog_entry WHERE status = :status AND client_id = :client_id ";
	$stmt = $pdo->prepare($sql);
	$params = array(
		":status" => $search_filter,
		":client_id" => $user['id']
	);
	$stmt->execute($params);
	$blog_entrys = $stmt->fetchAll();


}elseif(isset($_GET['search_keyword'])&&!(isset($_GET['search_filter']))){
    $search_keyword = $_GET['search_keyword'];
	$search_filter ='';

	$search_value = $search_keyword;

	$sql = "SELECT * FROM blog_entry WHERE (title LIKE '%$search_keyword%' OR contents LIKE '%$search_keyword%' OR slug LIKE '%$search_keyword%' OR seo_description  LIKE '%$search_keyword%' OR seo_keywords LIKE '%$search_keyword%' ) ORDER BY id AND blog_id = :blog_id ";
	$stmt = $pdo->prepare($sql);
	$params = array(
		":blog_id" =>$blog_id
    );
	$stmt->execute($params);
	$blog_entrys = $stmt->fetchAll();


}elseif(isset($_GET['search_filter'])&&(isset($_GET['search_keyword']))){

    $search_filter =$_GET['search_filter'];
    $search_keyword = $_GET['search_keyword'];

	$search_value = $search_keyword;

	$sql = "SELECT * FROM blog_entry WHERE  status =:status AND blog_id = :blog_id AND (title LIKE '%$search_keyword%' OR contents LIKE '%$search_keyword%' OR slug LIKE '%$search_keyword%' OR seo_description  LIKE '%$search_keyword%' OR seo_keywords LIKE '%$search_keyword%' ) ORDER BY id  ";
	$stmt = $pdo->prepare($sql);
	$params = array(
		":status" => $search_filter,
		":blog_id" => $blog_id
	);
	$stmt->execute($params);
	$blog_entrys = $stmt->fetchAll();


}

//error_log($search_filter,3,"./error.log");

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
					<input type="text" id="search_keyword" name="search_keyword" class="form-control input-white" placeholder="検索キーワードを入力してください。" value="<?php if(isset($search_keyword)) echo h($search_keyword); ?>" />
					<?php if ($search_filter) :?>


					<input type="hidden" name="search_filter" value="<?php echo $search_filter ; ?>" />
					<?PHP endif; ?>
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
						<?php if ($search_keyword) :?>
						<li><a href="?search_filter=1&page=1&search_keyword=<?php echo $search_keyword;?>">公開中</a></li>
						<?PHP else :?>
						<li><a href="?search_filter=1&page=1">公開中</a></li>
						<?PHP endif; ?>
						<?php if ($search_keyword) :?>
						<li><a href="?search_filter=2&page=1&search_keyword=<?php echo $search_keyword;?>">非公開</a></li>
						<?PHP else :?>
						<li><a href="?search_filter=2&page=1">非公開</a></li>
						<?PHP endif; ?>

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
									<th class="width-100 text-center text-white">記事ＩＤ</th>
									<th class="width-300 text-center text-white">タイトル</th>
									<th class="width-80  text-center text-white">パス</th>
									<th class="width-150 text-center text-white">閲覧数</th>
									<th class="width-150 text-center text-white"></th>
								</tr>
							</thead>
							<tbody>

								<?php foreach ($blog_entrys as $blog_entry): ?>
								<tr id="<?php echo h($blog_entry['blog_entry_code']);?>">
									<td class="text-center">
										<?php if ($blog_entry['status'] == 1) :?>
										<span class="label label-success">公開中</span>
										<?PHP elseif ($blog_entry['status'] == 2):?>
										<span class="label label-danger">下書き</span>
										<?PHP endif; ?>
									</td>
									<td class="text-center"><?php echo $blog_entry['blog_entry_code'];?></td>
									<td><?php echo $blog_entry['title'];?></td>
									<?php if(empty($blog_entry['slug'])) : ?>
										<td><a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/entry/<?php echo $blog_entry['blog_entry_code'];?>.html" class="btn btn-primary" " target="_blank"><?php echo $blog_entry['blog_entry_code'];?>.html</a></td>
									<?php else : ?>
										<td><a href="http://b.blog-system-5884.localhost/<?php echo h($client_code); ?>/<?php echo $blog_entry['slug'];?>.html" class="btn btn-primary " target="_blank""><?php echo $blog_entry['slug'];?>.html</a></td>
									<?php endif; ?>



									<td><center><?php echo $blog_entry['view_count'];?></center></td>
									<td class="text-center">
										<a href="/blog/entry/?id=<?php echo h($blog_entry['blog_entry_code']);?>" class="btn btn-primary">編集</a>
										<a href="javascript:void(0);" class="btn btn-danger" onclick="var ok=confirm('削除しても宜しいですか?');if (ok) location.href='/blog/delete2/?id=<?php echo h($blog_entry['blog_entry_code']);?>'; return false;">削除</a>
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
