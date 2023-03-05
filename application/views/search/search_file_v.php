<!--begin::Card-->
<div class="card card-custom" id="idCard1">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon-search"></i>
            </span>
            <h3 class="card-label"><?php echo strtoupper($menu_name); ?></h3>
        </div>
        <div class="card-toolbar">
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="scroll" style="min-height:400px; " id="divIdTable">
                <div class="row">
                    <div class="col-md-12">
                        <button id="id_Reload4" style="display: none;"></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row mb-6">  
                            <div class="col-lg-4 mb-lg-0 mb-6">
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
                                            )?>"><?php echo trim($row->folder_name); ?></option>
                                        <?php
                                            endforeach;
                                        ?>
                                    </select>
                                </div>                              
                                <div class="col-lg-4 mb-lg-0 mb-6">
                                    <label>Category Document:</label>
                                    <select class="form-control" id="categoryDocID" name="categoryDoc" required="">
                                        <option></option>
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
                                <?php 
                                    $usergroup = $this->session->userdata('usergroup');
                                    if($usergroup == 1){
                                ?>
                                <div class="col-lg-2 mb-lg-0 mb-6">
                                    <label>&nbsp;&nbsp;</label>
                                    <a class="btn btn-primary btn-primary--icon form-control datatable-input" id="kt_search" data-col-index="2" onclick="downloadExcel()">
                                    <span>
                                        <i class="fas fa-file-download"></i>
                                        <span>Download</span>
                                    </span>
                                    </a>
                                </div>
                                <?php
                                    }
                                ?>                               
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-separate table-head-custom table-checkable" id="idTabelListDoc">
                            <thead>
                                <tr> 
                                    
                                </tr>
                            </thead>
                            <tbody>
                                                                                
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
<!--end::Card-->

<!--begin::Card 5-->
<div class="card card-custom" id="idCard2" style="display: none;">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon-search"></i>
            </span>
            <h3 class="card-label"><?php echo strtoupper($menu_name); ?></h3>
        </div>
        
        <div class="card-toolbar">
             <a href="#" class="btn btn-primary font-weight-bolder mr-2" id="btnBackDisplayDoc">
                <i class="flaticon2-back-1"></i>
                Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="scroll" style="min-height:500px; " id="divIdTable5">
                <div class="row">
                    <div class="col-md-12">
                        <button id="id_Reload5" style="display: none;"></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="row" id="idDivIframe">
                            <div class="col-md-12">
                                <div class="embed-responsive embed-responsive-16by9 z-depth-1-half" style="height: 25cm;">
                                  <iframe class="embed-responsive-item" allowfullscreen width="auto" height="auto" id="myFrame" type="application/pdf"></iframe>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-custom shadow-lg p-3 mb-5 bg-white rounded">
                            <div class="card-header ribbon ribbon-top ribbon-ver">
                                 <h3 class="card-title" id="idDocKet" style="font-weight: bold"></h3>
                            </div>
                            <div class="card-body">
                                <div id="idIndexingGeneralFile"></div>
                                <div id="idIndexingSpecificFile"></div>
                            </div>
                        </div>
                    </div>
                </div>               
                <!-- END ROW-->
            </div>
            <!--  -->
        </div>    
    </div>
</div>
<!--end::Card 5-->
<!-- Modal detilShareDoc -->
<div class="modal fade" id="kt_modal_detailShareDoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="kt-font-brand kt-font-bold"><i class="fa fa-share-alt"></i>&nbsp;&nbsp;Share Document</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
                <label>Search:<input type="search" class="form-control form-control-sm" id="myInputTextFieldSearch"></label>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <button id="reloadtableDetailShareDocSearch" style="display: none;"></button>
                    </div>
                </div>
                <form class="kt-form" id="form_detailShareDoc" method="post" action="javascript:;">
                    <div class="kt-portlet__body table-responsive">   
                        <table class="table table-head-custom table-head-bg table-borderless table-vertical-center" id="tableDetailShareDocSearch">
                            <thead>
                                <tr class="text-left text-uppercase">
                                    <!-- <th style="min-width: 200px">Date</th> -->
                                    <th>No.</th>
                                    <th  class="pl-7">
                                        <span>User</span>
                                    </th>
                                    <th >Date</th>
                                    <th >Shared By</th>
                                    <th >Status</th>
                                    <th >Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                                               
                            </tbody>
                        </table>                    

                    </div>            
                    
                </form>
            </div>
            <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
         </div>
    </div>
