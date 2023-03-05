<!--begin::Card 5-->
<div class="card card-custom" id="idCard5" style="display: none;">
    <div class="card-header">
        <div class="card-title">
            <!-- <span class="card-icon">
                <i class="fa far fa-folder-open"></i>
            </span> -->
        </div>
        
        <div class="card-toolbar">
            <div id="btnApprovalDisplay"></div>
             <a href="#" class="btn btn-primary font-weight-bolder mr-2" id="btnBackDisplayDoc">
                <i class="flaticon2-back-1"></i>
                Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="scroll" style="min-height:400px; " id="divIdTable5">
                <div class="row">
                    <div class="col-md-12">
                        <button id="id_Reload5" style="display: none;"></button>
                        <input type="hidden" id="idValueOpenSubFolder2" size="100">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="row" id="idDivIframe">
                            <div class="col-md-12">
                                <div class="embed-responsive embed-responsive-21by9 z-depth-1-half" style="height: 25cm;">
                                  <iframe class="embed-responsive-item" allowfullscreen width="auto" height="auto" id="myFrame" type="application/pdf"></iframe>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-custom shadow-lg p-3 mb-5 bg-white rounded">
                            <div class="card-header ribbon ribbon-top ribbon-ver">
                                 <h3 class="card-title" id="idDocKet"></h3>
                            </div>
                            <div class="card-body col-md-12">
                                <div id="idIndexingGeneralFile"></div>
                                <div id="idIndexingSpecificFile"></div>
                            </div>
                        </div>
                    </div>
                </div>               
                <!-- END ROW-->
            </div>
            <!--  -->
        </div>    
    </div>
</div>
<!--end::Card 5-->
<script type="text/javascript">
    $(document).ready(function(){
        prepareFrame();
    });
    function prepareFrame(b) {     
    //alert(b);                 
        $('#btnApprovalDisplay').empty(); 
        //$('#btnApprovalDisplay').remove();  
        var hasilSplit = b.split("+");
        var directory  = hasilSplit[0];
        var subFolder  = hasilSplit[1];
        var document_id   = hasilSplit[2];
        var trans_doc_id  = hasilSplit[3];
        var folder_id  = hasilSplit[4];
        var document_name  = hasilSplit[5];
        //alert(document_id);

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>collection/my_collection/getKetFile",
            data: { subFolder: subFolder,document_id: document_id,trans_doc_id: trans_doc_id,folder_id: folder_id}, 
            success: function(result)
            {   
                document.getElementById('idDocKet').textContent = document_name;    
                $.each(result.getGeneralIndexName, function(key, val) {
                    // $('#idIndexingGeneralFile').append('<label>'+val.general_index_name+'&nbsp;<span>&nbsp;:&nbsp;</span>'+val.general_index+'</label>');   
                    $('#idIndexingGeneralFile').append('<div class="row"><label for="example-password-input" class="col-5 col-form-label">'+val.general_index_name+'</label><label class="col-1 col-form-label">:</label><div class="col-5"><label for="example-password-input" class="col-form-label">'+val.general_index+'</label></div></div>');                  
                });
                var approval;
                var trans_doc_id;
                 $.each(result.getSpecificIndexName, function(key, val) {
                    // $('#idIndexingGeneralFile').append('<label>'+val.general_index_name+'&nbsp;<span>&nbsp;:&nbsp;</span>'+val.general_index+'</label>');   
                    var indexFormat = val.specific_index_format;
                    var specificIndex = val.specific_index;
                    trans_doc_id = val.trans_doc_id.trim();
                    approval = val.approval.trim();
                    if(indexFormat == 4){
                        if(specificIndex == ""||specificIndex=="NULL"){
                            specificIndex = "0.00";
                        }else{
                            specificIndex = addCommas(val.specific_index);
                        }
                        
                    }
                    
                    $('#idIndexingSpecificFile').append('<div class="row"><label for="example-password-input" class="col-5 col-form-label">'+val.specific_index_name+'</label><label class="col-1 col-form-label">:</label><div class="col-5"><label for="example-password-input" class="col-form-label">'+specificIndex+'</label></div></div>');                  
                });
                 //alert(approval);
                if(approval == "-"){
                    //alert("dewi");
                }else{
                    //alert("sis");
                   $('#btnApprovalDisplay').append('<a href="#" class="btn btn-primary font-weight-bolder mr-2" id="btnApproval" onclick=displayModalApproval("'+trans_doc_id+'")><i class="fa fa-user-edit"></i>Approval</a>'); 
                }     
                document.getElementById( 'idCard5' ).style.display   = 'block'; 
                var omyFrame = document.getElementById("myFrame");
                omyFrame.src = directory;
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
</script>