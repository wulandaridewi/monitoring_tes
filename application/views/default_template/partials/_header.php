
<!--begin::Header-->
					<div id="kt_header" class="header header-fixed">

						<!--begin::Header Wrapper-->
						<div class="header-wrapper rounded-top-xl d-flex flex-grow-1 align-items-center">

							<!--begin::Container-->
							<div class="container d-flex align-items-center justify-content-end justify-content-lg-between flex-wrap">

								<!--begin::Menu Wrapper-->
								<div class="header-menu-wrapper header-menu-wrapper-left py-lg-2" id="kt_header_menu_wrapper">

									<!--begin::Menu-->
									<div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">

										<!--begin::Nav-->
										<ul class="menu-nav">
										<li class="menu-item menu-item-active" aria-haspopup="true">
											<a href="<?= base_url('main') ?>" class="menu-link">
												<span class="menu-text">Dashboard</span>
											</a>
										</li>
										<?php 
											$i = 0;
											// echo "<pre>";
											// print_r($multilevel);
											// echo "</pre>";
											foreach ($multilevel as $data) {
												$i++;
												$submenu = $data['child'];
												if($i == 1){
													$menuActive = "<li class='menu-item menu-item-submenu' data-menu-toggle='click' aria-haspopup='true' id='menu_root_".$data['id']."'><a href='javascript:;' class='menu-link menu-toggle'><span class='menu-text'>" . $data['nama'] . "</span><span class='menu-desc'></span><i class='menu-arrow'></i></a>";
												}else{
													$menuActive = "<li class='menu-item menu-item-submenu menu-item-rel' data-menu-toggle='click' aria-haspopup='true' id='menu_root_".$data['id']."'><a href='javascript:;' class='menu-link menu-toggle'><span class='menu-text'>" . $data['nama'] . "</span><span class='menu-desc'></span><i class='menu-arrow'></i></a>";
												}
												echo ''.$menuActive.'
														
														<div class="menu-submenu menu-submenu-classic menu-submenu-left">
															<ul class="menu-subnav">';
															foreach ($submenu as $key => $value) {
																$namamenu  = $value['nama'];
																$linkmenu  = $value['link'];
																$menu_icon = $value['menu_icon'];
																echo '<li class="menu-item" aria-haspopup="true">
																		<a href="'.base_url($linkmenu).'" class="menu-link">
																		<span class="svg-icon menu-icon">
																			<i class="'.$menu_icon.'">
																			<span>&nbsp;</span>
																		</i>
																		</span>
																		
																		<span class="menu-text">'.$namamenu.'</span>
																		</a>
																	</li>';
															}
												echo '
															</ul>
														</div>
													</li>';
											}							
										?>						
									</ul>
									<!--end::Nav-->
									</div>

									<!--end::Menu-->
								</div>

								<!--end::Menu Wrapper-->

								<!--begin::Toolbar-->
								<div class="d-flex align-items-center py-3">

									<!--begin::Dropdown-->
									<div class="dropdown dropdown-inline" data-toggle="tooltip" title="Quick actions" data-placement="left">
										<!-- <a href="#" class="btn btn-dark font-weight-bold px-6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Create</a> -->
										<div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-md dropdown-menu-right">

											<!--[html-partial:begin:{"id":"demo1/dist/inc/view/partials/content/dropdowns/dropdown-1","page":"index"}]/-->

											<!--begin::Navigation-->
											<ul class="navi navi-hover">
												<li class="navi-header font-weight-bold py-4">
													<span class="font-size-lg">Choose Label:</span>
													<i class="flaticon2-information icon-md text-muted" data-toggle="tooltip" data-placement="right" title="Click to learn more..."></i>
												</li>
												<li class="navi-separator mb-3 opacity-70"></li>
												<li class="navi-item">
													<a href="#" class="navi-link">
														<span class="navi-text">
															<span class="label label-xl label-inline label-light-success">Customer</span>
														</span>
													</a>
												</li>
												<li class="navi-item">
													<a href="#" class="navi-link">
														<span class="navi-text">
															<span class="label label-xl label-inline label-light-danger">Partner</span>
														</span>
													</a>
												</li>
												<li class="navi-item">
													<a href="#" class="navi-link">
														<span class="navi-text">
															<span class="label label-xl label-inline label-light-warning">Suplier</span>
														</span>
													</a>
												</li>
												<li class="navi-item">
													<a href="#" class="navi-link">
														<span class="navi-text">
															<span class="label label-xl label-inline label-light-primary">Member</span>
														</span>
													</a>
												</li>
												<li class="navi-item">
													<a href="#" class="navi-link">
														<span class="navi-text">
															<span class="label label-xl label-inline label-light-dark">Staff</span>
														</span>
													</a>
												</li>
												<li class="navi-separator mt-3 opacity-70"></li>
												<li class="navi-footer py-4">
													<a class="btn btn-clean font-weight-bold btn-sm" href="#">
														<i class="ki ki-plus icon-sm"></i>Add new</a>
												</li>
											</ul>

											<!--end::Navigation-->

											<!--[html-partial:end:{"id":"demo1/dist/inc/view/partials/content/dropdowns/dropdown-1","page":"index"}]/-->
										</div>
									</div>

									<!--end::Dropdown-->
								</div>

								<!--end::Toolbar-->
							</div>

							<!--end::Container-->
						</div>

						<!--end::Header Wrapper-->
					</div>

					<!--end::Header-->