<!--begin::Card 1-->
<style type="text/css">

</style>

<!--card my container-->
<div class="card card-custom" id="idCardContainer">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="fa far fa-folder"></i>
            </span>
            <h3 class="card-label"><?php echo strtoupper($menu_name); ?></h3>
        </div>
        <div class="card-toolbar">
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="scroll" style="min-height:400px; " id="divIdTableContainer">
                <div class="row">
                    <div class="col-md-12">
                        <button id="id_Reload" style="display: none;"></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-separate table-head-custom table-checkable" id="idTableContainer">
                            <thead>
                                <tr> 
                                    <th>
                                        No.
                                    </th>                                    
                                    <th>
                                        folder id
                                    </th>                                    
                                    <th>Actions</th>
                                    <th>
                                        Title
                                    </th>
                                    <th>
                                        Create BY
                                    </th>
                                    <th>
                                        Create Date
                                    </th>
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
<!--End card my container-->

<!--card Sub container-->
<div class="card card-custom" id="idCardSubContainer" style="display: none;">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="fa far fa-folder-open"></i>
            </span>
            <h3 class="card-label" id="folderNameOpen"></h3>
        </div>
        <div class="card-toolbar">
            <a href="#" id="idBtnAddSubContainer" class="btn btn-primary font-weight-bolder mr-2" data-toggle="modal" data-target="#modal_add_sub_container" onclick="openDataModalSubCategory()">
                <i class="flaticon2-plus-1"></i>
                Add Sub Container
            </a>
            <a href="#" class="btn btn-primary font-weight-bolder mr-2" id="btnBackContainer">
                <i class="flaticon2-back-1"></i>

                Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="scroll" style="min-height:400px; " id="divIdTableSubContainer">
                <div class="row">
                    <div class="col-md-12">
                        <button id="id_Reload2" style="display: none;"></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">                        
                    <input type="text" id="folderIdSubContainer"/>
                    <input type="text" id="folderNameSubContainer"/>
                        <table class="table table-separate table-head-custom table-checkable" id="idTabelSubContainer">
                            <thead>
                                <tr> 
                                    <th>
                                        No
                                    </th>                                     
                                    <th>Actions</th>
                                    <th>
                                        Title
                                    </th>
                                    <th>
                                        SubFOlderID
                                    </th>
                                    <th>
                                        Modified BY
                                    </th>
                                    <th>
                                        Last Modified
                                    </th>
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
<!--End card Sub container-->

<!-- Modal Add Sub Container -->
<div class="modal fade" id="modal_add_sub_container" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="kt-font-brand kt-font-bold"><i class="flaticon2-plus-1"></i>&nbsp;&nbsp;Add Sub Container</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form class="kt-form" id="form_add_sub_container" method="post" action="javascript:;">
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" id="folderIdSubContainerAdd" name="folderIdSubContainerAdd"/>
                                    <input type="text" id="folderNameSubContainerAdd" name="folderNameSubContainerAdd"/>
                                    <table id="dynamic_field_general2" border="0" width="100%"></table>
                                </div>
                            </div>
                        </div>                       
                    </div>            
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" id="submitSubContainer" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--End Modal Add Sub Container-->

<!--begin::Card List Category Document-->
<div class="card card-custom" id="idCardListCategoryDoc" style="display: none;">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="fa far fa-folder-open"></i>
            </span>
            <h3 class="card-label" id="idLabelFolder"></h3>
        </div>
        
        <div class="card-toolbar">
            <a href="#" id="idBtnAddDocInListCategoryDoc" class="btn btn-primary font-weight-bolder mr-2" id="idAddDoc" data-toggle="modal" data-target="#modal_add_document" onclick="openDataModalAddDocInListCategoryDoc()">
                <i class="flaticon2-plus-1"></i>
                Add Document
            </a>
            <a href="#" class="btn btn-primary font-weight-bolder mr-2" id="btnBackSubContainer">
                <i class="flaticon2-back-1"></i>

                Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="scroll" style="min-height:400px; " id="divIdTableListCategoryDoc">
                <div class="row">
                    <div class="col-md-12">
                        <button id="id_Reload3" style="display: none;"></button>
                    </div>
                </div>
                <div class="col-md-12">
                    <input type="text" id="folderIdListCategoryDoc"/>
                    <input type="text" id="subFolderIdListCategoryDoc"/>
                    <input type="text" id="folderNameListCategoryDoc"/>
                    <input type="text" id="subFolderListCategoryDoc"/>
                    <table class="table table-separate table-head-custom table-checkable" id="idTableListCategoryDoc">
                            <thead>
                                <tr> 
                                    <th>
                                        No
                                    </th> 
                                    <th>Actions</th>
                                    <th>
                                        Category Document
                                    </th>
                                    <th>
                                        Total Document
                                    </th>                                    
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
<!--End::Card List Category Document-->

<!-- Modal Add -->
<div class="modal fade" id="modal_add_document" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="kt-font-brand kt-font-bold"><i class="flaticon2-plus-1"></i>&nbsp;&nbsp;Add Document</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body" id="idBodyModalAdd">
                <form class="kt-form" id="form_add_document" action="<?php echo base_url('container/my_container/home'); ?>" action="javascript:;">
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Category Document</label>
                                <input type="text" class="form-control" id="idFlagRemoveFile" value="0" />
                                <!-- <input type="text" class="form-control" id="idDocID"/> -->
                                <input type="text" class="form-control" id="idCardDisplay"/>  
                                <input type="text" class="form-control" id="folderIdListCategoryDocAdd" name="folderID"/>
                                <input type="text" class="form-control" id="folderNameListCategoryDocAdd" name="folderNameID"/>
                                <input type="text" class="form-control" id="subFolderIdListCategoryDocAdd" name="subFolderIdName">
                                <input type="text" class="form-control" id="subFolderListCategoryDocAdd">
                                <input id="idFileSize" name="fileSize" class="form-control" type="hidden">                  
                                <input type="text" class="form-control" id="categoryDocValID" name="categoryDocVal"/>
                                <input type="text" class="form-control" id="documentName"/>
                                <input id="fileNameAddID" class="form-control" type="hidden">
                                <input id="fileNameUploadAddID" name="fileNameUploadAdd" class="form-control" type="hidden">
                                <input id="fileNameUploadID" name="fileNameUpload" class="form-control" type="hidden">
                                
                                <input id="directoryAddID" name="directoryAdd" class="form-control" type="hidden">
                                <input id="directoryID" name="directory" class="form-control" type="hidden">
                                <select class="form-control" id="categoryDocID" name="categoryDoc" required="">
                                    <option></option>
                                </select>   
                                </div>
                                <div id="dynamic_field_general"></div>
                                <div id="dynamic_field"></div>
                             </div>
                            <div class="col-md-6">
                                <div class="dropzone dropzone-default dropzone-primary" id="kt_dropzone_2">
                                    <div class="dropzone-msg dz-message needsclick">
                                        <h3 class="dropzone-msg-title">Drop files here or click to upload.</h3>
                                        <span class="dropzone-msg-desc">Upload up to 10 files</span>
                                         
                                    </div>
                                </div>
                            </div>
                        </div>                       
                    </div>                            
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" id="submitAddDocument" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--begin::Modal Add-->
<!--begin::Card List Document-->
<div class="card card-custom" id="idCardListDocument" style="display: none;">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="fa far fa-folder-open"></i>
            </span>
            <h3 class="card-label" id="idLabelFolderCat"></h3>
            <input type="text" id="docIdListDocument"/>  
            <input type="text" id="subFolderIdListDocument"/>  
            <input type="text" id="folderNameListDocument"/>
            <input type="text" id="documentNameListDocument"/>
            <input type="text" id="subFolderListDocument"/>
            <input type="text" id="folderIdListDocument"/>
        </div>
        
        <div class="card-toolbar">
            <a href="#" id="idBtnAddDocInListCategoryDoc2" class="btn btn-primary font-weight-bolder mr-2" id="idAddDoc" data-toggle="modal" data-target="#modal_add_document" onclick="openDataModalAddDocInListDoc()">
                <i class="flaticon2-plus-1"></i>
                Add Document
            </a>
            <a href="#" class="btn btn-primary font-weight-bolder mr-2" id="btnBackListCategory">
                <i class="flaticon2-back-1"></i>
                Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="scroll" style="min-height:400px; " id="divIdTable4">
                <div class="row">
                    <div class="col-md-12">
                        <button id="id_Reload4" style="display: none;"></button>
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="load_document" style="display:none;"></div>                    
                 </div>
                <!-- END ROW-->
            </div>
            <!--  -->
        </div>    
    </div>
