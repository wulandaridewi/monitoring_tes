<style type="text/css">

</style>
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
            <a href="#" class="btn btn-primary btn-elevate btn-icon-sm" data-toggle="modal" data-target="#kt_modal_Add">
                <i class="flaticon-folder-4"></i>
                Add Container
            </a>
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
                        <table class="table table-bordered table-hover table-checkable dataTable no-footer dtr-inline collapsed" id="idTabelDocument">
                            <thead>
                                <tr> 
                                    <th>
                                        No
                                    </th>                                    
                                    <th>
                                        Folder_id
                                    </th>
                                    <th>
                                        Container Name
                                    </th>
                                    <th>
                                        Document
                                    </th>
                                    <th>
                                        Document Total
                                    </th>
                                    <th>
                                        Create BY
                                    </th>
                                    <th>
                                        Create Date
                                    </th>
                                    <th>
                                        Create ById
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
<!--end::Card-->
<!-- Modal Add -->
<div class="modal fade" id="kt_modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="kt-font-brand kt-font-bold"><i class="flaticon-folder-4"></i>&nbsp;&nbsp;Add Container</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="kt-form" id="form_add" method="post" action="javascript:;">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Container Name</label>
                                <input id="idValueField" type="hidden" value="0" />
                                <table width="100%">
                                    <td>
                                        <input id="idFolderName" required="required" class="form-control" type="text" name="folderName" onfocusout="cariFolderName()" placeholder=""/>
                                        <input id="idLastIdField" type="hidden" />
                                        <input id="cekField" type="hidden" value="0" />
                                    </td>
                                    <td>
                                        
                                    </td>
                                </table>                                 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Group User Document</label>
                                <select class="form-control select2" id="idGroupUserDoc" name="userGroupDoc" required="">    
                                    <option></option>
                                    <?php
                                        $data = array();
                                        $data[''] = '';
                                        //print_r($jenis_document);
                                        foreach ($getUserGroupDoc as $row) :
                                            // $status_barcode = $row->status_barcode;
                                    ?>       
                                        <option value="<?php echo trim($row->group_user_doc_id) ?>"><?php echo trim($row->group_user_doc_name); ?>                                                        
                                        </option>
                                    <?php
                                        endforeach;
                                    ?>
                                </select>                               
                            </div>
                        </div>
                    </div> 
                    <div class="row">                         
                        <div class="col-md-12">                            
                            <div class="form-group">
                                <label>Document</label>
                                <select class="form-control select2" id="kt_select2_3_modal" name="groupDocument[]" multiple="multiple" required="">    
                                    <option></option>
                                    <?php
                                        $data = array();
                                        $data[''] = '';
                                        //print_r($jenis_document);
                                        foreach ($jenis_document as $row) :
                                            // $status_barcode = $row->status_barcode;
                                    ?>       
                                        <option value="<?php echo trim($row->document_id) ?>"><?php echo trim($row->document_name); ?>                                                        
                                        </option>
                                    <?php
                                        endforeach;
                                    ?>
                                </select>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                            <button type="button" name="add" id="add" class="btn btn-primary btn-elevate btn-icon-sm">+ Add Indexing General</button>
                            <table class="table table-bordered" id="dynamic_field"></table>
                        </div>
                    </div>                   
                </div>
                <div class="modal-footer">
                    <button name="btnSimpan" class="btn btn-light-primary font-weight-bold mr-2" id="submitAddID" type="submit"><i class="fa fa-check"></i> Submit</button>
                    <button type="button" class="btn btn-light-dark font-weight-bold" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--begin::Modal Add-->
