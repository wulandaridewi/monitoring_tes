<style type="text/css">
   /*table#kt_table_1 th:nth-child(1){
        display: none;
    } 
    table#kt_table_1 td:nth-child(1){
        display: none;
    } 
    table#kt_table_1 tr.filter th:nth-child(1){
        display: none;
    } 
    table#kt_table_1 tr.filter td:nth-child(1){
        display: none;
    }  */ 

</style>
<!--begin::Card-->
<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="<?php echo $menu_icon; ?>"></i>
            </span>
            <h3 class="card-label"><?php echo strtoupper($menu_nama); ?></h3>
        </div>
        <div class="card-toolbar">
            <!-- <a href="#" class="btn btn-primary btn-elevate btn-icon-sm" data-toggle="modal" data-target="#kt_modal_Add">
                <i class="fa fa-user-plus"></i>
                Add User
            </a> -->
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="scroller" style="height:400px; " id="divIdTable">
                <div class="row">
                    <div class="col-md-12">
                        <button id="id_Reload" style="display: none;"></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-hover table-checkable dataTable no-footer dtr-inline collapsed"
                               id="idTabelDocument">
                            <thead>
                                <tr> 
                                    <th>
                                        No
                                    </th>                                    
                                    <th>
                                        Kode document
                                    </th>
                                    <th>
                                        Nama document
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
                                    <th>status_barcode</th>
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
            <div class="row col-md-12" id="divIdData" style="display: none;">
                <form class="kt-form" id="form_add" method="post" action="javascript:;">
                    <div class="kt-portlet__body">
                        <div class="form-group">
                            <label>Nama Document</label>
                            <table width="70%">
                                <td>
                                    <input id="id_name_document" maxlength="240" required="required" class="form-control col-md-11" type="text" name="nameDocument" placeholder=""/>
                                    <input id="idLastIdField" type="hidden" />
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
                            <input type="hidden" id="id_createById" name="createById">
                              
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dynamic_field"></table>
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
<!--end::Card-->


<script>
    jQuery(document).ready(function() {
        initTable1();
    });
   var initTable1 = function() {

        // begin first table
        var table = $('#idTabelDocument').DataTable({
            responsive: true,

            ajax: "<?php echo base_url("/master/document/getDocumentAll"); ?>",
            columns: [
                {data: "no"},
                {data: "document_id"},
                {data: "document_name"},
                {data: "createBy"},
                {data: "createDate"},
                {data: "createById"},
                {data: "status_barcode"},
                {data: 'Actions', responsivePriority: -1},
            ],
            columnDefs: [
                {
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    width: '70px',
                    render: function(data, type, row) {
                        return '<a class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">'+
                               '<i class="flaticon-edit-1" onclick=view("'+row.document_id+'")></i></a> '+
                               '<a class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">'+
                               '<i class="flaticon2-trash" onclick=delet("'+row.document_id+'")></i></a>';
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
                {
                    targets: 6,
                    visible: false,
                    searchable: false,
                },
            ],
        });

    };

    function view(document_id){
         $.ajax({
                type: "POST",
                url: "getFieldAll?document_id="+document_id,
                dataType:"JSON",
                success: function(result){
                    $("#navitab_2_2").trigger('click');
                    //alert(result.Coba);
                    var x=0;
                    //$('#id_name_documentEdit').val("result.document_name");
                    $.each(result, function(key, val) {
                    x++;
                    //alert(val.fieldName);
                    //alert(val.idField);    
                        document.getElementById( 'divIdTable' ).style.display = 'none';
                        document.getElementById( 'divIdData' ).style.display = 'block';      
                        $('#id_name_document').val(val.document_name);         
                        $('#dynamic_field').append('<tr id="row'+x+'"><td><input type="text" name="name[]" value="'+val.fieldName+'" class="form-control name_list" required /></td><td style="display:none;"><input type="text" id="idField'+x+'" name="idField[]" value="'+val.idField+'" class="form-control" /></td><td><select class="form-control" required name="nameFormat[]" id="idNameFormat'+x+'"><option value="1">Free text</option><option value="2">Number</option><option value="3">Date</option><option value="4">Accounting</option></select></td><td><button type="button" name="remove" id="'+x+'" class="btn btn-danger btn_remove">X</button></td></tr>');
                        $('#idLastIdField').val(x);
                        $('#idNameFormat'+x+'').val(val.document_format);
                    });

                }
            });
        
    }


    var i=0;
    $('#add').click(function(){
        //alert(idLastIdField);
        i++;
        var idLastIdField = $('#idLastIdField').val();
        var LastIdField = parseInt(idLastIdField)  + i;
        
        if(idLastIdField !== ""){
            $('#dynamic_field').append('<tr id="row'+LastIdField+'"><td><input type="text" name="name[]" placeholder="" class="form-control name_list" required /></td><td><select class="form-control" required name="nameFormat[]"><option value="1">Free text</option><option value="2">Number</option><option value="3">Date</option><option value="4">Accounting</option></select></td><td><button type="button" name="remove" id="'+LastIdField+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        }else{
            $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" placeholder="" class="form-control name_list" required /></td><td><select class="form-control" required name="nameFormat[]"><option value="1">Free text</option><option value="2">Number</option><option value="3">Date</option><option value="4">Accounting</option></select></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
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
            removeFieldDB(idField)
        }
     });

       function removeFieldDB(idField){
        //alert(document_id);
        $.ajax({
                type: "POST",
                url: "removeFieldDB?idField="+idField,
                dataType:"JSON",
                success: function(result){
                    UIToastr.init(result.tipePesan, result.pesan);
                    $("#navitab_2_1").trigger('click');
                }
            });
        }
         $('#id_from_document').submit(function (event) {
        dataString = $("#id_from_document").serialize();

        var aksiBtn = $('#idTmpAksiBtn').val();
        if (aksiBtn == '1') {
            ajaxSubmit("master/document/simpan",dataString);
            $('#id_from_document')[0].reset();
            $('table#dynamic_field tr').remove();
            
        } else if (aksiBtn == '2') {
            ajaxSubmit("master/document/ubah",dataString);
            $("#navitab_2_1").trigger('click');

        } else if (aksiBtn == '3'){
            ajaxSubmit("master/document/hapus",dataString);
            $("#navitab_2_1").trigger('click');
            // $('#id_from_document')[0].reset();
            // $('table#dynamic_field tr').remove();
        }
        event.preventDefault();
    });
</script>
