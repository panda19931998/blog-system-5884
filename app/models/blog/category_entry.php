<?php include(TEMPLATE_PATH."/template_head.php"); ?>
<!-- begin #content -->
			<div id="content" class="content">
				<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="http://blog-system-5884.localhost/">HOME</a></li>
			<li class="breadcrumb-item"><a href="http://blog-system-5884.localhost/blog/category/">ブログカテゴリー</a></li>
			<li class="breadcrumb-item active">ブログカテゴリー登録</li>
	</ol>
<!-- end breadcrumb -->

				<!-- begin page-header -->
				<h1 class="page-header">ブログカテゴリー登録</h1>
				<!-- end page-header -->

<form method="POST" class="form-horizontal form-bordered" id="mainform" enctype="multipart/form-data">
	<!-- begin panel -->
	<div class="panel panel-inverse">
		<!-- begin panel-body -->
		<div class="panel-body panel-form">
			<div class="form-group row">
				<label class="col-md-2 col-form-label">カテゴリー名</label>
				<div class="col-md-10">
					<input name="category_name" type="text" class="form-control " value="" />
					<div class="invalid-feedback"></div>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-2 col-form-label">スラッグ</label>
				<div class="col-md-10">
					<input name="blog_category_slug" type="text" class="form-control " value="" />
					<div class="invalid-feedback"></div>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-2 col-form-label">表示順序</label>
				<div class="col-md-10">
					<input name="sort_order" type="text" class="form-control " value="" />
					<div class="invalid-feedback"></div>
				</div>
			</div>

		</div>
		<!-- end panel-body -->
	</div>
	<!-- end panel -->

	<!-- begin wrapper -->
	<div class="wrapper bg-silver text-right">
		<a href="/blog/category/"><button type="button" class="btn btn-white p-l-40 p-r-40 m-r-5">キャンセル</button></a>
		<button type="submit" class="btn btn-primary p-l-40 p-r-40" onclick="mainform.submit();">登録</button>
	</div>
	<!-- end wrapper -->

	<input type="hidden" name="code" value="" />
	<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
	<input type="hidden" name="FLUXDEMOTOKEN" value="b954cbe308fc29566ee7dcf09b65bcf807fd0e97" />
</form>

			</div>
			<!-- end #content -->


<?php include(TEMPLATE_PATH."/template_bottom.php"); ?>
