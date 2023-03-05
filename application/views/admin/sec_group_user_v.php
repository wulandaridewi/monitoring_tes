<!--begin::Card-->
<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="fa fa-users-cog"></i>
            </span>
            <h3 class="card-label"><?php echo strtoupper($menu_name); ?></h3>
        </div>
        <div class="card-toolbar">
            <a href="#" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#kt_modal_Add">
                <i class="flaticon2-plus-1"></i>
                New User Group
            </a>
        </div>
    </div>
    <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-bordered table-hover table-checkable" id="kt_datatable">
            <thead>
                <tr>
                    <th>User Group ID</th>
                    <th>User Group</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>User Group ID</th>
                    <th>User Group</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
        </table>
        <!--end: Datatable-->
    </div>
</div>
<!--end::Card-->
<!-- Modal Add -->
<div class="modal fade" id="kt_modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="kt-font-brand kt-font-bold"><i class="fa fa-users"></i>&nbsp;&nbsp;Add User Group</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form class="kt-form" id="form_add" method="post" action="javascript:;">
                    <div class="kt-portlet__body">
                        
                        <div class="form-group">
                            <label>User Group</label>
                            <input type="text" class="form-control" name="userGroupName" id="userGroupID" required="">
                        </div>
                    </div>            
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" id="submituserGroupNameID" name="submituserGroupName" type="submit">Submit</button>
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
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="kt-font-brand kt-font-bold"><i class="fa fa-users"></i>&nbsp;&nbsp;Edit User Group</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form class="cls_id_form_edit" id="id_form_edit" method="post" action="javascript:;">
                    <div class="kt-portlet__body">                        
                        <div class="form-group">
                            <label>User Group</label>
                            <input type="text" class="form-control" name="editUserGroupName" id="editUserGroupID" required="">
                            <input type="hidden" class="form-control" name="editUserGroupID" id="editUserGroupidID" required="">
                        </div>
                    </div>            
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!-- <a class="btn btn-primary" id="submitEdituserGroupNameID" name="submitEdituserGroupName" onclick="saveEditUsergroup()">Submit</a> -->
                        <button class="btn btn-primary" id="submitEdituserGroupNameID" type="submit">Submit</button>
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
        KTDatatablesSearchOptionsColumnSearch.init();
    });

    var KTDatatablesSearchOptionsColumnSearch = function() {

    $.fn.dataTable.Api.register('column().title()', function() {
        return $(this.header()).text().trim();
    });

    var initTable1 = function() {

        // begin first table
        var table = $('#kt_datatable').DataTable({
            responsive: true,

            // Pagination settings
            dom: `<'row'<'col-sm-12'tr>>
            <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            // read more: https://datatables.net/examples/basic_init/dom.html

            lengthMenu: [5, 10, 25, 50],

            pageLength: 10,

            language: {
                'lengthMenu': 'Display _MENU_',
            },

            searchDelay: 500,
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?php echo base_url("/admin/sec_group_user/getUserGroupAll"); ?>',
                type: 'POST',
                data: {
                    // parameters for custom backend script demo
                    columnsDef: [
                        'usergroupId', 'usergroupDesc', 'Actions',
                    ],
                },
            },
            columns: [
                {data: 'usergroupId'},
                {data: 'usergroupDesc'},
                {data: 'Actions', responsivePriority: -1},
            ],
            initComplete: function() {
                var thisTable = this;
                var rowFilter = $('<tr class="filter"></tr>').appendTo($(table.table().header()));

                this.api().columns().every(function() {
                    var column = this;
                    var input;

                    switch (column.title()) {
                        //case 'User Group ID':
                        case 'User Group':
                            input = $(`<input type="text" class="form-control form-control-sm form-filter datatable-input" data-col-index="` + column.index() + `"/>`);
                            break;

                        case 'Actions':
                            var search = $(`
                                <button class="btn btn-primary kt-btn btn-sm kt-btn--icon d-block" id="id_btn_search">
                                    <span>
                                        <i class="flaticon-search"></i>
                                        <span>Search</span>
                                    </span>
                                </button>`);

                            var reset = $(`
                                <button class="btn btn-secondary kt-btn btn-sm kt-btn--icon">
                                    <span>
                                       <i class="flaticon2-cross"></i>
                                       <span>Reset</span>
                                    </span>
                                </button>`);

                            $('<th>').append(search).append(reset).appendTo(rowFilter);

                            $(search).on('click', function(e) {
                                e.preventDefault();
                                var params = {};
                                $(rowFilter).find('.datatable-input').each(function() {
                                    var i = $(this).data('col-index');
                                    if (params[i]) {
                                        params[i] += '|' + $(this).val();
                                    } else {
                                        params[i] = $(this).val();
                                    }
                                });
                                $.each(params, function(i, val) {
                                    // apply search params to datatable
                                    table.column(i).search(val ? val : '', false, false);
                                });
                                table.table().draw();
                            });

                            $(reset).on('click', function(e) {
                                e.preventDefault();
                                $(rowFilter).find('.datatable-input').each(function(i) {
                                    $(this).val('');
                                    table.column($(this).data('col-index')).search('', false, false);
                                });
                                table.table().draw();
                            });
                            break;
                    }

                    if (column.title() !== 'Actions') {
                        $(input).appendTo($('<th>').appendTo(rowFilter));
                    }
                });

                // hide search column for responsive table
                var hideSearchColumnResponsive = function() {
                    thisTable.api().columns().every(function() {
                        var column = this
                        if (column.responsiveHidden()) {
                            $(rowFilter).find('th').eq(column.index()).show();
                        } else {
                            $(rowFilter).find('th').eq(column.index()).hide();
                        }
                    })
                };

                // init on datatable load
                hideSearchColumnResponsive();
                // recheck on window resize
                window.onresize = hideSearchColumnResponsive;

                $('#kt_datepicker_1,#kt_datepicker_2').datepicker();
            },
            columnDefs: [
                {
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    width: '70px',
                    render: function(ddata, type, row) {
                        return '<a class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">'+
                               '<i class="flaticon-edit-1" onclick=editUserGroup('+row.usergroupId+',"'+row.usergroupDesc+'")></i></a> '+
                               '<a class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">'+
                               '<i class="flaticon2-trash" onclick=deleteUserGroup('+row.usergroupId+')></i></a>';
                    },
                    
                },
            ],
        });

    };

    return {

        //main function to initiate the module
        init: function() {
            initTable1();
        },

    };

}();

$("#form_add").submit(function(event){
    $('#submituserGroupNameID').addClass('kt-spinner kt-spinner--right kt-spinner--md kt-spinner--light');
    event.preventDefault(); 
    dataString = $("#form_add").serialize();
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url(); ?>admin/sec_group_user/saveUserGroup",
        data: dataString,
        success:function(data)
        {
            UIToastr.init(data.tipePesan, data.pesan); 
            $('#submituserGroupNameID').removeClass('kt-spinner kt-spinner--right kt-spinner--md kt-spinner--light');
            //setTimeout(function() {$('#kt_modal_Add').modal('hide');}, 2000);            
            setTimeout(function() {if($('#kt_modal_Add').modal('hide')){$("#form_add")[0].reset();}}, 2000); 
            $("#id_btn_search").trigger('click');
            //$("#form_add")[0].reset();
            
        }
    });
    //return false;
});

function editUserGroup(id,name){
    //alert(a);
    //UIToastr.init('error', 'error'); 
    $('#editUserGroupID').val(name);
    $('#editUserGroupidID').val(id);
    $('#id_modal_edit').modal('show');
}

function deleteUserGroup(id){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url(); ?>admin/sec_group_user/deleteUserGroup",
        data: { usergroupId: id }, 
        success:function(data)
        {
            UIToastr.init(data.tipePesan, data.pesan); 
            $("#id_btn_search").trigger('click');
        }
    });
}

$("#id_form_edit").submit(function(event){
    $('#submitEdituserGroupNameID').addClass('kt-spinner kt-spinner--right kt-spinner--md kt-spinner--light');
    event.preventDefault(); 
    dataString = $("#id_form_edit").serialize();
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url(); ?>admin/sec_group_user/editUserGroup",
        data: dataString,
        success:function(data)
        {
            UIToastr.init(data.tipePesan, data.pesan); 
            $('#submitEdituserGroupNameID').removeClass('kt-spinner kt-spinner--right kt-spinner--md kt-spinner--light');
            setTimeout(function() {if($('#id_modal_edit').modal('hide')){$("#id_form_edit")[0].reset();}}, 2000);            
            $("#id_btn_search").trigger('click');
            
        }
    });
   // return false;
});

</script>