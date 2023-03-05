<!--begin::Card 1-->
<div class="card card-custom" id="idCard1">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="fa far fa-folder"></i>
            </span>
            <h3 class="card-label"><?php echo strtoupper($menu_name); ?></h3>
        </div>
        <div class="card-toolbar">
            <!-- <a href="#" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#kt_modal_Add">
                <i class="flaticon2-plus-1"></i>
                New Document
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
                        <table class="table table-separate table-head-custom table-checkable" id="idTabel1">
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
                    <!-- end col-12 -->
                </div>
                <!-- END ROW-->
            </div>
            <!--  -->
        </div>    
    </div>
</div>
<!--end::Card 1-->
<!--begin::Card 2-->
<div class="card card-custom" id="idCard2" style="display: none;">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="fa far fa-folder-open"></i>
            </span>
            <h3 class="card-label" id="idLabel2"></h3>
        </div>
        <div class="card-toolbar">
            <a href="#" class="btn btn-primary font-weight-bolder mr-2" data-toggle="modal" data-target="#kt_modal_Add_2" onclick="openIndex()">
                <i class="flaticon2-plus-1"></i>
                Add Container
            </a>
            <a href="#" class="btn btn-primary font-weight-bolder mr-2" id="btnBackIdFolder">
                <i class="flaticon2-back-1"></i>

                Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="scroll" style="min-height:400px; " id="divIdTable2">
                <div class="row">
                    <div class="col-md-12">
                        <button id="id_Reload2" style="display: none;"></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-separate table-head-custom table-checkable" id="idTabel2">
                            <thead>
                                <tr> 
                                    <th>
                                        No
                                    </th>                                    
                                    <th>
                                        folder id
                                    </th>                                    
                                    <th>Actions</th>
                                    <th>
                                        Title
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
                    <!-- end col-12 -->
                </div>
                <!-- END ROW-->
            </div>
            <!--  -->
        </div>    
    </div>
</div>
<!--end::Card 2-->
<!--begin::Card 3-->
<div class="card card-custom" id="idCard3" style="display: none;">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="fa far fa-folder-open"></i>
            </span>
            <h3 class="card-label" id="idLabelFolder"></h3>
        </div>
        
        <div class="card-toolbar">
            <a href="#" class="btn btn-primary font-weight-bolder mr-2" id="idAddDoc" data-toggle="modal" data-target="#kt_modal_Add" onclick="clickCard3()">
                <i class="flaticon2-plus-1"></i>
                Add Document
            </a>
            <a href="#" class="btn btn-primary font-weight-bolder mr-2" id="btnBackIdSubFolder">
                <i class="flaticon2-back-1"></i>

                Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="scroll" style="min-height:400px; " id="divIdTable3">
                <div class="row">
                    <div class="col-md-12">
                        <button id="id_Reload3" style="display: none;"></button>
                    </div>
                </div>
                <div class="col-md-12">
                    <input type="hidden" id="folderIDid"/>
                    <input type="hidden" id="folderNameID"/>
                    <input type="hidden" id="subFolderIDDropzone"/>
                    <table class="table table-separate table-head-custom table-checkable" id="idTabel3">
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
                <!-- END ROW-->
            </div>
            <!--  -->
        </div>    
    </div>
</div>
<!--end::Card 3-->

<!--begin::Card 4-->
<div class="card card-custom" id="idCard4" style="display: none;">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="fa far fa-folder-open"></i>
            </span>
            <h3 class="card-label" id="idLabelFolderCat"></h3>
            
        </div>
        
        <div class="card-toolbar">
            <a href="#" class="btn btn-primary font-weight-bolder mr-2" id="idAddDoc" data-toggle="modal" data-target="#kt_modal_Add" onclick="clickCard4()">
                <i class="flaticon2-plus-1"></i>
                Add Document
            </a>
            <a href="#" class="btn btn-primary font-weight-bolder mr-2" id="btnBackIdSubFolderCat">
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
<!--end::Card 4-->

<!--begin::Card 5-->
<div class="card card-custom" id="idCard5" style="display: none;">
    <div class="card-header">
        <div class="card-title">
            <!-- <span class="card-icon">
                <i class="fa far fa-folder-open"></i>
            </span> -->
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
            <div class="scroll" style="min-height:400px; " id="divIdTable5">
                <div class="row">
                    <div class="col-md-12">
                        <button id="id_Reload5" style="display: none;"></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="row" id="idDivIframe">
                            <div class="col-md-12">
                                <div class="embed-responsive embed-responsive-16by9 z-depth-1-half">
                                  <iframe class="embed-responsive-item" allowfullscreen width="auto" height="auto" id="myFrame" type="application/pdf"></iframe>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-custom shadow-lg p-3 mb-5 bg-white rounded">
                            <div class="card-header ribbon ribbon-top ribbon-ver">
                                 <h3 class="card-title" id="idDocKet"></h3>
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

<!-- Modal Add -->
<div class="modal fade" id="kt_modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="kt-font-brand kt-font-bold"><i class="flaticon2-plus-1"></i>&nbsp;&nbsp;Add Document</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form class="kt-form" id="form_add" method="post" action="javascript:;">
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category Document</label>
                                    <input type="hidden" class="form-control" id="fileNameRenameID"/>
                                    <input type="hidden" class="form-control" id="idCatDoc4"/>
                                    <input type="hidden" class="form-control" id="idDocID"/>
                                    <input type="hidden" class="form-control" id="idCardDisplay"/>  
                                    <input type="hidden" class="form-control" id="folderIDidModal" name="folderID"/>
                                    <input type="hidden" class="form-control" id="folderNameIDModal" name="folderNameID"/>
                                    <input id="idFileSize" name="fileSize" class="form-control" type="hidden">                  
                                    <input type="hidden" class="form-control" id="categoryDocValID" name="categoryDocVal"/>
                                    <input id="fileNameAddID" class="form-control" type="hidden">
                                    <input id="fileNameUploadAddID" name="fileNameUploadAdd" class="form-control" type="hidden">
                                    <input id="fileNameUploadArrID" name="fileNameUploadArr" class="form-control" type="hidden">
                                    <input id="subFolderIDDropzoneModal" class="form-control" type="hidden">
                                    <input id="directoryAddID" name="directoryAdd" class="form-control" type="hidden">
                                    <input id="directoryArrID" name="directoryArr" class="form-control" type="hidden">
                                    <!-- <input id="subFolderid" name="subFolder" class="form-control" type="text">
                                    <input id="subFolderidArr" class="form-control" type="text"> -->
                                    <select class="form-control" id="categoryDocID" name="categoryDoc" required="">
                                        <option></option>
                                    </select>   
                                </div>
                                <div class="form-group">
                                    <table id="dynamic_field_general" border="0" width="100%">
                                                    
                                    </table>   
                                    <table id="dynamic_field" border="0" width="100%">
                                                    
                                    </table> 
                                </div>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" id="submitAddID" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--begin::Modal Add-->

