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
            <a href="#" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#kt_modal_Add">
                <i class="flaticon2-plus-1"></i>
                New Group User Document
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
                        <table class="table table-bordered table-hover table-checkable dataTable no-footer dtr-inline collapsed" id="idTabelGroupUserDoc">
                            <thead>
                                <tr> 
                                    <th>
                                        No
                                    </th>                                    
                                    <th>
                                        Group User Doc ID
                                    </th>
                                    <th>
                                        Name
                                    </th>
                                   <!--   <th>
                                        Group User Document
                                    </th> -->
                                    <th>
                                        Create BY
                                    </th>
                                    <th>
                                        Create Date
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
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="kt-font-brand kt-font-bold"><i class="flaticon2-plus-1"></i>&nbsp;&nbsp;Add Group User Document</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form class="kt-form" id="form_add" method="post" action="javascript:;">
                    <div class="kt-portlet__body">                        
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="nameGroupUserDoc" id="nameGroupUserDocID" required="">
                        </div>
                        <div class="form-group">
                            <label>Group User Document</label>
                             <select class="form-control select2" id="kt_select2_3_modal" name="groupUserDoc[]" multiple="multiple" required="">    
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
                        <button class="btn btn-primary" id="submitGroupUserDocID" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--begin::Modal Add-->

<!-- Modal Edit -->
<div class="modal fade" id="kt_modal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="kt-font-brand kt-font-bold"><i class="flaticon-edit-1"></i>&nbsp;&nbsp;Edit Group User Document</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form class="kt-form" id="form_edit" method="post" action="javascript:;">
                    <div class="kt-portlet__body">                        
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="nameGroupUserDocEdit" id="nameGroupUserDocIDEdit" required="">
                            <input type="hidden" class="form-control" name="groupUserDocID" id="groupUserDocIDid" required="">
                        </div>
                        <div class="form-group">
                            <label>Group User Document</label>
                             <select class="form-control select2" id="kt_select2_3_modal_edit" name="groupUserDocEdit[]" multiple="multiple" required="">    
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
                        <button class="btn btn-primary" id="submitGroupUserDocIDEdit" type="submit">Submit</button>
                    </div>
                </form>
            </div>
         </div>
    </div>
</div>
<!--begin::Modal Edit-->
<script type="text/javascript">
    jQuery(document).ready(function() {
        initTable1();
        //$('#kt_select2_3_modal').attr('placeholder','Select User');
       
    });

     $('#kt_select2_3_modal').select2({
                placeholder: {
                    id: '-1', // the value of the option
                    text: 'Select User'
                  },
                width: '100%',
                allowClear: true
            });
            $('#kt_select2_3_modal_edit').select2({
                placeholder: {
                    id: '-1', // the value of the option
                    text: 'Select User'
                  },
                width: '100%',
                allowClear: true
            });
   var initTable1 = function() {

        // begin first table
        var table = $('#idTabelGroupUserDoc').DataTable({
            responsive: true,

            ajax: "<?php echo base_url("/master/group_user_doc/getGroupUserDoc"); ?>",
            columns: [
                {data: "no"},
                {data: "group_user_doc_id"},
                {data: "group_user_doc_name"},
               // {data: "group_user_doc"},
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
                        return '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Detail">'+
                               '<i class="flaticon-profile" onclick=view("'+row.group_user_doc_id+'")></i></a> '+
                               '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Delete">'+
                               '<i class="flaticon2-trash" onclick=deleteGroupUserDoc("'+row.group_user_doc_id+'")></i></a>';
                    },
                },
                {
                    targets: 1,
                    visible: false,
                    searchable: false,
                },
                // {
                //     targets: 3,
                //     visible: false,
                //     searchable: false,
                // },
            ],
        });
        $('#id_Reload').click(function () {
            table.ajax.reload();
        });

    };

    $("#form_add").submit(function(event){
        $('#submitGroupUserDocID').addClass("spinner spinner-right spinner-white pr-15", "Please wait");
        event.preventDefault(); 
        dataString = $("#form_add").serialize();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>master/group_user_doc/save",
            data: dataString,
            success:function(data)
            {
                UIToastr.init(data.tipePesan, data.pesan); 
                $('#submitGroupUserDocID').removeClass("spinner spinner-right spinner-white pr-15", "Please wait");
                $("#kt_select2_3_modal").val('').trigger('change');
                setTimeout(function() {if($('#kt_modal_Add').modal('hide')){$("#form_add")[0].reset();}}, 1000); 
                $("#id_Reload").trigger('click');        
            }
        });
    });

    function view(group_user_doc_id){
         $.ajax({
            type: "POST",
            url: "getFieldAll?group_user_doc_id="+group_user_doc_id,
            dataType:"JSON",
            success: function(result){
                //$("#navitab_2_2").trigger('click');
                $("#form_edit")[0].reset();
                $('#kt_modal_edit').modal('show');
                //alert(result.Coba);
                var x=0;
                //$('#id_name_documentEdit').val("result.document_name");
                $.each(result, function(key, val) {
                x++; 
                    $('#nameGroupUserDocIDEdit').val(val.group_user_doc_name); 
                    $('#groupUserDocIDid').val(val.group_user_doc_id);
                    var $mySelect = $("#kt_select2_3_modal_edit").select2({
                        placeholder: {
                            id: '-1', // the value of the option
                            text: 'Select Document'
                          },
                        width: '100%',
                        allowClear: true
                    });
                    var group_user_doc = val.group_user_doc;
                    var arr = group_user_doc.split('+');
                    //group_user_doc.splice(0, 1);
                     $mySelect.val(arr).trigger("change");
                });

            }
        });        
    }

    $("#form_edit").submit(function(event){
        $('#submitGroupUserDocIDEdit').addClass("spinner spinner-right spinner-white pr-15", "Please wait");
        event.preventDefault(); 
        dataString = $("#form_edit").serialize();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>master/group_user_doc/edit",
            data: dataString,
            success:function(data)
            {
                UIToastr.init(data.tipePesan, data.pesan); 
                $('#submitGroupUserDocIDEdit').removeClass("spinner spinner-right spinner-white pr-15", "Please wait");
                setTimeout(function() {if($('#kt_modal_edit').modal('hide')){$("#form_edit")[0].reset();}}, 1000); 
                $("#id_Reload").trigger('click');        
            }
        });
    });

    function deleteGroupUserDoc(group_user_doc_id){
          $.ajax({
                type: "POST",
                url: "delete?group_user_doc_id="+group_user_doc_id,
                dataType:"JSON",
                success: function(data){
                    UIToastr.init(data.tipePesan, data.pesan); 
                    $("#id_Reload").trigger('click');
                }
            });       
    }

</script>