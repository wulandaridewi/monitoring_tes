<!--begin::Card-->
<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon-map"></i>
            </span>
            <h3 class="card-label"><?php echo strtoupper($menu_name); ?></h3>
        </div>
        <div class="card-toolbar">
            <a href="#" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#kt_modal_Add">
                <i class="flaticon2-plus-1"></i>
                New Expedition
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
                        <table class="table table-bordered table-hover table-checkable dataTable no-footer dtr-inline collapsed" id="idTabelExpedition">
                            <thead>
                                <tr> 
                                    <th>
                                        No
                                    </th>                                    
                                    <th>
                                        Expediton ID
                                    </th>
                                    <th>
                                        Expediton
                                    </th>
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
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="kt-font-brand kt-font-bold"><i class="flaticon2-plus-1"></i>&nbsp;&nbsp;Add Expediton</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form class="kt-form" id="form_add" method="post" action="javascript:;">
                    <div class="kt-portlet__body">
                        
                        <div class="form-group">
                            <label>Expediton</label>
                            <input type="text" class="form-control" name="expediton" id="expediton_id" required="">
                        </div>
                    </div>            
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" id="submitExpeditionNameID" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--begin::Modal Add-->

<!-- Modal Edit -->
<div class="modal fade" id="id_modal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="kt-font-brand kt-font-bold"><i class="flaticon-edit-1"></i>&nbsp;&nbsp;Edit Expediton</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form class="cls_id_form_edit" id="id_form_edit" method="post" action="javascript:;">
                    <div class="kt-portlet__body">                        
                        <div class="form-group">
                            <label>Expediton</label>
                            <input type="text" class="form-control" name="editExpedition" id="editExpeditionID" required="">
                            <input type="hidden" class="form-control" name="editExpeditionID" id="editExpeditionIDid" required="">
                        </div>
                    </div>            
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!-- <a class="btn btn-primary" id="submitEdituserGroupNameID" name="submitEdituserGroupName" onclick="saveEditUsergroup()">Submit</a> -->
                        <button class="btn btn-primary" id="submitEditExpeditionNameID" type="submit">Submit</button>
                        <!-- <a href="javascript:;" class="btn btn-primary" id="submitEdituserGroupNameID">Submit</a> -->
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
    });

   var initTable1 = function() {

        // begin first table
        var table = $('#idTabelExpedition').DataTable({
            responsive: true,

            ajax: "<?php echo base_url("/master/expedition/getExpeditionAll"); ?>",
            columns: [
                {data: "no"},
                {data: "expedition_id"},
                {data: "expedition_name"},
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
                        return '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Edit" onclick=view("'+row.expedition_id+'")>'+
                               '<i class="flaticon-edit-1"></i></a> '+
                               '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Delete" onclick=deleteExpedition("'+row.expedition_id+'")>'+
                               '<i class="flaticon2-trash"></i></a>';
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

$("#form_add").submit(function(event){
    $('#submitExpeditionNameID').attr("disabled", true); 
    $('#submitExpeditionNameID').addClass('spinner spinner-white spinner-right');
    event.preventDefault(); 
    dataString = $("#form_add").serialize();
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url(); ?>master/expedition/save",
        data: dataString,
        success:function(data)
        {
            UIToastr.init(data.tipePesan, data.pesan); 
            $('#submitExpeditionNameID').removeClass('spinner spinner-white spinner-right');
            //setTimeout(function() {$('#kt_modal_Add').modal('hide');}, 2000);            
            setTimeout(function() {if($('#kt_modal_Add').modal('hide')){$("#form_add")[0].reset();}}, 2000); 
            $('#submitExpeditionNameID').attr("disabled", false); 
            $("#id_Reload").trigger('click');
            //$("#form_add")[0].reset();
            
        }
    });
    //return false;
});

// function view(expedition_id,expedition){
//     //alert(a);
//     //UIToastr.init('error', 'error'); 
//     $('#editExpeditionID').val(expedition);
//     $('#editExpeditionIDid').val(expedition_id);
//     $('#id_modal_edit').modal('show');
// }

function view(expedition_id){
     $.ajax({
        type: "POST",
        url: "getFieldAll?expedition_id="+expedition_id,
        dataType:"JSON",
        success: function(result){
            $.each(result, function(key, val) {
            //alert(val.group_user_doc_id);
                $('#editExpeditionID').val(val.expedition_name);
                $('#editExpeditionIDid').val(val.expedition_id);
                $('#id_modal_edit').modal('show');
            });

        }
    });        
}


function deleteExpedition(expedition_id){
    Swal.fire({
            title: "Are you sure?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!"
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "hapus?expedition_id="+expedition_id,
                    dataType:"JSON",
                    success: function(data){
                        UIToastr.init(data.tipePesan, data.pesan); 
                        $("#id_Reload").trigger('click');
                    }
                }); 
            }
        });   
}

$("#id_form_edit").submit(function(event){
    $('#submitExpeditionNameID').attr("disabled", true); 
    $('#submitEditExpeditionNameID').addClass('spinner spinner-white spinner-right');
    event.preventDefault(); 
    dataString = $("#id_form_edit").serialize();
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url(); ?>master/expedition/editExpedition",
        data: dataString,
        success:function(data)
        {
            UIToastr.init(data.tipePesan, data.pesan); 
            $('#submitEditExpeditionNameID').removeClass('spinner spinner-white spinner-right');
            setTimeout(function() {if($('#id_modal_edit').modal('hide')){$("#id_form_edit")[0].reset();}}, 2000);  
            $('#submitExpeditionNameID').attr("disabled", false);           
            $("#id_Reload").trigger('click');            
        }
    });
   // return false;
});

</script>