<!-- Modal Add 2 -->
<div class="modal fade" id="kt_modal_Add_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="kt-font-brand kt-font-bold"><i class="flaticon2-plus-1"></i>&nbsp;&nbsp;Add Container</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form class="kt-form" id="form_add_2" method="post" action="javascript:;">
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- <div class="form-group">
                                    <label>Category Document</label>
                                    <input type="hidden" id="categoryDocValID2" name="categoryDocVal2"/>
                                    <select class="form-control" id="categoryDocID2" name="categoryDoc2" required="">
                                        <option></option>
                                    </select>   
                                </div> -->
                                <input type="hidden" id="folderNameID2" name="folderNameID2"/>
                                <input type="hidden" id="folderIDid2" name="folderID2"/>
                                <div class="form-group">
                                    <table id="dynamic_field_general2" border="0" width="100%">
                                                    
                                    </table>
                                </div>
                            </div>
                        </div>                       
                    </div>            
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" id="submitFolderID" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--begin::Modal Add 2-->

<script type="text/javascript">
    jQuery(document).ready(function() {
        initTable1();

        
        $('#fileNameAddID').val('0');
        $('#categoryDocID').select2({
            width: '100%',
            placeholder: "Select Category"
        });
        // $('#categoryDocID2').select2({
        //     width: '100%',
        //     placeholder: "Select Category"
        // });

        // multiple file upload

    });

    
   var initTable1 = function() {

        // begin first table
        var table = $('#idTabel1').DataTable({
            responsive: true,

            ajax: "<?php echo base_url("/collection/my_collection/getCollection"); ?>",
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
                         return '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Open">'+
                               '<i class="fa far fa-folder-open" onclick=view("'+row.folder_id+'")></i></a>'+
                               '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Delete">'+
                               '<i class="flaticon2-trash" onclick=DeleteFolder("'+row.folder_id+'")></i></a>';
                    },
                },
                {
                    targets: 1,
                    visible: false,
                    searchable: false,
                },
                // {
                //     targets: 5,
                //     visible: false,
                //     searchable: false,
                // },
            ],
        });
        $('#id_Reload').click(function () {
            table.ajax.reload();
        });

    };

    function DeleteFolder(folder_id){
          $.ajax({
                type: "POST",
                url: "hapus?folder_id="+folder_id,
                dataType:"JSON",
                success: function(data){
                    UIToastr.init(data.tipePesan, data.pesan); 
                    $("#id_Reload").trigger('click');
                }
            });       
    }

    function view(folder_id){

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>collection/my_collection/getSubFolder",
            data: { folder_id: folder_id }, 
            success: function(result)
            {   
                $('#folderIDid').val(result.folder_id); 
                $('#folderIDid2').val(result.folder_id);
                $('#folderNameID').val(result.folder_name); 
                $('#folderNameID2').val(result.folder_name);
                document.getElementById('idLabel2').textContent = result.folder_name;
                // var groupDoc    = result.group_document;
                // var groupDocArr = groupDoc.split(",");
                // var folderID    = result.folder_id;

                // for (i = 0; i < groupDocArr.length; i++) {
                //   var opt = document.createElement("option");
                //   document.getElementById("categoryDocID").innerHTML += '<option value="' + folderID + '+' + groupDocArr[i] + '">' + groupDocArr[i] + '</option>';
                //    // document.getElementById("categoryDocID2").innerHTML += '<option value="' + groupDocArr[i] + '-' + folderID + '">' + groupDocArr[i] + '</option>';
                // }
                document.getElementById( 'idCard2' ).style.display = 'block';
                document.getElementById( 'idCard1' ).style.display = 'none';
                document.getElementById( 'idCard3' ).style.display = 'none';
                document.getElementById( 'idCard4' ).style.display = 'none';
                document.getElementById( 'idCard5' ).style.display   = 'none'; 
                initTable2(folder_id);
                
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function initTable2 (folder_id) {

        // begin first table
        var table = $('#idTabel2').DataTable({
            responsive: true,

            ajax: {
                url: '<?php echo base_url("/collection/my_collection/getCollectionSub"); ?>',
                type: 'POST',
                data: { folder_id: folder_id }, 
            },
            columns: [
                {data: "no"},
                {data: "folder_id"},
                {data: 'Actions', responsivePriority: 2},
                {data: "sub_folder"},
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
                        return '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Open">'+
                               '<i class="fa far fa-folder-open" onclick=openSubFolder("'+row.sub_folder+'+'+row.folder_id+'")></i></a>'+
                               '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Delete">'+
                               '<i class="flaticon2-trash" onclick=DeleteSubFolder("'+row.sub_folder+'")></i></a>';
                    },
                },
                {
                    targets: 1,
                    visible: false,
                    searchable: false,
                },
            ],
        });
        $('#id_Reload2').click(function () {
            table.ajax.reload();
        });
    };

    function DeleteSubFolder(sub_folder){
          $.ajax({
                type: "POST",
                url: "DeleteSubFolder?sub_folder="+sub_folder,
                dataType:"JSON",
                success: function(data){
                    UIToastr.init(data.tipePesan, data.pesan); 
                    $("#id_Reload2").trigger('click');
                }
            });       
    }

    function deleteDocument(value){
        var hasilSplit = value.split("+");
        var trans_doc_id = hasilSplit[0];        
        var subFolder1 = hasilSplit[1];   
        var document_id = hasilSplit[2];
          $.ajax({
                type: "POST",
                url: "deleteDocument?trans_doc_id="+trans_doc_id,
                dataType:"JSON",
                success: function(data){
                    UIToastr.init(data.tipePesan, data.pesan); 
                    var valueOpen = subFolder1+'+'+document_id
                    openSubFolder2(valueOpen);
                    //$("#id_Reload4").trigger('click');
                }
            });       
    }

