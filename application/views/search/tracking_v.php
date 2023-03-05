<style type="text/css">

</style>
<!--begin::Card-->
<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"></rect>
                        <path d="M12.8434797,16 L11.1565203,16 L10.9852159,16.6393167 C10.3352654,19.064965 7.84199997,20.5044524 5.41635172,19.8545019 C2.99070348,19.2045514 1.55121603,16.711286 2.20116652,14.2856378 L3.92086709,7.86762789 C4.57081758,5.44197964 7.06408298,4.00249219 9.48973122,4.65244268 C10.5421727,4.93444352 11.4089671,5.56345262 12,6.38338695 C12.5910329,5.56345262 13.4578273,4.93444352 14.5102688,4.65244268 C16.935917,4.00249219 19.4291824,5.44197964 20.0791329,7.86762789 L21.7988335,14.2856378 C22.448784,16.711286 21.0092965,19.2045514 18.5836483,19.8545019 C16.158,20.5044524 13.6647346,19.064965 13.0147841,16.6393167 L12.8434797,16 Z M17.4563502,18.1051865 C18.9630797,18.1051865 20.1845253,16.8377967 20.1845253,15.2743923 C20.1845253,13.7109878 18.9630797,12.4435981 17.4563502,12.4435981 C15.9496207,12.4435981 14.7281751,13.7109878 14.7281751,15.2743923 C14.7281751,16.8377967 15.9496207,18.1051865 17.4563502,18.1051865 Z M6.54364977,18.1051865 C8.05037928,18.1051865 9.27182488,16.8377967 9.27182488,15.2743923 C9.27182488,13.7109878 8.05037928,12.4435981 6.54364977,12.4435981 C5.03692026,12.4435981 3.81547465,13.7109878 3.81547465,15.2743923 C3.81547465,16.8377967 5.03692026,18.1051865 6.54364977,18.1051865 Z" fill="#000000"></path>
                    </g>
                </svg>
            </span>
            <h3 class="card-label"><?php echo strtoupper($menu_name); ?></h3>
        </div>
        <div class="card-toolbar"></div>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="scroll" style="min-height:300px; " id="divIdTable">
                <div class="row">
                    <div class="col-md-12">
                        <button id="id_Reload" style="display: none;"></button>
                    </div>
                </div>
                <div class="row">                  
                  <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control" id="Category" name="Category" required="">
                                      <option value=""></option>
                                      <option value="DOC">Document</option>
                                      <option value="NONDOC">Non Document</option>
                                  </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>No. Register</label>
                                    <input class="form-control" id="regNum" name="regNum" type="text">  
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button class="form-control btn btn-primary" id="saveDoc" onclick="searchFile()" ><i class="la la-binoculars"></i> Submit</button>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="load_document" style="display:none;"></div>                    
                    </div>
                </div>              
            </div>
        </div>    
    </div>
</div>
<!--end::Card-->
<script type="text/javascript">
    
    // alert(cat);
    function searchFile(){
       var regNum = $('#regNum').val();
       var category = $('#Category').val();
       //alert(category);
        if(category == 'DOC'){
          $.ajax({
              type: "POST",
              url: "<?php echo base_url(); ?>search/tracking/getNoRegDoc",
              data: { regNum: regNum,category:category}, 
              success: function (data){ 
                $('#load_document').fadeIn('slow');
                $('#load_document').html(data);     
                    
              },
              beforeSend: function() {             
                  //$('#load_document').fadeIn('slow');
              }
          });
        }else if(category == 'NONDOC'){
          $.ajax({
              type: "POST",
              url: "<?php echo base_url(); ?>search/tracking/getNoRegNonDoc",
              data: { regNum: regNum,category:category}, 
              success: function (data){ 
                $('#load_document').fadeIn('slow');
                $('#load_document').html(data);     
                    
              },
              beforeSend: function() {             
                  //$('#load_document').fadeIn('slow');
              }
          });
        }else{
          UIToastr.init('warning', 'Select Category'); 
          return false;
        }
    }

    // $("#regNum").keypress(

    //   function(event){

    //     if (event.which == '13') {
    //          var regNum = $('#regNum').val();
    //          var category = $('#Category').val();
    //          //alert(category);
    //           if(category == 'DOC'){
    //             $.ajax({
    //                 type: "POST",
    //                 url: "<?php echo base_url(); ?>search/tracking/getNoRegDoc",
    //                 data: { regNum: regNum,category:category}, 
    //                 success: function (data){ 
    //                   $('#load_document').fadeIn('slow');
    //                   $('#load_document').html(data);     
                          
    //                 },
    //                 beforeSend: function() {             
    //                     //$('#load_document').fadeIn('slow');
    //                 }
    //             });
    //           }else if(category == 'NONDOC'){
    //             $.ajax({
    //                 type: "POST",
    //                 url: "<?php echo base_url(); ?>search/tracking/getNoRegNonDoc",
    //                 data: { regNum: regNum,category:category}, 
    //                 success: function (data){ 
    //                   $('#load_document').fadeIn('slow');
    //                   $('#load_document').html(data);     
                          
    //                 },
    //                 beforeSend: function() {             
    //                     //$('#load_document').fadeIn('slow');
    //                 }
    //             });
    //           }else{
    //             UIToastr.init('warning', 'Select Category'); 
    //             return false;
    //           }
            
    //       event.preventDefault();
    //     }
    // });

</script>
