<div class="row">
	<div class="col-md-6">
		<div class="card card-custom">
		    <div class="card-header">
		        <div class="card-title">
		            <span class="card-icon">
		                <i class="<?php echo $menu_icon; ?>"></i>
		            </span>
		            <h3 class="card-label"><?php echo strtoupper($menu_name); ?> ROOT</h3>
		        </div>
		        <div class="card-toolbar">
		            
		        </div>
		    </div>
		    <div class="card-body">
		        <form class="kt-form" method="post" action="<?php echo base_url('admin/sec_menu/home'); ?>">
					<div class="kt-portlet__body">
						<div>
		                    <span id="event_result">
		                        <?php
		                        if ($this->session->flashdata('successRoot') != '') {
		                            echo '<div class="alert alert-custom alert-light-primary fade show mb-5" role="alert">
										<div class="alert-icon"><i class="flaticon-interface-5"></i></div>
										<div class="alert-text">' . $this->session->flashdata('successRoot') . '</div>
										<div class="alert-close">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true"><i class="flaticon2-cross"></i></span>
											</button>
										</div>
									</div>';
		                        }
		                        if ($this->session->flashdata('errorRoot') != '') {
		                            echo '<div class="alert alert-custom alert-light-danger fade show mb-5" role="alert">
										<div class="alert-icon"><i class="flaticon-cancel"></i></div>
										<div class="alert-text">' . $this->session->flashdata('errorRoot') . '</div>
										<div class="alert-close">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true"><i class="flaticon2-cross"></i></span>
											</button>
										</div>
									</div>';
		                        }
		                        ?>
		                    </span>
		                </div>
						<div class="form-group ">
							<label>Menu Root</label>
							<div class="input-group">
								<input id="id_idRootMenu" class="form-control" type="hidden" name="idRootMenu"/>
								<input class="form-control" type="text" name="nameMenuRoot" id="idNameMenuRoot" required="">
								<div class="input-group-append">
									<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#kt_modal_1_2"><i class="flaticon2-search" style="color: white;"></i></button>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Sequence Menu Root</label>
							<input type="number" class="form-control" name="squenceMenuRoot" id="idSquenceMenuRoot" required="">
						</div>
					</div>

					<div class="kt-portlet__foot">
						<div class="kt-form__actions">
							<button class="btn btn-primary" id="idBtnModalSaveMenuRoot" name="btnModalSaveMenuRoot">Save</button>
							<button class="btn btn-warning" id="idBtnModalEditMenuRoot" name="btnModalEditMenuRoot">Edit</button>
							<button class="btn btn-danger" id="idBtnModalDeleteMenuRoot" name="btnModalDeleteMenuRoot">Delete</button>
							<button type="reset" class="btn btn-secondary" id="idBtnModalCancelMenuRoot" name="btnModalCancelMenuRoot">Cancel</button>
						</div>
					</div>
				</form>
		    </div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card card-custom">
		    <div class="card-header">
		        <div class="card-title">
		            <span class="card-icon">
		                <i class="flaticon2-menu"></i>
		            </span>
		            <h3 class="card-label"><?php echo strtoupper($menu_name); ?></h3>
		        </div>
		        <div class="card-toolbar">
		            
		        </div>
		    </div>
		    <div class="card-body">
		        <form class="kt-form" method="post" action="<?php echo base_url('admin/sec_menu/home'); ?>">				
					<div class="kt-portlet__body">
						<div>
		                    <span id="event_result">
		                        <?php
		                        if ($this->session->flashdata('successMenu') != '') {
		                            echo '<div class="alert alert-custom alert-light-primary fade show mb-5" role="alert">
										<div class="alert-icon"><i class="flaticon-interface-5"></i></div>
										<div class="alert-text">' . $this->session->flashdata('successMenu') . '</div>
										<div class="alert-close">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true"><i class="flaticon2-cross"></i></span>
											</button>
										</div>
									</div>';
		                        }
		                        if ($this->session->flashdata('errorMenu') != '') {
		                            echo '<div class="alert alert-custom alert-light-danger fade show mb-5" role="alert">
										<div class="alert-icon"><i class="flaticon-cancel"></i></div>
										<div class="alert-text">' . $this->session->flashdata('errorMenu') . '</div>
										<div class="alert-close">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true"><i class="flaticon2-cross"></i></span>
											</button>
										</div>
									</div>';
		                        }
		                        ?>
		                    </span>
		                </div>
						<input id="id_tempTreeFlag" class="form-control" type="hidden" name="tempTreeFlag"/>
						<div class="form-group ">
							<label>Menu Root</label>					
							<div class="input-group">
								<input id="id_idParent" class="form-control" type="hidden" name="idParent" placeholder=""/>
								<input type="text" class="form-control" name="nameMenuRoot2" id="idNameMenuRootNew">
								<div class="input-group-append">
									<button class="btn btn-primary" type="button" id="id_btnModalTreeParent" data-toggle="modal" data-target="#kt_modal_1_3"><i class="flaticon2-search" style="color: white;"></i></button>
								</div>
							</div>
						</div>
						<div class="form-group ">
							<label>Menu</label>
							<div class="input-group">
								<input id="id_idMenu" class="form-control" type="hidden" name="idMenu" placeholder=""/>
								<input type="text" class="form-control" name="nameMenu" id="idNameMenu">
								<div class="input-group-append">
									<button class="btn btn-primary" type="button" id="id_btnModalTreeMenu" data-toggle="modal" data-target="#kt_modal_1_3"><i class="flaticon2-search" style="color: white;"></i></button>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Header Menu</label>
							<input type="text" class="form-control" name="headerMenu" id="idHeaderMenu">
						</div>
						<div class="form-group">
							<label>Uri Menu</label>
							<input type="text" class="form-control" name="uriMenu" id="idUriMenu">
						</div>
						<div class="form-group">
							<label>Sequence Menu</label>
							<input type="number" class="form-control" name="squenceMenu" id="idSquenceMenu">
						</div>
						<div class="form-group">
							<label>Icon Menu</label>
							<input type="text" class="form-control" name="iconMenu" id="idIconMenu">
						</div>
					</div>
					<div class="kt-portlet__foot">
						<div class="kt-form__actions">
							<button class="btn btn-primary" id="idBtnModalSaveMenu" name="btnModalSaveMenu">Save</button>
							<button class="btn btn-warning" id="idBtnModalEditMenu" name="btnModalEditMenu">Edit</button>
							<button class="btn btn-danger" id="idBtnModalDeleteMenu" name="btnModalDeleteMenu">Delete</button>
							<button class="btn btn-secondary" id="idBtnModalCancelMenu" name="btnModalCancelMenu" type="reset" >Cancel</button>
						</div>
					</div>
				</form>
		    </div>
		</div>
	</div>
