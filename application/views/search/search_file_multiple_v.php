<!--begin::Card-->
<div class="card card-custom" id="idCard1">
    <div class="card-header">
        <div class="quick-search quick-search-inline mt-4 w-500px" id="kt_quick_search_inline">
                <!--begin::Form-->
                <form method="get" class="quick-search-form">
                    <div class="input-group rounded bg-light">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="svg-icon svg-icon-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                            <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
                                        </g>
                                    </svg>
                                </span>
                            </span>
                        </div>
                        <input type="search" class="form-control h-45px" placeholder="Search..." id="searchDocumentID" oninput="searchDocuments()">
                    </div>
                </form>
                <!--end::Form-->
            </div>
        <div class="card-toolbar"></div>
    </div>
<!--Start::Card-->
    <div class="card-body">
        <div class="tab-content">
            <div class="scroll" style="min-height:400px; " id="divIdTable">
                <div class="row">
                    <div class="col-md-12">
                        <button id="id_Reload4" style="display: none;"></button>
                    </div>
                </div>                
                <div class="row" id="listDocumentNameID">
                    
                        
                </div>
            </div>
        </div>    
    </div>
</div>
<!--end::Card-->
<!-- Modal detail dokument -->
<div class="modal fade" id="kt_modal_detailDokumen" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row" id="idDivIframe">
                            <div class="col-md-12">
                                <div class="embed-responsive embed-responsive-16by9 z-depth-1-half" style="height: 25cm;">
                                  <iframe class="embed-responsive-item" allowfullscreen width="auto" height="auto" id="myFrame" type="application/pdf"></iframe>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-custom shadow-lg p-3 mb-5 bg-white rounded">
                            <div class="card-header ribbon ribbon-top ribbon-ver">
                                 <h3 class="card-title" id="idDocKet" style="font-weight: bold"></h3>
                            </div>
                            <div class="card-body">
                                <div id="idIndexingGeneralFile"></div>
                                <div id="idIndexingSpecificFile"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>
<!--begin::Modal detail dokument-->

<script type="text/javascript">

function searchDocuments(){
    $('#listDocumentNameID').empty();
    var valueTextSearch = document.getElementById("searchDocumentID").value;

    $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url(); ?>search/search_file_multiple/searchDocument",
        data: { valueTextSearch: valueTextSearch},  
        success: function(result)
        {   
            var x=0;

            if(result.listDocumentName.length === 0){
                if(valueTextSearch == ''){
                    $('#listDocumentNameID').html('<div class="col-md-12"></div>');
                }else{
                    // $('#listDocumentNameID').append('<div class="col-md-12"><h5 class="card-label">Not Found</h5></div>');
                    $('#listDocumentNameID').html("<div class='col-md-12'><h5 class='card-label'>Not Found</h5></div>"); 
                }
                
            }else{
                //$('#listDocumentNameID').append(result.listDocumentName);
                $('#listDocumentNameID').html("" + result.listDocumentName + "");  
            }                
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
           // alert('Error get data from ajax');
        }
    });
}

