
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
                // echo "<pre>";
                // print_r($getListRegis);die();
                // echo "</pre>";
                foreach ($getListRegis as $key => $value) {
                    $number           = $no++;
                    $register_doc_id = trim($value['register_doc_id']);
                    $type            = trim($value['type']);
                    $doc_description = trim($value['doc_description']);
                    $name            = trim($value['name']);
                    $information     = trim($value['information']);
                    $update_date     = date('d-m-Y H:i:s',strtotime($value['update_date']));
                    $create_date     = date('d-m-Y H:i:s',strtotime($value['create_date']));
                    $doc_status      = trim($value['doc_status']);
                    $register_status = trim($value['register_status']);
                    $status_indexing = trim($value['status_indexing']);
                    $pickup_by       = trim($value['pickup_by']);
                    $recipient       = trim($value['recipient']);
                    $expedition      = trim($value['expedition']);
                    $receipt_number  = trim($value['receipt_number']);
                    $delivery_status = trim($value['delivery_status']);

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
                    //echo $type.'-'.$doc_status.'-'.$register_status.'-'.$status_indexing.'-'.$pickup_by;
                    if($type == 'DOC_IN' && $doc_status == 'PICKUP' && $register_status == 0 && $status_indexing == 0){
                        $status_doc  = 'Progress';
                        $information = 'Waiting for Indexing by Operator';
                    }elseif($type == 'DOC_IN' && $doc_status == 'PICKUP' && $register_status == 0 && ($status_indexing == 1 || $status_indexing == 2) && $pickup_by=='-'){
                        $status_doc  = 'Progress';
                        $information = 'Waiting for Pickup by Owner';
                    }elseif($type == 'DOC_IN' && $doc_status == 'PICKUP' && $register_status == 1 && ($status_indexing == 1 || $status_indexing == 2)){
                        $status_doc  = 'Done';
                        $information = 'Pickup by '.$pickup_by;
                    }elseif($type == 'DOC_IN' && $doc_status == 'DELIVER' && $register_status == 0 && $status_indexing == 0){
                        $status_doc  = 'Progress';
                        $information = 'Waiting for Indexing by Operator';
                    }elseif($type == 'DOC_IN' && $doc_status == 'DELIVER' && $register_status == 0 && ($status_indexing == 1 || $status_indexing == 2)){
                        $status_doc  = 'Progress';
                        $information = 'Waiting to be Send by Operator';
                    }elseif($type == 'DOC_IN' && $doc_status == 'DELIVER' && $register_status == 2 && ($status_indexing == 1 || $status_indexing == 2)){
                        $status_doc  = 'Progress';
                        $information = 'Process Send by Operator';
                    }elseif($type == 'DOC_IN' && $doc_status == 'DELIVER' && $register_status == 1 && ($status_indexing == 1 || $status_indexing == 2)){
                        $status_doc  = 'Done';
                        $information = 'Received by '.$recipient;
                    }elseif($type == 'DOC_OUT' && $doc_status == 'DELIVER' && $register_status == 0 && $status_indexing == 0){
                        $status_doc  = 'Progress';
                        $information = 'Waiting for Indexing by Operator';
                    }elseif($type == 'DOC_OUT' && $doc_status == 'DELIVER' && $register_status == 0 && ($status_indexing == 1 || $status_indexing == 2)){
                        $status_doc  = 'Progress';
                        $information = 'Waiting to be Send by Expidition ('.$expedition.')';
                    }elseif($type == 'DOC_OUT' && $doc_status == 'DELIVER' && $register_status == 1 && ($status_indexing == 1 || $status_indexing == 2)){
                        $status_doc  = 'Done';
                        $information = 'Expedition ('.$expedition.') and Receipt Number ('.$receipt_number.')';
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