</div>

<!-- MODAL MENU ROOT I START -->
<div class="modal fade" id="kt_modal_1_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel"><i class="<?php echo $menu_icon; ?>"></i>&nbsp;&nbsp;<?php echo strtoupper($menu_name); ?> ROOT</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			</button>
		</div>
		<div class="modal-body">
				<div id="kt_tree_2" class="tree-demo jstree jstree-2 jstree-default" role="tree" aria-multiselectable="true" tabindex="0" aria-activedescendant="j2_1" aria-busy="false">
					<ul class="jstree-container-ul jstree-children" role="group">
						<?php
                            foreach ($menu_all as $data) {
                                echo '<li id = "b' . $data['id'] . '" role="treeitem" aria-selected="false" aria-level="1" aria-labelledby="j2_1_anchor" aria-expanded="true" class="jstree-node jstree-open"><i class="jstree-icon jstree-ocl" role="presentation"></i>';
                                echo '<a href="#" id = "b' . $data['id'] . '" class =jstree-anchor"><i class="jstree-icon jstree-themeicon fa fa-folder kt-font-warning jstree-themeicon-custom" role="presentation"></i>';
                                echo $data['nama'];
                                echo '</a>';
                                echo '<ul>';
                                echo '</ul>';
                                echo '</li>';
                            }
                        ?>
						
					</ul>
				</div>												
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" id="idBtnModalCloseMenuRoot" data-dismiss="modal">Close</button>
		</div>
	</div>
</div>
</div>
<!-- MODAL MENU ROOT I START -->