function openIndex() {     
    // alert('sagfsdgg');                    
    //         //alert(this.value);
    $('table#dynamic_field_general2 tr').remove();
    var folder_id =  $('#folderIDid2').val(); 
    //alert(folder_id);
    $.ajax({
        type: "POST",
        url: "getFieldGeneralAll?folder_id="+folder_id,
        dataType:"JSON",
        success: function(result){
            var x=0;
           
            $.each(result, function(key, val) {
            x++;
                if(val.general_index_format == 4){
                    $('#dynamic_field_general2').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.general_index_name+'</label><input type="text" name="nameGeneral[]" class="form-control nomor col-md-12" required=""/><input type="hidden" name="general_index_id[]" class="form-control general_index_id_list hidden" value="'+val.general_index_id+'" /><input type="hidden" name="general_index_format[]" class="form-control hidden" value="'+val.general_index_format+'" /></div></td></tr>');
                }else if(val.general_index_format == 3){
                    $('#dynamic_field_general2').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.general_index_name+'</label><input type="text" name="nameGeneral[]" class="form-control kt_datepicker_1" data-date-format="dd-mm-yyyy" placeholder="Select date" required=""/><input type="hidden" name="general_index_id[]" class="form-control specigeneral_index_idfic_index_id_list hidden" value="'+val.general_index_id+'" /><input type="hidden" name="general_index_format[]" class="form-control hidden" value="'+val.general_index_format+'" /></div></td></tr>');
                }else if(val.general_index_format == 2){
                    $('#dynamic_field_general2').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.general_index_name+'</label><input type="number" name="nameGeneral[]" class="form-control col-md-12" required=""/><input type="hidden" name="general_index_id[]" class="form-control general_index_id_list hidden" value="'+val.general_index_id+'" /><input type="hidden" name="general_index_format[]" class="form-control hidden" value="'+val.general_index_format+'" /></div></td></tr>');
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

                $('.kt_datepicker_1').datepicker({
                    rtl: KTUtil.isRTL(),
                    todayHighlight: true,
                    orientation: "bottom left",
                    templates: arrows
                });

                $(".nomor").val("0.00");
                $(".nomor").focus(function () {
                    if ($(this).val() == '0.00') {
                        $(this).val('');
                    } else {
                        this.select();
                    }
                });
                $(".nomor").focusout(function () {
                    if ($(this).val() == '') {
                        $(this).val('0.00');
                    } else {
                        var angka = $(this).val();
                        $(this).val(number_format(angka, 2));
                    }
                });
                $(".nomor").keyup(function () {
                    var val = $(this).val();
                    if (isNaN(val)) {
                        val = val.replace(/[^0-9\.]/g, '');
                        if (val.split('.').length > 2)
                            val = val.replace(/\.+$/, "");
                    }
                    $(this).val(val);

                });
            });
        }
    });                    
}

