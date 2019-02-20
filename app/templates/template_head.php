<!DOCTYPE html>
<!--[if IE 8]> <html lang="ja" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="ja">
<!--<![endif]-->
<head>
<?php include(TEMPLATE_PATH."/head_tag.php"); ?>
</head>
<body>
	<!-- begin #page-loader -->
	<?php include(TEMPLATE_PATH."/page_loader.php"); ?>
	<!-- end #page-loader -->

	<!-- begin #page-container -->
	<div id="page-container" class="page-container fade page-sidebar-fixed page-header-fixed">
		<!-- begin #header -->
		<?php include(TEMPLATE_PATH."/header.php"); ?>
		<!-- end #header -->

		<?php include(TEMPLATE_PATH."/sidebar.php"); ?>


		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<?php include(TEMPLATE_PATH."/breadcrumb.php"); ?>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Blank Page <small>header small text goes here...</small></h1>
			<!-- end page-header -->
