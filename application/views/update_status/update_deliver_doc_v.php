<style type="text/css">

</style>
<!--begin::Card-->
<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="<?php echo $menu_icon; ?>"></i>
            </span>
            <h3 class="card-label"><?php echo strtoupper($menu_name); ?></h3>
        </div>
        <div class="card-toolbar"></div>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="scroll" style="min-height:400px; " id="divIdTable">
                <div class="row">
                    <div class="col-md-12">
                        <button id="id_Reload" style="display: none;"></button>
                    </div>
                </div>
                <form class="form_add" id="idFromAdd" method="post" action="javascript:;">
                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalBarcode"></button> -->
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No. Register</label>
                                <input class="form-control" id="regNum" name="regNum" type="text" value="<?php echo $regNum; ?>" readonly="">  
                            </div>
                        </div>

                        
                    </div> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Owner</label>
                                <input class="form-control" id="ownerName" name="ownerName" type="text" value="<?php echo $username; ?>" readonly="">  
                            </div> 
                            <div class="form-group">
                                <label>Description</label>
                                <input class="form-control" id="description" name="description" type="text" value="<?php echo $doc_description; ?>" readonly=""> 
                            </div> 
                            <div class="form-group">
                                <label>Note</label>
                                <textarea class="form-control" id="note" name="note" type="text" rows="3"></textarea>
                            </div>
                        </div>
                    </div>  
                </div>                                     
                <div class="card-footer" id="buttonSimpan">
                    <button class="btn btn-primary" id="saveDoc" type="submit">Delivery Request</button>
                    <div id="alertSuccessID" style="display: none;">                        
                        <div class="alert alert-custom alert-light-primary fade show mb-5 col-md-6" role="alert">
                            <div class="alert-icon">
                                <i class="flaticon2-check-mark"></i>
                            </div>
                            <div class="alert-text">Documents will be sent by mailroom</div>
                            <div class="alert-close">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">
                                        <i class="ki ki-close"></i>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>               
            </div>
        </div>    
    </div>
</div>
<!--end::Card-->

<script type="text/javascript">
    $("#idFromAdd").submit(function(event){
        $('#saveDoc').attr("disabled", true); 
        $('#saveDoc').addClass('spinner spinner-white spinner-right');
        event.preventDefault(); 
        dataString = $("#idFromAdd").serialize();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>update_status/update_deliver_doc/save",
            data: dataString,
            success:function(data)
            {
                $('#saveDoc').removeClass('spinner spinner-white spinner-right');
                var act = data.act;

                UIToastr.init(data.tipePesan, data.pesan);
                $('#saveDoc').attr("disabled", false); 
                if(act == 1){
                    document.getElementById( 'alertSuccessID' ).style.display = 'block';
                    document.getElementById( 'saveDoc' ).style.display = 'none';
                }else{
                    document.getElementById( 'alertSuccessID' ).style.display = 'none';
                    document.getElementById( 'saveDoc' ).style.display = 'block';
                }
            }
        });
    });
</script>