function openSubFolder(value){  
    //alert(sub_folder);  
    var hasilSplit = value.split("+");
    var sub_folder = hasilSplit[0];        
    var folder_id  = hasilSplit[1];  

     // will remove the element from DOM
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url(); ?>collection/my_collection/getSubFolder",
        data: { folder_id: folder_id }, 
        success: function(result)
        {   
            var groupDoc    = result.group_document;
            var groupDocArr = groupDoc.split(",");
            var folderID    = result.folder_id;

            for (i = 0; i < groupDocArr.length; i++) {
              var opt = document.createElement("option");
              document.getElementById("categoryDocID").innerHTML += '<option value="' + folderID + '+' + groupDocArr[i] + '">' + groupDocArr[i] + '</option>';
            }               
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
    document.getElementById( 'idCard2' ).style.display   = 'none';
    document.getElementById( 'idCard1' ).style.display   = 'none';
    document.getElementById( 'idCard3' ).style.display   = 'block'; 
    document.getElementById( 'idCard4' ).style.display   = 'none'; 
    document.getElementById( 'idCard5' ).style.display   = 'none'; 
    document.getElementById('idLabelFolder').textContent = sub_folder;
    $('#subFolderIDDropzone').val(sub_folder);
    initTable3(sub_folder);
}

    function clickCard3(){
        $('#idCardDisplay').val('card3');
        $('#categoryDocID').attr("disabled", false); 
        var folderID     = $('#folderIDid').val();
        var folderNameID = $('#folderNameID').val();
        var subFolder    = $('#subFolderIDDropzone').val();
        $('#folderIDidModal').val(folderID);
        $('#folderNameIDModal').val(folderNameID);
        $('#subFolderIDDropzoneModal').val(subFolder);
        var cat = $('#categoryDocValID').val();
        if(cat !== ""){
            $('#kt_dropzone_2').show();
        }else{
            $('#kt_dropzone_2').hide();
        }
       
    }

    function openSubFolder2(sub_folder){ 
        //alert(sub_folder);
        var hasilSplit = sub_folder.split("+");
        var subFolderNew = hasilSplit[0];        
        var document_id = hasilSplit[1];   
        var category = hasilSplit[2];
         $.ajax({
              url: '<?php echo base_url(); ?>collection/my_collection/getListDoc',
              type: 'POST',
              data: {document_id:document_id,subFolderNew:subFolderNew},             
              // cache: false,
              // contentType: false,
              // processData: false,
              success: function (jawaban){ 
                //var value = JSON.stringify(jawaban);
                //alert(jawaban);
                if(jawaban.trim() === "kosong") {
                    // array empty or does not exist
                    //alert('tes');
                    $("#btnBackIdSubFolderCat").trigger('click'); 
                    // var subFolder = $('#subFolderIDDropzone').val();
                    // $("#idTabel4").dataTable().fnDestroy();
                    // $("#idTabel3").dataTable().fnDestroy();
                    // openSubFolder(subFolder);
                    
                }else{
                    //alert('dewi');
                    $('#idDocID').val(document_id);         
                    document.getElementById( 'idCard2' ).style.display   = 'none';
                    document.getElementById( 'idCard1' ).style.display   = 'none';
                    document.getElementById( 'idCard3' ).style.display   = 'none'; 
                    document.getElementById( 'idCard4' ).style.display   = 'block';
                    document.getElementById( 'idCard5' ).style.display   = 'none'; 
                    document.getElementById('idLabelFolderCat').textContent = subFolderNew;
                    $('#idCatDoc4').val(category);
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

    function clickCard4(){
        $('#idCardDisplay').val('card4');
        var catDoc = $('#idCatDoc4').val();
        var folderID     = $('#folderIDid').val();
        var folderNameID = $('#folderNameID').val();
        $('#folderIDidModal').val(folderID);
        $('#folderNameIDModal').val(folderNameID);
        var valueSel = folderID+'+'+catDoc;
        $('#categoryDocID').val(valueSel);
        dropdownCat();
        //document.getElementById('categoryDocID').selectedIndex=catDoc+'-'+folderID;
    }

    function dropdownCat (){
        $('#categoryDocID').select2().trigger('change');
        $('#categoryDocID').attr("disabled", true); 
        $('#categoryDocID').select2({
            width: '100%',
            placeholder: "Select Category"
        });
    }  

    $("#categoryDocID").change(function () {
        //alert(this.value);
        $('table#dynamic_field tr').remove();
        $('table#dynamic_field_general tr').remove();
        var a = this.value;
        //var stringDocument = (a.value || a.options[a.selectedIndex].value);
        var hasilSplit = a.split("+");
        var folder_id = hasilSplit[0];
        var categoryDoc = hasilSplit[1];
        $('#categoryDocValID').val(categoryDoc); 
        var subFolder = document.getElementById("idLabelFolder").textContent;
        $('#kt_dropzone_2').show();
        //alert(subFolder);
        $.ajax({
            type: "POST",
            url: "getFieldGeneralAllAndValue?folder_id="+folder_id+"&subFolder="+subFolder,
            dataType:"JSON",
            success: function(result){
                var x=0;
               
                $.each(result, function(key, val) {
                x++;
                    if(val.general_index_format == 4){
                        $('#dynamic_field_general').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.general_index_name+'</label><input type="text" name="nameGeneral[]" class="form-control nomor col-md-12" value="'+val.general_index+'" required="" readonly/><input type="hidden" name="general_index_id[]" class="form-control general_index_id_list hidden" value="'+val.general_index_id+'" /><input type="hidden" name="general_index_format[]" class="form-control hidden" value="'+val.general_index_format+'" /></div></td></tr>');
                    }else if(val.general_index_format == 3){
                        $('#dynamic_field_general').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.general_index_name+'</label><input type="text" name="nameGeneral[]" value="'+val.general_index+'" class="form-control kt_datepicker_1" data-date-format="dd-mm-yyyy" placeholder="Select date" required="" readonly/><input type="hidden" name="general_index_id[]" class="form-control specigeneral_index_idfic_index_id_list hidden" value="'+val.general_index_id+'" /><input type="hidden" name="general_index_format[]" class="form-control hidden" value="'+val.general_index_format+'" /></div></td></tr>');
                    }else if(val.general_index_format == 2){
                        $('#dynamic_field_general').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.general_index_name+'</label><input type="number" name="nameGeneral[]" value="'+val.general_index+'" class="form-control col-md-12" required="" readonly/><input type="hidden" name="general_index_id[]" class="form-control general_index_id_list hidden" value="'+val.general_index_id+'" /><input type="hidden" name="general_index_format[]" class="form-control hidden" value="'+val.general_index_format+'" /></div></td></tr>');
                    }else{
                          $('#dynamic_field_general').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.general_index_name+'</label><input type="text" name="nameGeneral[]" value="'+val.general_index+'" class="form-control" required="" readonly/><td><input type="hidden" name="general_index_id[]" class="form-control general_index_id_list hidden" value="'+val.general_index_id+'" /><input type="hidden" name="general_index_format[]" class="form-control hidden" value="'+val.general_index_format+'" /></div></td></tr>');
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

                    $('.kt_datepicker_1').datepicker({
                        rtl: KTUtil.isRTL(),
                        todayHighlight: true,
                        orientation: "bottom left",
                        templates: arrows
                    });

                    $(".nomor").val("0.00");
                    $(".nomor").focus(function () {
                        if ($(this).val() == '0.00') {
                            $(this).val('');
                        } else {
                            this.select();
                        }
                    });
                    $(".nomor").focusout(function () {
                        if ($(this).val() == '') {
                            $(this).val('0.00');
                        } else {
                            var angka = $(this).val();
                            $(this).val(number_format(angka, 2));
                        }
                    });
                    $(".nomor").keyup(function () {
                        var val = $(this).val();
                        if (isNaN(val)) {
                            val = val.replace(/[^0-9\.]/g, '');
                            if (val.split('.').length > 2)
                                val = val.replace(/\.+$/, "");
                        }
                        $(this).val(val);

                    });
                });
            }
        });

        $.ajax({
            type: "POST",
            url: "getFieldAll?categoryDoc="+categoryDoc,
            dataType:"JSON",
            success: function(result){
                var x=0;
               
                $.each(result, function(key, val) {
                x++;
                    if(val.specific_index_format == 4){
                        $('#dynamic_field').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.specific_index_name+'</label><input type="text" name="name[]" class="form-control nomor col-md-12"/><input type="hidden" name="specific_index_id[]" class="form-control specific_index_id_list hidden" value="'+val.specific_index_id+'" /><input type="hidden" name="specific_index_format[]" class="form-control hidden" value="'+val.specific_index_format+'" /></div></td></tr>');
                    }else if(val.specific_index_format == 3){
                        $('#dynamic_field').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.specific_index_name+'</label><input type="text" name="name[]" class="form-control kt_datepicker_1" data-date-format="dd-mm-yyyy" placeholder="Select date"/><input type="hidden" name="specific_index_id[]" class="form-control specific_index_id_list hidden" value="'+val.specific_index_id+'" /><input type="hidden" name="specific_index_format[]" class="form-control hidden" value="'+val.specific_index_format+'" /></div></td></tr>');
                    }else if(val.specific_index_format == 2){
                        $('#dynamic_field').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.specific_index_name+'</label><input type="number" name="name[]" class="form-control col-md-12"/><input type="hidden" name="specific_index_id[]" class="form-control specific_index_id_list hidden" value="'+val.specific_index_id+'" /><input type="hidden" name="specific_index_format[]" class="form-control hidden" value="'+val.specific_index_format+'" /></div></td></tr>');
                    }else{
                          $('#dynamic_field').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.specific_index_name+'</label><input type="text" name="name[]" class="form-control"/><input type="hidden" name="specific_index_id[]" class="form-control specific_index_id_list hidden" value="'+val.specific_index_id+'" /><input type="hidden" name="specific_index_format[]" class="form-control hidden" value="'+val.specific_index_format+'" /></div></td></tr>');
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

                    $('.kt_datepicker_1').datepicker({
                        rtl: KTUtil.isRTL(),
                        todayHighlight: true,
                        orientation: "bottom left",
                        templates: arrows
                    });

                    $(".nomor").val("0.00");
                    $(".nomor").focus(function () {
                        if ($(this).val() == '0.00') {
                            $(this).val('');
                        } else {
                            this.select();
                        }
                    });
                    $(".nomor").focusout(function () {
                        if ($(this).val() == '') {
                            $(this).val('0.00');
                        } else {
                            var angka = $(this).val();
                            $(this).val(number_format(angka, 2));
                        }
                    });
                    $(".nomor").keyup(function () {
                        var val = $(this).val();
                        if (isNaN(val)) {
                            val = val.replace(/[^0-9\.]/g, '');
                            if (val.split('.').length > 2)
                                val = val.replace(/\.+$/, "");
                        }
                        $(this).val(val);

                    });
                });
            }
        });
    });


