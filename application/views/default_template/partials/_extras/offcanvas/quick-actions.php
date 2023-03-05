<style type="text/css">
	.pull-left{float:left!important;}
.pull-right{float:right!important;}
.dataTables_paginate{
display:flex;
align-items:center;
}
.dataTables_paginate a{
padding:0 10px;
}
</style>

<div id="kt_quick_actions" class="offcanvas offcanvas-left p-10">

	<!--begin::Header-->
	<div class="offcanvas-header d-flex align-items-center justify-content-between pb-10">
		<h3 class="font-weight-bold m-0">New Document
			<small class="text-muted font-size-sm ml-2"><label id="totalNewDocument"></label> New</small>
		</h3>
		<a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_actions_close">
			<i class="ki ki-close icon-xs text-muted"></i>
		</a>
	</div>

	<!--end::Header-->

	<!--begin::Content-->
	<div class="offcanvas-content pr-5 mr-n5">
		<!--begin::Nav-->
		<div class="navi navi-icon-circle navi-spacer-x-0">
			<!--begin::Item-->
			<button id="idReloadNotifNewDoc" style="display: none;"></button>
			<table class="table table-separate table-head-custom table-checkable" id="idTabelListDocNotif">
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
		countNotifNewDocument();
		setInterval('countNotifNewDocument()', 10000);

        // showNotifNewDocument();
        // setInterval('showNotifNewDocument()', 10000);
    });

    function countNotifNewDocument() {
	    // $('#idDetailProjectNoActions').remove();
	     $.ajax({
	        // type: "POST",
	        type: "GET",
	        url: '<?php echo base_url();?>main/countNotifNewDocument',
	        dataType:"JSON",
	        success: function(result){
	            document.getElementById('totalNewDocument2').textContent = result;
	            document.getElementById('totalNewDocument').textContent = result;
	        }
	    });  	        
	}

	function showListDoc() {
		$("#idTabelListDocNotif").dataTable().fnDestroy();
         var table = $('#idTabelListDocNotif').DataTable({
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
	        url: '<?php echo base_url();?>main/showNotifNewDocument',
	        dataType:"JSON",
            }
        });
        $('#idReloadNotifNewDoc').click(function () {
            table.ajax.reload( null, false );
            //table.ajax.reload();
        });
    }; 

	// function showListDoc() {
	//     //alert('adadd');  
	//     //getValue.replaceAll(' ','+')
	//     $.ajax({
	//         type: "GET",
	//         url: '<?php echo base_url();?>main/showNotifNewDocument',
	//         dataType:"JSON",
	//         success: function(jawaban){
	//             $('#showNotifNewDocument').empty();
	//             $.each(jawaban, function(key, val) {
	//             	$('#showNotifNewDocument').append('<a class="navi-item" onclick=prepareFrameNotif("'+val.document_id+'%2B'+val.folder_id.trim()+'%2B'+val.sub_folder_id.trim()+'%2B'+val.trans_doc_id.trim()+'%2B'+val.folder_name.trim().replaceAll(' ','%20')+'%2B'+val.sub_folder.trim().replaceAll(' ','%20')+'%2B'+val.document_name.trim().replaceAll(' ','%20')+'")>'+
	// 				'<div class="navi-link rounded">'+
	// 				'<div class="symbol symbol-50 symbol-circle mr-3">'+
	// 				'<div class="symbol-label">'+
	// 				'<i class="far fa-file-alt text-primary icon-lg"></i>'+
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

	// function showListDoc() {
	//     //alert('adadd');  
	//     //getValue.replaceAll(' ','+')
	//     $.ajax({
	//         type: "GET",
	//         url: '<?php echo base_url();?>main/showNotifNewDocument',
	//         dataType:"JSON",
	//         success: function(jawaban){
	//             $('#showNotifNewDocument').empty();
	//             $.each(jawaban, function(key, val) {
	//             	$('#showNotifNewDocument').append('<a class="navi-item" onclick=prepareFrameNotif("'+val.document_id+'%2B'+val.folder_id.trim()+'%2B'+val.sub_folder_id.trim()+'%2B'+val.trans_doc_id.trim()+'%2B'+val.folder_name.trim().replaceAll(' ','%20')+'%2B'+val.sub_folder.trim().replaceAll(' ','%20')+'%2B'+val.document_name.trim().replaceAll(' ','%20')+'")>'+
	// 				'<div class="navi-link rounded">'+
	// 				'<div class="symbol symbol-50 symbol-circle mr-3">'+
	// 				'<div class="symbol-label">'+
	// 				'<i class="far fa-file-alt text-primary icon-lg"></i>'+
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