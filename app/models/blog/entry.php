<?php

$page_title = "ブログ記事作成";
$page_base_head_tag_template = "head_blog_entry.php";
$page_base_body_tag_template = "body_blog_entry.php";

?>

<?php include(TEMPLATE_PATH."/template_head.php"); ?>

<!-- end #sidebar -->

<!-- begin #content -->
<div id="content" class="content">
				<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li class="breadcrumb-item"><a href="http://blog-system-5884.localhost/">HOME</a></li>
	<li class="breadcrumb-item"><a href="http://blog-system-5884.localhost/blog/">記事一覧</a></li>
	<li class="breadcrumb-item active">ブログ記事作成</li>
</ol>
<!-- end breadcrumb -->

<!-- begin page-header -->
<h1 class="page-header">ブログ記事作成</h1>
<!-- end page-header -->

<form method="POST" class="form-horizontal form-bordered" id="mainform" enctype="multipart/form-data">

	<div class="vertical-box inbox">
		<div class="vertical-box-column bg-white">
			<!-- begin wrapper -->
			<div class="wrapper bg-silver border-bottom">
				<span class="btn-group m-r-5">
					<div class="input-group date" id="datetimepicker1">
						<div class="input-group-addon">
							<span class="f-s-11">投稿日時</span>
						</div>
						<input type="text" name="posting_date" class="form-control " placeholder="投稿日時" value="2019/02/23 23:03" />
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
					</div>
				</span>

				<span class="pull-right">
					<input type="checkbox" id="status" name="status" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="公開" data-off="下書き"  />
					<a href="javascript:;" class="m-l-10" data-click="preview"><button type="button" class="btn btn-white p-l-40 p-r-40 m-r-5">プレビュー</button></a>
					<button type="submit" class="btn btn-primary p-l-40 p-r-40">登録</button>
				</span>
			</div>
			<!-- end wrapper -->

			<!-- begin scrollbar -->
			<div data-scrollbar="true" data-height="100%" class="p-15">
				<!-- begin email subject -->
				<div class="email-subject">
					<input type="text" name="title" class="form-control form-control-lg " placeholder="記事タイトル（22-32文字）" value="" />
					<div class="invalid-feedback"></div>
				</div>
				<!-- end email subject -->

				<!-- begin email content -->
				<div class="email-content p-t-15">
					<textarea class="summernote form-control " name="contents"></textarea>
					<div class="invalid-feedback"></div>
				</div>
				<!-- end email content -->
			</div>
			<!-- end scrollbar -->
		</div>

		<div class="vertical-box-column bg-silver width-300 border-left">
			<!-- begin wrapper -->
			<div class="wrapper bg-silver text-center border-bottom">
				<div class="image-preview m-b-4"></div>

				<label class="m-t-1 m-b-1">
					<span class="btn btn-inverse p-l-40 p-r-40 btn-sm">
						<i class="fa fa-image"></i> アイキャッチ画像
						<input type="file" name="eye_catch_image" style="display:none">
					</span>
				</label>
			</div>
			<!-- end wrapper -->

			<!-- begin wrapper -->
			<div class="wrapper p-0">
				<div class="nav-title"><b>SLUG</b></div>
				<div class="m-l-10 m-r-10">
					<input type="text" class="form-control " name="slug" placeholder="" value="" />
					<div class="invalid-feedback"></div>
				</div>

				<div class="nav-title m-t-10"><b>SEO DESCRIPTION</b><div id="seo_description_text_count" class="text_count pull-right"></div></div>
				<div class="m-l-10 m-r-10">
					<textarea class="textarea form-control " name="seo_description" id="seo_description" placeholder="SEOディスクリプション（80-120文字）" rows="6"></textarea>
					<div class="invalid-feedback"></div>
				</div>

				<div class="nav-title m-t-10"><b>SEO KEYWORDS</b></div>
				<div class="m-l-10 m-r-10">
					<input type="text" class="form-control " name="seo_keywords" placeholder="SEOキーワード（カンマ区切りで複数指定可）" value="" />
					<div class="invalid-feedback"></div>
				</div>

				<div class="nav-title m-t-10"><b>CATEGORIES</b></div>
				<ul id="category_area" class="nav nav-inbox">
				<li class="checkbox checkbox-css m-l-15 m-b-5">
					<input type="checkbox" id="category_40" name="category_id[]" value="40"  />
					<label for="category_40">
					プログラマーを知る
					</label>
				</li>
				<li class="checkbox checkbox-css m-l-15 m-b-5">
					<input type="checkbox" id="category_41" name="category_id[]" value="41"  />
					<label for="category_41">
					プログラミングを学ぶメリット
					</label>
				</li>
				<li class="checkbox checkbox-css m-l-15 m-b-5">
					<input type="checkbox" id="category_42" name="category_id[]" value="42"  />
					<label for="category_42">
					プログラマーになる方法
					</label>
				</li>
				<li class="checkbox checkbox-css m-l-15 m-b-5">
					<input type="checkbox" id="category_43" name="category_id[]" value="43"  />
					<label for="category_43">
					TIPS
					</label>
				</li>
				<li class="checkbox checkbox-css m-l-15 m-b-5">
					<input type="checkbox" id="category_44" name="category_id[]" value="44"  />
					<label for="category_44">
						おすすめツール／書籍
					</label>
				</li>
				<li class="checkbox checkbox-css m-l-15 m-b-5">
					<input type="checkbox" id="category_45" name="category_id[]" value="45"  />
					<label for="category_45">
					プログラマーの日常
					</label>
				</li>
				<li class="checkbox checkbox-css m-l-15 m-b-5">
					<input type="checkbox" id="category_46" name="category_id[]" value="46"  />
					<label for="category_46">
					おすすめ記事
					</label>
				</li>
				</ul>

				<div class="m-t-20 m-l-10 m-r-10 m-b-10">
					<div class="input-group">
						<input type="text" class="form-control" id="new_category_name" name="new_category_name" placeholder="新規カテゴリー">
						<div class="input-group-append">
							<button type="button" class="btn btn-white dropdown-toggle no-caret" onclick="create_category();">追加</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end wrapper -->
		</div>
	</div>

	<input type="hidden" name="code" value="" />
	<input type="hidden" name="mode" value="save" />
	<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
	<input type="hidden" name="FLUXDEMOTOKEN" value="fb101adcbf182caee4e77515ddcb8acc39818d47" />
</form>

</div>
<!-- end #content -->

			<!-- begin #footer -->
<div id="footer" class="footer text-right">
	&copy;2019 SENSE SHARE All Rights Reserved.
</div>
<!-- end #footer -->

			<!-- begin scroll to top btn -->
<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
<!-- end scroll to top btn -->
</div>
		<!-- end page container -->
<?php include(TEMPLATE_PATH."/template_bottom.php"); ?>