function initTable3 (sub_folder) {

        // begin first table
        var table = $('#idTabel3').DataTable({
            responsive: true,

            ajax: {
                url: '<?php echo base_url("/collection/my_collection/getOpenSubFolder"); ?>',
                type: 'POST',
                data: { sub_folder: sub_folder }, 
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
                        return '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Open">'+
                               '<i class="fa far fa-folder-open" onclick=openSubFolder2("'+sub_folder+'+'+row.document_id+'+'+row.document_name+'")></i></a> ';
                    },
                },
                
            ],
        });
        $('#id_Reload3').click(function () {
            table.ajax.reload();
        });
    };


    function prepareFrame(b) {     
    //alert(b);                    
        var hasilSplit = b.split("+");
        var directory  = hasilSplit[0];
        var subFolder  = hasilSplit[1];
        var document_id   = hasilSplit[2];
        var trans_doc_id  = hasilSplit[3];
        var folder_id  = hasilSplit[4];
        var document_name  = hasilSplit[5];
        //alert(document_id);

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>collection/my_collection/getKetFile",
            data: { subFolder: subFolder,document_id: document_id,trans_doc_id: trans_doc_id,folder_id: folder_id}, 
            success: function(result)
            {   
                document.getElementById('idDocKet').textContent = document_name;    
                $.each(result.getGeneralIndexName, function(key, val) {
                    // $('#idIndexingGeneralFile').append('<label>'+val.general_index_name+'&nbsp;<span>&nbsp;:&nbsp;</span>'+val.general_index+'</label>');   
                    $('#idIndexingGeneralFile').append('<div class="row"><label for="example-password-input" class="col-4 col-form-label">'+val.general_index_name+'</label><label class="col-1 col-form-label">:</label><div class="col-7"><label for="example-password-input" class="col-form-label">'+val.general_index+'</label></div></div>');                  
                });
                 $.each(result.getSpecificIndexName, function(key, val) {
                    // $('#idIndexingGeneralFile').append('<label>'+val.general_index_name+'&nbsp;<span>&nbsp;:&nbsp;</span>'+val.general_index+'</label>');   
                    $('#idIndexingSpecificFile').append('<div class="row"><label for="example-password-input" class="col-4 col-form-label">'+val.specific_index_name+'</label><label class="col-1 col-form-label">:</label><div class="col-7"><label for="example-password-input" class="col-form-label">'+val.specific_index+'</label></div></div>');                  
                });
                          
                document.getElementById( 'idCard2' ).style.display   = 'none';
                document.getElementById( 'idCard1' ).style.display   = 'none';
                document.getElementById( 'idCard3' ).style.display   = 'none';
                document.getElementById( 'idCard4' ).style.display   = 'none'; 
                document.getElementById( 'idCard5' ).style.display   = 'block'; 
                var omyFrame = document.getElementById("myFrame");
                omyFrame.src = directory;
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });






         // $.ajax({
         //      url: '<?php echo base_url(); ?>collection/my_collection/getKetFile',
         //      type: 'POST',
         //      data: {subFolder:subFolder},             
         //      success: function (jawaban) {   
         //        // document.getElementById( 'idDivIframe' ).style.display = 'block';
         //        // document.getElementById( 'load_document' ).style.display = 'none';
         //        // var omyFrame = document.getElementById("myFrame");
         //        // omyFrame.src = directory;       
         //      },
         //      beforeSend: function() {             
         //          //$('#idDivIframe').fadeIn('slow');
         //          //$('#loader_table').html('<img src="<?php echo base_url();?>assets/img/Loadingcc.gif">');
         //        }
         //    });
        //     return false;
        // alert(b);
        // document.getElementById( 'btnBackId' ).style.display = 'block';




        // document.getElementById( 'idAddDoc' ).style.display = 'none';
        // var hasilSplit = b.split("+");
        // var directory = hasilSplit[0];
        // var subFolder = hasilSplit[1];
        // document.getElementById( 'idCard2' ).style.display   = 'none';
        // document.getElementById( 'idCard1' ).style.display   = 'none';
        // document.getElementById( 'idCard3' ).style.display   = 'none';
        // document.getElementById( 'idCard4' ).style.display   = 'none'; 
        // document.getElementById( 'idCard5' ).style.display   = 'block'; 
        // var omyFrame = document.getElementById("myFrame");
        // omyFrame.src = directory;
    }

    // $('#btnBackId').on('click', function() {
    //     document.getElementById( 'idDivIframe' ).style.display = 'none';
    //     document.getElementById( 'load_document' ).style.display = 'block';
    // });