function viewDocumentDetail(value) {  
    //alert(value);
    $('#idIndexingGeneralFile').empty();
    $('#idIndexingSpecificFile').empty();
    var hasilSplit    = value.split("+");
    var trans_doc_id  = hasilSplit[0];
    var counter       = hasilSplit[1];
   $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>search/search_file_multiple/getKetFile",
            data: { trans_doc_id: trans_doc_id},  
            success: function(result)
            {    
                var document_name = result.document_name; 
                var file_name     = result.file_name; 
                var folder_name   = result.folder_name; 
                var sub_folder    = result.sub_folder; 
                document.getElementById('exampleModalLabel').textContent = document_name + ' ' + counter;
                document.getElementById('idDocKet').textContent = result.document_name; 
                $.each(result.getGeneralIndexName, function(key, val) {  
                    $('#idIndexingGeneralFile').append('<div class="row"><label for="example-password-input" class="col-5 col-form-label"><b>'+val.general_index_name+'</b></label><label class="col-1 col-form-label"><b>:</b></label><div class="col-5"><label for="example-password-input" class="col-form-label"><b>'+val.general_index+'</v></label></div></div>');                  
                });
                $.each(result.getSpecificIndexName, function(key, val) {
                    var indexFormat = val.specific_index_format;
                    var specificIndex = val.specific_index;
                    if(indexFormat == 4){
                        if(specificIndex == ""||specificIndex=="NULL"){
                            specificIndex = "0.00";
                        }else{
                            specificIndex = addCommas(val.specific_index);
                        }
                        
                    } 
                    $('#idIndexingSpecificFile').append('<div class="row"><label for="example-password-input" class="col-5 col-form-label"><b>'+val.specific_index_name+'</b></label><label class="col-1 col-form-label"><b>:</b></label><div class="col-5"><label for="example-password-input" class="col-form-label"><b>'+specificIndex+'</b></label></div></div>');                  
                });
                var omyFrame = document.getElementById("myFrame");
                omyFrame.src = "<?php echo base_url(); ?>uploads/"+folder_name+"/"+sub_folder+"/"+document_name+"/"+file_name;
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
   $('#kt_modal_detailDokumen').modal('show');
    }
    
    
    // $.ajax({
    //     type: "POST",
    //     dataType: "json",
    //     url: "<?php echo base_url(); ?>search/search_file/getKetFile",
    //     // data: { subFolder: subFolder,document_id: document_id,trans_doc_id: trans_doc_id,folder_id: folder_id},
    //     data: { trans_doc_id: trans_doc_id},  
    //     success: function(result)
    //     {   
    //         var document_name = result.document_name; 
    //         var file_name     = result.file_name; 
    //         var folder_name   = result.folder_name; 
    //         var sub_folder    = result.sub_folder; 
    //         document.getElementById('idDocKet').textContent = result.document_name;    
    //         $.each(result.getGeneralIndexName, function(key, val) {  
    //             $('#idIndexingGeneralFile').append('<div class="row"><label for="example-password-input" class="col-5 col-form-label"><b>'+val.general_index_name+'</b></label><label class="col-1 col-form-label"><b>:</b></label><div class="col-5"><label for="example-password-input" class="col-form-label"><b>'+val.general_index+'</v></label></div></div>');                  
    //         });
    //          $.each(result.getSpecificIndexName, function(key, val) {
    //             // $('#idIndexingGeneralFile').append('<label>'+val.general_index_name+'&nbsp;<span>&nbsp;:&nbsp;</span>'+val.general_index+'</label>');  
    //             var indexFormat = val.specific_index_format;
    //             var specificIndex = val.specific_index;
    //             if(indexFormat == 4){
    //                 if(specificIndex == ""||specificIndex=="NULL"){
    //                     specificIndex = "0.00";
    //                 }else{
    //                     specificIndex = addCommas(val.specific_index);
    //                 }
                    
    //             } 
    //             $('#idIndexingSpecificFile').append('<div class="row"><label for="example-password-input" class="col-5 col-form-label"><b>'+val.specific_index_name+'</b></label><label class="col-1 col-form-label"><b>:</b></label><div class="col-5"><label for="example-password-input" class="col-form-label"><b>'+specificIndex+'</b></label></div></div>');                  
    //         });
                      
    //         document.getElementById( 'idCard1' ).style.display   = 'none'; 
    //         document.getElementById( 'idCard2' ).style.display   = 'block'; 
    //         var omyFrame = document.getElementById("myFrame");
    //         omyFrame.src = "<?php echo base_url(); ?>uploads/"+folder_name+"/"+sub_folder+"/"+document_name+"/"+file_name;
    //     },
    //     error: function (jqXHR, textStatus, errorThrown)
    //     {
    //         alert('Error get data from ajax');
    //     }
    // });

</script>