<!-- MODAL MENU ROOT II START -->
<div class="modal fade" id="kt_modal_1_3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel"><i class="<?php echo $menu_icon; ?>"></i>&nbsp;&nbsp;<?php echo strtoupper($menu_name); ?> ROOT</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			</button>
		</div>
		<div class="modal-body">
				<div id="kt_tree_21" class="tree-demo jstree jstree-2 jstree-default" role="tree" aria-multiselectable="true" tabindex="0" aria-activedescendant="j2_1" aria-busy="false">
					<ul class="jstree-container-ul jstree-children" role="group">
						<?php
                            foreach ($menu_all as $data) {
                            	$submenu = $data['child'];
                            	// echo "<pre>";
                            	// print_r($data['child']);
                            	// echo "</pre>";
                                echo '<li id = "' . $data['id'] . '" role="treeitem" aria-selected="false" aria-level="1" aria-labelledby="j2_1_anchor" aria-expanded="true" class="jstree-node jstree-open"><i class="jstree-icon jstree-ocl" role="presentation"></i>';
                                echo '<a href="#" id = "a' . $data['id'] . '" class =jstree-anchor"><i class="jstree-icon jstree-themeicon fa fa-folder kt-font-warning jstree-themeicon-custom" role="presentation"></i>';
                                echo $data['nama'];
                                echo '</a>';
                                echo '<ul role="group" class="jstree-children">';
                                echo print_recursive_secMenuUser($data['child']);
                                echo '</ul>';
                                echo '</li>';
                            }
                        ?>
						
					</ul>
				</div>												
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" id="idBtnModalCloseMenu" data-dismiss="modal">Close</button>
		</div>
	</div>
</div>
</div>


<script type="text/javascript">
	var inputMenuRoot   = document.getElementById('idNameMenuRoot').value;
	var squenceMenuRoot = document.getElementById("idSquenceMenuRoot").value;
	document.getElementById("idBtnModalSaveMenuRoot").onclick   = function() {btnSaveRoot()};
	document.getElementById("idBtnModalEditMenuRoot").onclick   = function() {btnEditRoot()};
	document.getElementById("idBtnModalDeleteMenuRoot").onclick = function() {btnDeleteRoot()};
	
	//var inputMenuRoot = $('#idNameMenuRoot');
	//var btnSaveRoot = $('#idBtnModalSaveMenuRoot');
	function btnSaveRoot() {
		//alert(squenceMenuRoot);
		// if(inputMenuRoot != "" && squenceMenuRoot != ""){
		// 	//alert('tes');
		// 	$('#idBtnModalSaveMenuRoot').addClass('kt-spinner kt-spinner--right kt-spinner--md kt-spinner--light');
		// }
		$('#idBtnModalSaveMenuRoot').addClass('kt-spinner kt-spinner--right kt-spinner--md kt-spinner--light');
	}
	function btnEditRoot() {
		$('#idBtnModalEditMenuRoot').addClass('kt-spinner kt-spinner--right kt-spinner--md kt-spinner--light');
	}
	function btnDeleteRoot() {
		$('#idBtnModalDeleteMenuRoot').addClass('kt-spinner kt-spinner--right kt-spinner--md kt-spinner--light');
	}
</script>