</div>
<!--end::Card List Document-->

<!--begin::Card display Document-->
<div class="card card-custom" id="idCardDisplayDocument" style="display: none;">
    <div class="card-header">
        <div class="card-title"></div>        
        <div class="card-toolbar">
            <div id="btnApprovalDisplay"></div>
             <a href="#" class="btn btn-primary font-weight-bolder mr-2" id="btnBackDisplayDoc">
                <i class="flaticon2-back-1"></i>
                Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="scroll" style="min-height:400px; " id="divIdTable5">
                <div class="row">
                    <div class="col-md-12">
                        <button id="id_Reload5" style="display: none;"></button>
                        <input type="hidden" id="idValueopenListDocument" size="100">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <div class="row" id="idDivIframe">
                            <div class="col-md-12">
                                <div class="embed-responsive embed-responsive-21by9 z-depth-1-half" style="height: 25cm;">
                                  <iframe class="embed-responsive-item" allowfullscreen width="auto" height="auto" id="myFrame" type="application/pdf"></iframe>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card card-custom shadow-lg p-3 mb-5 bg-white rounded">
                            <div class="card-header ribbon ribbon-top ribbon-ver">
                                 <h3 class="card-title" id="idDocKet"></h3>
                            </div>
                            <div class="card-body col-md-12">
                                <div id="idIndexingGeneralFile"></div>
                                <div id="idIndexingSpecificFile"></div>
                            </div>
                        </div>
                    </div>
                </div>               
            </div>
        </div>    
    </div>
</div>
<!--end::Card display Document-->

<!-- Modal Edit Document -->
<div class="modal fade" id="kt_modal_EditDoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="kt-font-brand kt-font-bold"><i class="flaticon2-plus-1"></i>&nbsp;&nbsp;Add Document</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form class="kt-form" id="form_editDoc" action="<?php echo base_url('container/my_container/home'); ?>" action="javascript:;">
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" id="fileNameUploadIDEditDoc" name="fileNameUpload"/>
                                    <input type="text" id="transDocIdEditDoc" name="transDocIdEditDoc"/>

                                    <input type="text" id="subFolderNameEditDocOld" name="subFolderNameEditDocOld"/>
                                    <input type="text" id="subFolderIdEditDocOld" name="subFolderIdEditDocOld"/>
                                    <input type="text" id="folderNameEditDoc" name="folderNameEditDoc"/>
                                    <input type="text" id="folderIDEditDoc" name="folderIDEditDoc"/>
                                    <input id="fileNameEditID" class="form-control" type="hidden">                       <input type="text" id="idFileSizeEditDoc" name="fileSizeEditDoc"/>         
                                    <input type="text" id="directoryIDEditDoc" name="directory"/>
                                    <input type="text" id="idFlagRemoveFileEditDoc" name="directory" value="0"/>
                                    <label>Category Document</label>
                                    <input class="form-control" id="categoryDocEdit" name="categoryDocEdit" required="" readonly="" />
                                </div>
                                <div class="form-group">
                                    <table id="dynamic_field_general_editDoc" border="0" width="100%">
                                        <tr></tr>       
                                    </table>   
                                    <table id="dynamic_field_editDoc" border="0" width="100%">
                                        <tr></tr>          
                                    </table> 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="dropzone dropzone-default dropzone-primary" id="kt_dropzone_editDoc">
                                    <div class="dropzone-msg dz-message needsclick">
                                        <h3 class="dropzone-msg-title">Drop files here or click to upload.</h3>
                                        <span class="dropzone-msg-desc">Upload up to 10 files</span>
                                         
                                    </div>
                                </div>
                            </div>
                        </div>                       
                    </div>            
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" id="submitEditDoc" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--begin::Modal Edit Document-->
<!-- Modal shareDocument -->
<div class="modal fade" id="kt_modal_shareDoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="kt-font-brand kt-font-bold"><i class="fa fa-share-alt"></i>&nbsp;&nbsp;Share Document</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form class="kt-form" id="form_shareDoc" method="post" action="javascript:;">
                    <div class="kt-portlet__body">   
                        <div class="form-group">
                            <label>Document Name</label>
                            <input type="hidden" class="form-control" name="transDocShareDoc" id="transDocShareDoc">
                            <input type="text" class="form-control" name="editOrInsertShareDoc" id="editOrInsertShareDoc">
                            <input type="text" class="form-control" name="documentShareDoc" id="documentShareDoc" readonly="">                            
                            <input type="hidden" class="form-control" name="docIdShareDoc" id="docIdShareDoc">
                            
                        </div>                     
                        <div class="form-group">
                            <label>User</label>
                             <select class="form-control select2" id="kt_select2_shareDoc" name="setUserShareDoc[]" multiple="multiple">    
                                <option></option>
                                <?php
                                    $data = array();
                                    $data[''] = '';
                                    //print_r($jenis_document);
                                    foreach ($getUser as $row) :
                                        // $status_barcode = $row->status_barcode;
                                ?>       
                                    <option value="<?php echo trim($row->userid) ?>"><?php echo trim($row->name) ." - ".trim($row->department); ?>                                                      
                                    </option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                        </div>
                    </div>            
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn" id="submitShareDocId" type="submit" style="background-color: #006677;color: #fff">Submit</button>
                    </div>
                </form>
            </div>
         </div>
    </div>
</div>
<!--begin:: Modal shareDocument-->


