<div class="row">
	<div class="col-md-6">
		<!--begin::Card-->
		<div class="card card-custom">
		    <div class="card-header">
		        <div class="card-title">
		            <span class="card-icon">
		                <i class="<?php echo $menu_icon; ?>"></i>
		            </span>
		            <h3 class="card-label"><?php echo strtoupper($menu_name); ?></h3>
		        </div>
		        <div class="card-toolbar">
		            
		        </div>
		    </div>
		    <div class="card-body">
		        <form method="post" id="id_from_sec_group_user"  method="post" action="javascript:;">
					<div class="kt-portlet__body" style="height: 165px;">					
						<div class="form-group">
							<label>Group User</label>
	                        <?php
	                        $data = array();
	                        $data[''] = '';
	                        foreach ($status_user as $row) :
	                            $data[$row['usergroup_id']] = $row['usergroup_desc'];
	                        endforeach;
	                        echo form_dropdown('status_user', $data, '', 'id="groupUserSelectID" class="form-control  input-sm" required="required" ');
	                        ?>
	                        <input type="hidden" name="menu_allow" class="form-control" placeholder="" id="id_menu_allow">
						</div>
					</div>

					<div class="kt-portlet__foot">
						<div class="kt-form__actions">
						<button type="button" name="btnSimpan" class="btn btn-primary" id="id_btnSimpan">Save</button>
						<button type="reset" class="btn btn-secondary" id="idBtnModalCancelMenuRoot" name="btnModalCancelMenuRoot">Cancel</button>
						</div>
					</div>
				</form>
		    </div>
		</div>
		<!--end::Card-->
	</div>
	<div class="col-md-6">
		<!--begin::Card-->
		<div class="card card-custom">
		    <div class="card-header">
		        <div class="card-title">
		            <span class="card-icon">
		                <i class="flaticon2-menu-2"></i>
		            </span>
		            <h3 class="card-label">MENU</h3>
		        </div>
		        <div class="card-toolbar">

		        </div>
		    </div>
		    <div class="card-body">
		        <form class="kt-form" method="post" action="<?php echo base_url('admin/sec_group_menu/home'); ?>">				<div class="kt-portlet__body">	
						<div class="kt-scroll" data-scroll="true" data-height="500" data-scrollbar-shown="true">
							<div id="kt_tree_3" class="scroller">
			                    <ul>
			                        <?php
			                        $i = 2;
			                        foreach ($menu_all as $data) {
			                            echo '<li id = "' . $data['id'] . '">';
			                            echo '<a href="#" id = "a' . $data['id'] . '">';
			                            echo $data['nama'];
			                            echo '</a>';
			                            echo '<ul>';
			                            echo print_recursive_menu_all_li($data['child']);
			                            echo '</ul>';
			                            echo '</li>';
			                            $i++;
			                        }
			                        ?>
			                    </ul>
			                </div>
						</div>			
					</div>
				</form>
		    </div>
		</div>
		<!--end::Card-->
	</div>
</div>






<script type="text/javascript">
	$('#kt_select2_1').select2({
        placeholder: "Select user group"
    });

    $('#kt_tree_3').jstree({
            'plugins': ["wholerow", "checkbox", "types"],
            'core': {
                "themes" : {
                    "responsive": false
                },  
            },
            "types" : {
                "default" : {
                    "icon" : "fa fa-folder text-warning"
                },
                "file" : {
                    "icon" : "fa fa-file  text-warning"
                }
            },
        });

    $("#groupUserSelectID").change(function () {
    	//alert('aa');
        var kd = $(this).val();
        kd = kd.trim();
        if (kd != '') {
            //  alert(kd);
            $.post("<?php echo site_url('admin/sec_group_menu/get_menu_group_user'); ?>",
            {
                'kd_group_user': kd
            },
            function (data) {
                console.log(data);
                var total_menu = data.data_menu.length;
                var i,j;
                $('#kt_tree_3').jstree("deselect_all");
                $("#kt_tree_3").jstree('open_all');

                for (i = 0; i < total_menu; i++) {
                    if (data.data_menu[i].parent == 0){
                        $("#a" + data.data_menu[i].menu_id).trigger('click');

                    }else{
                        $("#a" + data.data_menu[i].menu_id + "_" + data.data_menu[i].parent).trigger('click');
                    }
                }
            }, "json");
        }else{
        	$('#kt_tree_3').jstree("deselect_all");
        	$("#kt_tree_3").jstree('close_all');
        }
    });

    function get_selected_node_tree() {
    	//alert('aa');
        $("#id_menu_allow").val('');
        var result = $('#kt_tree_3').jstree('get_checked');
        $("#id_menu_allow").val(result);

    }

    $("#id_btnSimpan").click(function () {
        get_selected_node_tree();
        var a = $("#groupUserSelectID").val();
        if(a == ""){
        	alert('Select User Group');
        	$('#kt_tree_3').jstree("deselect_all");
        	$("#kt_tree_3").jstree('close_all');
        }else{
        	//alert('Select User Group 1111111');
	        dataString = $("#id_from_sec_group_user").serialize();
		    $.ajax({
		        type: "POST",
		        dataType: "json",
		        url: "<?php echo base_url(); ?>admin/sec_group_menu/saveMenuGroup",
		        data: dataString,
		        success:function(data)
		        {
		            UIToastr.init(data.tipePesan, data.pesan); 
		            setTimeout(function(){ location.reload(); }, 1000)	            
		        }
		    });
        }
    
    });
</script>

<!-- MODAL MENU ROOT II START -->
