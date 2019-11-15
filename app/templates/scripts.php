<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<?php if ($page_base_body_tag_template): ?>
<?php include(TEMPLATE_PATH."/page_level/".$page_base_body_tag_template); ?>
<?php endif; ?>
<!-- ================== END PAGE LEVEL JS ================== -->
<script src="<?php echo CONTENTS_SERVER_URL ?>/assets/plugins/jquery/jquery-3.3.1.min.js"></script>
<script src="<?php echo CONTENTS_SERVER_URL ?>/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo CONTENTS_SERVER_URL ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!--[if lt IE 9]>
	<script src="<?php echo CONTENTS_SERVER_URL ?>/assets/crossbrowserjs/html5shiv.js"></script>
	<script src="<?php echo CONTENTS_SERVER_URL ?>/assets/crossbrowserjs/respond.min.js"></script>
	<script src="<?php echo CONTENTS_SERVER_URL ?>/assets/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
<script src="<?php echo CONTENTS_SERVER_URL ?>/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo CONTENTS_SERVER_URL ?>/assets/plugins/js-cookie/js.cookie.js"></script>
<script src="<?php echo CONTENTS_SERVER_URL ?>/assets/js/theme/default.min.js"></script>
<script src="<?php echo CONTENTS_SERVER_URL ?>/assets/js/apps.min.js"></script>
<!-- ================== END BASE JS ================== -->

<script>
	$(document).ready(function() {
		App.init();
	});
</script>
