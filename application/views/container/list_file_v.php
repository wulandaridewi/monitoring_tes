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
                        $getGeneralIndexNameTable = $this->my_container_m->getGeneralIndexNameTable($folder_id,$colGeneral,$document_id,$trans_doc_id,$usergroup,$idUser);
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
                ?>          
                            <td><?php echo $value[$col[$i]]; ?></td>
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
</script>

        <!-- "base_url().''.$directory.'+'.$subFolder" -->