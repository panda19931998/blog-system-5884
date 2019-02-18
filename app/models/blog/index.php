<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
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
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<div class="panel-heading">
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
					<h4 class="panel-title">Panel Title here</h4>
				</div>
				<div class="panel-body">
					Panel Content Here
				</div>
			</div>
			<!-- end panel -->
		</div>
		<!-- end #content -->

		<!-- begin theme-panel -->

		<!-- end theme-panel -->

		<!-- begin scroll to top btn -->
		<?php include(TEMPLATE_PATH."/scroll_top.php"); ?>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->

	<!-- ================== BEGIN BASE JS ================== -->
	<?php include(TEMPLATE_PATH."/scripts.php"); ?>
</body>
</html>
