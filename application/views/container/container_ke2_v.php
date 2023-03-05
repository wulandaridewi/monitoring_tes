<!--begin::Card 1-->
<style type="text/css">

/*#idBodyModalAdd {
    height: 80vh;
    overflow-y: auto;
}*/
/*#idBodyModalAdd {
    min-width: 400vh;
}*/
</style>
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
            <a href="#" id="idBtnAddContainer" class="btn btn-primary font-weight-bolder mr-2" data-toggle="modal" data-target="#kt_modal_Add_2" onclick="openIndex()">
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

<script type="text/javascript">
	
	function initTable2 (folder_id) {

        // begin first table
        var table = $('#idTabel2').DataTable({
            responsive: true,

            ajax: {
                url: '<?php echo base_url("/container/my_container_/getCollectionSub"); ?>',
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
                        // return '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Open">'+
                        //        '<i class="fa far fa-folder-open" onclick=openSubFolder("'+row.sub_folder+'+'+row.folder_id+'")></i></a>'+
                        //        '<div class="dropdown dropdown-inline">'+
                        //             '<a href="javascript:;" class="btn btn-icon btn-light-primary btn-sm mr-2" data-toggle="dropdown">'+
                        //                 '<i class="la la-cog"></i></a>'+
                        //             '<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">'+
                        //                 '<ul class="nav nav-hoverable flex-column">'+
                        //                     '<li class="nav-item"><a class="nav-link" onclick=EditSubFolder("'+row.sub_folder+'+'+row.folder_id+'")><i class="nav-icon la la-edit"></i>'+
                        //                     '<span class="nav-text">Edit Container</span></a></li>'+
                        //                     '<li class="nav-item"><a class="nav-link" onclick=DeleteSubFolder("'+row.sub_folder+'")><i class="nav-icon la la-trash"></i>'+
                        //                     '<span class="nav-text">Delete Container</span></a></li>'+
                        //                 '</ul>'+
                        //             '</div>'+
                        //         '</div>';

                        return '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Open" onclick=openSubFolder("'+row.sub_folder+'+'+row.folder_id+'")>'+
                               '<i class="fa far fa-folder-open"></i></a>'+
                               '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Delete" onclick=DeleteSubFolder("'+row.sub_folder+'")>'+
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
        $('#id_Reload2').click(function () {
            table.ajax.reload();
        });
    };
</script>