<script type="text/javascript">
	$('#id_btnModalTreeParent').click(function () {
            $("#id_tempTreeFlag").val(0);
        });
        /*Jika lihat data menu biasa*/
        $('#id_btnModalTreeMenu').click(function () {
            $("#id_tempTreeFlag").val(1);
        });
		$('#kt_tree_2').jstree({
	            "core" : {
	                "themes" : {
	                    "responsive": false
	                }            
	            },
	            "types" : {
	                "default" : {
	                    "icon" : "fa fa-folder text-warning"
	                },
	                "file" : {
	                    "icon" : "fa fa-file  text-warning"
	                }
	            },
	            "plugins": ["types"]
	        });

	        // handle link clicks in tree nodes(support target="_blank" as well)
	        $('#kt_tree_2').on('select_node.jstree', function(e,data) { 
	            console.log(data);
                var menuRootText = data.node.text;
                var menuRootId = data.node.id
                var menuRootId = menuRootId.substr(1);
                $("#idNameMenuRoot").val("");
                $("#id_idRootMenu").val("");
                $("#id_idRootMenu").val(menuRootId);
                $("#idNameMenuRoot").val(menuRootText);
                getDescMenuRoot(menuRootId.trim());
                //urutMenuRoot

                $('#idBtnModalCloseMenuRoot').trigger('click');
                $("#idBtnModalSaveMenuRoot").attr("disabled", "disabled");
                $("#idBtnModalEditMenuRoot").removeAttr("disabled");
                $("#idBtnModalDeleteMenuRoot").removeAttr("disabled");
	        });

	        function getDescMenuRoot(idMenu) {
            if (idMenu != '') {
                $.post("<?php echo site_url('admin/sec_menu/getDescMenu'); ?>",
                        {
                            'idMenu': idMenu
                        }, function (data) {
                    if (data.baris == 1) {
                        $('#idSquenceMenuRoot').val(data.urutan);
                        /*
                         $('#').val(data.); */
                    } else {
                        alert('Data tidak ditemukan!');
                        $('#id_btnBatal').trigger('click');
                    }
                }, "json");
            }
        }

        $('#kt_tree_21').jstree({
	            "core" : {
	                "themes" : {
	                    "responsive": false
	                }            
	            },
	            "types" : {
	                "default" : {
	                    "icon" : "fa fa-folder text-warning"
	                },
	                "file" : {
	                    "icon" : "fa fa-file text-warning"
	                }
	            },
	            "plugins": ["types"]
	        });

	        // handle link clicks in tree nodes(support target="_blank" as well)
	        $('#kt_tree_21').on('select_node.jstree', function(e,data) { 
	            console.log(data);
                    var tempTreeFlag = $("#id_tempTreeFlag").val();
                    var menuText 	 = data.node.text;
                    var menuId 	     = data.node.id
                    var menuIdParent = data.node.parent;
                    //alert(menuText+'-'+menuId+'-'+menuIdParent);
                    /*
                     var menuIdArray 	= new Array();
                     menuIdArray		= menuId.split("_");*/
                    if (tempTreeFlag == 0) {//jika Parent menu
                        $("#id_idParent").val((menuId.trim()));
                        $("#idNameMenuRootNew").val(menuText);
                        $('#idBtnModalCloseMenu').trigger('click');
                    } else {//jika menu biasa
                        if (menuIdParent == '#') {
                            alert("Root menu tidak dapat dikonfigurasi di form ini !");
                        } else {
                            /*Kosongkan parent id dan desc jika menu yang diselect tidak punya parent*/
                            $("#id_idParent").val("");
                            $("#idNameMenuRootNew").val("");
                            /*End Kosongkan parent id dan desc jika menu yang diselect tidak punya parent*/
                            $("#id_idParent").val((menuIdParent.trim()));//ID Parent

                            var idMenuTextParent = $("#id_idParent").val();
                            var menuTextParent = $('#a' + idMenuTextParent).text();

                            $("#idNameMenuRootNew").val(menuTextParent);//Text Parent
                            $("#id_idMenu").val((menuId.trim()));//ID Menu
                            var menuUri = $("#a" + menuId).attr('attrMenuUri');// get nama class dari id node child_parent 
                            $("#idUriMenu").val(menuUri);//menuUri
                            $("#idNameMenu").val(menuText);//Deskripsi Menu

                            getDescMenu(menuId.trim());

                            $("#idBtnModalEditMenu").removeAttr("disabled");
                            $("#idBtnModalDeleteMenu").removeAttr("disabled");
                            $('#idBtnModalCloseMenu').trigger('click');
                            $("#idBtnModalSaveMenu").attr("disabled", "disabled");
                        }
                    }
	        });

	        function getDescMenuRoot(idMenu) {
            if (idMenu != '') {
                $.post("<?php echo site_url('admin/sec_menu/getDescMenu'); ?>",
                        {
                            'idMenu': idMenu
                        }, function (data) {
                    if (data.baris == 1) {
                        $('#idSquenceMenuRoot').val(data.urutan);
                        /*
                         $('#').val(data.); */
                    } else {
                        alert('Data tidak ditemukan!');
                        $('#idBtnModalCancelMenuRoot').trigger('click');
                    }
                }, "json");
            }
        }

        function getDescMenu(idMenu) {
            if (idMenu != '') {
                $.post("<?php echo site_url('/admin/sec_menu/getDescMenu'); ?>",
                        {
                            'idMenu': idMenu
                        }, function (data) {
                    if (data.baris == 1) {
                        $('#idHeaderMenu').val(data.header);
                        $('#idSquenceMenu').val(data.urutan);
                        $('#idIconMenu').val(data.menu_icon);
                        /*
                         $('#').val(data.); */
                    } else {
                        alert('Data tidak ditemukan!');
                        $('#idBtnModalCancelMenu').trigger('click');
                    }
                }, "json");
            }
        }
        

</script>
<!-- MODAL MENU ROOT II START -->
