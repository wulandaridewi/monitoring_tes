<div id="kt_quick_notifications" class="offcanvas offcanvas-left p-10">

	<!--begin::Header-->
	<div class="offcanvas-header d-flex align-items-center justify-content-between mb-10">
		<h3 class="font-weight-bold m-0">Approval
			<small class="text-muted font-size-sm ml-2"><label id="totalApprovalId"></label> New</small>
		</h3>
		<a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_notifications_close">
			<i class="ki ki-close icon-xs text-muted"></i>
		</a>
	</div>
	<!--end::Header-->

	<!--begin::Content-->
	<div class="offcanvas-content pr-5 mr-n5">
		<!--begin::Nav-->
		<div class="navi navi-icon-circle navi-spacer-x-0">
			<!--begin::Item-->
			<button id="idReloadNewNotifApproval" style="display: none;"></button>
			<table class="table table-separate table-head-custom table-checkable" id="idTabelListNotifApproval">
                <thead style="display: none;">
                    <tr> 
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                                                                    
                </tbody>
                <tfoot>

                </tfoot>
            </table>
			<!--end::Item-->					
		</div>
		<!--end::Nav-->
	</div>
	<!--end::Content-->
</div>
<script type="text/javascript">
	var base_url = "<?php echo base_url();?>";
	$(document).ready(function(){
		countNotifNewApproval();
		setInterval('countNotifNewApproval()', 10000);
    });
	function countNotifNewApproval() {
	    // $('#idDetailProjectNoActions').remove();
	     $.ajax({
	        // type: "POST",
	        type: "GET",
	        url: '<?php echo base_url();?>main/countNotifNewApproval',
	        dataType:"JSON",
	        success: function(result){
	            document.getElementById('totalApprovalId2').textContent = result;
	            document.getElementById('totalApprovalId').textContent = result;
	        }
	    });  	        
	}

	function showListNewApproval() {
		$("#idTabelListNotifApproval").dataTable().fnDestroy();
         var table = $('#idTabelListNotifApproval').DataTable({
            responsive: true,
            searching: false,
            processing: true,
            serverSide: true,
            "bPaginate": true,
            "bFilter": true,
            "bLengthChange": false,
            "bInfo" : false,
            "dom": '<"pull-left"f><"pull-right"l>tip',
            "oLanguage": {
		        "sEmptyTable": "Notifications empty"
		    },
            fnDrawCallback: function(oSettings) {
			    if (oSettings._iRecordsTotal < 11) {
			        $('.dataTables_paginate').hide();
			    }
			},
            ajax: {
            type: "POST",
	        url: '<?php echo base_url();?>main/showNotifApproval',
	        dataType:"JSON",
            }
        });
        $('#idReloadNewNotifApproval').click(function () {
            table.ajax.reload( null, false );
            //table.ajax.reload();
        });
    }; 
	// function showNotifApproval() {
	//     // $('#idDetailProjectNoActions').remove();
	//      $.ajax({
	//         // type: "POST",
	//         type: "GET",
	//         url: '<?php echo base_url();?>main/showNotifApproval',
	//         // dataType:"html",
	//         dataType:"JSON",
	//         success: function(jawaban){
	//             $('#showNotifApproval').empty();
	//             var x=0;
	//             var totalApproval = jawaban.length;
	//             document.getElementById('totalApprovalId').textContent = totalApproval;
	//              document.getElementById('totalApprovalId2').textContent = totalApproval;
	//             $.each(jawaban, function(key, val) {

	//             $('#showNotifApproval').append('<a href="#" class="navi-item" onclick=prepareFrameNotif("'+val.directory.trim()+'+'+val.sub_folder.trim()+'+'+val.document_id+'+'+val.trans_doc_id.trim()+'+'+val.folder_id.trim()+'+'+val.document_name.trim()+'+'+val.folder_name.trim()+'")>'+
	// 				'<div class="navi-link rounded">'+
	// 				'<div class="symbol symbol-50 symbol-circle mr-3">'+
	// 				'<div class="symbol-label">'+
	// 				'<i class="fa fa-user-edit text-primary icon-lg"></i>'+
	// 				'</div>'+
	// 				'</div>'+
	// 				'<div class="navi-text">'+
	// 				'<div class="font-weight-bold font-size-lg">'+val.document_name+'</div>'+
	// 				'<div class="text-muted">'+val.sub_folder+'</div>'+
	// 				'<div class="text-muted">'+val.create_date+'</div>'+
	// 				'</div>'+
	// 				'</div>'+
	// 				'</a>'); 
	//             }); 
	//         }
	//     });  	        
	// }

	


</script>