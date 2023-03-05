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
                    <th>Document</th> 
                    <th>Approval</th> 
          <!--           <th>Sub Folder</th>  
                    <th>Document Name</th>  -->
                    <?php 
                        foreach ($getFieldNameIndexGeneral as $key => $value2) {
                            $colGeneral[$key]=$value2['general_index_name'];
                    ?>
                           <th><?php echo $value2['general_index_name']; ?></th>
                    <?php 
                        }                                           
                    ?>     
                    <?php 
                        foreach ($getFieldNameIndexSpecific as $key => $value) {
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
                $usergroup = trim($this->session->userdata('usergroup'));
                $idUser    = trim($this->session->userdata('id_user'));
                $a = 0;

                    foreach ($getSpecificIndexNameTable as $key => $value) {
                        $directory=$value['directory'];
                        $document_size=$value['document_size'];
                        $trans_doc_id=$value['trans_doc_id'];
                        $document_id=$value['document_id'];
                        $folder_id=$value['folder_id'];
                        $subFolder=$value['subFolder'];
                        $document_name=$value['document_name'];
                        echo "<tr>";
                        echo "<td>";
                        echo "&nbsp;&nbsp;&nbsp;<button class='btn btn-icon btn-primary btn-sm mr-2' title='dokumen'><i class='far fa-file-pdf' style='color:white' onclick=prepareFrame('".base_url().trim($directory).'+'.trim($subFolder).'+'.$document_id.'+'.trim($trans_doc_id).'+'.trim($folder_id).'+'.trim($document_name)."')></i></button>";
                        $getGeneralIndexNameTable = $this->search_file_m->getGeneralIndexNameTable($folder_id,$colGeneral,$document_id,$trans_doc_id,$usergroup,$idUser);
                        echo "</td>";
                        $getStatusApprove = $this->search_file_m->getStatusApprove($trans_doc_id);
                        $totalUserApproval = count($getStatusApprove);
                        $hitung = 0;
                        $total_waiting = 0;
                        $total_approved = 0;
                        $total_reject = 0;
                        $cetakStatusApproval = "-";
                        if(empty($getStatusApprove)){
                            echo "<td> - </td>";
                        }else{
                            foreach ($getStatusApprove as $key => $valueSetApproval) {
                                $statusapprove = trim($valueSetApproval['status_approve']);
                                $hitung++;
                                
                                if($statusapprove == 'waiting'){
                                    $total_waiting++;
                                }elseif($statusapprove == 'reject'){
                                    $total_reject++;
                                }elseif($statusapprove == 'approved'){
                                    $total_approved++;
                                }  
                            }
                            if($total_waiting == $totalUserApproval || $total_waiting !== 0){
                                    $cetakStatusApproval = "<a class='label label-lg label-light-warning label-inline' onclick=detailApproval('".trim($trans_doc_id)."') style='cursor: pointer;'>Waiting</a>";
                            }elseif ($total_reject == $totalUserApproval || ($total_reject !==0 && $total_waiting == 0)) {
                                $cetakStatusApproval = "<a class='label label-lg label-light-danger label-inline' onclick=detailApproval('".trim($trans_doc_id)."') style='cursor: pointer;'>Rejected</a>";
                            }elseif ($total_approved == $totalUserApproval || ($total_waiting == 0 && $total_reject == 0)) {
                                $cetakStatusApproval = "<a class='label label-lg label-light-primary label-inline' onclick=detailApproval('".trim($trans_doc_id)."') style='cursor: pointer;'>Approved</a>";
                            } 
                            echo "<td>".$cetakStatusApproval."</td>";
                        }
                        foreach($getGeneralIndexNameTable as $row => $value2){
                          // $sub_folder=$value2['sub_folder'];
                          //   $document_name=$value2['document_name'];
                          //   echo "<td>".$sub_folder."</td>";  
                          //   echo "<td>".$document_name."</td>";
                        for ($k=0; $k < count($colGeneral); $k++) { 
                        
                ?>
                        <td><?php echo $value2[$colGeneral[$k]]; ?></td>
                <?php
                        }}
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
                <?php  
                        }  
                        echo "<td>".$document_size." Kb</td>";                   
                        echo "</tr>";
                        $a++;
                    } 
                ?>
            </tbody>
            <tfoot></tfoot>
        </table>
<!-- Modal detailApprovall -->
<div class="modal fade" id="kt_modal_detailApproval" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
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
    });
    $('#id_Reload4').click(function () {
        table.ajax.reload();
    });
};  

function detailApproval(trans_doc_id){    
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>search/search_file/getUserApproval?trans_doc_id="+trans_doc_id,
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
</script>

        <!-- "base_url().''.$directory.'+'.$subFolder" -->