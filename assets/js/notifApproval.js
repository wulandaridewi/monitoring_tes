function addCommas(nStr) {
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function prepareFrameNotif(b) { 
    //alert('mmmmm');
    window.location = base_url+"container/my_container/home?detail=2&value="+b;
}


// function prepareFrameNotif(b) {     
//     //alert(b);                 
//         $('#btnApprovalDisplay').empty(); 
//         $('#idIndexingGeneralFile').empty(); 
//         $('#idIndexingSpecificFile').empty(); 
//         //$('#btnApprovalDisplay').remove();  
//         var hasilSplit = b.split("+");
//         var directory  = hasilSplit[0];
//         var subFolder  = hasilSplit[1];
//         var document_id   = hasilSplit[2];
//         var trans_doc_id  = hasilSplit[3];
//         var folder_id  = hasilSplit[4];
//         var document_name  = hasilSplit[5];
//         //alert(document_id);

//         $.ajax({
//             type: "POST",
//             dataType: "json",
//             url: base_url+"collection/my_collection/getKetFile",
//             //url: window.location.hostname+'/collection/my_collection/getKetFile',
//             data: { subFolder: subFolder,document_id: document_id,trans_doc_id: trans_doc_id,folder_id: folder_id}, 
//             success: function(result)
//             {   
//                 document.getElementById('idDocKet').textContent = document_name;    
//                 $.each(result.getGeneralIndexName, function(key, val) {
//                     // $('#idIndexingGeneralFile').append('<label>'+val.general_index_name+'&nbsp;<span>&nbsp;:&nbsp;</span>'+val.general_index+'</label>');   
//                     $('#idIndexingGeneralFile').append('<div class="row"><label for="example-password-input" class="col-5 col-form-label">'+val.general_index_name+'</label><label class="col-1 col-form-label">:</label><div class="col-5"><label for="example-password-input" class="col-form-label">'+val.general_index+'</label></div></div>');                  
//                 });
//                 var approval;
//                 var trans_doc_id;
//                  $.each(result.getSpecificIndexName, function(key, val) {
//                     // $('#idIndexingGeneralFile').append('<label>'+val.general_index_name+'&nbsp;<span>&nbsp;:&nbsp;</span>'+val.general_index+'</label>');   
//                     var indexFormat = val.specific_index_format;
//                     var specificIndex = val.specific_index;
//                     trans_doc_id = val.trans_doc_id.trim();
//                     approval = val.approval.trim();
//                     if(indexFormat == 4){
//                         if(specificIndex == ""||specificIndex=="NULL"){
//                             specificIndex = "0.00";
//                         }else{
//                             specificIndex = addCommas(val.specific_index);
//                         }
                        
//                     }
                    
//                     $('#idIndexingSpecificFile').append('<div class="row"><label for="example-password-input" class="col-5 col-form-label">'+val.specific_index_name+'</label><label class="col-1 col-form-label">:</label><div class="col-5"><label for="example-password-input" class="col-form-label">'+specificIndex+'</label></div></div>');                  
//                 });
//                  //alert(approval);
//                 if(approval == "-"){
//                     //alert("dewi");
//                 }else{
//                     //alert("sis");
//                    $('#btnApprovalDisplay').append('<a href="#" class="btn btn-primary font-weight-bolder mr-2" id="btnApproval" onclick=displayModalApproval("'+trans_doc_id+'")><i class="fa fa-user-edit"></i>Approval</a>'); 
//                 }     
//                 document.getElementById( 'idCard2' ).style.display   = 'none';
//                 document.getElementById( 'idCard1' ).style.display   = 'none';
//                 document.getElementById( 'idCard3' ).style.display   = 'none';
//                 document.getElementById( 'idCard4' ).style.display   = 'none'; 
//                 document.getElementById( 'idCard5' ).style.display   = 'block'; 
//                 var omyFrame = document.getElementById("myFrame");
//                 omyFrame.src = directory;
//                 $("#kt_quick_notifications_close").trigger('click');   
                
//             },
//             error: function (jqXHR, textStatus, errorThrown)
//             {
//                 alert('Error get data from ajax');
//             }
//         });
//     }