function doesFileExist(urlToFile) {
    var xhr = new XMLHttpRequest();
    xhr.open('HEAD', urlToFile, false);
    xhr.send();
     
    if (xhr.status == "404") {
        return false;
    } else {
        return true;
    }
}

function bytesToSize(bytes) {
   var totalSizeMB = Math.round(bytes / Math.pow(1024,1));
   return totalSizeMB;
   // var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   // if (bytes == 0) return '0 Byte';
   // var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   // return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

Dropzone.autoDiscover = false;

var uploadFile= new Dropzone(".dropzone",{
    autoProcessQueue: false,
    url: "<?php echo base_url(); ?>collection/my_collection/uploadFileAdd", // Set the url for your upload script location
    maxFiles: 10,
    maxFilesize: 50, // MB
    method:"post",
    acceptedFiles: "image/*,application/pdf",
    paramName:"filenameAdd",
    dictInvalidFileType:"Type file ini tidak dizinkan",    
    parallelUploads: 30,
 //uploadMultiple: true,
    addRemoveLinks: true,
    renameFilename: function (filename) {
        var catDoc =  $('#categoryDocValID').val();
        var myString = filename.replaceAll(" ", "_").toLowerCase();
        var newFileName = catDoc + '_' + myString;
        var subFolderIDDropzoneModal = $('#subFolderIDDropzoneModal').val();
        var folderNameIDModal = $('#folderNameIDModal').val();
        var path = folderNameIDModal+'/'+subFolderIDDropzoneModal+'/'+newFileName;
        var result = doesFileExist("<?php echo base_url(); ?>uploads/"+path+"");
 
        if (result == true) {
            newFileName = new Date().getTime() + '_' + newFileName;
        }
        $('#fileNameRenameID').val(newFileName);
        return newFileName;
    },
    accept: function(file, done ) {
        //alert(file);

        if (file.name == "") {
            
            $('#fileNameAddID').val('0');
            done("Naha, you don't.");
        } else {
            
            $('#fileNameAddID').val('1');
            //var json = JSON.parse(response);
            var size = bytesToSize(file.size);
            $('#idFileSize').val(size);
            var fileName = $('#fileNameRenameID').val();
            var folderName = $('#folderNameIDModal').val();
            var subFolder  = $('#subFolderIDDropzoneModal').val();
            var directory = 'uploads/'+folderName+'/'+subFolder+'/'+fileName;

            $('#fileNameUploadAddID').val(fileName);
            $('#directoryAddID').val(directory);
            var fileNameUploadAddID = document.getElementById("fileNameUploadAddID").value;
            var fileNameUploadArrID = document.getElementById("fileNameUploadArrID").value;
            var directoryAddID      = document.getElementById("directoryAddID").value;
            var directoryArrID      = document.getElementById("directoryArrID").value;
            if(fileNameUploadArrID == ""){
                $('#fileNameUploadArrID').attr('value', fileNameUploadAddID);
            }else{
                 $('#fileNameUploadArrID').attr('value', fileNameUploadArrID + "+" + fileNameUploadAddID);
            }

            if(directoryArrID == ""){
                $('#directoryArrID').attr('value', directoryAddID);
            }else{
                 $('#directoryArrID').attr('value', directoryArrID + "+" + directoryAddID);
            }
            done();
        }


    },
    success: function(file, response){
        this.removeFile(file);


            //alert(file);
    },
    init: function() {
        this.on("error", function(file, message, xhr) { 
           if (xhr == null) this.removeFile(file); // perhaps not remove on xhr errors
           UIToastr.init('error', 'Only image or pdf / file size is too large '); 
        });
     }
});


// //Event ketika Memulai mengupload
uploadFile.on("sending",function(a,b,c){
    //alert('dewi');
    // $("#subFolderidArr").removeAttr('value');
    // $('input[name="nameGeneral[]"]').each(function(){
    //     var nameGeneral = $(this).val();        
    //     $('#subFolderid').val(nameGeneral);
    //     var subFolderid = document.getElementById("subFolderid").value;
    //     var subFolderidArr = document.getElementById("subFolderidArr").value;
    //     if(subFolderidArr == ""){
    //         $('#subFolderidArr').attr('value', subFolderid);
    //     }else{
    //          $('#subFolderidArr').attr('value', subFolderidArr + "_" + subFolderid);
    //     }
     
    // });

    // var folderName =  document.getElementById("idLabel2").textContent;
    // var subFolder  = document.getElementById("subFolderidArr").value;
    var folderName = $('#folderNameIDModal').val();
    var subFolder  = $('#subFolderIDDropzoneModal').val();

    a.folderNameCmp =  folderName+'+'+subFolder;
        //alert(folderNameCmp);
        c.append("folderNameCmp",a.folderNameCmp); //Menmpersiapkan token untuk masing masing foto
    //alert(folderName);
    c.append("folderName",a.folderName); //Menmpersiapkan token untuk masing masing foto
});

$("#form_add").submit(function(event){
    $(".dz-remove").trigger('click'); 
    uploadFile.processQueue();
    $("#idTabel3").dataTable().fnDestroy();
    //$("#idTabel4").dataTable().fnDestroy();
    // var a = $('#fileNameAddID').val();
    //var fileName = $('#fileNameUploadArrID').val();
    var subFolder = document.getElementById("idLabelFolder").textContent;
    var idCardDisplay = $('#idCardDisplay').val();
    $('#submitAddID').addClass("spinner spinner-right spinner-white pr-15", "Please wait");
    event.preventDefault(); 
    dataString = $("#form_add").serialize();
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url(); ?>collection/my_collection/simpan",
        data: dataString,
        success:function(data)
        {   
            
           //alert('dsafaf');
            UIToastr.init(data.tipePesan, data.pesan); 
            $('#submitAddID').removeClass("spinner spinner-right spinner-white pr-15", "Please wait");
            $("#fileNameUploadArrID").removeAttr('value');
            $("#directoryArrID").removeAttr('value');
            //$("#form_add")[0].reset();
            setTimeout(function() {if($('#kt_modal_Add').modal('hide')){$("#form_add")[0].reset();}}, 1000); 
            $('#categoryDocID').val("");
            dropdownCat();
            $('table#dynamic_field tr').remove();
            $('table#dynamic_field_general tr').remove();
            if(idCardDisplay == 'card3'){
                $("#id_Reload3").trigger('click'); 

            }else{                        
                // document.getElementById( 'idCard3' ).style.display = 'none';
                // document.getElementById( 'idCard4' ).style.display = 'block';
                var document_id = document.getElementById("idDocID").value;
                var valueOpen = subFolder+'+'+document_id
                //alert(valueOpen);
              openSubFolder2(valueOpen);
                //$("#id_Reload4").trigger('click'); 
            }
                   
            //openSubFolder(subFolder);
        }
    });
});   

