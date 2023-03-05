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
                                <label>Type</label>
                                <select class="form-control" id="typeRegisDoc" name="typeRegisDoc" required="">
                                    <option value=""></option>
                                    <option value="DOC_IN">Incoming Documents</option>
                                    <option value="DOC_OUT">Outgoing Documents</option>
                                </select> 
                            </div>
                        </div>
                        <div class="col-md-6" id="divIndex" style="display: none;">
                            <div class="form-group">
                                <label>Indexing or Not Indexing</label>
                                <select class="form-control" id="indexing" name="indexing" required="">
                                    <option value=""></option>
                                    <option value="INDEX">Indexing</option>
                                    <option value="NOT_INDEX">Not Indexing</option>
                                </select>
                            </div>                             
                        </div>
                    </div>   
                </div>
                <div class="col-md-12" id="divInternal" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Owner</label>
                                <select class="form-control" id="ownerName" name="ownerName" required="">
                                    <option></option>
                                    <?php
                                        $data = array();
                                        $data[''] = '';
                                        //print_r($jenis_document);
                                        foreach ($getUser as $row) :
                                            // $status_barcode = $row->status_barcode;
                                    ?>       
                                        <option value="<?php echo trim($row->userid) ?>"><?php echo trim($row->name) ." - ".trim($row->department); ?>
                                            
                                        </option>
                                    <?php
                                        endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Description</label>
                                <input class="form-control" id="description" name="description" type="text">  
                            </div> 
                        </div>
                    </div>   
                </div>  
                <div class="col-md-12" id="divExternal" style="display: none;">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Recipient</label>
                                <input id="recipient" name="recipient" class="form-control" type="text">  
                            </div> 
                        </div>                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Estimated Time</label>
                                <input class="form-control" id="kt_inputmask_1" data-inputmask="'alias': 'datetime', 'inputFormat': 'mm/dd/yyyy'" name="estimasiWaktu" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Delivery Location</label>
                                <input id="delivery_location" name="delivery_location" class="form-control" type="text">  
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="card-footer" id="buttonSimpan" style="display: none;">
                    <button class="btn btn-primary" id="saveDoc" type="submit">Submit</button>
                </div>
                </form>               
            </div>
        </div>    
    </div>
</div>
<!--end::Card-->
<!-- Start Modal Barcode -->
<div class="modal fade" id="modalBarcode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registration Number</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group" id="image-barcode">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold" onclick="printBarcode()">Print Barcode</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Barcode -->
<!-- Start print barcode -->
<div id="divToPrint" style="display:none;">
  <div style="background-color:teal;">
           <div id="image-barcode2">
                                        <!-- <img id="myImg" src="" alt="Image" /> -->
            </div>    
  </div>
</div>
<!-- End print barcode -->
<script type="text/javascript">
    jQuery(document).ready(function() {
       document.getElementById( 'divIndex' ).style.display = 'none';
       Inputmask().mask("kt_inputmask_1");
       // // date format
       //  $("#kt_inputmask_1").inputmask("99-99-9999", {
       //   "placeholder": "dd-mm-yyyy",
       //   autoUnmask: true
       //  });
    });
    $('#ownerName').select2({
        width: '100%',
        placeholder: "Select Category"
    });
    $("#typeRegisDoc").change(function () {
        var value = this.value;
        if(value == "DOC_OUT"){
            document.getElementById( 'divExternal' ).style.display   = 'block';
            document.getElementById( 'divInternal' ).style.display   = 'block';
            document.getElementById( 'divIndex' ).style.display      = 'block';
            document.getElementById( 'buttonSimpan' ).style.display  = 'block';
        }else{
            document.getElementById( 'divExternal' ).style.display   = 'none';
            document.getElementById( 'divInternal' ).style.display   = 'block';
            document.getElementById( 'divIndex' ).style.display      = 'block';
            document.getElementById( 'buttonSimpan' ).style.display  = 'block';            
            $('#recipient').val('');
            $('#delivery_location').val('');
        }
    });

    $("#idFromAdd").submit(function(event){
       //alert('adafdfd');
        $('#saveDoc').attr("disabled", true); 
        var type = $('#typeRegisDoc').val();
       //alert(type);
        if(type == 'DOC_IN'){
        //alert('dad');
            $('#saveDoc').addClass('spinner spinner-white spinner-right');
            event.preventDefault(); 
            dataString = $("#idFromAdd").serialize();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo base_url(); ?>registration/doc_in/saveDocIn",
                data: dataString,
                success:function(data)
                {
                    if(data.tipePesan == 'success'){
                        $('#modalBarcode').modal('show');
                        $('#image-barcode').html('<img src="<?php echo base_url().'' ?>'+ data.folder +'/'+ data.barcodeNum +'.png" alt="Image" />');
                        $('#image-barcode2').html('<img src="<?php echo base_url().'' ?>'+ data.folder +'/'+ data.barcodeNum +'.png" alt="Image" />');
                        
                    }
                    $("#idFromAdd")[0].reset();
                    $('#ownerName').val('').trigger('change');
                    $('#saveDoc').removeClass('spinner spinner-white spinner-right');
                    UIToastr.init(data.tipePesan, data.pesan);                     
                    $('#saveDoc').attr("disabled", false); 
                }
            });
       }else{
        //alert('adadda');
         $('#saveDoc').addClass('spinner spinner-white spinner-right');
            event.preventDefault(); 
            dataString = $("#idFromAdd").serialize();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo base_url(); ?>registration/doc_in/saveDocOut",
                data: dataString,
                success:function(data)
                {
                    if(data.tipePesan == 'success'){
                        $('#modalBarcode').modal('show');
                        $('#image-barcode').html('<img src="<?php echo base_url().'' ?>'+ data.folder +'/'+ data.barcodeNum +'.png" alt="Image" />');
                        $('#image-barcode2').html('<img src="<?php echo base_url().'' ?>'+ data.folder +'/'+ data.barcodeNum +'.png" alt="Image" />');
                        
                    }
                    $("#idFromAdd")[0].reset();
                    $('#ownerName').val('').trigger('change');
                    $('#saveDoc').removeClass('spinner spinner-white spinner-right');
                    UIToastr.init(data.tipePesan, data.pesan);                     
                    $('#saveDoc').attr("disabled", false); 
                }
            });
       }
       
    });

    function printBarcode() {
       var divToPrint = document.getElementById('divToPrint');
       var popupWin = window.open('', '_blank', 'width=700,height=700');
       popupWin.document.open();
       popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
       popupWin.document.close();
    }
</script>
