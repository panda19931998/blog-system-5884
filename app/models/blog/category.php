<?php

$blog_category_masters = array();

if (isset($_GET['search_keyword'])) {
	$search_keyword = h($_GET['search_keyword']);
	$search_value = $search_keyword;

	$sql = "SELECT * FROM blog_category_master where category_name LIKE '%$search_keyword%' order by id and blog_id = :blog_id ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(":blog_id" =>$blog_id ));
	$blog_category_masters = $stmt->fetchAll();
	
}else {
	$search_keyword = '';
	$search_value = '';

	$sql = "select * from blog_category_master where blog_id = :blog_id ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(":blog_id" =>$blog_id ));
	$blog_category_masters = $stmt->fetchAll();
}

foreach ($blog_category_masters as $blog_category_master):
	$sql = "SELECT count(*) as num FROM blog_category where blog_id =:blog_id and blog_category_master_id = :blog_category_master_id ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(":blog_category_master_id" => $blog_category_master['blog_category_code'],
						"blog_id" => $blog_id
						));
	$row[$blog_category_master['blog_category_code']] = $stmt->fetch();
endforeach;

unset($pdo);
?>

<?php include(TEMPLATE_PATH."/template_head.php"); ?>

<<!-- begin #content -->
<div id="content" class="content">
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li class="breadcrumb-item"><a href="https://demo.flu-x.net">HOME</a></li>
	<li class="breadcrumb-item active">ブログカテゴリー</li>
</ol>
<!-- end breadcrumb -->

<!-- begin page-header -->
<h1 class="page-header">ブログカテゴリー</h1>
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
	<input type="text" id="search_keyword" name="search_keyword" class="form-control input-white" placeholder="検索キーワードを入力してください。" value="<?php if (isset($search_value))echo $search_value ;?>" />
	<div class="input-group-append">
		<button type="submit" class="btn btn-primary" value ="検索"><i class="fa fa-search fa-fw"></i></button>
	</div>
</div>
<!-- end input-group -->
				<div class="width-150 pull-right m-b-10">
					<a href="/blog/category_entry/" class="btn btn-inverse btn-block">新規作成</a>
				</div>

				<!-- begin panel -->
				<div class="panel" style="clear:both">
					<?php if (!$blog_category_masters): ?>
					<div class="alert" id="message">カテゴリーが登録されていません。</div>
					<?php else: ?>
					<div class="panel-body panel-form">
						<table class="table table-bordered table-valign-middle m-b-0">
							<thead>
								<tr class="bg-inverse">
									<th class="text-center text-white">カテゴリー名</th>
									<th class="width-300 text-center text-white">スラッグ</th>
									<th class="width-80 text-center text-white">記事数</th>
									<th class="width-150 text-center text-white"></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($blog_category_masters as $blog_category_master): ?>
								<tr id="<?php echo h($blog_category_master['blog_category_code']);?>">
									<td><?php echo $blog_category_master['category_name'];?></td>
									<td><?php echo $blog_category_master['blog_category_slug'];?></td>
									<td><?php echo $row[$blog_category_master['blog_category_code']]['num'];?></td>
									<td class="text-center">2</td>

									<td class="text-center">
										<a href="/blog/category_entry/?id=<?php echo h($blog_category_master['blog_category_code']);?>" class="btn btn-primary">編集</a>
										<a href="javascript:void(0);" class="btn btn-danger" onclick="var ok=confirm('削除しても宜しいですか?');if (ok) location.href='/blog/delete/?id=<?php echo h($blog_category_master['blog_category_code']);?>'; return false;">削除</a>
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
<?php include(TEMPLATE_PATH."/template_bottom.php"); ?>
