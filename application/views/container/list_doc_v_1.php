<div class="card card-custom wave wave-animate-slow wave-primary mb-8 mb-lg-0 shadow-sm p-3 mb-5 bg-white rounded">
    <div class="card-body">
        <div class="d-flex align-items-center p-5">
<!--             <div class="mr-6">
                <i class='far fa-file-pdf' style='font-size:50px;color:#0BB783'></i>
            </div> -->
            <div class="d-flex flex-column">
                <a href="#" class="text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">Document <?php echo $document_name; ?></a>
                <div class="text-dark-75">
                    <p>
                       <?php 
                            $i = 0;
                           foreach ($getGeneralIndexName as $key => $valueGeneral) {                                               
                        ?>
                        <label><?php echo $valueGeneral['general_index_name']; ?>&nbsp;<span>&nbsp;:&nbsp;</span> <?php echo $valueGeneral['general_index']; ?></label>&nbsp;,&nbsp;
                        
                        <?php 
                            }
                        ?> 
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<table width="100%" border="0">
    <tr>
        <td>&nbsp;</td>
    </tr>   
    <tr>
        <td>&nbsp;</td>
    </tr>              
</table> 
<table class="table table-separate table-head-custom table-checkable" id="idTabelListDoc" width="100%">
            <thead>
                <tr> 
                    <th></th>    
                    <th></th>    
                    <th>Document</th>    
                    <!-- <th>Approval</th>  -->
                    <?php 
                        foreach ($getFieldNameIndexSpecific as $key => $value){
                            $col[$key]=$value['specific_index_name'];
                    ?>
                           <th><?php echo $value['specific_index_name']; ?></th>
                    <?php 
                        }                                           
                    ?>
                    <th>Document Size</th>  
                </tr>
            </thead>
            <tbody>
                <?php 
                $a = 0;

                    foreach ($getSpecificIndexNameTable as $key => $value) {
                        $document_size = $value['document_size'];
                        $trans_doc_id  = $value['trans_doc_id'];
                        $share_doc     = $value['share_doc'];
                        echo "<tr>";
                        echo "<td width='10px'></td>";
                        if($share_doc == "NULL" || empty($share_doc) || $share_doc == "" || $share_doc == "null"){
                            echo "<td width='20px'></td>";  
                        }else{                              
                            echo "<td width='20px'><a onclick=detilShareDoc('".trim($trans_doc_id)."') style='cursor: pointer;'><i class='fa fa-user-friends'></i></a></td>";
                        }    
                        echo "<td width='100px'>";
                        echo "<button class='btn btn-icon btn-primary btn-sm mr-2' title='dokumen'><i class='far fa-file-pdf' style='color:white' onclick=prepareFrame('".trim($trans_doc_id)."')></i></button>";
                        echo "<div class='dropdown dropdown-inline'>
                                    <a href='javascript:;' class='btn btn-icon btn-light-primary btn-sm mr-2' data-toggle='dropdown'>
                                        <i class='la la-cog'></i></a>
                                    <div class='dropdown-menu dropdown-menu-sm dropdown-menu-right'>
                                        <ul class='nav nav-hoverable flex-column'>
                                            <li class='nav-item'><a class='nav-link' onclick=editDocument('".trim($trans_doc_id)."') style='cursor: pointer;'><i class='nav-icon la la-edit'></i>
                                            <span class='nav-text'>Edit Indexing</span></a></li>
                                            <li class='nav-item'><a class='nav-link' onclick=deleteDocument('".trim($trans_doc_id)."') style='cursor: pointer;'><i class='nav-icon la la-trash'></i>
                                            <span class='nav-text'>Delete File</span></a></li>
                                            <li class='nav-item'><a class='nav-link' onclick=shareDoc('".trim($trans_doc_id)."') style='cursor: pointer;'><i class='fa fa-share-alt'></i>
                                            <span class='nav-text'>&nbsp;Share Document</span></a></li>
                                            <li class='nav-item'><a class='nav-link' onclick=setApproval('".trim($trans_doc_id)."') style='cursor: pointer;'><i class='fa fa-user-edit'></i>
                                            <span class='nav-text'>&nbsp;Set Approval</span></a></li>
                                        </ul>
                                    </div>
                                </div>";
                        echo "</td>";
                        
                        // $getStatusApprove = $this->my_container_m->getStatusApprove($trans_doc_id);
                        // $totalUserApproval = count($getStatusApprove);
                        // $hitung = 0;
                        // $total_waiting = 0;
                        // $total_approved = 0;
                        // $total_reject = 0;
                        // $cetakStatusApproval = "-";
                        // if(empty($getStatusApprove)){
                        //     echo "<td> - </td>";
                        // }else{
                        //     foreach ($getStatusApprove as $key => $valueSetApproval) {
                        //         $statusapprove = trim($valueSetApproval['status_approve']);
                        //         $hitung++;
                                
                        //         if($statusapprove == 'waiting'){
                        //             $total_waiting++;
                        //         }elseif($statusapprove == 'reject'){
                        //             $total_reject++;
                        //         }elseif($statusapprove == 'approved'){
                        //             $total_approved++;
                        //         } 
                        //     }

                        //     if($total_waiting == $totalUserApproval || $total_waiting !== 0){
                        //             $cetakStatusApproval = "<a class='label label-lg label-light-warning label-inline' onclick=detailApproval('".trim($trans_doc_id)."') style='cursor: pointer;'>Waiting</a>";
                        //     }elseif ($total_reject == $totalUserApproval || ($total_reject !==0 && $total_waiting == 0)) {
                        //         $cetakStatusApproval = "<a class='label label-lg label-light-danger label-inline' onclick=detailApproval('".trim($trans_doc_id)."') style='cursor: pointer;'>Rejected</a>";
                        //     }elseif ($total_approved == $totalUserApproval || ($total_waiting == 0 && $total_reject == 0)) {
                        //         $cetakStatusApproval = "<a class='label label-lg label-light-primary label-inline' onclick=detailApproval('".trim($trans_doc_id)."') style='cursor: pointer;'>Approved</a>";
                        //     } 
                        //     echo "<td>".$cetakStatusApproval."</td>";
                        // }
                        
                         for ($i=0; $i < count($col); $i++) { 
                            if($specificIndexFormat[$i] == 4){
                                if($value[$col[$i]] == "" || $value[$col[$i]]=="NULL" || empty($value[$col[$i]])){
                                    $valueSpecific = "0.00";
                                }else{
                                   $valueSpecific = number_format($value[$col[$i]], 2); 
                                }
                                
                            }else{
                                $valueSpecific = $value[$col[$i]];
                            }
                        ?>          
                             <td><?php echo $valueSpecific; ?></td> 
                            <!-- <td><?php echo $value[$col[$i]]; ?></td> -->
                        <?php  }  
                        echo "<td>".$document_size." Kb</td>";                   
                        echo "</tr>";
                        $a++;
                    } ?>
            </tbody>
            <tfoot></tfoot>
        </table>
