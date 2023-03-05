<?php 
	foreach ($getKetDoc as $key => $value) {
		$register_doc_id   = trim($value['register_non_doc_id']);
        $type 			   = trim($value['ntype']);
        $doc_description   = trim($value['ndoc_description']);
        $name 			   = trim($value['name']);
        $doc_status        = trim($value['ndoc_status']);
        $pickup_by 		   = trim($value['npickup_by']);
        $delivery_status   = trim($value['ndelivery_status']);
        $delivery_location = trim($value['ndelivery_location']);
        $recipient 		   = trim($value['nrecipient']);
        $expedition 	   = trim($value['nexpedition']);
        $receipt_number    = trim($value['nreceipt_number']);
        $status_email      = $value['nstatus_email'];
        $register_status   = $value['nregister_status'];
        $email 			   = $value['email'];
        $create_date	   = date('d-m-Y H:i:s',strtotime($value['create_date']));
        $update_date	   = date('d-m-Y H:i:s',strtotime($value['update_date']));
        //echo $type.'_'.$doc_status.'-'.$register_status;
        if($type == 'DOC_IN' && $doc_status == 'PICKUP' && $register_status == 0 && $pickup_by=='-'){
        	echo "<table class='table table-separate table-head-custom table-checkable dataTable no-footer' id='idTabelListDoc' width='100%'>
        		<thead>
        			<tr>        				
		        		<th>No. Register</th>
		        		<th>Register Date</th>
		        		<th>Document Description</th>
		        		<th>Owner</th>
		        		<th>Service</th>
		        		<th>Status Document</th>
		        		<th>Next Step</th>
		        		<th>Pickup By</th>
		        		<th>Last Update</th>
        			</tr>
        		</thead>
        		<tbody>
        			<tr>
        				<td>".$register_doc_id."</td>
        				<td>".$create_date."</td>
        				<td>".$doc_description."</td>
        				<td>".$name."</td>
        				<td>".$doc_status."</td>
        				<td>Waiting for Pickup by Owner</td>
        				<td>Done</td>
        				<td>".$pickup_by."</td>
        				<td>".$update_date."</td>
        			</tr>
        		</tbody>
        	</table>";
        }

        if($type == 'DOC_IN' && $doc_status == 'PICKUP' && $register_status == 1){
        	echo "<table class='table table-separate table-head-custom table-checkable dataTable no-footer' id='idTabelListDoc' width='100%'>
        		<thead>
        			<tr>        				
		        		<th>No. Register</th>
		        		<th>Register Date</th>
		        		<th>Document Description</th>
		        		<th>Owner</th>
		        		<th>Service</th>
		        		<th>Status Document</th>
		        		<th>Next Step</th>
		        		<th>Pickup By</th>
		        		<th>Last Update</th>
        			</tr>
        		</thead>
        		<tbody>
        			<tr>
        				<td>".$register_doc_id."</td>
        				<td>".$create_date."</td>
        				<td>".$doc_description."</td>
        				<td>".$name."</td>
        				<td>".$doc_status."</td>
        				<td>Done</td>
        				<td>Done</td>
        				<td>".$pickup_by."</td>
        				<td>".$update_date."</td>
        			</tr>
        		</tbody>
        	</table>";
        }

        if($type == 'DOC_IN' && $doc_status == 'DELIVER' && $register_status == 0){
        	echo "<table class='table table-separate table-head-custom table-checkable dataTable no-footer' id='idTabelListDoc' width='100%'>
        		<thead>
        			<tr>        				
		        		<th>No. Register</th>
		        		<th>Register Date</th>
		        		<th>Document Description</th>
		        		<th>Owner</th>
		        		<th>Service</th>
		        		<th>Status Document</th>
		        		<th>Next Step</th>
		        		<th>Recipient</th>
		        		<th>Last Update</th>
        			</tr>
        		</thead>
        		<tbody>
        			<tr>
        				<td>".$register_doc_id."</td>
        				<td>".$create_date."</td>
        				<td>".$doc_description."</td>
        				<td>".$name."</td>
        				<td>".$doc_status."</td>
        				<td>Waiting to be send</td>
        				<td>Done</td>
        				<td>".$recipient."</td>
        				<td>".$update_date."</td>
        			</tr>
        		</tbody>
        	</table>";
        }

        if($type == 'DOC_IN' && $doc_status == 'DELIVER' && $register_status == 1){
        	echo "<table class='table table-separate table-head-custom table-checkable dataTable no-footer' id='idTabelListDoc' width='100%'>
        		<thead>
        			<tr>        				
		        		<th>No. Register</th>
		        		<th>Register Date</th>
		        		<th>Document Description</th>
		        		<th>Owner</th>
		        		<th>Service</th>
		        		<th>Status Document</th>
		        		<th>Next Step</th>
		        		<th>Recipient</th>
		        		<th>Last Update</th>
        			</tr>
        		</thead>
        		<tbody>
        			<tr>
        				<td>".$register_doc_id."</td>
        				<td>".$create_date."</td>
        				<td>".$doc_description."</td>
        				<td>".$name."</td>
        				<td>".$doc_status."</td>
        				<td>Done</td>
        				<td>Done</td>
        				<td>".$recipient."</td>
        				<td>".$update_date."</td>
        			</tr>
        		</tbody>
        	</table>";
        }

        if($type == 'DOC_OUT' && $doc_status == 'DELIVER' && $register_status == 0){
        	echo "<table class='table table-separate table-head-custom table-checkable dataTable no-footer' id='idTabelListDoc' width='100%'>
        		<thead>
        			<tr>        				
		        		<th>No. Register</th>
		        		<th>Register Date</th>
		        		<th>Document Description</th>
		        		<th>Owner</th>
		        		<th>Service</th>
		        		<th>Location</th>		        		
		        		<th>Recipient</th>		        		
		        		<th>Expedition</th>
		        		<th>Recipient Number</th>
		        		<th>Status Document</th>
		        		<th>Next Step</th>
		        		<th>Last Update</th>
        			</tr>
        		</thead>
        		<tbody>
        			<tr>
        				<td>".$register_doc_id."</td>
        				<td>".$create_date."</td>
        				<td>".$doc_description."</td>
        				<td>".$name."</td>
        				<td>Delivery External</td>  
        				<td>".$delivery_location."</td>      				
        				<td>".$recipient."</td>     
        				<td>".$expedition."</td>   
		        		<td>".$receipt_number."</td>    				
        				<td>Waiting to be send</td>
        				<td>Done</td>
        				<td>".$update_date."</td>
        			</tr>
        		</tbody>
        	</table>";
        }

        if($type == 'DOC_OUT' && $doc_status == 'DELIVER' && $register_status == 1){
        	echo "<table class='table table-separate table-head-custom table-checkable dataTable no-footer' id='idTabelListDoc' width='100%'>
        		<thead>
        			<tr>        				
		        		<th>No. Register</th>
		        		<th>Register Date</th>
		        		<th>Document Description</th>
		        		<th>Owner</th>
		        		<th>Service</th>
		        		<th>Location</th>		        		
		        		<th>Recipient</th>		        		
		        		<th>Expedition</th>
		        		<th>Recipient Number</th>
		        		<th>Status Document</th>
		        		<th>Next Step</th>
		        		<th>Last Update</th>
        			</tr>
        		</thead>
        		<tbody>
        			<tr>
        				<td>".$register_doc_id."</td>
        				<td>".$create_date."</td>
        				<td>".$doc_description."</td>
        				<td>".$name."</td>
        				<td>Delivery External</td>  
        				<td>".$delivery_location."</td>      				
        				<td>".$recipient."</td>     
        				<td>".$expedition."</td>   
		        		<td>".$receipt_number."</td>    				
        				<td>Done</td>
        				<td>Done</td>
        				<td>".$update_date."</td>
        			</tr>
        		</tbody>
        	</table>";
        }
    }
?>
<script type="text/javascript">
$('#idTabelListDoc').DataTable({
    responsive: true,
    scrollX: '68vh',
    searching: false,
    paging:   false,
    ordering: false,
    info:     false,

});    
</script>