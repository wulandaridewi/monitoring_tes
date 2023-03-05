
<!DOCTYPE html>
<html lang="en">
	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>DigitizeDocument | Astragraphia</title>
		<meta name="description" content="Login page example" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link href="<?= base_url('assets/css/font_google.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?= base_url('assets/css/pages/login/_login-1.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?= base_url('assets/plugins/global/_plugins.bundle.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?= base_url('assets/plugins/custom/prismjs/_prismjs.bundle.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?= base_url('assets/css/_style.bundle.css') ?>" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="<?= base_url('assets/media/logos/favicon.png') ?>" />
		<script>(function(h,o,t,j,a,r){ h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)}; h._hjSettings={hjid:1070954,hjsv:6}; a=o.getElementsByTagName('head')[0]; r=o.createElement('script');r.async=1; r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv; a.appendChild(r); })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');</script>
		<script async="async" src="<?= base_url('assets/js/googletag.js') ?>"></script>
		<script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'UA-37564768-1');</script>
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled page-loading">

		<div class="d-flex flex-column flex-root">
			<!--begin::Login-->
			<div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
				<!--begin::Aside-->
				<div class="login-aside d-flex flex-column flex-row-auto" style="background-color: #8950fc;">
					<!--begin::Aside Top-->
					<div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
						<!--begin::Aside header-->
						<a href="#" class="text-center mb-10">
							<img src="<?= base_url('assets/media/logos/logo-letter-1.png') ?>" class="max-h-70px" alt="" />
						</a>
						<!--end::Aside header-->
						<!--begin::Aside title-->
						<h3 class="font-weight-bolder text-left font-size-h4 font-size-h3-lg" style="color: #ffffff;text-align: justify;margin-right: 20px;margin-left: 20px;">DigitizeDocument is a Digital Mailroom extended tool.We provide DigitizeDocument as a system to help you connect with your document and information.</h3>
						<!--end::Aside title-->
					</div>
					<!--end::Aside Top-->
					<!--begin::Aside Bottom-->
					<div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-right" style="background-image: url(assets/media/logos/Asset-3.png);margin-bottom: 40px;margin-right: 20px; "></div>
					<!--end::Aside Bottom-->
				</div>
				<!--begin::Aside-->
				<!--begin::Content-->
				<div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
					<!--begin::Content body-->
					<div class="d-flex flex-column-fluid flex-center">
						<!--begin::Signin-->
						<div class="login-form login-signin">
							<!--begin::Form-->
							<form class="kt-form" action="<?= base_url('update_status/update_deliver_nondoc/loginUpdateDeliver') ?>" method="post" id="kt_login_form">
								<div class="pb-13 pt-lg-0 pt-5">
									<h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Welcome to DigitizeDocument</h3>
								</div>
								<div class="form-group">
									<label class="font-size-h6 font-weight-bolder text-dark">User</label>
									<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="text" name="username" id="id_userName" autocomplete="off" />
								</div>
								<div class="form-group">
									<div class="d-flex justify-content-between mt-n5">
										<label class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>
									</div>
									<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="password" name="password" id="id_password" autocomplete="off" />
									<input type="hidden" name="regNum" id="regNum" value="<?php echo $regNum; ?>">
									
								</div>
									<?php
		                                $tgl_hr_ini = date("Y-m-d");
		                                echo form_input(array('name' => 'tgl_login', 'class' => 'form-control placeholder-no-fix hidden', 'value' => "$tgl_hr_ini", 'id' => 'tgl_login', 'readonly' => 'readonly', 'autocomplete' => 'off','style' => 'display: none'));
		                                ?>
									<div class="kt-login__actions">
										<button id="btn_submit" class="btn btn-info" type="submit">Sign In</button>
									</div>
								</form>
							<!--end::Form-->
						</div>
						<!--end::Signin-->
					</div>
				</div>
				<!--end::Content-->
			</div>
			<!--end::Login-->
		</div>

		<!-- end:: Page -->

		<!-- begin::Global Config(global config for global JS sciprts) -->
		<script>
			var KTAppOptions = {
				"colors": {
					"state": {
						"brand": "#716aca",
						"light": "#ffffff",
						"dark": "#282a3c",
						"primary": "#5867dd",
						"success": "#34bfa3",
						"info": "#36a3f7",
						"warning": "#ffb822",
						"danger": "#fd3995"
					},
					"base": {
						"label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
						"shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
					}
				}
			};

		</script>

		<!-- end::Global Config -->

		<!--begin::Global Theme Bundle(used by all pages) -->
		<script src="<?= base_url('assets/plugins/global/plugins.bundle.js') ?>" type="text/javascript"></script>
		<script src="<?= base_url('assets/js/scripts.bundle.js') ?>" type="text/javascript"></script>

		<!--end::Global Theme Bundle -->

		<!--begin::Page Scripts(used by this page) -->
		<script src="<?= base_url('assets/js/pages/custom/login/login-1.js') ?>" type="text/javascript"></script>

		<script>

			 $('#kt_login_form').submit(function (e) {
			 	var regNum = $('#regNum').val();
			 	//alert(regNum);
			 	$("#btn_submit").attr("disabled", true);
			 	$('#btn_submit').addClass('spinner spinner-white spinner-right');
		        e.preventDefault();

				var form = $('#kt_login_form');

				form.validate({
					rules: {
						username: {
							required: true
						},
						password: {
							required: true
						}
					}
				});

				if (!form.valid()) {
					return;
				}

				setTimeout(function () {
					KTApp.unprogress(btn[0]);
				}, 2000);

				// ajax form submit:  http://jquery.malsup.com/form/
				form.ajaxSubmit({
	                type: "POST",
	            	dataType: "json",
	            	url: "<?= base_url('update_status/update_deliver_nondoc/loginUpdateDeliver') ?>",
	                success: function (data) {
						// similate 2s delay
						setTimeout(function () {
						$('#btn_submit').removeClass('spinner spinner-white spinner-right');
						$("#btn_submit").attr("disabled", false);
						var result = data.act;
							if(result == 0){
								 swal.fire({
					                        text: "Your username and/or password do not match,",
					                        icon: "error",
					                        buttonsStyling: false,
					                        confirmButtonText: "Ok!",
					                            customClass: {
					                    confirmButton: "btn font-weight-bold btn-light-danger"
					                  }
					                    }).then(function() {
					                KTUtil.scrollTop();
					              });
							} else if(result == 1) {
								//alert('aa');								
								window.location.href = '<?php echo base_url().'' ?>update_status/update_deliver_nondoc/home/?regNum='+ regNum;

							}

							
						}, 1000);
					}
	            });
		        
		    });
		</script>

		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>