</div>
<!--begin:: Modal detilShareDoc-->
<script type="text/javascript">
    $('#categoryDocID').select2({
        width: '100%',
        placeholder: "Select Category"
    });
    $('#containerID').select2({
        width: '100%',
        placeholder: "Select Container"
    });

    function searchFile(){
        $('table#idTabelListDoc thead tr th').remove();
        var categoryDocID = $('#categoryDocID').val();
        var containerID   = $('#containerID').val();
        if(containerID==""){
            UIToastr.init('warning', 'Select Container');
            //alert('Select Container');
            return false;
        }else{
            if(categoryDocID==""){
                UIToastr.init('warning', 'Select Category Document');
                //alert('Select Category Document');
                return false;
            }else{
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: '<?php echo base_url(); ?>search/search_file/getListDocDetailFolder',
                    data: {document_id:categoryDocID,folder_id:containerID},  
                    success: function(result)
                    {   
                         //ADD HEADER TABLE LIS DOCUMENT
                            if($.fn.DataTable.isDataTable( '#idTabelListDoc' )){
                                $('#idTabelListDoc').dataTable().fnClearTable();
                                $("#idTabelListDoc").dataTable().fnDestroy();  
                            }                    

                            $('#idTabelListDoc').find('thead').empty();
                            var content = '<tr>';

                            content += '<th></th>';
                            content += '<th></th>';
                            content += '<th>DOCUMENT</th>';
                             $.each(result.getFieldNameIndexGeneral, function(key, val) {
                                content += '<th>'+val.general_index_name+'</th>';
                            }); 
                            $.each(result.getFieldNameIndexSpecific, function(key, val) {
                                content += '<th>'+val.specific_index_name+'</th>';
                            }); 
                            content += '<th>DOCUMENT SIZE</th>';

                            content += '</tr>';

                            $('#idTabelListDoc').find('thead').append(content);
                            //END ADD HEADER TABLE LIS DOCUMENT      
                        var valueLoadListDoc = categoryDocID+'+'+containerID;
                        initTableListDocument(valueLoadListDoc);         
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error get data from ajax');
                    }
                }); 
            }
        }      
    }

    function initTableListDocument(valueLoadListDoc) {
        // begin first table
        //$("#idTabelListDoc").dataTable().fnDestroy(); 
        var hasilSplit    = valueLoadListDoc.split("+");
        var document_id = hasilSplit[0];        
        var folderId = hasilSplit[1]; 

        var table = $('#idTabelListDoc').DataTable({
            responsive: true,
            searching: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?php echo base_url(); ?>search/search_file/getListDoc',
                type: 'POST',
                data: {document_id:document_id,folderId:folderId}, 
            },
            // "initComplete": function(settings, json) {
            //     $("#pageloader").fadeOut();
            //   }
        });
        $('#id_Reload4').click(function () {
            table.ajax.reload( null, false );
            //table.ajax.reload();
        });
    }; 

    function prepareFrame(trans_doc_id) {  

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>search/search_file/getKetFile",
            // data: { subFolder: subFolder,document_id: document_id,trans_doc_id: trans_doc_id,folder_id: folder_id},
            data: { trans_doc_id: trans_doc_id},  
            success: function(result)
            {   
                var document_name = result.document_name; 
                var file_name     = result.file_name; 
                var folder_name   = result.folder_name; 
                var sub_folder    = result.sub_folder; 
                document.getElementById('idDocKet').textContent = result.document_name;    
                $.each(result.getGeneralIndexName, function(key, val) {  
                    $('#idIndexingGeneralFile').append('<div class="row"><label for="example-password-input" class="col-5 col-form-label"><b>'+val.general_index_name+'</b></label><label class="col-1 col-form-label"><b>:</b></label><div class="col-5"><label for="example-password-input" class="col-form-label"><b>'+val.general_index+'</v></label></div></div>');                  
                });
                 $.each(result.getSpecificIndexName, function(key, val) {
                    // $('#idIndexingGeneralFile').append('<label>'+val.general_index_name+'&nbsp;<span>&nbsp;:&nbsp;</span>'+val.general_index+'</label>');  
                    var indexFormat = val.specific_index_format;
                    var specificIndex = val.specific_index;
                    if(indexFormat == 4){
                        if(specificIndex == ""||specificIndex=="NULL"){
                            specificIndex = "0.00";
                        }else{
                            specificIndex = addCommas(val.specific_index);
                        }
                        
                    } 
                    $('#idIndexingSpecificFile').append('<div class="row"><label for="example-password-input" class="col-5 col-form-label"><b>'+val.specific_index_name+'</b></label><label class="col-1 col-form-label"><b>:</b></label><div class="col-5"><label for="example-password-input" class="col-form-label"><b>'+specificIndex+'</b></label></div></div>');                  
                });
                          
                document.getElementById( 'idCard1' ).style.display   = 'none'; 
                document.getElementById( 'idCard2' ).style.display   = 'block'; 
                var omyFrame = document.getElementById("myFrame");
                omyFrame.src = "<?php echo base_url(); ?>uploads/"+folder_name+"/"+sub_folder+"/"+document_name+"/"+file_name;
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    
     $('#btnBackDisplayDoc').on('click', function() {
        //$("#idTabel4").dataTable().fnDestroy();
        $('#idIndexingGeneralFile').empty();
        $('#idIndexingSpecificFile').empty();
        document.getElementById( 'idCard2' ).style.display   = 'none';
        document.getElementById( 'idCard1' ).style.display   = 'block';
        $("#kt_search").trigger('click');        
    });

     $("#containerID").change(function () {
        
        document.getElementById("categoryDocID").innerHTML = "<option></option>";
        var folder_id = this.value;
        //alert(folder_id);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>search/search_file/getDocument",
            data: { folder_id: folder_id }, 
            success: function(result)
            {   
                $.each(result, function(key, val) {
                    var document_id    = val.document_id;
                    var document_name  = val.document_name;
                    var opt = document.createElement("option");
                    document.getElementById("categoryDocID").innerHTML += '<option value="' + document_id + '">' + document_name + '</option>';
                });
                
              
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });       
    });

    function downloadExcel(){
        var categoryDocID = $('#categoryDocID').val();
        var containerID = $('#containerID').val();
        var hasilSplit     = containerID.split("#");
        var folder_id      = hasilSplit[0];
        if(containerID==""){
            UIToastr.init('warning', 'Select Container');
            //alert('Select Container');
            return false;
        }else{
            if(categoryDocID==""){
                UIToastr.init('warning', 'Select Category Document');
                //alert('Select Category Document');
                return false;
            }else{
               window.location= "<?php echo base_url(); ?>search/search_file/downloadExcel/?document_id="+categoryDocID+"&folder_id="+folder_id;   
            }
        }             
    }

     function detilShareDoc(valueLoadListDoc){  
    // alert('adad');  
        var hasilSplit        = valueLoadListDoc.split("+");
        var trans_doc_id      = hasilSplit[0];        
        var group_user_doc_id = hasilSplit[1]; 
        $("#tableDetailShareDocSearch").dataTable().fnDestroy();
        var table = $('#tableDetailShareDocSearch').DataTable({
            responsive: true,
            bFilter: false,
            ordering:false,
            searching: true,
            processing: false,
            serverSide: false,
            paging: false,
            dom: 't'  ,
            ajax: {
                url: '<?php echo base_url(); ?>search/search_file/getUserShare',
                type: 'POST',
                data: { trans_doc_id: trans_doc_id,group_user_doc_id:group_user_doc_id}, 
            },

        });
        $('#reloadtableDetailShareDocSearch').click(function () {
            table.ajax.reload( null, false );
        });

        $('#kt_modal_detailShareDoc').modal('show');   
        $('#myInputTextFieldSearch').keyup(function(){
          table.search($(this).val()).draw() ;
        });
        // $('#myInputTextFieldSearch').keyup(function(){
        //   table.fnFilter(this.value);
        // });
     
    } 

    function deleteShareDoc(valueLoadListDoc){
    //alert(trans_doc_id);
        var hasilSplit   = valueLoadListDoc.split("+");
        var trans_doc_id = hasilSplit[0];        
        var userid       = hasilSplit[1]; 
        Swal.fire({
            title: "Are you sure?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Unshare it!"
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "<?php echo base_url(); ?>search/search_file/deleteShareDoc",
                    data: { trans_doc_id: trans_doc_id,userid: userid }, 
                    success: function(data){
                        Swal.fire(
                            "Deleted!",
                            "success"
                        )
                        $("#reloadtableDetailShareDocSearch").trigger('click');   
                    }
                });   
            }
        });       
    }
</script>