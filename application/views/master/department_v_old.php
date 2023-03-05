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
                New Department
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
                        <table class="table table-bordered table-hover table-checkable dataTable no-footer dtr-inline collapsed" id="idTabelDept">
                            <thead>
                                <tr> 
                                    <th>
                                        No
                                    </th>                                    
                                    <th>
                                        Dept ID
                                    </th>
                                    <th>
                                        Department
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
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="kt-font-brand kt-font-bold"><i class="flaticon2-plus-1"></i>&nbsp;&nbsp;Add Department</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form class="kt-form" id="form_add" method="post" action="javascript:;">
                    <div class="kt-portlet__body">
                        
                        <div class="form-group">
                            <label>Department</label>
                            <input type="text" class="form-control" name="deptName" id="deptId" required="">
                        </div>
                    </div>            
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" id="submitDeptNameID" name="submituserGroupName" type="submit">Submit</button>
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
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="kt-font-brand kt-font-bold"><i class="flaticon-edit-1"></i>&nbsp;&nbsp;Edit Department</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form class="cls_id_form_edit" id="id_form_edit" method="post" action="javascript:;">
                    <div class="kt-portlet__body">                        
                        <div class="form-group">
                            <label>Department</label>
                            <input type="text" class="form-control" name="ediDeptName" id="editDeptID" required="">
                            <input type="hidden" class="form-control" name="editDeptID" id="editDeptidID" required="">
                        </div>
                    </div>            
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!-- <a class="btn btn-primary" id="submitEdituserGroupNameID" name="submitEdituserGroupName" onclick="saveEditUsergroup()">Submit</a> -->
                        <button class="btn btn-primary" id="submitEditDeptNameID" type="submit">Submit</button>
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
        $.fn.dataTable.ext.errMode = 'none';
        initTable1();
    });

   var initTable1 = function() {

        // begin first table
        var table = $('#idTabelDept').DataTable({
            responsive: true,

            ajax: "<?php echo base_url("/master/department/getDeptAll"); ?>",
            columns: [
                {data: "no"},
                {data: "dept_id"},
                {data: "department"},
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
                        return '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Edit" onclick=view("'+row.dept_id+'","'+row.department+'")>'+
                               '<i class="flaticon-edit-1"></i></a> '+
                               '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Delete" onclick=deleteDept("'+row.dept_id+'")>'+
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
    $('#submitDeptNameID').addClass('kt-spinner kt-spinner--right kt-spinner--md kt-spinner--light');
    event.preventDefault(); 
    dataString = $("#form_add").serialize();
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url(); ?>master/department/save",
        data: dataString,
        success:function(data)
        {
            UIToastr.init(data.tipePesan, data.pesan); 
            $('#submitDeptNameID').removeClass('kt-spinner kt-spinner--right kt-spinner--md kt-spinner--light');
            //setTimeout(function() {$('#kt_modal_Add').modal('hide');}, 2000);            
            setTimeout(function() {if($('#kt_modal_Add').modal('hide')){$("#form_add")[0].reset();}}, 2000); 
            $("#id_Reload").trigger('click');
            //$("#form_add")[0].reset();
            
        }
    });
    //return false;
});

function view(dept_id,deptName){
    //alert(a);
    //UIToastr.init('error', 'error'); 
    $('#editDeptID').val(deptName);
    $('#editDeptidID').val(dept_id);
    $('#id_modal_edit').modal('show');
}

function deleteDept(dept_id){
    $.ajax({
        type: "POST",
        url: "hapus?dept_id="+dept_id,
        dataType:"JSON",
        success: function(data){
            UIToastr.init(data.tipePesan, data.pesan); 
            $("#id_Reload").trigger('click');
        }
    });  
}

$("#id_form_edit").submit(function(event){
    $('#submitEditDeptNameID').addClass('kt-spinner kt-spinner--right kt-spinner--md kt-spinner--light');
    event.preventDefault(); 
    dataString = $("#id_form_edit").serialize();
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url(); ?>master/department/editDept",
        data: dataString,
        success:function(data)
        {
            UIToastr.init(data.tipePesan, data.pesan); 
            $('#submitEdituserGroupNameID').removeClass('kt-spinner kt-spinner--right kt-spinner--md kt-spinner--light');
            setTimeout(function() {if($('#id_modal_edit').modal('hide')){$("#id_form_edit")[0].reset();}}, 2000);            
            $("#id_Reload").trigger('click');            
        }
    });
   // return false;
});

</script>