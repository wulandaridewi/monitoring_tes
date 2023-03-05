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
            <h3 class="card-label"><?php echo strtoupper($menu_name); ?></h3>
        </div>
        <div class="card-toolbar">
            <a href="#" class="btn btn-primary btn-elevate btn-icon-sm" data-toggle="modal" data-target="#kt_modal_Add">
                <i class="fa fa-user-plus"></i>
                Add User
            </a>
        </div>
    </div>
    <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-bordered table-hover table-checkable" id="kt_table_1">
            <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Employee Name</th>
                        <th>Department</th>
                        <th>dept id</th>
                        <th>Email</th>
                        <th>User Name</th>
                        <th>Password</th>
                        <th>ID User Group</th>
                        <th>User Group</th> 
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>User ID</th>
                        <th>Employee Name</th>
                        <th>Department</th>
                        <th>dept id</th>
                        <th>Email</th>
                        <th>User Name</th>
                        <th>Password</th>
                        <th>ID User Group</th>
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
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="kt-font-brand kt-font-bold"><i class="fa fa-user-plus"></i>&nbsp;&nbsp;Add User</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form class="kt-form" id="form_add" method="post" action="javascript:;">
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" style="display: none;">
                                    <label>User id</label>
                                    <input id="id_userId" class="form-control" type="text" name="userId" readonly/>
                                </div>
                                <div class="form-group">
                                    <label>Employee Name</label>
                                    <input id="id_karyawan"  name="karyawan" class="form-control" type="text" placeholder="Enter Employee Name" required>
                                </div>                                
                                <div class="row">
                                    <div class="form-group col-md-8">
                                        <label>User name</label> 
                                        <input id="userNameID"  name="userName" class="form-control" type="text" placeholder="Enter your username" required> 
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Gender</label>
                                        <select class="form-control" id="gender" name="gender" required="">
                                            <option value="P">Woman</option>
                                            <option value="L">Men</option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Department</label>
                                    <?php
                                        $data = array();
                                        $data[''] = '';
                                        foreach ($get_dept as $row) :
                                            $data[trim($row['dept_id'])] = trim($row['department']);
                                        endforeach;
                                        echo form_dropdown('department', $data, '', 'id="dept_id" class="form-control" placeholder="Select Department" required');
                                    ?>
                                </div>
                            </div>                     
                            <div class="col-md-6">  

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="email" id="emailID" placeholder="Enter your email" required="">
                                </div>                              
                                <div class="form-group">
                                    <label>Group User</label>
                                    <?php
                                        $data = array();
                                        $data[''] = '';
                                        foreach ($group_user as $row) :
                                            $data[trim($row['usergroup_id'])] = trim($row['usergroup_desc']);
                                        endforeach;
                                        echo form_dropdown('userGroup', $data, '', 'id="id_groupUser" class="form-control" required');
                                    ?>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Password</label>
                                        <input id="passwordID"  name="password" class="form-control clsPasswd" type="password" required> 
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Confirmation Password</label>
                                        <input id="confPasswordID"  name="confPassword" class="form-control clsPasswd" type="password" required> 
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="mt-checkbox-list" >
                                        <label class="mt-checkbox mt-checkbox-outline" id ="id_showPassword">
                                            <input type="checkbox" name="remember" value="1" id="id_chckshowPassword" /> Show password
                                            <span></span>
                                        </label>
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

<!-- Modal Edit -->
<div class="modal fade" id="id_modal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="kt-font-brand kt-font-bold"><i class="fa fa-user-edit"></i>&nbsp;&nbsp;Edit User</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form class="kt-form" id="form_edit" method="post" action="javascript:;">
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" style="display: none;">
                                    <label>User id</label>
                                    <input id="id_userIdEdit" class="form-control" type="text" name="userIdEdit" readonly/>
                                </div>
                                <div class="form-group">
                                    <label>Employee Name</label>
                                    <input id="id_karyawanEdit"  name="karyawanEdit" class="form-control" type="text" required>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-8">
                                        <label>User name</label> 
                                        <input id="userNameIDEdit"  name="userNameEdit" class="form-control" type="text" required> 
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Gender</label>
                                        <select class="form-control" id="genderEdit" name="genderEdit" required="">
                                            <option value="P">Woman</option>
                                            <option value="L">Men</option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Department</label>
                                    <?php
                                        $data = array();
                                        $data[''] = '';
                                        foreach ($get_dept as $row) :
                                            $data[trim($row['dept_id'])] = trim($row['department']);
                                        endforeach;
                                        echo form_dropdown('departmentEdit', $data, '', 'id="deptIDEdit" class="form-control" placeholder="Select Department" required');
                                    ?>
                                </div>
                                
                            </div>                     
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="emailEdit" id="emailIDEdit" placeholder="Enter your email" required="">
                                </div>
                                <div class="form-group">
                                    <label>Group User</label>
                                    <?php
                                        $data = array();
                                        $data[''] = '';
                                        foreach ($group_user as $row) :
                                            $data[trim($row['usergroup_id'])] = trim($row['usergroup_desc']);
                                        endforeach;
                                        echo form_dropdown('userGroupEdit', $data, '', 'id="id_groupUserEdit" class="form-control" required');
                                    ?>
                                </div>
                                <div class="row">                                    
                                    <div class="form-group col-md-6">
                                        <label>Password</label>
                                        <input id="passwordIDEdit"  name="passwordEdit" class="form-control clsPasswd" type="password" required> 
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Confirmation Password</label>
                                        <input id="confPasswordIDEdit"  name="confPasswordEdit" class="form-control clsPasswd" type="password" required> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="mt-checkbox-list" >
                                        <label class="mt-checkbox mt-checkbox-outline" id ="id_showPasswordEdit">
                                            <input type="checkbox" name="rememberEdit" value="1" id="id_chckshowPasswordEdit" /> Show password
                                            <span></span>
                                        </label>
                                    </div>
                                </div>                                
                            </div>
                        </div>                       
                    </div>            
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" id="submitEditID" type="submit">Submit</button>
                    </div>
                </form>
            </div>
         </div>
    </div>
