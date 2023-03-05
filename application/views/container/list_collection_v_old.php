<div class="col-xl-6">
    <!--begin::Stats Widget 14-->
    <div class="card card-custom bg-primary bg-hover-state-primary card-stretch gutter-b">
        <!--begin::Body-->
        <div class="card-header border-0">
            <div class="card-title">
                <h3 class="card-label text-white"><?php echo $document_name; ?></h3>
            </div>
           <!--  <div class="card-toolbar">
                <a href="#" class="btn btn-sm btn-white">
                <i class="flaticon2-cube"></i>Settings</a>
            </div> -->
        </div>
        <div class="separator separator-solid separator-white opacity-20"></div>
        <div class="card-body">
            
            <div class="text-inverse-primary font-weight-bolder font-size-h5 mb-2 mt-5">
                <table width="100%" border="0">
                <tr>
                    <td width="80%">
                        <?php 
                            $i = 0;
                           foreach ($getGeneralIndexName as $key => $value) {
                                $col[$key] = $value['general_index_name'];
                                                    
                        ?>
                        <table width="100%">
                            <tr>
                                <td width="30%"> <?php echo $value['general_index_name']; ?></td>
                                <td width="5%"> : </td>
                                <td> <?php echo $value['general_index']; ?></td>
                            </tr>
                        </table>
                        <?php 
                            }
                        ?>
                         <?php 
                            $i = 0;
                           foreach ($getSpecificIndexName as $key => $value) {
                                $col[$key] = $value['specific_index_name'];
                                                    
                        ?>
                        <table width="100%">
                            <tr>
                                <td width="30%"> <?php echo $value['specific_index_name']; ?></td>
                                <td width="5%"> : </td>
                                <td> <?php echo $value['specific_index']; ?></td>
                            </tr>
                        </table>
                        <?php 
                            }
                        ?>
                    </td>
                    <td width="50%">
                        <?php 
                           foreach ($getFileName as $key => $value) {
                                                    
                        ?>
                            <center>
                                <button class="btn btn-primary font-weight-bolder" title="dokumen"><i class="far fa-file-pdf" style="font-size:50px;color:white" onclick=prepareFrame("<?php echo base_url().''.$value['directory']; ?>+<?php echo $value['sub_folder']; ?>")></i></button>
                            </center>
                        <?php 
                            }
                        ?>
                        
                    </td>
                </tr>                
            </table>   
            </div>
            <!-- <div class="font-weight-bold text-inverse-primary font-size-sm">Flats, Shared Rooms, Duplex</div> -->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Stats Widget 14-->
</div>