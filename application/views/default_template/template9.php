<!DOCTYPE html>
<html lang="en">

	<!--begin::Head-->
	<head>
		<base href="">
		<meta charset="utf-8" />
		<title>DigitizeDocument | Astragraphia</title>
		<meta name="description" content="Updates and statistics" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link href="<?= base_url('assets/css/font_google.css') ?>" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Asap+Condensed:500">
		<link href="<?= base_url('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?= base_url('assets/plugins/global/_plugins.bundle.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?= base_url('assets/plugins/custom/datatables/_datatables.bundle.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?= base_url('assets/plugins/custom/prismjs/_prismjs.bundle.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?= base_url('assets/css/_style.bundle.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?= base_url('assets/plugins/custom/jstree/jstree.bundle.css') ?>" rel="stylesheet" type="text/css">
		<link rel="shortcut icon" href="<?= base_url('assets/media/logos/favicon.png') ?>" />
		<style type="text/css">
			#pageloader
			{
			  background: rgba( 255, 255, 255, 0.8 );
			  display: none;
			  height: 100%;
			  position: fixed;
			  width: 100%;
			  z-index: 9999;
			}

			#pageloader img
			{
			  left: 30%;
			  position: absolute;			  
			  top: 25%;
			}
		</style>
	</head>

	<!--end::Head-->
	<div id="pageloader">
	   <img src="<?= base_url('assets/images/pleasewait.gif') ?>" alt="processing..." />
	</div>
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled page-loading">
		
		<!--[html-partial:include:{"file":"layout.html"}]/-->

		<!--[html-partial:include:{"file":"partials/_extras/offcanvas/quick-user.html"}]/-->

		<script>
			var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";
		</script>

		<!--begin::Global Config(global config for global JS scripts)-->
		<script>

			var KTAppSettings = {
				"breakpoints": {
					"sm": 576,
					"md": 768,
					"lg": 992,
					"xl": 1200,
					"xxl": 1200
				},
				"colors": {
					"theme": {
						"base": {
							"white": "#ffffff",
							"primary": "#8950FC",
							"secondary": "#E5EAEE",
							"success": "#1BC5BD",
							"info": "#8950FC",
							"warning": "#FFA800",
							"danger": "#F64E60",
							"light": "#F3F6F9",
							"dark": "#212121"
						},
						"light": {
							"white": "#ffffff",
							"primary": "#E1E9FF",
							"secondary": "#ECF0F3",
							"success": "#C9F7F5",
							"info": "#EEE5FF",
							"warning": "#FFF4DE",
							"danger": "#FFE2E5",
							"light": "#F3F6F9",
							"dark": "#D6D6E0"
						},
						"inverse": {
							"white": "#ffffff",
							"primary": "#ffffff",
							"secondary": "#212121",
							"success": "#ffffff",
							"info": "#ffffff",
							"warning": "#ffffff",
							"danger": "#ffffff",
							"light": "#464E5F",
							"dark": "#ffffff"
						}
					},
					"gray": {
						"gray-100": "#F3F6F9",
						"gray-200": "#ECF0F3",
						"gray-300": "#E5EAEE",
						"gray-400": "#D6D6E0",
						"gray-500": "#B5B5C3",
						"gray-600": "#80808F",
						"gray-700": "#464E5F",
						"gray-800": "#1B283F",
						"gray-900": "#212121"
					}
				},
				"font-family": "Poppins"
			};
		</script>
		<script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>" type="text/javascript"></script>
		<script src="<?= base_url('assets/js/global.js') ?>" type="text/javascript"></script>
		<script src="<?= base_url('assets/plugins/global/_plugins.bundle.js') ?>" type="text/javascript"></script>
		<script src="<?= base_url('assets/plugins/custom/prismjs/_prismjs.bundle.js') ?>" type="text/javascript"></script>
		<script src="<?= base_url('assets/js/_scripts.bundle.js') ?>" type="text/javascript"></script>
		<script src="<?= base_url('assets/plugins/custom/datatables/datatables.bundle.js') ?>" type="text/javascript"></script>
		<script src="<?= base_url('assets/plugins/custom/jstree/jstree.bundle.js') ?>" type="text/javascript"></script>
		<script src="<?= base_url('assets/js/pages/crud/forms/widgets/select2.js') ?>" type="text/javascript"></script>
    	<script src="<?= base_url('assets/js/pages/components/extended/treeview.js') ?>" type="text/javascript"></script>
		<script src="<?= base_url('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') ?>" type="text/javascript"></script>
		<script src="<?= base_url('assets/js/start.js') ?>" type="text/javascript"></script>
		<script src="<?= base_url('assets/js/pages/widgets.js') ?>" type="text/javascript"></script>
		<script src="<?= base_url('assets/js/notifApproval.js') ?>" type="text/javascript"></script>

	
		<?php include 'layout_demo9.php'; ?>
		<?php include 'partials/_extras/offcanvas/quick-notifications.php'; ?>
		<?php include 'partials/_extras/offcanvas/quick-actions.php'; ?>
		<?php include 'partials/_extras/offcanvas/quick-user.php'; ?>
		<?php //include 'partials/_extras/offcanvas/quick-panel.php'; ?>
		<?php //include 'partials/_extras/chat.php'; ?>
		<?php include 'partials/_extras/scrolltop.php'; ?>
		<?php //include 'partials/_extras/offcanvas/demo-panel.php'; ?>
	</body>

	<!--end::Body-->
</html>