$("#form_add_2").submit(function(event){
    $('#submitFolderID').addClass("spinner spinner-right spinner-white pr-15", "Please wait");
    event.preventDefault(); 
    dataString = $("#form_add_2").serialize();
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url(); ?>collection/my_collection/simpanFolder",
        data: dataString,
        success:function(data)
        {                          
            UIToastr.init(data.tipePesan, data.pesan); 
            $('#submitFolderID').removeClass("spinner spinner-right spinner-white pr-15", "Please wait");
            setTimeout(function() {if($('#kt_modal_Add_2').modal('hide')){$("#form_add_2")[0].reset();}}, 1000); 
            $('table#dynamic_field_general2 tr').remove();
            $("#id_Reload2").trigger('click');        
        }
    });
});

$('#btnBackIdSubFolder').on('click', function() {
        document.getElementById("categoryDocID").innerHTML = "<option></option>";
        // var element = document.getElementById('categoryDocID'); // will return element
        // element.parentNode.removeChild(element);
        $("#idTabel3").dataTable().fnDestroy();
        $("#idTabel2").dataTable().fnDestroy();
        var valueFolderID = $('#folderIDid').val();
        view(valueFolderID);
        // document.getElementById( 'idCard2' ).style.display   = 'block';
        // document.getElementById( 'idCard1' ).style.display   = 'none';
        // document.getElementById( 'idCard3' ).style.display   = 'none';
        // document.getElementById( 'idCard4' ).style.display   = 'none'; 
        // document.getElementById( 'idCard5' ).style.display   = 'none'; 
    });

     $('#btnBackIdFolder').on('click', function() {
        $("#idTabel2").dataTable().fnDestroy();
        $("#idTabel1").dataTable().fnDestroy();
        initTable1();
        document.getElementById( 'idCard2' ).style.display   = 'none';
        document.getElementById( 'idCard1' ).style.display   = 'block';
        document.getElementById( 'idCard3' ).style.display   = 'none';
        document.getElementById( 'idCard4' ).style.display   = 'none'; 
        document.getElementById( 'idCard5' ).style.display   = 'none'; 
    });

    $('#btnBackIdSubFolderCat').on('click', function() {
        $("#idTabel4").dataTable().fnDestroy();
        $("#idTabel3").dataTable().fnDestroy();
        var subFolder = $('#subFolderIDDropzone').val();
        openSubFolder(subFolder);
        // document.getElementById( 'idCard2' ).style.display   = 'none';
        // document.getElementById( 'idCard1' ).style.display   = 'none';
        // document.getElementById( 'idCard3' ).style.display   = 'block';
        // document.getElementById( 'idCard4' ).style.display   = 'none'; 
        // document.getElementById( 'idCard5' ).style.display   = 'none'; 
    });

    $('#btnBackDisplayDoc').on('click', function() {
        //$("#idTabel4").dataTable().fnDestroy();
        document.getElementById( 'idCard2' ).style.display   = 'none';
        document.getElementById( 'idCard1' ).style.display   = 'none';
        document.getElementById( 'idCard3' ).style.display   = 'none';
        document.getElementById( 'idCard4' ).style.display   = 'block'; 
        document.getElementById( 'idCard5' ).style.display   = 'none'; 
        $("#form_add")[0].reset();
        $('#categoryDocID').val("");
        dropdownCat();
        $('#idIndexingGeneralFile').empty();
        $('#idIndexingSpecificFile').empty();
    });

// $("#form_add").submit(function(event){
//     $(".dz-remove").trigger('click'); 
//     //uploadFile.processQueue();
//     $("#idTabel3").dataTable().fnDestroy();
//     //$("#idTabel4").dataTable().fnDestroy();
//     var a = $('#fileNameAddID').val();
//     var fileName = $('#fileNameUploadArrID').val();
//     var subFolder = document.getElementById("idLabelFolder").textContent;
//     var idCardDisplay = $('#idCardDisplay').val();
//     if(a == 0){
//         Swal.fire("WARNING", "Drop or Drag File", "warning");
//         //UIToastr.init('warning', 'Upload File'); 
//         return false;
//     }else{
//         if(fileName !== ""){
//             $('#submitAddID').addClass("spinner spinner-right spinner-white pr-15", "Please wait");
//             event.preventDefault(); 
//             dataString = $("#form_add").serialize();
//             $.ajax({
//                 type: "POST",
//                 dataType: "json",
//                 url: "<?php echo base_url(); ?>collection/my_collection/simpan",
//                 data: dataString,
//                 success:function(data)
//                 {   
                    