<!-- Modal detilShareDoc -->
<div class="modal fade" id="kt_modal_detailShareDoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="kt-font-brand kt-font-bold"><i class="fa fa-share-alt"></i>&nbsp;&nbsp;Share Document</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form class="kt-form" id="form_detailShareDoc" method="post" action="javascript:;">
                    <div class="kt-portlet__body table-responsive">   
                        <table class="table table-head-custom table-head-bg table-borderless table-vertical-center" id="tableDetailShareDoc">
                            <thead>
                                <tr class="text-left text-uppercase">
                                    <!-- <th style="min-width: 250px" class="pl-7">
                                        <span>User</span>
                                    </th>
                                    <th style="min-width: 100px">Department</th> -->
                                    <th style="min-width: 200px" class="pl-7">
                                        <span>User</span>
                                    </th>
                                    <th style="min-width: 200px">Date</th>
                                    <th style="min-width: 200px">Shared By</th>
                                </tr>
                            </thead>
                            <tbody>
                                                               
                            </tbody>
                        </table>                    

                    </div>            
                    
                </form>
            </div>
            <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
         </div>
    </div>
</div>
<!--begin:: Modal detilShareDoc-->
<!-- Modal detailApprovall -->
<div class="modal fade" id="kt_modal_detailApproval" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="kt-font-brand kt-font-bold"><i class="fa fa-user-edit"></i>&nbsp;&nbsp;Detail User Approval Document</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form class="kt-form" id="form_detailApproval" method="post" action="javascript:;">
                    <div class="kt-portlet__body table-responsive">   
                        <table class="table table-head-custom table-head-bg table-borderless table-vertical-center" id="tableDetailApproval">
                            <thead>
                                <tr class="text-left text-uppercase">
                                    <th style="min-width: 250px" class="pl-7">
                                        <span>User</span>
                                    </th>
                                    <th style="min-width: 100px">Approval</th>
                                    <th style="min-width: 200px">Note</th>
                                    <th style="min-width: 100px">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                                               
                            </tbody>
                        </table>                    

                    </div>          
                </form>
            </div>
            <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
         </div>
    </div>
