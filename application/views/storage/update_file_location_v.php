<!--begin::Card-->
<div class="card card-custom" id="idCard1">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="<?php echo $menu_icon; ?>"></i>
            </span>
            <h3 class="card-label"><?php echo strtoupper($menu_name); ?></h3>
        </div>
        <div class="card-toolbar">
            <!-- <a href="#" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#kt_modal_Add">
                <i class="flaticon2-plus-1"></i>
                New Department
            </a> -->
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="scroll" style="min-height:400px; " id="divIdTable">
                <div class="row">
                    <div class="col-md-12">
                        <button id="id_Reload" style="display: none;"></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <form class="mb-15">
                            <div class="row mb-6">  
                            <div class="col-lg-3 mb-lg-0 mb-6">
                                    <label>Container:</label>
                                    <select id="containerID" name="container" required>
                                        <option value=""></option>
                                        <?php
                                            $data = array();
                                            $data[''] = '';
                                            //print_r($jenis_document);
                                            foreach ($getContainer as $row) :
                                        ?>       
                                            <option value="<?php echo trim($row->folder_id
                                            )."-".trim($row->group_document
                                            ) ?>"><?php echo trim($row->folder_name); ?></option>
                                        <?php
                                            endforeach;
                                        ?>
                                    </select>
                                </div>                              
                                <div class="col-lg-2 mb-lg-0 mb-6">
                                    <label>&nbsp;&nbsp;</label>
                                    <a class="btn btn-primary btn-primary--icon form-control datatable-input" id="kt_search" data-col-index="2" onclick="searchFile()">
                                    <span>
                                        <i class="la la-search"></i>
                                        <span>Search</span>
                                    </span>
                                </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="load_document" style="display:none;"></div>                    
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
<!--end::Card-->



<script type="text/javascript">

    $('#containerID').select2({
        width: '100%',
        placeholder: "Select Container"
    });

    function searchFile(){
        var folder_id = $('#containerID').val();
        if(folder_id==""){
            UIToastr.init('warning', 'Select Container');
            //alert('Select Container');
            return false;
        }else{
            $.ajax({
              url: '<?php echo base_url(); ?>storage/update_file_location/getListDoc',
              type: 'POST',
              data: {folder_id:folder_id},             
              success: function (jawaban){ 
                $('#load_document').fadeIn('slow');
                $('#load_document').html(jawaban);     
                    
              },
              beforeSend: function() {             
                  //$('#load_document').fadeIn('slow');
                }
            });
            return false; 
        }       
        
    }

    
</script>