//                    //alert('dsafaf');
//                     UIToastr.init(data.tipePesan, data.pesan); 
//                     $('#submitAddID').removeClass("spinner spinner-right spinner-white pr-15", "Please wait");
//                     $("#fileNameUploadArrID").removeAttr('value');
//                     $("#directoryArrID").removeAttr('value');
//                     $("#form_add")[0].reset();
//                     //setTimeout(function() {if($('#kt_modal_Add').modal('hide')){$("#form_add")[0].reset();}}, 1000); 
//                     $('#categoryDocID').val("");
//                     dropdownCat();
//                     $('table#dynamic_field tr').remove();
//                     $('table#dynamic_field_general tr').remove();
//                     if(idCardDisplay == 'card3'){
//                         $("#id_Reload3").trigger('click'); 

//                     }else{                        
//                         // document.getElementById( 'idCard3' ).style.display = 'none';
//                         // document.getElementById( 'idCard4' ).style.display = 'block';
//                         var document_id = document.getElementById("idDocID").value;
//                         var valueOpen = subFolder+'+'+document_id
//                         //alert(valueOpen);
//                       openSubFolder2(valueOpen);
//                         //$("#id_Reload4").trigger('click'); 
//                     }
                           
//                     //openSubFolder(subFolder);
//                 }
//             });
//         }
        
//     }

// });   

// $("#categoryDocID2").change(function () {
//         //alert(this.value);
//         $('table#dynamic_field_general2 tr').remove();
//         var a = this.value;
//         //var stringDocument = (a.value || a.options[a.selectedIndex].value);
//         var hasilSplit = a.split("-");
//         var folder_id = hasilSplit[1];
//         var categoryDoc = hasilSplit[0];
//         $('#categoryDocValID2').val(categoryDoc); 
//         //alert(folder_id);
//         $.ajax({
//             type: "POST",
//             url: "getFieldGeneralAll?folder_id="+folder_id,
//             dataType:"JSON",
//             success: function(result){
//                 var x=0;
               
//                 $.each(result, function(key, val) {
//                 x++;
//                     if(val.general_index_format == 4){
//                         $('#dynamic_field_general2').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.general_index_name+'</label><input type="text" name="nameGeneral[]" class="form-control nomor col-md-12" required=""/><input type="hidden" name="general_index_id[]" class="form-control general_index_id_list hidden" value="'+val.general_index_id+'" /><input type="hidden" name="general_index_format[]" class="form-control hidden" value="'+val.general_index_format+'" /></div></td></tr>');
//                     }else if(val.general_index_format == 3){
//                         $('#dynamic_field_general2').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.general_index_name+'</label><input type="text" name="nameGeneral[]" class="form-control kt_datepicker_1" data-date-format="dd-mm-yyyy" placeholder="Select date" required=""/><input type="hidden" name="general_index_id[]" class="form-control specigeneral_index_idfic_index_id_list hidden" value="'+val.general_index_id+'" /><input type="hidden" name="general_index_format[]" class="form-control hidden" value="'+val.general_index_format+'" /></div></td></tr>');
//                     }else if(val.general_index_format == 2){
//                         $('#dynamic_field_general2').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.general_index_name+'</label><input type="number" name="nameGeneral[]" class="form-control col-md-12" required=""/><input type="hidden" name="general_index_id[]" class="form-control general_index_id_list hidden" value="'+val.general_index_id+'" /><input type="hidden" name="general_index_format[]" class="form-control hidden" value="'+val.general_index_format+'" /></div></td></tr>');
//                     }else{
//                           $('#dynamic_field_general2').append('<tr id="row'+x+'"><td><div class="form-group"><label>'+val.general_index_name+'</label><input type="text" name="nameGeneral[]" class="form-control" required=""/><td><input type="hidden" name="general_index_id[]" class="form-control general_index_id_list hidden" value="'+val.general_index_id+'" /><input type="hidden" name="general_index_format[]" class="form-control hidden" value="'+val.general_index_format+'" /></div></td></tr>');
//                     }   

//                     var arrows;
//                         if (KTUtil.isRTL()) {
//                             arrows = {
//                                 leftArrow: '<i class="la la-angle-right"></i>',
//                                 rightArrow: '<i class="la la-angle-left"></i>'
//                             }
//                         } else {
//                             arrows = {
//                                 leftArrow: '<i class="la la-angle-left"></i>',
//                                 rightArrow: '<i class="la la-angle-right"></i>'
//                             }
//                         }

//                     $('.kt_datepicker_1').datepicker({
//                         rtl: KTUtil.isRTL(),
//                         todayHighlight: true,
//                         orientation: "bottom left",
//                         templates: arrows
//                     });

//                     $(".nomor").val("0.00");
//                     $(".nomor").focus(function () {
//                         if ($(this).val() == '0.00') {
//                             $(this).val('');
//                         } else {
//                             this.select();
//                         }
//                     });
//                     $(".nomor").focusout(function () {
//                         if ($(this).val() == '') {
//                             $(this).val('0.00');
//                         } else {
//                             var angka = $(this).val();
//                             $(this).val(number_format(angka, 2));
//                         }
//                     });
//                     $(".nomor").keyup(function () {
//                         var val = $(this).val();
//                         if (isNaN(val)) {
//                             val = val.replace(/[^0-9\.]/g, '');
//                             if (val.split('.').length > 2)
//                                 val = val.replace(/\.+$/, "");
//                         }
//                         $(this).val(val);

//                     });
//                 });
//             }
//         });
//     });
</script>

