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
<!--start::Card 1-->
<div id="mainContainerId" style="display:none;">
    
</div>  
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

<script type="text/javascript">
    jQuery(document).ready(function() {
        $.fn.dataTable.ext.errMode = 'none';
        let searchParams = new URLSearchParams(window.location.search)

        var getValueApprove = searchParams.get('value');
        var getDetailApprove = searchParams.get('detail');
        //console.log(getValueApprove);
        if (getDetailApprove == 1) {
            prepareFrameApprove(getValueApprove.replaceAll(' ','+'));
        }
        initTable1();        
        $('#fileNameAddID').val('0');
        $('#categoryDocID').select2({
            width: '100%',
            placeholder: "Select Category"
        });
    });

    var initTable1 = function() {

        // begin first table
        var table = $('#idTabel1').DataTable({
            responsive: true,

            ajax: "<?php echo base_url("/container/my_container/getCollection"); ?>",
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
                         return '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Open" onclick=view("'+row.folder_id+'")>'+
                               '<i class="fa far fa-folder-open"></i></a>'+
                               '<a class="btn btn-icon btn-light-primary btn-sm mr-2" title="Delete" onclick=DeleteFolder("'+row.folder_id+'")>'+
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
        $('#id_Reload').click(function () {
            table.ajax.reload();
        });
    };

    function view(folder_id){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>container/my_container/getSubFolder",
            data: { folder_id: folder_id }, 
            success: function(result)
            {   
            	$('#mainContainerId').fadeIn('slow');
                $('#mainContainerId').html(result.folder_id);
                // $('#folderIDid').val(result.folder_id); 
                // $('#folderIDid2').val(result.folder_id);
                // $('#folderNameID').val(result.folder_name); 
                // $('#folderNameID2').val(result.folder_name);
                // var userAllowed = result.group_user_doc_id;
                // //alert(userAllowed);
                // if(userAllowed == "-"){
                //     document.getElementById( 'idBtnAddContainer' ).style.display = 'none';
                // }else{
                //     document.getElementById( 'idBtnAddContainer' ).style.display = 'block';
                // }
                // document.getElementById('idLabel2').textContent = result.folder_name;

                // document.getElementById( 'idCard2' ).style.display = 'block';
                // document.getElementById( 'idCard1' ).style.display = 'none';
                // document.getElementById( 'idCard3' ).style.display = 'none';
                // document.getElementById( 'idCard4' ).style.display = 'none';
                // document.getElementById( 'idCard5' ).style.display   = 'none'; 
                // initTable2(folder_id);
                
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
 </script>