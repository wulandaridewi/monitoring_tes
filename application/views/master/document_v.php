<style type="text/css">
    .dataTables_filter{
        float: right !important;
    } 
    .dataTables_length{
       width: 1000px;
   }
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
                <i class="fa fas fa-file-medical"></i>
                Add Document
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
                                        Kode document
                                    </th>
                                    <th>
                                        Document Name
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
                                    <th>Actions</th>
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
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="kt-font-brand kt-font-bold"><i class="fa fas fa-file-medical"></i>&nbsp;&nbsp;Add Document</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form class="kt-form" id="form_add" method="post" action="javascript:;">
                <div class="modal-body">
                    <div class="kt-portlet__body">
                        <div class="form-group">
                            <label>Document Name</label>
                            <table width="70%">
                                <td>
                                    <input id="id_name_document" maxlength="240" required="required" class="form-control col-md-11" type="text" name="nameDocument" onfocusout="cariNameDocument()" placeholder=""/>
                                    <input id="idLastIdField" type="hidden" />
                                    <input id="idValueField" type="hidden" value="0" />
                                    <input id="cekField" type="hidden" value="0" />
                                </td>
                                <td>
                                    <button type="button" name="add" id="add" class="btn btn-primary btn-elevate btn-icon-sm">+ AddField</button>
                                </td>
                            </table>
                            <!-- HIDDEN INPUT -->
                            <input type="hidden" id="id_id_document"   name="idDocument" placeholder=""/>
                            <input type="hidden" id="idTmpAksiBtn"><!-- END HIDDEN INPUT --> 
                            <input type="hidden" id="id_createBy" name="createBy">
                            <input type="hidden" id="id_createDate" name="createDate">
                              
                        </div>
                        <div class="table-responsive">
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
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="kt-font-brand kt-font-bold"><i class="flaticon-edit-1"></i>&nbsp;&nbsp;Edit Document</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form class="kt-form" id="form_edit" method="post" action="javascript:;">
                <div class="modal-body">
                    <div class="kt-portlet__body">
                        <div class="form-group">
                            <label>Nama Document</label>
                            <table width="70%">
                                <td>
                                    <input id="id_name_document_edit" maxlength="240" required="required" class="form-control col-md-11" type="text" name="nameDocumentEdit" placeholder=""/>
                                    <input id="id_name_document_old_edit" class="form-control col-md-11" type="hidden" name="nameDocumentOldEdit"/>
                                    <input id="idLastIdFieldEdit" type="hidden" />
                                    <input id="cekFieldEdit" type="hidden" value="0" />
                                </td>
                                <td>
                                    <button type="button" name="add" id="addEdit" class="btn btn-primary btn-elevate btn-icon-sm">+ AddField</button>
                                </td>
                            </table>
                            <!-- HIDDEN INPUT -->
                            <input type="hidden" id="id_id_documentEdit" name="idDocument" placeholder=""/>
                            <input type="hidden" id="idTmpAksiBtnEdit"><!-- END HIDDEN INPUT --> 
                              
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dynamic_field_edit"></table>
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
    });
   var initTable1 = function() {

        // begin first table
        var table = $('#idTabelDocument').DataTable({
            responsive: true,
            //dom: "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i>>",
            ajax: "<?php echo base_url("/master/document/getDocumentAll"); ?>",
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            columns: [
                {data: "no"},
                {data: "document_id"},
                {data: "document_name"},
                {data: "createBy"},
                {data: "createDate"},
                {data: "createById"},
                {data: 'Actions', responsivePriority: -1},
            ],
            columnDefs: [
                {
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    width: '100px',
                    render: function(data, type, row) {
                        return '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Edit">'+
                               '<i class="flaticon-edit-1" onclick=view("'+row.document_id+'")></i></a> '+
                               '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Delete">'+
                               '<i class="flaticon2-trash" onclick=DeleteDoc("'+row.document_id+'")></i></a>';
                    },
                },
                {
                    targets: 1,
                    visible: false,
                    searchable: false,
                },
                {
                    targets: 5,
                    visible: false,
                    searchable: false,
                },
            ],
        });
        $('#id_Reload').click(function () {
            table.ajax.reload();
        });

    };

    function view(document_id){
         $.ajax({
                type: "POST",
                url: "getFieldAll?document_id="+document_id,
                dataType:"JSON",
                success: function(result){
                    //$("#navitab_2_2").trigger('click');
                    $("#form_edit")[0].reset();
                    $("#dynamic_field_edit tr").remove();
                    $('#kt_modal_edit').modal('show');
                    //alert(result.Coba);
                    var x=0;
                    //$('#id_name_documentEdit').val("result.document_name");
                    $.each(result, function(key, val) {
                    x++;
     
                        $('#id_name_document_edit').val(val.document_name); 
                        $('#id_name_document_old_edit').val(val.document_name); 
                        $('#id_id_documentEdit').val(val.document_id);
                        $('#dynamic_field_edit').append('<tr id="row'+x+'"><td><input type="text" name="name[]" value="'+val.specific_index_name+'" class="form-control name_list" required /></td><td style="display:none;"><input type="text" id="idField'+x+'" name="idField[]" value="'+val.specific_index_id+'" class="form-control" /></td><td><select class="form-control" required name="nameFormat[]" id="idNameFormat'+x+'"><option value="1">Free text</option><option value="2">Number</option><option value="3">Date</option><option value="4">Accounting</option></select></td><td><button type="button" name="remove" id="'+x+'" class="btn btn-danger btn_remove">X</button></td></tr>');
                        $('#idLastIdFieldEdit').val(x);
                        $('#idNameFormat'+x+'').val(val.specific_index_format);
                    });

                }
            });
        
    }



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

   function removeFieldDB(idField,button_id){
    //alert(document_id);
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
                    url: "<?php echo base_url(); ?>master/document/getDatacariNameIndexSubmit",
                    data: dataString,
                    success:function(data)
                    {
                        var result = data.result;
                        var Indexing = data.text;
                        if($.trim(result)=="singel"){
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "<?php echo base_url(); ?>master/document/simpan",
                                data: dataString,
                                success:function(data)
                                {
                                    UIToastr.init(data.tipePesan, data.pesan); 
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
            //UIToastr.init('warning', 'Add Field Indexing'); 
             //return false;
        }
        
    });

    $("#form_edit").submit(function(event){
        $('#submitEditID').addClass("spinner spinner-right spinner-white pr-15", "Please wait");
        event.preventDefault(); 
        dataString = $("#form_edit").serialize();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>master/document/getDatacariNameIndexSubmit",
            data: dataString,
            success:function(data)
            {
                var result = data.result;
                var Indexing = data.text;
                if($.trim(result)=="singel"){
                    $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "<?php echo base_url(); ?>master/document/ubah",
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


    function DeleteDoc(document_id){
        Swal.fire({
            title: "Are you sure?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!"
        }).then(function(result) {
            if (result.value) {  
                  $.ajax({
                        type: "POST",
                        url: "hapus?document_id="+document_id,
                        dataType:"JSON",
                        success: function(data){
                            UIToastr.init(data.tipePesan, data.pesan); 
                            $("#id_Reload").trigger('click');
                        }
                    });  
            }
        }); 
     
    }

    function cariNameDocument() {
        //alert('adad');
        var nameDoc = $('#id_name_document').val();
        // alert(nomorPolis);
        $.ajax({
            type: "POST",
            url: "getDataCariNameDoc?nameDoc="+nameDoc,
            dataType:"JSON",
            success: function(result){
                var document_name = result.document_name;
                //alert(document_name);
                if($.trim(document_name)=="" || $.trim(document_name)=="NULL"){
                    // alert("oke");
                }else{
                    //alert("Nama Dokumen '"+ document_name +"' sudah digunakan");
                    Swal.fire("Document Name'"+document_name+"'", "Already Exist", "warning");
                    $('#id_name_document').val('');
                    $('#id_name_document').focus();
                    return false;
                }                
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
            url: "<?php echo base_url(); ?>master/document/getDatacariNameIndex",
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
            url: "<?php echo base_url(); ?>master/document/getDatacariNameIndex",
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
