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
        <div class="card-toolbar">
            <button id="id_Reload3" style="display: none;"></button>
           <!--  <div class="mr-2">
                <a href="#" class="btn btn-primary font-weight-bolder" id="getDataBtn" data-toggle="modal" data-target="#kt_modal_Add">
                    <i class="fas fa-file-upload"></i>&nbsp;Upload
                </a>
            </div>  -->     
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="scroll" style="min-height:400px; " id="divIdTable">
                <form class="mb-15">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-lg-4 col-sm-6">Range Date</label>
                            <div class="input-daterange input-group col-sm-12" id="kt_datepicker_5">
                                <input type="text" class="form-control" name="startDate" id="startDate">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-ellipsis-h"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" name="endDate" id="endDate">
                            </div>
                        </div>  
                        <div class="form-group mr-2">
                            <label>&nbsp;&nbsp;</label>
                            <a class="btn btn-primary btn-primary--icon form-control datatable-input" id="kt_search" data-col-index="2" onclick="searchFile()">
                                <span>
                                    <i class="flaticon-imac"></i>
                                    <span>Display</span>
                                </span>
                            </a>
                        </div>    
                        <div class="form-group mr-2">
                            <label>&nbsp;&nbsp;</label>
                            <a class="btn btn-primary btn-primary--icon form-control datatable-input" id="kt_search" data-col-index="2" onclick="downloadFile()">
                                <i class="fas fa-file-download"></i>&nbsp;Download
                            </a>
                        </div>                
                    </div> 
                </form>
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
var KTBootstrapDatepicker=function(){
var t;
t=KTUtil.isRTL()?{
    leftArrow: '<i class="la la-angle-right"></i>',
    rightArrow: '<i class="la la-angle-left"></i>'
  }: {
    leftArrow: '<i class="la la-angle-left"></i>',
    rightArrow: '<i class="la la-angle-right"></i>'
  };return{
    init: function(){
      $("#kt_datepicker_5").datepicker({
        rtl: KTUtil.isRTL(),
        todayHighlight: !0,
        templates: t,
        locale: {
            format: 'dd/mm/yyyy'
        }
      })
    }
  }
}();
jQuery(document).ready((function(){
  KTBootstrapDatepicker.init()
}));

function searchFile(){
    var startDate = $('#startDate').val();
    var endDate   = $('#endDate').val();
    if(startDate==""){
        UIToastr.init('warning', 'Please fill Range date');
        //alert('Select Container');
        return false;
    }else{
        $.ajax({
            url: '<?php echo base_url(); ?>report/report_regis_nondoc/getListDoc',
            type: 'POST',
            data: {startDate:startDate,endDate:endDate},             
            success: function (jawaban){ 
                $('#load_document').fadeIn('slow');
                $('#load_document').html(jawaban);                     
            },
            beforeSend: function() {             
              //$('#load_document').fadeIn('slow');
            }
        });
        return false; 
    }      
}

function downloadFile(){
    var startDateID = $('#startDate').val();
    var endDateID   = $('#endDate').val();
    if(startDate==""){
        UIToastr.init('warning', 'Please fill Range date');
        //alert('Select Container');
        return false;
    }else{
        $('#btnDownload').attr("disabled", true); 
        $('#btnDownload').addClass("spinner spinner-right spinner-white pr-15", "Please wait");
        window.location= "<?php echo base_url(); ?>report/report_regis_nondoc/downloadExcel/?startDate="+startDateID+"&endDate="+endDateID;
        $('#btnDownload').removeClass("spinner spinner-right spinner-white pr-15", "Please wait"); 
        $('#btnDownload').attr("disabled", false); 
    }      
}
</script>
