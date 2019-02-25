
<!DOCTYPE html>
<!--[if IE 8]> <html lang="ja" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="ja">
<!--<![endif]-->

	<head>
		<meta charset="utf-8" />
<title>ログイン | BLOG SYSTEM</title>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
<meta content="Blog System Demonstration" name="description" />
<meta content="SENSE SHARE" name="author" />

<!-- ================== BEGIN BASE CSS STYLE ================== -->
<link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
<link href="/contents/assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
<link href="/contents/assets/plugins/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />
<link href="/contents/assets/plugins/font-awesome/5.0/css/fontawesome-all.min.css" rel="stylesheet" />
<link href="/contents/assets/plugins/animate/animate.min.css" rel="stylesheet" />
<link href="/contents/assets/css/default/style.min.css" rel="stylesheet" />
<link href="/contents/assets/css/default/style-responsive.min.css" rel="stylesheet" />
<link href="/contents/assets/css/default/theme/blue.css" rel="stylesheet" id="theme" />
<!-- ================== END BASE CSS STYLE ================== -->

<!-- ================== BEGIN BASE JS ================== -->
<script src="/contents/assets/plugins/pace/pace.min.js"></script>
<!-- ================== END BASE JS ================== -->

<link rel="icon" type="image/vnd.microsoft.icon" href="http://blog-system-5884.localhost/contents/img/favicon.ico">
<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="http://blog-system-5884.localhost/contents/img/favicon.ico">
<link rel="apple-touch-icon" sizes="180x180" href="http://blog-system-5884.localhost/contents/img/apple-touch-icon-180x180.png">

<!-- ================== BEGIN PAGE LEVEL CSS STYLE ================== -->
<!-- ================== END PAGE LEVEL CSS STYLE ================== -->

<style>
.border-top {border-top: 1px solid #dcdcdc!important;}
.border-bottom {border-bottom: 1px solid #dcdcdc!important;}
.border-left {border-left: 1px solid #dcdcdc!important;}
.border-right {border-right: 1px solid #dcdcdc!important;}
</style>
	</head>

	<body class="pace-top bg-white">

		<!-- begin #page-loader -->
<div id="page-loader" class="fade show"><span class="spinner"></span></div>
<!-- end #page-loader -->

		<!-- begin #page-container -->
		<div id="page-container" class="fade">

			<!-- begin login -->
			<div class="login login-with-news-feed">
				<!-- begin news-feed -->
				<div class="news-feed">
					<div class="news-image" style="background-image: url(/contents/assets/img/login-bg/login-bg-11.jpg)"></div>
					<div class="news-caption">
						<h4 class="caption-title"><b>BLOG SYSTEM</b></h4>
						<p>
							Blog System Demonstration						</p>
					</div>
				</div>
				<!-- end news-feed -->

				<!-- begin right-content -->
				<div class="right-content">
					<!-- begin login-header -->
					<div class="login-header">
						<div class="brand">
							<span class="logo"></span> <b>BLOG</b> Login
							<small>Blog System Demonstration</small>
						</div>
						<div class="icon">
							<i class="fa fa-sign-in"></i>
						</div>
					</div>
					<!-- end login-header -->

					<!-- begin login-content -->
					<div class="login-content">
						<form method="POST" class="margin-bottom-0">
							<div class="form-group m-b-15">
								<input id="mail_address" name="mail_address" type="text" class="form-control form-control-lg " placeholder="メールアドレス" value="" />
								<div class="invalid-feedback"></div>
							</div>
							<div class="form-group m-b-15">
								<input id="password" name="password" type="password" class="form-control form-control-lg " placeholder="パスワード" value="" />
								<div class="invalid-feedback"></div>
							</div>
							<div class="checkbox checkbox-css m-b-30">
								<input type="checkbox" id="auto_login" name="auto_login" value="1" />
								<label for="auto_login">
									ログイン情報を記憶する
								</label>
							</div>
							<div class="login-buttons">
								<button type="submit" class="btn btn-success btn-block btn-lg">ログイン</button>
							</div>
							<hr />
							<p class="text-center text-grey-darker">
								&copy;2019 SENSE SHARE All Rights Reserved.							</p>

							<input type="hidden" name="FLUXDEMOTOKEN" value="eca05d458721f2145d064fbe37f1bd6ea0636a92" />
						</form>
					</div>
					<!-- end login-content -->
				</div>
				<!-- end right-container -->
			</div>
			<!-- end login -->
		</div>
		<!-- end page container -->

		<!-- ================== BEGIN BASE JS ================== -->
<script src="/contents/assets/plugins/jquery/jquery-3.2.1.min.js"></script>
<script src="/contents/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
<script src="/contents/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="/contents/assets/plugins/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
<!--[if lt IE 9]>
<script src="/contents/assets/crossbrowserjs/html5shiv.js"></script>
<script src="/contents/assets/crossbrowserjs/respond.min.js"></script>
<script src="/contents/assets/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
<script src="/contents/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/contents/assets/plugins/js-cookie/js.cookie.js"></script>
<script src="/contents/assets/js/theme/default.min.js"></script>
<script src="/contents/assets/js/apps.min.js"></script>
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<!-- ================== END PAGE LEVEL JS ================== -->

<script src="/contents/assets/plugins/bootstrap-sweetalert/sweetalert.min.js"></script>

<script>
$(document).ready(function() {
	App.init();
});

function form_submit(mode, code, message) {
	if (confirm(message)) {
		document.mainform.mode.value = mode;
		document.mainform.code.value = code;
		document.mainform.submit();
	}
}



$('[data-click="delete-confirm"]').click(function(e) {
	e.preventDefault();
	swal({
		title: '削除してもよろしいですか？',
		text: '削除したデータは元には戻せません。',
		icon: 'error',
		buttons: {
			cancel: {
				text: 'キャンセル',
				value: null,
				visible: true,
				className: 'btn btn-default',
				closeModal: true,
			},
			confirm: {
				text: '削除',
				value: true,
				visible: true,
				className: 'btn btn-danger',
				closeModal: true
			}
		}
	})
	.then((willDelete) => {
		if (willDelete) {
			var delete_code = $(this).data('id');

			var formData = new FormData(document.getElementById("mainform"));
			formData.append('mode', 'delete');
			formData.append('code', delete_code);

			$.ajax({
				type: "POST",
				url: "/",
				data: formData,
				processData: false,
				contentType: false,
				success: function(xml) {
					var check_status = $(xml).find("status").text();
					if (check_status == 1) {
						$("#item_"+delete_code).remove();
					}
				}
			});
		}
	});
});
</script>

	</body>
</html>
