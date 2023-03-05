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
                <div class="row">
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
    $("#regNum").keypress(
      function(event){
        if (event.which == '13') {
             var regNum = $('#regNum').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>search/tracking_doc/getNoRegDoc",
                data: { regNum: regNum }, 
                success: function (data){ 
                  $('#load_document').fadeIn('slow');
                  $('#load_document').html(data);     
                      
                },
                beforeSend: function() {             
                    //$('#load_document').fadeIn('slow');
                }
            });
          event.preventDefault();
        }
    });

</script>
