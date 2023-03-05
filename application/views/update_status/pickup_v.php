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
                                <input class="form-control" id="regNum" name="regNum" type="text">  
                            </div>
                        </div>
                    </div>   
                </div>
                <div class="col-md-12" id="divKetDoc" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Owner</label>
                                <input class="form-control" id="ownerName" name="ownerName" type="text" readonly="">  
                            </div> 
                            <div class="form-group">
                                <label>Description</label>
                                <input class="form-control" id="description" name="description" type="text" readonly=""> 
                                <input class="form-control" id="email" name="email" type="hidden" readonly="">   
                            </div> 
                        </div>
                    </div>
                </div> 
                <div class="col-md-12" id="divDisplay" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pickup By</label>
                                <input class="form-control" id="pickup_by" name="pickup_by" type="text">  
                            </div> 
                        </div>
                    </div>                     
                    <div class="card-footer" id="buttonSimpan">
                        <button class="btn btn-primary" id="saveDoc" type="submit">Submit</button>
                    </div>
                </div>
                </form>               
            </div>
        </div>    
    </div>
</div>
<!--end::Card-->

<script type="text/javascript">
    jQuery(document).ready(function() {

    });
    // $("#regNum").keyup(function(event) {
    //     if (event.keyCode === 13) {
    //         //alert('adsafnfh');
    //         var regNum = $('#regNum').val();
    //         $.ajax({
    //             type: "POST",
    //             dataType: "json",
    //             url: "<?php echo base_url(); ?>update_status/pickup/getNoRegDoc",
    //             data: { regNum: regNum }, 
    //             success:function(data)
    //             {
    //                 var owner     = data.username;
    //                 var desc      = data.doc_description;
    //                 var pickup_by = data.pickup_by;
    //                 // alert(owner);
    //                 // alert(desc);
    //                 // alert(pickup_by);
    //                 if(pickup_by === "" || pickup_by === "null"){
    //                     if(owner == "" && desc == ""){
    //                         UIToastr.init('warning', 'Registration number not found');   
    //                     }else{
    //                         document.getElementById( 'divKetDoc' ).style.display    = 'block';
    //                         $('#ownerName').val(owner);
    //                         $('#description').val(desc);
    //                         document.getElementById( 'divDisplay' ).style.display   = 'block';  
    //                     }   
    //                 }else{
    //                     UIToastr.init('success', 'Pickup By '+ data.pickup_by +'');   
    //                 }                    
    //             }
    //         });
    //         return false;
    //     }
    // });

    $("#regNum").keypress(
      function(event){
        if (event.which == '13') {
             var regNum = $('#regNum').val();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo base_url(); ?>update_status/pickup/getNoRegDoc",
                data: { regNum: regNum }, 
                success:function(data)
                {
                    var owner     = data.username;
                    var desc      = data.doc_description;
                    var pickup_by = data.pickup_by;
                    var email     = data.email;
                    // alert(owner);
                    // alert(desc);
                    // alert(pickup_by);
                    if(pickup_by === "" || pickup_by === "null"){
                        if(owner == "" && desc == ""){
                            UIToastr.init('warning', 'Registration number not found or Service Delivery');   
                        }else{
                            document.getElementById( 'divKetDoc' ).style.display    = 'block';
                            $('#ownerName').val(owner);
                            $('#description').val(desc);
                            $('#email').val(email);
                            document.getElementById( 'divDisplay' ).style.display   = 'block';  
                        }   
                    }else{
                        UIToastr.init('success', 'Pickup By '+ data.pickup_by +'');   
                    }                    
                }
            });
          event.preventDefault();
        }
    });

    $("#idFromAdd").submit(function(event){
        $('#saveDoc').attr("disabled", true); 
        $('#saveDoc').addClass('spinner spinner-white spinner-right');
        event.preventDefault(); 
        dataString = $("#idFromAdd").serialize();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>update_status/pickup/save",
            data: dataString,
            success:function(data)
            {
                $('#saveDoc').removeClass('spinner spinner-white spinner-right');
                UIToastr.init(data.tipePesan, data.pesan);
                $("#idFromAdd")[0].reset();
                document.getElementById( 'divKetDoc' ).style.display    = 'none';
                document.getElementById( 'divDisplay' ).style.display    = 'none';
                $('#saveDoc').attr("disabled", false); 
            }
        });
    });

     // $("#idFromAdd").on("keypress", function (event) { 
     //        console.log("aaya"); 
     //        var keyPressed = event.keyCode || event.which; 
     //        if (keyPressed === 13) { 
     //            //alert("You pressed the Enter key!!"); 
     //            var regNum = $('#regNum').val();
     //            $.ajax({
     //                type: "POST",
     //                dataType: "json",
     //                url: "<?php echo base_url(); ?>update_status/pickup/getNoRegDoc",
     //                data: { regNum: regNum }, 
     //                success:function(data)
     //                {
     //                    var owner     = data.username;
     //                    var desc      = data.doc_description;
     //                    var pickup_by = data.pickup_by;
     //                    // alert(owner);
     //                    // alert(desc);
     //                    // alert(pickup_by);
     //                    if(pickup_by === "" || pickup_by === "null"){
     //                        if(owner == "" && desc == ""){
     //                            UIToastr.init('warning', 'Registration number not found');   
     //                        }else{
     //                            document.getElementById( 'divKetDoc' ).style.display    = 'block';
     //                            $('#ownerName').val(owner);
     //                            $('#description').val(desc);
     //                            document.getElementById( 'divDisplay' ).style.display   = 'block';  
     //                        }   
     //                    }else{
     //                        UIToastr.init('success', 'Pickup By '+ data.pickup_by +'');   
     //                    }                    
     //                }
     //            });
     //            event.preventDefault(); 
     //            return false; 
     //        } 
     //    }); 
        
  


</script>
