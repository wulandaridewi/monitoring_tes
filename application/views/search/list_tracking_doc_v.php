<?php 
	foreach ($getKetDoc as $key => $value) {
		$register_doc_id   = trim($value['register_doc_id']);
        $type 			   = trim($value['type']);
        $doc_description   = trim($value['doc_description']);
        $name 			   = trim($value['name']);
        $doc_status        = trim($value['doc_status']);
        $pickup_by 		   = trim($value['pickup_by']);
        $delivery_status   = trim($value['delivery_status']);
        $delivery_location = trim($value['delivery_location']);
        $recipient 		   = trim($value['recipient']);
        $expedition 	   = trim($value['expedition']);
        $receipt_number    = trim($value['receipt_number']);
        $status_email      = $value['status_email'];
        $register_status   = $value['register_status'];
        $status_indexing   = $value['status_indexing'];
        $email 			   = $value['email'];
        $create_date	   = date('d-m-Y H:i:s',strtotime($value['create_date']));
        $update_date	   = date('d-m-Y H:i:s',strtotime($value['update_date']));
        $information       = trim($value['information']);

        if($type == 'DOC_IN' && $doc_status == 'PICKUP' && $register_status == 0 && $status_indexing == 0){
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
        				<td>Waiting for indexing</td>
        				<td>indexing Process</td>
        				<td>".$pickup_by."</td>
        				<td>".$update_date."</td>
        			</tr>
        		</tbody>
        	</table>";
        }

        if($type == 'DOC_IN' && $doc_status == 'PICKUP' && $register_status == 0 && ($status_indexing == 1 || $status_indexing == 2) && $pickup_by=='-'){
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

        if($type == 'DOC_IN' && $doc_status == 'PICKUP' && $register_status == 1 && ($status_indexing == 1 || $status_indexing == 2)){
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

        if($type == 'DOC_IN' && $doc_status == 'DELIVER' && $register_status == 0 && $status_indexing == 0){
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
                        <th>Information</th>
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
        				<td>Waiting for indexing</td>
        				<td>indexing Process</td>
        				<td>".$recipient."</td>
                        <td>".$information."</td>
        				<td>".$update_date."</td>
        			</tr>
        		</tbody>
        	</table>";
        }

        if($type == 'DOC_IN' && $doc_status == 'DELIVER' && $register_status == 0 && ($status_indexing == 1 || $status_indexing == 2)){
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
                        <th>Information</th>
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
                        <td>".$information."</td>
        				<td>".$update_date."</td>
        			</tr>
        		</tbody>
        	</table>";
        }

        if($type == 'DOC_IN' && $doc_status == 'DELIVER' && $register_status == 1 && ($status_indexing == 1 || $status_indexing == 2)){
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
                        <th>Information</th>
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
                        <td>".$information."</td>
        				<td>".$update_date."</td>
        			</tr>
        		</tbody>
        	</table>";
        }

        if($type == 'DOC_OUT' && $doc_status == 'DELIVER' && $register_status == 0 && $status_indexing == 0){
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
        				<td>Waiting for indexing</td>
        				<td>indexing Process</td>
        				<td>".$update_date."</td>
        			</tr>
        		</tbody>
        	</table>";
        }

        if($type == 'DOC_OUT' && $doc_status == 'DELIVER' && $register_status == 0 && ($status_indexing == 1 || $status_indexing == 2)){
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

        if($type == 'DOC_OUT' && $doc_status == 'DELIVER' && $register_status == 1 && ($status_indexing == 1 || $status_indexing == 2)){
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