<!-- Modal Edit -->
<div class="modal fade" id="kt_modal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="kt-font-brand kt-font-bold"><i class="flaticon-folder-4"></i>&nbsp;&nbsp;Edit Container</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form class="kt-form" id="form_edit" method="post" action="javascript:;">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Container Name</label>
                                <table width="100%">
                                    <td>
                                        <input id="idFolderNameEdit" required="required" class="form-control" type="text" name="folderNameEdit" placeholder=""/>
                                        <input id="idLastIdFieldEdit" type="hidden" />
                                        <input id="cekFieldEdit" type="hidden" value="0" />
                                    </td>
                                    <td>
                                        
                                    </td>
                                </table>                                 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Group User Document</label>
                                <select class="form-control select2" id="idGroupUserDocEdit" name="userGroupDocEdit" required="">    
                                    <option></option>
                                    <?php
                                        $data = array();
                                        $data[''] = '';
                                        //print_r($jenis_document);
                                        foreach ($getUserGroupDoc as $row) :
                                            // $status_barcode = $row->status_barcode;
                                    ?>       
                                        <option value="<?php echo trim($row->group_user_doc_id); ?>"><?php echo trim($row->group_user_doc_name); ?>                                                        
                                        </option>
                                    <?php
                                        endforeach;
                                    ?>
                                </select>                               
                            </div>
                        </div>
                    </div> 
                    <div class="row">                        
                        <div class="col-md-6">                            
                            <div class="form-group">
                                <label>Document</label>
                                <select class="form-control select2" id="kt_select2_3_modal_edit" name="groupDocumentEdit[]" multiple="multiple" required="">    
                                    <option></option>
                                    <?php
                                        $data = array();
                                        $data[''] = '';
                                        //print_r($jenis_document);
                                        foreach ($jenis_document as $row) :
                                            // $status_barcode = $row->status_barcode;
                                    ?>       
                                        <option value="<?php echo trim($row->document_id) ?>"><?php echo trim($row->document_name); ?>                                                        
                                        </option>
                                    <?php
                                        endforeach;
                                    ?>
                                </select>
                            </div>                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                            <button type="button" name="add" id="addEdit" class="btn btn-primary btn-elevate btn-icon-sm">+ Add Indexing General</button>
                            <table class="table table-bordered" id="dynamic_field_edit"></table>
                            <input type="hidden" id="id_id_folderEdit" name="idFolderEdit" placeholder=""/>
                        </div>
                    </div>                   
                </div>
                <div class="modal-footer">
                    <button name="btnEdit" class="btn btn-light-primary font-weight-bold mr-2" id="submitEditID" type="submit"><i class="fa fa-check"></i> Submit</button>
                    <button type="button" class="btn btn-light-dark font-weight-bold" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--begin::Modal Edit-->