</div>
<!--begin::Modal Edit-->
<script type="text/javascript">

jQuery(document).ready(function() {
    resetForm()
    KTDatatablesSearchOptionsColumnSearch.init();

});

$("#id_showPassword").click(function () {
    if ($('#id_chckshowPassword').is(':checked')) {
        $('.clsPasswd').attr('type', 'text');
    } else {
        $('.clsPasswd').attr('type', 'password');
    }
});
$("#id_showPasswordEdit").click(function () {
    if ($('#id_chckshowPasswordEdit').is(':checked')) {
        $('.clsPasswd').attr('type', 'text');
    } else {
        $('.clsPasswd').attr('type', 'password');
    }
});

var KTDatatablesSearchOptionsColumnSearch = function() {

    $.fn.dataTable.Api.register('column().title()', function() {
        return $(this.header()).text().trim();
    });

    var initTable1 = function() {

        // begin first table
        var table = $('#kt_table_1').DataTable({
            responsive: true,

            // Pagination settings
            dom: "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
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
                url: '<?php echo base_url("/master/sec_user/getUserAll"); ?>',
                type: 'POST',
                data: {
                    // parameters for custom backend script demo
                    columnsDef: [
                        'userid', 'name', 'username', 'password', 'usergroup', 'usergroupDesc', 'Actions',],
                },
            },

            columns: [
                {data: 'userid'},
                {data: 'name'},
                {data: 'department'},
                {data: 'dept_id'},
                {data: 'email'},
                {data: 'username'},
                {data: 'password'},
                {data: 'usergroup'},
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
                        case 'Employee Name':
                        case 'User Name':
                        case 'Department':
                        case 'Email':
                            input = $('<input type="text" class="form-control form-control-sm form-filter datatable-input" data-col-index="' + column.index() + '"/>');
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

                                    }
                                    else {
                                        params[i] = $(this).val();
                                    }
                                    //alert(params[i]);
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
                 var hideSearchColumnResponsive = function () {
                   thisTable.api().columns().every(function () {
                       var column = this
                       if(column.responsiveHidden()) {
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
                    render: function(data, type, row) {
                        return '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Edit">'+
                               '<i class="fa fa-user-edit" onclick=editUser("'+row.userid+'")></i></a> '+
                               '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Delete">'+
                               '<i class="flaticon2-trash" onclick=deleteUser("'+row.userid+'")></i></a>';
                    },
                },
                {
                    targets: 3,
                    visible: false,
                    searchable: false,
                },
                {
                    targets: 6,
                    visible: false,
                    searchable: false,
                },
                {
                    targets: 7,
                    visible: false,
                    searchable: false,
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
// document.getElementById("submituserGroupNameID").onclick   = function() {btnSaveUserGroup()};
// function btnSaveUserGroup() {
    
// }
$("#form_add").submit(function(event){
    $('#submitAddID').addClass('kt-spinner kt-spinner--right kt-spinner--md kt-spinner--light');
    event.preventDefault(); 
    dataString = $("#form_add").serialize();
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url(); ?>master/sec_user/save",
        data: dataString,
        success:function(data)
        {
            UIToastr.init(data.tipePesan, data.pesan); 
            $('#submitAddID').removeClass('kt-spinner kt-spinner--right kt-spinner--md kt-spinner--light');
            setTimeout(function() {if($('#kt_modal_Add').modal('hide')){$("#form_add")[0].reset();}}, 2000); 
            $("#id_btn_search").trigger('click');           
        }
    });
    //return false;
});

function editUser(userid){
    $('#form_edit')[0].reset(); // reset form on modals 
    //Ajax Load data from ajax
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url(); ?>master/sec_user/getDataRowTable",
        data: { userid: userid }, 
        success: function(data)
        {
           $('#id_userIdEdit').val(data.userid);
            $('#id_karyawanEdit').val(data.name);
            $('#passwordIDEdit').val(data.passwd);
            $('#confPasswordIDEdit').val(data.passwd);  
            $('#id_groupUserEdit').val(data.usergroupid);  
            $('#userNameIDEdit').val(data.username); 
            $('#emailIDEdit').val(data.email); 
            $('#deptIDEdit').val(data.dept_id); 
            $('#genderEdit').val(data.gender); 
            $('#id_modal_edit').modal('show');
            //alert(data.name);
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

$("#form_edit").submit(function(event){
    $('#submitEditID').addClass('kt-spinner kt-spinner--right kt-spinner--md kt-spinner--light');
    event.preventDefault(); 
    dataString = $("#form_edit").serialize();
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url(); ?>master/sec_user/editUser",
        data: dataString,
        success:function(data)
        {
            UIToastr.init(data.tipePesan, data.pesan); 
            $('#submitEditID').removeClass('kt-spinner kt-spinner--right kt-spinner--md kt-spinner--light');
            setTimeout(function() {if($('#id_modal_edit').modal('hide')){$("#form_edit")[0].reset();}}, 2000);            
            $("#id_btn_search").trigger('click');
            
        }
    });
   // return false;
});

function deleteUser(id){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url(); ?>master/sec_user/delete",
        data: { userid: id }, 
        success:function(data)
        {
            UIToastr.init(data.tipePesan, data.pesan); 
            $("#id_btn_search").trigger('click');
        }
    });
}



</script>