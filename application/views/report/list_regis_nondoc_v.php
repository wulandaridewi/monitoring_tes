
<table class="table table-separate table-head-custom table-checkable" id="idTabelListDoc" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Register Id</th>
                    <th>Register Date</th>
                    <th>Type</th>
                    <th>Document Description</th>
                    <th>Owner</th>
                    <th>Service</th>
                    <th>Status Document</th>
                    <th>Information</th>
                    <th>Last Update</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $usergroup = trim($this->session->userdata('usergroup'));
                $idUser    = trim($this->session->userdata('id_user'));
                $no        = 1;
                foreach ($getListRegis as $key => $value) {
                    $number           = $no++;
                    $register_doc_id = trim($value['register_non_doc_id']);
                    $type            = trim($value['ntype']);
                    $doc_description = trim($value['ndoc_description']);
                    $name            = trim($value['name']);
                    $update_date     = date('d-m-Y H:i:s',strtotime($value['update_date']));
                    $create_date     = date('d-m-Y H:i:s',strtotime($value['create_date']));
                    $doc_status      = trim($value['ndoc_status']);
                    $register_status = trim($value['nregister_status']);
                    $pickup_by       = trim($value['npickup_by']);
                    $recipient       = trim($value['nrecipient']);
                    $expedition      = "( ".trim($value['nexpedition'])." )";
                    $receipt_number  = "( ".trim($value['nreceipt_number'])." )";
                    $delivery_status = trim($value['ndelivery_status']);

                    $service_1       = $doc_status.'_'.$delivery_status;
                    //echo $service_1;
                    if($service_1 == 'DELIVER_INTERNAL'){
                        $service = 'Delivery Internal';
                    }elseif($service_1 == 'DELIVER_EXTERNAL'){
                        $service = 'Delivery External';
                    }elseif($service_1 == 'PICKUP_INTERNAL'){
                        $service = 'Pickup';
                    }elseif($service_1 == 'PICKUP_EXTERNAL'){
                        $service = 'Pickup';
                    }

                    if($type == 'DOC_IN' && $doc_status == 'PICKUP' && $register_status == 0){
                        $type = 'NON_DOC_IN';
                        $status_doc  = 'Progress';
                        $information = 'Waiting for Pickup by Owner';
                    }elseif($type == 'DOC_IN' && $doc_status == 'PICKUP' && $register_status == 1){
                        $type = 'NON_DOC_IN';
                        $status_doc  = 'Done';
                        $information = 'Pickup by '.$pickup_by;
                    }elseif($type == 'DOC_IN' && $doc_status == 'DELIVER' && $register_status == 0){
                        $type = 'NON_DOC_IN';
                        $status_doc  = 'Progress';
                        $information = 'Waiting to be Send by Operator';
                    }elseif($type == 'DOC_IN' && $doc_status == 'DELIVER' && $register_status == 2){
                        $type = 'NON_DOC_IN';
                        $status_doc  = 'Progress';
                        $information = 'Process Send by Operator';
                    }elseif($type == 'DOC_IN' && $doc_status == 'DELIVER' && $register_status == 1){
                        $type = 'NON_DOC_IN';
                        $status_doc  = 'Done';
                        $information = 'Received by '.$recipient;
                    }elseif($type == 'DOC_OUT' && $doc_status == 'DELIVER' && $register_status == 0){
                        $type = 'NON_DOC_OUT';
                        $status_doc  = 'Progress';
                        $information = 'Waiting to be Send by Expidition '.$expedition;
                    }elseif($type == 'DOC_OUT' && $doc_status == 'DELIVER' && $register_status == 1){
                        $type = 'NON_DOC_OUT';
                        $status_doc  = 'Done';
                        $information = 'Expedition '.$expedition.' and Receipt Number '.$receipt_number.'';
                    }

                    echo "<tr>";
                        
                ?> 
                    <td><?php echo $number; ?></td>
                    <td><?php echo $register_doc_id; ?></td>
                    <td><?php echo $create_date; ?></td>
                    <td><?php echo $type; ?></td>
                    <td><?php echo $doc_description; ?></td>
                    <td><?php echo $name; ?></td>
                    <td><?php echo $service; ?></td>
                    <td><?php echo $status_doc; ?></td>
                    <td><?php echo $information; ?></td>
                    <td><?php echo $update_date; ?></td>
                    
                <?php  
                    echo "</tr>";
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