<script>
    jQuery(document).ready(function() {
        initTable1();
            $('#idGroupUserDoc').select2({
                placeholder: "Select a Group ",
                width: '100%',
            });
            $('#idGroupUserDocEdit').select2({
                placeholder: "Select a Group ",
                width: '100%',
            });
            $('#kt_select2_3_modal').select2({
                placeholder: {
                    id: '-1', // the value of the option
                    text: 'Select Document'
                  },
                width: '100%',
                allowClear: true
            });
            $('#kt_select2_3_modal_edit').select2({
                placeholder: {
                    id: '-1', // the value of the option
                    text: 'Select Document'
                  },
                width: '100%',
                allowClear: true
            });
        });
    
   var initTable1 = function() {
        // begin first table
        var table = $('#idTabelDocument').DataTable({
            responsive: true,

            ajax: "<?php echo base_url("/master/container/getFolderAll"); ?>",
            columns: [
                {data: "no"},
                {data: "folder_id"},
                {data: "folder_name"},                
                {data: "group_document"},
                {data: "document_total"},
                {data: "createBy"},
                {data: "createDate"},
                {data: 'Actions', responsivePriority: -1},
            ],
            columnDefs: [
                {
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    width: '100px',
                    render: function(data, type, row) {
                        return '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Edit" onclick=view("'+row.folder_id+'")>'+
                               '<i class="flaticon-edit-1"></i></a> '+
                               '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Delete" onclick=DeleteFolder("'+row.folder_id+'")>'+
                               '<i class="flaticon2-trash"></i></a>';
                    },
                },
                {
                    targets: 1,
                    visible: false,
                    searchable: false,
                },
                {
                    targets: 3,
                    width: '250px',
                },
                {
                    targets: 4,
                    width: '80px',
                },
            ],
        });
        $('#id_Reload').click(function () {
            table.ajax.reload();
        });
    };

    var i=0;
    $('#add').click(function(){
        //alert(idLastIdField);
        $('#idValueField').val('1');
        i++;

        var idLastIdField = $('#idLastIdField').val();
        var LastIdField = parseInt(idLastIdField)  + i;
        
        if(idLastIdField !== ""){
            $('#dynamic_field').append('<tr id="row'+LastIdField+'"><td><input type="text" name="name[]" id="name'+i+'" onfocusout="cariNameIndex('+i+')" placeholder="" class="form-control name_list" required /></td><td><select class="form-control" required name="nameFormat[]"><option value="1">Free text</option><option value="2">Number</option><option value="3">Date</option><option value="4">Accounting</option></select></td><td><button type="button" name="remove" id="'+LastIdField+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        }else{
            $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" id="name'+i+'" onfocusout="cariNameIndex('+i+')" placeholder="" class="form-control name_list" required /></td><td><select class="form-control" required name="nameFormat[]"><option value="1">Free text</option><option value="2">Number</option><option value="3">Date</option><option value="4">Accounting</option></select></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        }

    });

    $(document).on('click', '.btn_remove', function(){
        var button_id = $(this).attr("id"); 
        var idField = $('#idField'+button_id+'').val();
        //alert(idField);
        if(typeof(idField) === "undefined" && idField !== null) {
            //alert("name");
            $('#row'+button_id+'').remove();
        }else{
            //alert("deiw");
            removeFieldDB(idField,button_id)
        }
    });

    $("#form_add").submit(function(event){
        var idValueField = $("#idValueField").val();
        var cekField = $("#cekField").val();
        $('#submitAddID').addClass("spinner spinner-right spinner-white pr-15", "Please wait");
        event.preventDefault(); 
        dataString = $("#form_add").serialize();
        if(idValueField == 1){
            if(cekField == 0){
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "<?php echo base_url(); ?>master/container/getDatacariNameIndexSubmit",
                    data: dataString,
                    success:function(data)
                    {
                        var result = data.result;
                        var Indexing = data.text;
                        if($.trim(result)=="singel"){
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "<?php echo base_url(); ?>master/container/simpan",
                                data: dataString,
                                success:function(data)
                                {
                                    UIToastr.init(data.tipePesan, data.pesan); 
                                    $('#idGroupUserDoc').val('').trigger('change');
                                    $('#kt_select2_3_modal').val(0).trigger('change');                    
                                    $('#submitAddID').removeClass("spinner spinner-right spinner-white pr-15", "Please wait");
                                    setTimeout(function() {if($('#kt_modal_Add').modal('hide')){$("#form_add")[0].reset();}}, 1000); 
                                    $("#dynamic_field tr").remove();
                                    $("#id_Reload").trigger('click');        
                                }
                            });
                        }else{
                            $('#submitAddID').removeClass("spinner spinner-right spinner-white pr-15", "Please wait");
                            Swal.fire("Please", "There is double Field", "warning");
                            return false;
                        }  
                    }
                });
            }else{
                Swal.fire("Please", "There is double indexing", "warning");
            }
            
        }else{
            Swal.fire("Please", "Add Field Indexing", "warning");
        }        
    });

    function cariFolderName() {
        //alert('adad');
        var folderName = $('#idFolderName').val();
        // alert(nomorPolis);
        $.ajax({
            type: "POST",
            url: "getDataCariFolderName?folderName="+folderName,
            dataType:"JSON",
            success: function(result){
                var folder_name = result.folder_name;
                //alert(document_name);
                if($.trim(folder_name)=="" || $.trim(folder_name)=="NULL"){
                    // alert("oke");
                }else{
                    //alert("Nama Dokumen '"+ document_name +"' sudah digunakan");
                    Swal.fire("Nama Folder'"+folder_name+"'", "Sudah Di Gunakan", "warning");
                    $('#idFolderName').val('');
                    $('#idFolderName').focus();
                    return false;
                }                
            }
        });
    }

    

    function view(folder_id){
         $.ajax({
            type: "POST",
            url: "getFieldAll?folder_id="+folder_id,
            dataType:"JSON",
            success: function(result){
                $("#form_edit")[0].reset();
                $("#dynamic_field_edit tr").remove();
                $('#kt_modal_edit').modal('show');
                //data folder
                 $.each(result.getFolderNameinContainer, function(key, val) {
                    var groupUserDoc = val.group_user_doc_id;
                    $('#idFolderNameEdit').val(val.folder_name); 
                    $('#id_id_folderEdit').val(val.folder_id);
                    var mySelect2 = $("#idGroupUserDocEdit").select2({
                        placeholder: {
                            id: '-1', // the value of the option
                            text: 'Select a group'
                          },
                        width: '100%',
                        allowClear: true
                    });
                    mySelect2.val(groupUserDoc).trigger("change");
                    
                });
                //data group document
                var groupDoc = [];
                $.each(result.getGroupDocinContainer, function(key, val) {
                     groupDoc.push(val.document_id);
                });
                var $mySelect = $("#kt_select2_3_modal_edit").select2({
                        placeholder: {
                            id: '-1', // the value of the option
                            text: 'Select Document'
                          },
                        width: '100%',
                        allowClear: true
                    });
                 $mySelect.val(groupDoc).trigger("change"); 
                //data group index general
                var x=0;
                $.each(result.getIndexGeneral, function(key, val) {
                x++;                 
                    
                    $('#dynamic_field_edit').append('<tr id="row'+x+'"><td><input type="text" name="name[]" id="name'+x+'" value="'+val.general_index_name+'" class="form-control name_list" required /></td><td style="display:none;"><input type="text" id="idField'+x+'" name="idField[]" value="'+val.general_index_id+'" class="form-control" /></td><td><select class="form-control" required name="nameFormat[]" id="idNameFormat'+x+'"><option value="1">Free text</option><option value="2">Number</option><option value="3">Date</option><option value="4">Accounting</option></select></td><td><button type="button" name="remove" id="'+x+'" class="btn btn-danger btn_remove">X</button></td></tr>');
                    $('#idLastIdFieldEdit').val(x);
                    $('#idNameFormat'+x+'').val(val.general_index_format);
                });

            }
        });        
    }

    $('#addEdit').click(function(){
        //alert(idLastIdField);
        i++;

        var idLastIdField = $('#idLastIdFieldEdit').val();
        var LastIdField = parseInt(idLastIdField)  + i;
        
        if(idLastIdField !== ""){
            $('#dynamic_field_edit').append('<tr id="row'+LastIdField+'"><td><input type="text" name="name[]" id="name'+i+'" onfocusout="cariNameIndexEdit('+i+')" placeholder="" class="form-control name_list" required /></td><td><select class="form-control" required name="nameFormat[]"><option value="1">Free text</option><option value="2">Number</option><option value="3">Date</option><option value="4">Accounting</option></select></td><td><button type="button" name="remove" id="'+LastIdField+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        }else{
            $('#dynamic_field_edit').append('<tr id="row'+i+'"><td><input type="text" name="name[]" id="name'+i+'" onfocusout="cariNameIndexEdit('+i+')" placeholder="" class="form-control name_list" required /></td><td><select class="form-control" required name="nameFormat[]"><option value="1">Free text</option><option value="2">Number</option><option value="3">Date</option><option value="4">Accounting</option></select></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        }

    });

     $("#form_edit").submit(function(event){
        $('#submitEditID').addClass("spinner spinner-right spinner-white pr-15", "Please wait");
        event.preventDefault(); 
        dataString = $("#form_edit").serialize();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>master/container/getDatacariNameIndexSubmit",
            data: dataString,
            success:function(data)
            {
                var result = data.result;
                var Indexing = data.text;
                if($.trim(result)=="singel"){
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "<?php echo base_url(); ?>master/container/ubah",
                        data: dataString,
                        success:function(data)
                        {
                            UIToastr.init(data.tipePesan, data.pesan); 
                            $('#submitEditID').removeClass("spinner spinner-right spinner-white pr-15", "Please wait");
                            setTimeout(function() {if($('#kt_modal_edit').modal('hide')){$("#form_edit")[0].reset();}}, 1000); 
                            $("#dynamic_field_edit tr").remove();
                            $("#id_Reload").trigger('click');        
                        }
                    });

                }else{
                    $('#submitEditID').removeClass("spinner spinner-right spinner-white pr-15", "Please wait");
                    Swal.fire("Please", "There is double Field", "warning");
                    return false;
                }  
            }
        });
    });

    function DeleteFolder(folder_id){
        Swal.fire({
            title: "Are you sure?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!"
        }).then(function(result) {
            if (result.value) {
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
        });       
    }

    function removeFieldDB(idField,button_id){
        Swal.fire({
            title: "Are you sure?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!"
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "removeFieldDB?idField="+idField,
                    dataType:"JSON",
                    success: function(result){
                        UIToastr.init(result.tipePesan, result.pesan);
                        $('#row'+button_id+'').remove();
                        //$("#navitab_2_1").trigger('click');
                    }
                });
            }
        });                    
    }  

    function cariNameIndex(row) {
        //alert('adad');
        event.preventDefault(); 
        dataString = $("#form_add").serialize();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>master/container/getDatacariNameIndex",
            data: dataString,
            success:function(data)
            {
                var result = data.result;
                var Indexing = data.text;
                //alert(document_name);
                if($.trim(result)=="singel"){
                    $('#cekField').val(0);
                }else{
                    Swal.fire("Indexing '"+Indexing+"'", "Already Exist", "warning");
                    $('#name'+row+'').val('');
                    //$('#name'+row+'').focus();
                    var cek1 = $('#cekField').val();
                    cek1++;
                    $('#cekField').val(cek1);
                    return false;
                } 
            } 
        });
    }

    function cariNameIndexEdit(row) {
        //alert('adad');
        event.preventDefault(); 
        dataString = $("#form_edit").serialize();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>master/container/getDatacariNameIndex",
            data: dataString,
            success:function(data)
            {
                var result = data.result;
                var Indexing = data.text;
                //alert(document_name);
                if($.trim(result)=="singel"){
                    $('#cekFieldEdit').val(0);
                }else{
                    Swal.fire("Indexing '"+Indexing+"'", "Already Exist", "warning");
                    $('#name'+row+'').val('');
                    //$('#name'+row+'').focus();
                    var cek1 = $('#cekFieldEdit').val();
                    cek1++;
                    $('#cekFieldEdit').val(cek1);
                    return false;
                }  
            }
        });
    }     

</script>