<script type="text/javascript">
    jQuery(document).ready(function() {
        $.fn.dataTable.ext.errMode = 'none';
        let searchParams = new URLSearchParams(window.location.search)

        var getValueApprove = searchParams.get('value');
        var getDetailApprove = searchParams.get('detail');
        //console.log(getValueApprove);
        if (getDetailApprove == 1) {
            prepareFrameApprove(getValueApprove.replaceAll(' ','+'));
        }
        initTableContainer();        
        $('#fileNameAddID').val('0');
        $('#categoryDocID').select2({
            width: '100%',
            placeholder: "Select Category"
        });
    });
    $('#kt_select2_setApproval').select2({
        placeholder: {
            id: '-1',
            text: 'Select User'
          },
        width: '100%',
        allowClear: true
    });
    
   var initTableContainer = function() {
        var table = $('#idTableContainer').DataTable({
            responsive: true,

            ajax: "<?php echo base_url("/container/my_container/getContainer"); ?>",
            columns: [
                {data: "no"},
                {data: "folder_id"},                
                {data: 'Actions', responsivePriority: 2},
                {data: "folder_name"},
                {data: "createBy"},
                {data: "createDate"},
            ],
            columnDefs: [
                {
                    targets: 2,
                    title: 'Actions',
                    orderable: false,
                    width: '100px',
                    render: function(data, type, row) {
                    return '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Open" onclick=viewSubContainer("'+row.folder_id+'")>'+
                           '<i class="fa far fa-folder-open"></i></a>'+
                           '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Delete" onclick=deleteContainer("'+row.folder_id+'")>'+
                           '<i class="flaticon2-trash"></i></a>';
                    },
                },
                {
                    targets: 1,
                    visible: false,
                    searchable: false,
                },
            ],
        });
        $('#id_Reload').click(function () {
            table.ajax.reload();
        });
    };

    function deleteContainer(folder_id){

        Swal.fire({
            title: "Are you sure?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!"
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "<?php echo base_url(); ?>container/my_container/deleteContainer",
                    data: { folder_id: folder_id }, 
                    success: function(data){
                        Swal.fire(
                            "Deleted!",
                            "success"
                        )
                        $("#idTableContainer").dataTable().fnDestroy();
                        initTableContainer();
                    }
                });  
            }
        });     
    }

    function viewSubContainer(folder_id){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>container/my_container/viewSubContainer",
            data: { folder_id: folder_id }, 
            success: function(result)
            {   
                $('#folderIdSubContainer').val(folder_id);
                $('#folderNameSubContainer').val(result.folder_name); 
                var userAllowed = result.group_user_doc_id;
                //alert(userAllowed);
                if(userAllowed == "NULL" || userAllowed == "null" ||userAllowed == ""){
                    document.getElementById( 'idBtnAddSubContainer' ).style.display = 'none';
                }else{
                    document.getElementById( 'idBtnAddSubContainer' ).style.display = 'block';
                }
                document.getElementById('folderNameOpen').textContent            = result.folder_name;
                document.getElementById( 'idCardSubContainer' ).style.display    = 'block';
                document.getElementById( 'idCardContainer' ).style.display       = 'none';
                document.getElementById( 'idCardListCategoryDoc' ).style.display = 'none';
                document.getElementById( 'idCardListDocument' ).style.display    = 'none';
                document.getElementById( 'idCardDisplayDocument' ).style.display = 'none'; 
                initTableSubContainer(folder_id);
                
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function initTableSubContainer (folder_id) {

        // begin first table
        var table = $('#idTabelSubContainer').DataTable({
            responsive: true,

            ajax: {
                url: '<?php echo base_url("/container/my_container/getSubContainer"); ?>',
                type: 'POST',
                data: { folder_id: folder_id }, 
            },
            columns: [
                {data: "no"},
                {data: 'Actions', responsivePriority: 2},
                {data: "sub_folder"},
                {data: "sub_folder_id"},
                {data: "createBy"},
                {data: "createDate"},
                
            ],
            columnDefs: [
                {
                    targets: 1,
                    title: 'Actions',
                    orderable: false,
                    width: '100px',
                    render: function(data, type, row) {
                        return '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Open" onclick=openListCategoryDoc("'+row.sub_folder_id+'+'+folder_id+'")>'+
                               '<i class="fa far fa-folder-open"></i></a>'+
                               '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Delete" onclick=deleteSubContainer("'+row.sub_folder_id+'")>'+
                               '<i class="flaticon2-trash"></i></a>';
                    },
                },
                {
                    targets: 3,
                    visible: false,
                    searchable: false,
                },
            ],
        });
        $('#id_Reload2').click(function () {
            table.ajax.reload();
        });
    };

    $('#btnBackContainer').on('click', function() {
        $("#idTabelSubContainer").dataTable().fnDestroy();
        $("#idTableContainer").dataTable().fnDestroy();
        initTableContainer();
        document.getElementById( 'idCardSubContainer' ).style.display    = 'none';
        document.getElementById( 'idCardContainer' ).style.display       = 'block';
        document.getElementById( 'idCardListCategoryDoc' ).style.display = 'none';
        document.getElementById( 'idCardListDocument' ).style.display    = 'none'; 
        document.getElementById( 'idCardDisplayDocument' ).style.display = 'none'; 
    });

    function openDataModalSubCategory() {  
        $('table#dynamic_field_general2 tr').remove();
        var folder_id  =  $('#folderIdSubContainer').val(); 
        var folderName =  $('#folderNameSubContainer').val();
        $('#folderIdSubContainerAdd').val(folder_id);
        $('#folderNameSubContainerAdd').val(folderName);
        //alert(folder_id);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>container/my_container/getFieldGeneralAll",
            data: { folder_id: folder_id }, 
            success: function(result){
                var x=0;
                $.each(result, function(key, val) {
                x++;
                    if(val.general_index_format == 4){
                        $('#dynamic_field_general2').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.general_index_name+'</label><input type="text" name="nameGeneral[]" class="form-control currency col-md-12" required=""/><input type="hidden" name="general_index_id[]" class="form-control general_index_id_list hidden" value="'+val.general_index_id+'" /><input type="hidden" name="general_index_format[]" class="form-control hidden" value="'+val.general_index_format+'" /></div></td></tr>');
                    }else if(val.general_index_format == 3){
                        $('#dynamic_field_general2').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.general_index_name+'</label><input type="text" name="nameGeneral[]" class="form-control kt_datepicker_1" data-date-format="dd-mm-yyyy" placeholder="Select date" required=""/><input type="hidden" name="general_index_id[]" class="form-control specigeneral_index_idfic_index_id_list hidden" value="'+val.general_index_id+'" /><input type="hidden" name="general_index_format[]" class="form-control hidden" value="'+val.general_index_format+'" /></div></td></tr>');
                    }else if(val.general_index_format == 2){
                        $('#dynamic_field_general2').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.general_index_name+'</label><input type="text" name="nameGeneral[]" class="form-control col-md-12 numeric" required=""/><input type="hidden" name="general_index_id[]" class="form-control general_index_id_list hidden" value="'+val.general_index_id+'" /><input type="hidden" name="general_index_format[]" class="form-control hidden" value="'+val.general_index_format+'" /></div></td></tr>');
                    }else{
                          $('#dynamic_field_general2').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.general_index_name+'</label><input type="text" name="nameGeneral[]" class="form-control" required=""/><td><input type="hidden" name="general_index_id[]" class="form-control general_index_id_list hidden" value="'+val.general_index_id+'" /><input type="hidden" name="general_index_format[]" class="form-control hidden" value="'+val.general_index_format+'" /></div></td></tr>');
                    }   

                    var arrows;
                        if (KTUtil.isRTL()) {
                            arrows = {
                                leftArrow: '<i class="la la-angle-right"></i>',
                                rightArrow: '<i class="la la-angle-left"></i>'
                            }
                        } else {
                            arrows = {
                                leftArrow: '<i class="la la-angle-left"></i>',
                                rightArrow: '<i class="la la-angle-right"></i>'
                            }
                        }
                    $(".numeric").inputmask('decimal', {
                        rightAlignNumerics: false
                    });
                    $('.kt_datepicker_1').datepicker({
                        rtl: KTUtil.isRTL(),
                        todayHighlight: true,
                        orientation: "bottom left",
                        templates: arrows
                    });
                    $(".currency").inputmask({ alias : "currency", prefix: '',rightAlign: true });
                });
            }
        });                    
    }

    $("#form_add_sub_container").submit(function(event){
        $('#submitSubContainer').addClass("spinner spinner-right spinner-white pr-15", "Please wait");
        event.preventDefault(); 
        dataString = $("#form_add_sub_container").serialize();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>container/my_container/saveSubContainer",
            data: dataString,
            success:function(data)
            {                          
                UIToastr.init(data.tipePesan, data.pesan); 
                $('#submitSubContainer').removeClass("spinner spinner-right spinner-white pr-15", "Please wait");
                setTimeout(function() {if($('#modal_add_sub_container').modal('hide')){$("#form_add_sub_container")[0].reset();}}, 1000); 
                $('table#dynamic_field_general2 tr').remove();
                $("#idTabelSubContainer").dataTable().fnDestroy();  
                var valueFolderID = $('#folderIdSubContainerAdd').val();
                initTableSubContainer(valueFolderID);    
            }
        });
    });

    function deleteSubContainer(sub_folder_id){
        Swal.fire({
            title: "Are you sure?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!"
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "<?php echo base_url(); ?>container/my_container/deleteSubContainer",
                    data: { sub_folder_id: sub_folder_id }, 
                    success: function(data){
                        Swal.fire(
                            "Deleted!",
                            "success"
                        )
                     $("#idTabelSubContainer").dataTable().fnDestroy();
                     var valueFolderID = $('#folderIdSubContainer').val();
                     initTableSubContainer(valueFolderID);
                    }
                });  
            }
        });       
    }

    function openListCategoryDoc(value){  
        //alert(sub_folder);  
        var hasilSplit    = value.split("+");
        var sub_folder_id = hasilSplit[0];        
        var folder_id     = hasilSplit[1]; 
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>container/my_container/viewSubContainer",
            data: { folder_id: folder_id,sub_folder_id:sub_folder_id }, 
            success: function(result)
            {   
                var groupDoc      = result.group_document;
                var groupDocArr   = groupDoc.split(",");
                var groupDocID    = result.group_document_id;
                var groupDocIDArr = groupDocID.split(",");
                var userAllowed2  = result.group_user_doc_id;
                var sub_folder    = result.sub_folder;
                var folder_name   = result.folder_name
                $('#folderIdListCategoryDoc').val(folder_id);
                $('#subFolderIdListCategoryDoc').val(sub_folder_id); 
                $('#folderNameListCategoryDoc').val(folder_name); 
                $('#subFolderListCategoryDoc').val(sub_folder); 
                //alert(userAllowed);
                if(userAllowed2 == "NULL" || userAllowed2 == "null" || userAllowed2 == ""){
                    document.getElementById( 'idBtnAddDocInListCategoryDoc' ).style.display = 'none';
                    document.getElementById( 'idBtnAddDocInListCategoryDoc2' ).style.display = 'none';
                }else{
                    document.getElementById( 'idBtnAddDocInListCategoryDoc' ).style.display = 'block';
                    document.getElementById( 'idBtnAddDocInListCategoryDoc2' ).style.display = 'block';
                }

                for (i = 0; i < groupDocArr.length; i++) {
                  var opt = document.createElement("option");
                  document.getElementById("categoryDocID").innerHTML += '<option value="' + folder_id + '+' + groupDocIDArr[i] + '">' + groupDocArr[i] + '</option>';
                }  

                document.getElementById( 'idCardSubContainer' ).style.display    = 'none';
                document.getElementById( 'idCardContainer' ).style.display       = 'none';
                document.getElementById( 'idCardListCategoryDoc' ).style.display = 'block'; 
                document.getElementById( 'idCardListDocument' ).style.display    = 'none'; 
                document.getElementById( 'idCardDisplayDocument' ).style.display = 'none'; 
                document.getElementById('idLabelFolder').textContent = sub_folder;
                initTableListCategoryDoc(sub_folder_id);             
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });    
    }

     function initTableListCategoryDoc (sub_folder_id) {
        // begin first table
        var table = $('#idTableListCategoryDoc').DataTable({
            responsive: true,
            ajax: {
                url: '<?php echo base_url("/container/my_container/getListCategoryDoc"); ?>',
                type: 'POST',
                data: { sub_folder_id: sub_folder_id }, 
            },
            columns: [
                {data: "no"},
                {data: 'Actions', responsivePriority: 1},
                {data: "document_name"},
                {data: "total_doc"},                
            ],
            columnDefs: [
                {
                    targets: 1,
                    title: 'Actions',
                    orderable: false,
                    width: '100px',
                    render: function(data, type, row) {
                        return '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Open" onclick=openListDocument("'+row.document_id+'")>'+
                               '<i class="fa far fa-folder-open"></i></a> ';
                    },
                },
                
            ],
        });
        $('#id_Reload3').click(function () {
            table.ajax.reload();
        });
    };

    function openDataModalAddDocInListCategoryDoc(){

        var folderID     = $('#folderIdListCategoryDoc').val();
        var folderNameID = $('#folderNameListCategoryDoc').val();
        var subFolderId  = $('#subFolderIdListCategoryDoc').val();
        var categoryDoc  = $('#categoryDocValID').val();
        var subFolder    = $('#subFolderListCategoryDoc').val();
        $('#idCardDisplay').val('card3');
        $('#categoryDocID').attr("disabled", false); 
        $('#folderIdListCategoryDocAdd').val(folderID);
        $('#folderNameListCategoryDocAdd').val(folderNameID);
        $('#subFolderIdListCategoryDocAdd').val(subFolderId);
        $('#subFolderListCategoryDocAdd').val(subFolder);
        
        if(categoryDoc !== ""){
            $('#kt_dropzone_2').show();
        }else{
            $('#kt_dropzone_2').hide();
        }       
    }  

    $("#categoryDocID").change(function () {
        var div         = document.getElementById('dynamic_field_general');
        var div2        = document.getElementById('dynamic_field');        
        var subFolderID = $('#subFolderIdListCategoryDoc').val();  
        div.innerHTML   = "";
        div2.innerHTML  = "";
        var a           = this.value;
        var hasilSplit  = a.split("+");
        var folder_id   = hasilSplit[0];
        var document_id = hasilSplit[1];       
        $('#categoryDocValID').val(document_id); 
        $('#kt_dropzone_2').show();
        if(folder_id==""){
            return false;
        }
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>container/my_container/getFieldGeneralAllAndValue",
            data: { folder_id: folder_id,subFolderID: subFolderID},
            success: function(result){
                var x=0;
               
                $.each(result, function(key, val) {
                x++;
                    if(val.general_index_format == 4){
                        
                        div.innerHTML += '<div class="form-group"><label>'+val.general_index_name+'</label><input type="text" name="nameGeneral[]" class="form-control currency col-md-12" value="'+val.general_index+'" required="" readonly/><input type="hidden" name="general_index_id[]" class="form-control general_index_id_list hidden" value="'+val.general_index_id+'" /><input type="hidden" name="general_index_format[]" class="form-control hidden" value="'+val.general_index_format+'" /></div>';
                    }else if(val.general_index_format == 3){
                        div.innerHTML += '<div class="form-group"><label>'+val.general_index_name+'</label><input type="text" name="nameGeneral[]" value="'+val.general_index+'" class="form-control kt_datepicker_1" data-date-format="dd-mm-yyyy" placeholder="Select date" required="" readonly/><input type="hidden" name="general_index_id[]" class="form-control specigeneral_index_idfic_index_id_list hidden" value="'+val.general_index_id+'" /><input type="hidden" name="general_index_format[]" class="form-control hidden" value="'+val.general_index_format+'" /></div>';
                    }else if(val.general_index_format == 2){
                        div.innerHTML += '<div class="form-group"><label>'+val.general_index_name+'</label><input type="text" name="nameGeneral[]" value="'+val.general_index+'" class="form-control col-md-12 numeric" required="" readonly/><input type="hidden" name="general_index_id[]" class="form-control general_index_id_list hidden" value="'+val.general_index_id+'" /><input type="hidden" name="general_index_format[]" class="form-control hidden" value="'+val.general_index_format+'" /></div>';
                    }else{
                          div.innerHTML += '<div class="form-group"><label>'+val.general_index_name+'</label><input type="text" name="nameGeneral[]" value="'+val.general_index+'" class="form-control" required="" readonly/><td><input type="hidden" name="general_index_id[]" class="form-control general_index_id_list hidden" value="'+val.general_index_id+'" /><input type="hidden" name="general_index_format[]" class="form-control hidden" value="'+val.general_index_format+'" /></div>';
                    }   

                    var arrows;
                        if (KTUtil.isRTL()) {
                            arrows = {
                                leftArrow: '<i class="la la-angle-right"></i>',
                                rightArrow: '<i class="la la-angle-left"></i>'
                            }
                        } else {
                            arrows = {
                                leftArrow: '<i class="la la-angle-left"></i>',
                                rightArrow: '<i class="la la-angle-right"></i>'
                            }
                        }
                      $(".numeric").inputmask('decimal', {
                            rightAlignNumerics: false
                        });
                    $('.kt_datepicker_1').datepicker({
                        rtl: KTUtil.isRTL(),
                        todayHighlight: true,
                        orientation: "bottom left",
                        templates: arrows
                    });

                    $(".currency").inputmask({ alias : "currency", prefix: '',rightAlign: true });
                });
            }
        });

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>container/my_container/getFieldAll",
            data: { document_id: document_id}, 
            success: function(result){
                var x=0;
               
                $.each(result, function(key, val) {
                x++;
                    $('#documentName').val(val.document_name); 
                    if(val.specific_index_format == 4){
                        div2.innerHTML += '<div class="form-group"><label>'+val.specific_index_name+'</label><input type="text" name="name[]" class="form-control currency col-md-12" required=""/><input type="hidden" name="specific_index_id[]" class="form-control specific_index_id_list hidden" value="'+val.specific_index_id+'" /><input type="hidden" name="specific_index_format[]" class="form-control hidden" value="'+val.specific_index_format+'" /></div>';
                    }else if(val.specific_index_format == 3){
                        div2.innerHTML += '<div class="form-group"><label>'+val.specific_index_name+'</label><input type="text" name="name[]" class="form-control kt_datepicker_1" data-date-format="dd-mm-yyyy" placeholder="Select date" required=""/><input type="hidden" name="specific_index_id[]" class="form-control specific_index_id_list hidden" value="'+val.specific_index_id+'" /><input type="hidden" name="specific_index_format[]" class="form-control hidden" value="'+val.specific_index_format+'" /></div>';
                    }else if(val.specific_index_format == 2){
                        div2.innerHTML += '<div class="form-group"><label>'+val.specific_index_name+'</label><input type="text" name="name[]" class="form-control col-md-12 numeric" required=""/><input type="hidden" name="specific_index_id[]" class="form-control specific_index_id_list hidden" value="'+val.specific_index_id+'" /><input type="hidden" name="specific_index_format[]" class="form-control hidden" value="'+val.specific_index_format+'" /></div>';
                    }else{
                        div2.innerHTML += '<div class="form-group"><label>'+val.specific_index_name+'</label><input type="text" name="name[]" class="form-control" required=""/><input type="hidden" name="specific_index_id[]" class="form-control specific_index_id_list hidden" value="'+val.specific_index_id+'" /><input type="hidden" name="specific_index_format[]" class="form-control hidden" value="'+val.specific_index_format+'" /></div>';
                    }  

                    var arrows;
                        if (KTUtil.isRTL()) {
                            arrows = {
                                leftArrow: '<i class="la la-angle-right"></i>',
                                rightArrow: '<i class="la la-angle-left"></i>'
                            }
                        } else {
                            arrows = {
                                leftArrow: '<i class="la la-angle-left"></i>',
                                rightArrow: '<i class="la la-angle-right"></i>'
                            }
                        }
                    $(".numeric").inputmask('decimal', {
                        rightAlignNumerics: false
                    });
                    $('.kt_datepicker_1').datepicker({
                        rtl: KTUtil.isRTL(),
                        todayHighlight: true,
                        orientation: "bottom left",
                        templates: arrows
                    });
                    $(".currency").inputmask({ alias : "currency", prefix: '',rightAlign: true });
                    
                });
            }
        });
    });   

    $('#btnBackSubContainer').on('click', function() {
        document.getElementById("categoryDocID").innerHTML = "<option></option>";
        $("#idTableListCategoryDoc").dataTable().fnDestroy();
        $("#idTabelSubContainer").dataTable().fnDestroy();
        document.getElementById( 'idCardSubContainer' ).style.display    = 'block';
        document.getElementById( 'idCardContainer' ).style.display       = 'none';
        document.getElementById( 'idCardListCategoryDoc' ).style.display = 'none';
        document.getElementById( 'idCardListDocument' ).style.display    = 'none';
        document.getElementById( 'idCardDisplayDocument' ).style.display = 'none'; 
        var valueFolderID = $('#folderIdListCategoryDoc').val();
        $("#dynamic_field_general").empty();
        $("#dynamic_field").empty();
        initTableSubContainer(valueFolderID);
        //view(valueFolderID);
    });   

    $("#form_add_document").submit(function(event){
        var fileName = $('#fileNameUploadID').val();
        if(fileName === ""){
            UIToastr.init('warning', 'Drop file or click to upload');
            return false;
        }
        $('#idFlagRemoveFile').val('1');
        $("#idTableListCategoryDoc").dataTable().fnDestroy();        
        var subFolderId     = $('#subFolderIdListCategoryDoc').val();
        var idCardDisplay = $('#idCardDisplay').val();
        $('#submitAddDocument').attr("disabled", true); 
        $('#submitAddDocument').addClass("spinner spinner-right spinner-white pr-15", "Please wait");
        event.preventDefault(); 
        dataString = $("#form_add_document").serialize();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>container/my_container/saveDocument",
            data: dataString,
            success:function(data)
            {   
                $(".dz-remove")[0].click();                                
                setTimeout(function() {if($('#modal_add_document').modal('hide')){$("#form_add_document")[0].reset();}}, 1000); 
                $('table#dynamic_field tr').remove();
                $('table#dynamic_field_general tr').remove();
                $('#categoryDocID').val("");
                $('#idFlagRemoveFile').val('0');
                dropdownCat();
                if(idCardDisplay == 'card3'){
                    $("#idTableListCategoryDoc").dataTable().fnDestroy();
                    initTableListCategoryDoc(subFolderId);
                }else{        
                    var document_id = $('#docIdListDocument').val();
                    openListDocument(document_id);
                }                                  
                $('#submitAddDocument').removeClass("spinner spinner-right spinner-white pr-15", "Please wait");
                $('#submitAddDocument').attr("disabled", false); 
                UIToastr.init(data.tipePesan, data.pesan); 
            }
        });
    });

    //start function dropzone file
    function bytesToSize(bytes) {
       var totalSizeMB = Math.round(bytes / Math.pow(1024,1));
       return totalSizeMB;
    }

    Dropzone.autoDiscover = false;
    var uploadFile= new Dropzone(".dropzone",{
        url: "<?php echo base_url(); ?>container/my_container/uploadFileAdd", // Set the url for your upload script location
        maxFiles: 1,
        maxFilesize: 50, // MB
        method:"post",
        acceptedFiles: "image/*,application/pdf",
        paramName:"filenameAdd",
        dictInvalidFileType:"Type file ini tidak dizinkan",    
        addRemoveLinks: true,
        accept: function(file, done ) {
            //alert(file);
            if (file.name == "") {
                
                $('#fileNameAddID').val('0');
                done("Naha, you don't.");
            } else {
                
                $('#fileNameAddID').val('1');                
                var size = bytesToSize(file.size);
                $('#idFileSize').val(size);                
                done();
            }

        },
        success: function(file, response){
            var json = JSON.parse(response);            
            $('#fileNameUploadID').val(json.fileName);
            $('#directoryID').val(json.directory);
            if(json.tipePesan == 'error'){
                UIToastr.init(json.tipePesan, json.pesan); 
                this.removeFile(file);
            }
            $('#submitAddDocument').attr("disabled", false);
        },
        removedfile: function(file) {
            var flagRemove = $('#idFlagRemoveFile').val();
            var directory  = $('#directoryID').val();
             if(flagRemove == 0){
                //alert('tes 1');
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "<?php echo base_url(); ?>container/my_container/deleteFile",
                    data: { directory: directory}, 
                    success: function (response) {
                        $('#fileNameUploadID').val("");
                        $('#directoryID').val("");
                        console.log('success: ' + response);                         
                     // do something
                    },
                    error: function () {
                     // do something
                    }
                });
                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;        
             }else{
                //alert('tes 2');
                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;   
             }
             $('#submitAddDocument').attr("disabled", false);

        },
        init: function() {
            this.on("error", function(file, message, xhr) {
            //UIToastr.init('error', message);  
               if (xhr == null) this.removeFile(file); // perhaps not remove on xhr errors
               UIToastr.init('error', 'Only image or pdf / file size is too large / Only Singel File '); 
            });
         }
    });
    // //Event ketika Memulai mengupload
    uploadFile.on("sending",function(a,b,c){
        $('#submitAddDocument').attr("disabled", true); 
        var folderName  = $('#folderNameListCategoryDocAdd').val();
        var subFolder   = $('#subFolderListCategoryDocAdd').val();
        var documentName = $('#documentName').val();
        a.folderNameCmp =  folderName+'+'+subFolder+'+'+documentName;
        c.append("folderNameCmp",a.folderNameCmp); //Menmpersiapkan token untuk masing masing foto
        c.append("folderName",a.folderName); //Menmpersiapkan token untuk masing masing foto
    });
    //end function dropzone file

    function dropdownCat (){
        $('#categoryDocID').select2().trigger('change');
        $('#categoryDocID').attr("disabled", true); 
        $('#categoryDocID').select2({
            width: '100%',
            placeholder: "Select Category"
        });
    }

    //function dropzone edit
    var uploadFileEdit= new Dropzone("#kt_dropzone_editDoc",{
        //autoProcessQueue: false,
        url: "<?php echo base_url(); ?>container/my_container_/uploadFileAdd", // Set the url for your upload script location
        maxFiles: 1,
        maxFilesize: 50, // MB
        method:"post",
        acceptedFiles: "image/*,application/pdf",
        paramName:"filenameAdd",
        dictInvalidFileType:"Type file ini tidak dizinkan",    
        addRemoveLinks: true,
        accept: function(file, done ) {
            //alert(file);
            if (file.name == "") {
                
                $('#fileNameEditID').val('0');
                done("Naha, you don't.");
            } else {
                
                $('#fileNameEditID').val('1');                
                var size = bytesToSize(file.size);
                $('#idFileSizeEditDoc').val(size);                
                done();
            }
        },
        success: function(file, response){
            var json = JSON.parse(response);            
            $('#fileNameUploadIDEditDoc').val(json.fileName);
            $('#directoryIDEditDoc').val(json.directory);
            if(json.tipePesan == 'error'){
                UIToastr.init(json.tipePesan, json.pesan); 
                this.removeFile(file);
            }
        },
        removedfile: function(file) {
            var flagRemove = $('#idFlagRemoveFileEditDoc').val();
            var directory  = $('#directoryIDEditDoc').val();
             if(flagRemove == 0){
                //alert('tes 1');
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "<?php echo base_url(); ?>container/my_container_/deleteFile",
                    data: { directory: directory}, 
                    // type: "POST",
                    // url: "deleteFile?directory="+directory,
                    // dataType:"JSON",
                    success: function (response) {
                        $('#fileNameUploadIDEditDoc').val("");
                        $('#directoryIDEditDoc').val("");
                        console.log('success: ' + response);                         
                     // do something
                    },
                    error: function () {
                     // do something
                    }
                });
                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;        
             }else{
                //alert('tes 2');
                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;   
             }

        },
        init: function() {
            this.on("error", function(file, message, xhr) { 
               if (xhr == null) this.removeFile(file); // perhaps not remove on xhr errors
               UIToastr.init('error', 'Only image or pdf / file size is too large '); 
            });
         }
    });


    // //Event ketika Memulai mengupload
    uploadFileEdit.on("sending",function(a,b,c){

        var folderName = $('#folderNameEditDoc').val();
        var subFolder  = $('#subFolderNameEditDocOld').val();
        var categoryDoc= $('#categoryDocEdit').val();

        a.folderNameCmp =  folderName+'+'+subFolder+'+'+categoryDoc;
            //alert(folderNameCmp);
        c.append("folderNameCmp",a.folderNameCmp); //Menmpersiapkan token untuk masing masing foto
        //alert(folderName);
        c.append("folderName",a.folderName); //Menmpersiapkan token untuk masing masing foto
    });

    function openListDocument(document_id){ 
        $("#pageloader").fadeIn();
        //alert(sub_folder);               
        var subFolderID = $('#subFolderIdListCategoryDoc').val();
        var folderName  = $('#folderNameListCategoryDoc').val();
        var sub_folder  = $('#subFolderListCategoryDoc').val();
        var folder_id   = $('#folderIdListCategoryDoc').val();
        //alert(sub_folder);
        // var category    = hasilSplit[2];
        $('#docIdListDocument').val(document_id);  
        $('#subFolderIdListDocument').val(subFolderID);         
        $('#folderNameListDocument').val(folderName);
        $('#subFolderListDocument').val(sub_folder);
        $('#folderIdListDocument').val(folder_id);
        $.ajax({
                type: "POST",
                dataType: "json",
                url: '<?php echo base_url(); ?>container/my_container/getListDocDetailFolder',
                data: {document_id:document_id},   
                success: function(result)
                {   
                    document.getElementById('idLabelFolderCat').textContent = sub_folder;
                    $('#documentNameListDocument').val(result.document_name);
                    $('#categoryDocEdit').val(result.document_name);           
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            }); 
         $.ajax({
              url: '<?php echo base_url(); ?>container/my_container/getListDoc',
              type: 'POST',
              data: {document_id:document_id,subFolderID:subFolderID,folder_id:folder_id},             
              success: function (jawaban){ 
                //alert(jawaban);
                $('#idValueopenListDocument').val(document_id);         
                if(jawaban.trim() === "kosong") {
                    $("#btnBackListCategory").trigger('click');                 
                }else{                        
                    document.getElementById( 'idCardSubContainer' ).style.display    = 'none';
                    document.getElementById( 'idCardContainer' ).style.display       = 'none';
                    document.getElementById( 'idCardListCategoryDoc' ).style.display = 'none'; 
                    document.getElementById( 'idCardListDocument' ).style.display    = 'block';
                    document.getElementById( 'idCardDisplayDocument' ).style.display = 'none'; 
                    //$('#idDocID').val(document_id); 
                    $('#load_document').fadeIn('slow');
                    $('#load_document').html(jawaban);  
                }   
                    
              },
              beforeSend: function() {             
                  //$('#load_document').fadeIn('slow');
                }
            });
            return false; 
    }

    $('#btnBackListCategory').on('click', function() {
        //$("#idTabel4").dataTable().fnDestroy();
        $("#idTableListCategoryDoc").dataTable().fnDestroy();
        document.getElementById( 'idCardSubContainer' ).style.display    = 'none';
        document.getElementById( 'idCardContainer' ).style.display       = 'none';
        document.getElementById( 'idCardListCategoryDoc' ).style.display = 'block'; 
        document.getElementById( 'idCardListDocument' ).style.display    = 'none'; 
        document.getElementById( 'idCardDisplayDocument' ).style.display = 'none'; 
        var subFolderID = $('#subFolderIdListDocument').val();
        initTableListCategoryDoc(subFolderID);
    });

    function prepareFrame(trans_doc_id) {     
        //console.log(b);
        $('#btnApprovalDisplay').empty(); 
        var document_id   = $("#docIdListDocument").val();        
        var folder_id     = $("#folderIdListDocument").val();
        var subFolderID   = $("#subFolderIdListDocument").val();
        var containerName = $("#folderNameListDocument").val();
        var subContainer  = $("#subFolderListDocument").val();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>container/my_container/getKetFile",
            data: { document_id: document_id,folder_id: folder_id,subFolderID: subFolderID,trans_doc_id: trans_doc_id}, 
            success: function(result)
            {   
                document.getElementById('idDocKet').textContent = $('#documentNameListDocument').val();    
                $.each(result.getGeneralIndexName, function(key, val) {  
                    $('#idIndexingGeneralFile').append('<div class="row"><label for="example-password-input" class="col-5 col-form-label">'+val.general_index_name+'</label><label class="col-1 col-form-label">:</label><div class="col-5"><label for="example-password-input" class="col-form-label">'+val.general_index+'</label></div></div>');                  
                });
                var approval;
                 $.each(result.getSpecificIndexName, function(key, val) {
                    var indexFormat = val.specific_index_format;
                    var specificIndex = val.specific_index;
                    approval = val.approval.trim();
                    if(indexFormat == 4){
                        if(specificIndex == ""||specificIndex=="NULL"){
                            specificIndex = "0.00";
                        }else{
                            specificIndex = addCommas(val.specific_index);
                        }
                        
                    }
                    
                    $('#idIndexingSpecificFile').append('<div class="row"><label for="example-password-input" class="col-5 col-form-label">'+val.specific_index_name+'</label><label class="col-1 col-form-label">:</label><div class="col-5"><label for="example-password-input" class="col-form-label">'+specificIndex+'</label></div></div>');                  
                });
                 //alert(approval);
                if(approval == "-"){

                }else{
                   $('#btnApprovalDisplay').append('<a href="#" class="btn btn-primary font-weight-bolder mr-2" id="btnApproval" onclick=displayModalApproval("'+trans_doc_id+'")><i class="fa fa-user-edit"></i>Approval</a>'); 
                }   

                document.getElementById( 'idCardSubContainer' ).style.display    = 'none';
                document.getElementById( 'idCardContainer' ).style.display       = 'none';
                document.getElementById( 'idCardListCategoryDoc' ).style.display = 'none';
                document.getElementById( 'idCardListDocument' ).style.display    = 'none'; 
                document.getElementById( 'idCardDisplayDocument' ).style.display = 'block'; 
                var omyFrame = document.getElementById("myFrame");
                omyFrame.src = "<?php echo base_url(); ?>uploads/"+containerName+"/"+subContainer+"/"+result.file_name;
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
        document.getElementById( 'idCardSubContainer' ).style.display    = 'none';
        document.getElementById( 'idCardContainer' ).style.display       = 'none';
        document.getElementById( 'idCardListCategoryDoc' ).style.display = 'none';
        document.getElementById( 'idCardListDocument' ).style.display    = 'block'; 
        document.getElementById( 'idCardDisplayDocument' ).style.display = 'none'; 
        $("#form_add_document")[0].reset();
        $('#categoryDocID').val("");
        var valueOpen = $('#idValueopenListDocument').val();
        openListDocument(valueOpen);
        dropdownCat();        
    });

     function openDataModalAddDocInListDoc(){
        $('#idCardDisplay').val('card4');
        var documentId   = $('#docIdListDocument').val();
        var folderID     = $('#folderIdListCategoryDoc').val();
        var folderNameID = $('#folderNameListCategoryDoc').val();
        var subFolderId  = $('#subFolderIdListCategoryDoc').val();
        var subFolder    = $('#subFolderListCategoryDoc').val();
        $('#folderIdListCategoryDocAdd').val(folderID);
        $('#folderNameListCategoryDocAdd').val(folderNameID);
        $('#subFolderIdListCategoryDocAdd').val(subFolderId);
        $('#subFolderListCategoryDocAdd').val(subFolder);

        var valueSel = folderID+'+'+documentId;
        $('#categoryDocID').val(valueSel);
        dropdownCat();
    }

    function editDocument(trans_doc_id){
        //alert(this.value);
        $('table#dynamic_field_editDoc tr').remove();
        $('table#dynamic_field_general_editDoc tr').remove();
        var folder_id     = $("#folderIdListDocument").val();
        var subFolderID   = $("#subFolderIdListDocument").val();
        var subFolder     = $("#subFolderListDocument").val();
        var folderNameID  = $('#folderNameListDocument').val(); 
        var document_name = $('#documentNameListDocument').val();
        $('#folderNameEditDoc').val(folderNameID); 
        $('#subFolderNameEditDocOld').val(subFolder);         
        $('#transDocIdEditDoc').val(trans_doc_id);
        $('#subFolderIdEditDocOld').val(subFolderID); 
        $('#categoryDocEdit').val(document_name); 
        $('#folderIDEditDoc').val(folder_id); 

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>container/my_container/getFieldGeneralAllAndValue",
            data: { folder_id: folder_id,subFolderID:subFolderID}, 
            success: function(result){
                var x=0;               
                $.each(result, function(key, val) {
                x++;
                    if(val.general_index_format == 4){
                        $('#dynamic_field_general_editDoc').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.general_index_name+'</label><input type="hidden" name="transIndexGeneralID[]" class="form-control col-md-12" value="'+val.trans_index_general_id+'" required=""/><input type="text" name="nameGeneral[]" class="form-control currency col-md-12" value="'+val.general_index+'" required="" readonly/><input type="hidden" name="general_index_id[]" class="form-control general_index_id_list hidden" value="'+val.general_index_id+'" /><input type="hidden" name="general_index_format[]" class="form-control hidden" value="'+val.general_index_format+'" /></div></td></tr>');
                    }else if(val.general_index_format == 3){
                        $('#dynamic_field_general_editDoc').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.general_index_name+'</label><input type="hidden" name="transIndexGeneralID[]" class="form-control col-md-12" value="'+val.trans_index_general_id+'" required=""/><input type="text" name="nameGeneral[]" value="'+val.general_index+'" class="form-control kt_datepicker_1" data-date-format="dd-mm-yyyy" placeholder="Select date" required="" readonly/><input type="hidden" name="general_index_id[]" class="form-control specigeneral_index_idfic_index_id_list hidden" value="'+val.general_index_id+'" /><input type="hidden" name="general_index_format[]" class="form-control hidden" value="'+val.general_index_format+'" /></div></td></tr>');
                    }else if(val.general_index_format == 2){
                        $('#dynamic_field_general_editDoc').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.general_index_name+'</label><input type="hidden" name="transIndexGeneralID[]" class="form-control col-md-12" value="'+val.trans_index_general_id+'" required=""/><input type="text" name="nameGeneral[]" value="'+val.general_index+'" class="form-control col-md-12 numeric" required="" readonly/><input type="hidden" name="general_index_id[]" class="form-control general_index_id_list hidden" value="'+val.general_index_id+'" /><input type="hidden" name="general_index_format[]" class="form-control hidden" value="'+val.general_index_format+'" /></div></td></tr>');
                    }else{
                          $('#dynamic_field_general_editDoc').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.general_index_name+'</label><input type="hidden" name="transIndexGeneralID[]" class="form-control col-md-12" value="'+val.trans_index_general_id+'" required=""/><input type="text" name="nameGeneral[]" value="'+val.general_index+'" class="form-control" required="" readonly/><td><input type="hidden" name="general_index_id[]" class="form-control general_index_id_list hidden" value="'+val.general_index_id+'" /><input type="hidden" name="general_index_format[]" class="form-control hidden" value="'+val.general_index_format+'" /></div></td></tr>');
                    }    

                    var arrows;
                        if (KTUtil.isRTL()) {
                            arrows = {
                                leftArrow: '<i class="la la-angle-right"></i>',
                                rightArrow: '<i class="la la-angle-left"></i>'
                            }
                        } else {
                            arrows = {
                                leftArrow: '<i class="la la-angle-left"></i>',
                                rightArrow: '<i class="la la-angle-right"></i>'
                            }
                        }
                      $(".numeric").inputmask('decimal', {
                            rightAlignNumerics: false
                        });
                    $('.kt_datepicker_1').datepicker({
                        rtl: KTUtil.isRTL(),
                        todayHighlight: true,
                        orientation: "bottom left",
                        templates: arrows
                    });

                    $(".currency").inputmask({ alias : "currency", prefix: '',rightAlign: true });
                });
            }
        });

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>container/my_container/getFieldAllEdit",
            data: { trans_doc_id: trans_doc_id}, 
            success: function(result){
                var x=0;
               
                $.each(result, function(key, val) {
                x++;
                    if(val.specific_index_format == 4){
                        $('#dynamic_field_editDoc').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.specific_index_name+'</label><input type="hidden" name="transIndexSpecificID[]" class="form-control col-md-12" value="'+val.trans_index_specific_id+'" required=""/><input type="text" name="name[]" class="form-control currency col-md-12" value="'+val.specific_index+'"/><input type="hidden" name="specific_index_id[]" class="form-control specific_index_id_list hidden" value="'+val.specific_index_id+'" /><input type="hidden" name="specific_index_format[]" class="form-control hidden" value="'+val.specific_index_format+'" /></div></td></tr>');
                    }else if(val.specific_index_format == 3){
                        $('#dynamic_field_editDoc').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.specific_index_name+'</label><input type="hidden" name="transIndexSpecificID[]" class="form-control col-md-12" value="'+val.trans_index_specific_id+'" required=""/><input type="text" name="name[]" class="form-control kt_datepicker_1" data-date-format="dd-mm-yyyy" placeholder="Select date" value="'+val.specific_index+'"/><input type="hidden" name="specific_index_id[]" class="form-control specific_index_id_list hidden" value="'+val.specific_index_id+'" /><input type="hidden" name="specific_index_format[]" class="form-control hidden" value="'+val.specific_index_format+'" /></div></td></tr>');
                    }else if(val.specific_index_format == 2){
                        $('#dynamic_field_editDoc').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.specific_index_name+'</label><input type="hidden" name="transIndexSpecificID[]" class="form-control col-md-12" value="'+val.trans_index_specific_id+'" required=""/><input type="text" name="name[]" class="form-control col-md-12 numeric" value="'+val.specific_index+'"/><input type="hidden" name="specific_index_id[]" class="form-control specific_index_id_list hidden" value="'+val.specific_index_id+'" /><input type="hidden" name="specific_index_format[]" class="form-control hidden" value="'+val.specific_index_format+'" /></div></td></tr>');
                    }else{
                          $('#dynamic_field_editDoc').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.specific_index_name+'</label><input type="hidden" name="transIndexSpecificID[]" class="form-control col-md-12" value="'+val.trans_index_specific_id+'" required=""/><input type="text" name="name[]" class="form-control" value="'+val.specific_index+'"/><input type="hidden" name="specific_index_id[]" class="form-control specific_index_id_list hidden" value="'+val.specific_index_id+'" /><input type="hidden" name="specific_index_format[]" class="form-control hidden" value="'+val.specific_index_format+'" /></div></td></tr>');
                    }  

                    var arrows;
                        if (KTUtil.isRTL()) {
                            arrows = {
                                leftArrow: '<i class="la la-angle-right"></i>',
                                rightArrow: '<i class="la la-angle-left"></i>'
                            }
                        } else {
                            arrows = {
                                leftArrow: '<i class="la la-angle-left"></i>',
                                rightArrow: '<i class="la la-angle-right"></i>'
                            }
                        }
                    $(".numeric").inputmask('decimal', {
                        rightAlignNumerics: false
                    });
                    $('.kt_datepicker_1').datepicker({
                        rtl: KTUtil.isRTL(),
                        todayHighlight: true,
                        orientation: "bottom left",
                        templates: arrows
                    });

                    $(".currency").inputmask({ alias : "currency", prefix: '',rightAlign: true });
                });
            }
        });
        $('#kt_modal_EditDoc').modal('show');
    }

    $("#form_editDoc").submit(function(event){
        $('#idFlagRemoveFileEditDoc').val('1');
        $('#submitEditDoc').addClass("spinner spinner-right spinner-white pr-15", "Please wait");
        var fileName = $('#fileNameUploadIDEditDoc').val();
        event.preventDefault(); 
        dataString = $("#form_editDoc").serialize();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>container/my_container/editDoc",
            data: dataString,
            success:function(data)
            {       
                if(fileName!== ""){
                    $(".dz-remove")[0].click(); 
                }
                $('#idFlagRemoveFileEditDoc').val('0');
                var subFolderIdListDocument = $('#subFolderIdListDocument').val();           
                var docIdListDocument       = $('#docIdListDocument').val(); 
                openListDocument(docIdListDocument);              
                setTimeout(function() {if($('#kt_modal_EditDoc').modal('hide')){$("#form_editDoc")[0].reset();}}, 1000); 
                $('table#dynamic_field_editDoc tr').remove();
                $('table#dynamic_field_general_editDoc tr').remove();               
                UIToastr.init(data.tipePesan, data.pesan); 
                $('#submitEditDoc').removeClass("spinner spinner-right spinner-white pr-15", "Please wait");     
            }
        });
    });

    function deleteDocument(trans_doc_id){
        var docIdListDocument = $('#docIdListDocument').val();

        Swal.fire({
            title: "Are you sure?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!"
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "<?php echo base_url(); ?>container/my_container/deleteDocument",
                    data: { trans_doc_id: trans_doc_id }, 
                    success: function(data){
                        Swal.fire(
                            "Deleted!",
                            "success"
                        )
                        openListDocument(docIdListDocument);
                    }
                });   
            }
        });       
    }

    function shareDoc(trans_doc_id){
        var documentId    = $('#docIdListDocument').val(); 
        var document_name = $('#documentNameListDocument').val();

        $('#documentShareDoc').val(document_name);
        $('#transDocShareDoc').val(trans_doc_id);
        $('#docIdShareDoc').val(documentId);
        //alert(valueOpen);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>container/my_container/getUserShare?trans_doc_id="+trans_doc_id,
            dataType:"JSON",
            success: function(result){                  
                var x=0;
                
                // if(result.length>0){
                //     $('#editOrInsertShareDoc').val('edit');
                // }else{
                //     $('#editOrInsertShareDoc').val('insert');
                // }
                
                var arr = [];
                var valueEditarr = [];
                $.each(result, function(key, val) {
                    x++; 
                    var userid = val.userid;
                    //alert(userid);
                    arr.push(userid);
                    valueEditarr.push(userid);
                });
                $('#editOrInsertShareDoc').val(valueEditarr.join('+'));
                var $mySelect = $("#kt_select2_shareDoc").select2({
                    placeholder: {
                        id: '-1', // the value of the option
                        text: 'Select User'
                      },
                    width: '100%',
                    allowClear: true
                });
                    //alert(arr);
                $mySelect.val(arr).trigger("change");
                $('#kt_modal_shareDoc').modal('show');
            }
        });                      
    } 

     $("#form_shareDoc").submit(function(event){
        $('#submitShareDocId').addClass("spinner spinner-right spinner-white pr-15", "Please wait");
        var documentId = $('#docIdShareDoc').val();
        event.preventDefault(); 
        dataString = $("#form_shareDoc").serialize();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>container/my_container/editOrInsertShareDoc",
            data: dataString,
            success:function(data)
            {                
                setTimeout(function() {if($('#kt_modal_shareDoc').modal('hide')){$("#form_shareDoc")[0].reset();}}, 1000); 
                //alert(valueOpen);
                openListDocument(documentId);                   
                UIToastr.init(data.tipePesan, data.pesan); 
                $('#submitShareDocId').removeClass("spinner spinner-right spinner-white pr-15", "Please wait");        
            }
        });
    }); 
</script>