</div>
<!--begin:: Modal detailApproval-->
<script type="text/javascript">
jQuery(document).ready(function () {
    initTable4();

}); 

function initTable4() {
    // begin first table
    var table = $('#idTabelListDoc').DataTable({
        responsive: true,
        searching: true,
        "initComplete": function(settings, json) {
            $("#pageloader").fadeOut();
           // alert( 'DataTables has finished its initialisation.' );
          }
    });
    $('#id_Reload4').click(function () {
        table.ajax.reload();
    });
}; 

function detailApproval(trans_doc_id){    
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>collection/my_collection/getUserApproval?trans_doc_id="+trans_doc_id,
        //url: "getUserApproval?trans_doc_id="+trans_doc_id,
        dataType:"JSON",
        success: function(result){  
        $('table#tableDetailApproval tbody tr').remove();                
            var x=0;
            $.each(result, function(key, val) {
            x++; 
                var userimage = val.name_file_image.trim();
                var nameUser  = val.name.trim();
                var deptUser  = val.department.trim();
                var status_approve = val.status_approve.trim();
                if(status_approve == 'reject'){
                    var cetakStatusApproval = "<a class='label label-lg label-light-danger label-inline'>Rejected</a>";
                }else if(status_approve == 'waiting'){
                    var cetakStatusApproval = "<a class='label label-lg label-light-warning label-inline'>Waiting</a>";
                }else if(status_approve == 'approved'){
                    var cetakStatusApproval = "<a class='label label-lg label-light-primary label-inline'>Approved</a>";
                }
                var noted     = val.note;
                var lastDate = val.update_date.trim();
                //alert(note);
                $('#tableDetailApproval tbody').append('<tr id="row'+x+'"><td class="pl-0 py-8"><div class="d-flex align-items-center"> <div class="symbol symbol-50 symbol-light mr-4"><span class="symbol-label"><img src="<?php echo base_url(); ?>assets/media/svg/avatars/'+userimage+'" class="h-75 align-self-end" alt=""></span></div><div><a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">'+nameUser+'</a><span class="text-muted font-weight-bold d-block">'+deptUser+'</span></div></div></td><td><span class="text-dark-60 font-weight-bolder d-block font-size-lg">'+cetakStatusApproval+'</span></td><td><span class="text-dark-60 font-weight-bolder d-block font-size-lg">'+noted+'</span></td><td><span class="text-dark-60 font-weight-bolder d-block font-size-lg">'+lastDate+'</span></td></tr>');
            });

            $('#kt_modal_detailApproval').modal('show');
        }
    });          
}   
function detilShareDoc(trans_doc_id){    
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>container/my_container/getUserShare?trans_doc_id="+trans_doc_id,
        //url: "getUserApproval?trans_doc_id="+trans_doc_id,
        dataType:"JSON",
        success: function(result){  
        $('table#tableDetailShareDoc tbody tr').remove();                
            var x=0;
            $.each(result, function(key, val) {
            x++; 
                var userimage = val.name_file_image.trim();
                var nameUser  = val.user_share.trim();
                var deptUser  = val.department.trim();
                var lastDate = val.share_date.trim();
                var shared_by = val.shared_by.trim();
                //alert(note);
                $('#tableDetailShareDoc tbody').append('<tr id="row'+x+'"><td class="pl-0 py-8"><div class="d-flex align-items-center"> <div class="symbol symbol-50 symbol-light mr-4"><span class="symbol-label"><img src="<?php echo base_url(); ?>assets/media/svg/avatars/'+userimage+'" class="h-75 align-self-end" alt=""></span></div><div><a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">'+nameUser+'</a><span class="text-muted font-weight-bold d-block">'+deptUser+'</span></div></div></td><td><span class="text-dark-60 font-weight-bolder d-block font-size-lg">'+lastDate+'</span></td><td><span class="text-dark-60 font-weight-bolder d-block font-size-lg">'+shared_by+'</span></td></tr>');
                // $('#tableDetailShareDoc tbody').append('<tr id="row'+x+'"><td class="pl-0 py-8"><div class="d-flex align-items-center"> <div class="symbol symbol-50 symbol-light mr-4"><span class="symbol-label"><img src="<?php echo base_url(); ?>assets/media/svg/avatars/'+userimage+'" class="h-75 align-self-end" alt=""></span></div><div><a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">'+nameUser+'</a></div></div></td><td><span class="text-dark-60 font-weight-bolder d-block font-size-lg">'+deptUser+'</span></td></tr>');
            });

            $('#kt_modal_detailShareDoc').modal('show');
        }
    });          
} 
  
</script>

        <!-- "base_url().''.$directory.'+'.$subFolder" -->