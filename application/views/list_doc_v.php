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
                    <th>Document</th>    
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
                $a = 0;

                    foreach ($getSpecificIndexNameTable as $key => $value) {
                        $directory=$value['directory'];
                        $document_size=$value['document_size'];
                        $subFolder=$value['subFolder'];
                        $trans_doc_id=$value['trans_doc_id'];
                        $document_id=$value['document_id'];
                        $folder_id=$value['folder_id'];
                        echo "<tr>";
                        echo "<td>";
                        echo "<button class='btn btn-icon btn-primary btn-sm mr-2' title='dokumen'><i class='far fa-file-pdf' style='color:white' onclick=prepareFrame('".base_url().trim($directory).'+'.trim($subFolder).'+'.$document_id.'+'.trim($trans_doc_id).'+'.trim($folder_id).'+'.trim($document_name)."')></i></button>";
                        echo "<div class='dropdown dropdown-inline'>
                                    <a href='javascript:;' class='btn btn-icon btn-light-primary btn-sm mr-2' data-toggle='dropdown'>
                                        <i class='la la-cog'></i></a>
                                    <div class='dropdown-menu dropdown-menu-sm dropdown-menu-right'>
                                        <ul class='nav nav-hoverable flex-column'>
                                            <li class='nav-item'><a class='nav-link' onclick=editDocument('".trim($folder_id).'+'.trim($subFolder).'+'.trim($trans_doc_id).'+'.trim($document_name)."')><i class='nav-icon la la-edit'></i>
                                            <span class='nav-text'>Edit Indexing</span></a></li>
                                            <li class='nav-item'><a class='nav-link' onclick=deleteDocument('".trim($trans_doc_id).'+'.trim($subFolder).'+'.$document_id.'+'.trim($document_name)."')><i class='nav-icon la la-trash'></i>
                                            <span class='nav-text'>Delete File</span></a></li>
                                        </ul>
                                    </div>
                                </div>";
                        echo "</td>";
                        // echo "<td><button class='btn btn-icon btn-primary btn-sm mr-2' title='dokumen'><i class='far fa-file-pdf' style='color:white' onclick=prepareFrame('".base_url().trim($directory).'+'.trim($subFolder).'+'.$document_id.'+'.trim($trans_doc_id).'+'.trim($folder_id).'+'.trim($document_name)."')></i></button><button class='btn btn-icon btn-primary btn-sm mr-2' title='delete'><i class='flaticon2-trash' style='color:white' onclick=deleteDocument('".trim($trans_doc_id).'+'.trim($subFolder).'+'.$document_id.'+'.trim($document_name)."')></i></button></td>";
                        
                         for ($i=0; $i < count($col); $i++) { 
                            if($specificIndexFormat[$i] == 4){
                                $valueSpecific = number_format($value[$col[$i]], 2);
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