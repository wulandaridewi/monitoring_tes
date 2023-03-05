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
            <div class="mr-2">
                <a href="#" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#kt_modal_Add" id="getDataBtn">
                    <i class="fas fa-file-download"></i>&nbsp;Download
                </a>
            </div>
            <button id="id_Reload3" style="display: none;"></button>
            <!-- <div class="mr-2">
                <a href="#" class="btn btn-primary font-weight-bolder" id="getDataBtn">
                    <i class="fas fa-file-upload"></i>&nbsp;Upload
                </a>
            </div>  -->     
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="scroll" style="min-height:400px; " id="divIdTable">
                <div class="row">
                    <div class="col-md-12">
                        <button id="id_Reload" style="display: none;"></button>
                    </div>
                    <div class="col-md-12">
                        <!--begin: Datatable-->
                        <table class="table table-separate table-head-custom table-checkable" id="kt_datatable_2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Register Id</th>
                                    <th>Document Description</th>
                                    <th>Owner</th>
                                    <th>Department</th>
                                    <th>Note</th>
                                    <th>Recipient</th>
                                    <th>Information</th>
                                    <th>Create Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <!--end: Datatable-->
                    </div>
                </div>           
            </div>
        </div>    
    </div>
</div>
<!--end::Card-->
<!-- Modal Add -->
<div class="modal fade" id="kt_modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="kt-font-brand kt-font-bold"><i class="<?php echo $menu_icon; ?>"></i>&nbsp;&nbsp;<?php echo strtoupper($menu_name); ?></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form class="kt-form" id="form_add" method="post" action="javascript:;">
                    <div class="kt-portlet__body">
                        
                        <div class="form-group">
                            <center><h3>Are you sure to continue downloading?</h3></center>
                            <input type="hidden" class="form-control" name="regNumAll" id="regNumAll">
                        </div>
                    </div>            
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" id="btnDownload" type="submit">Download</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--begin::Modal Add-->
<script type="text/javascript">  
    $('#idExpedition').select2({
        placeholder: "Select a Expedition ",
        width: '100%',
    });
    var data = new Object();
    var t = $("#kt_datatable_2");
    var grid;
        grid = t.DataTable({
        responsive: !0,
        ajax: "<?php echo base_url("/download/delivery_internal_doc/getDevAll"); ?>",
        columns: [
            {data: "no"},
            {data: "register_doc_id"},
            {data: "doc_description"},
            {data: "name"},
            {data: "department"},
            {data: "note"},
            {data: "recipient"},
            {data: "information"},
            {data: "create_date"},
        ],
        dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
        lengthMenu: [5,10,25,50],
        pageLength: 10,
        language: {
            lengthMenu: "Display _MENU_"
        },
        order: [
            [
              1,
              "desc"
            ]
        ],
        headerCallback: function(t,a,l,s,e){
            t.getElementsByTagName("th")[
              0
            ].innerHTML='\n<label class="checkbox checkbox-single">\n<input type="checkbox" value="" class="group-checkable"/>\n<span></span>\n</label>'
        },
        columnDefs: [
        {
          targets: 0,
          width: "30px",
          className: "dt-left",
          orderable: !1,
          render: function(t,a,l,s){
            return'\n<label class="checkbox checkbox-single">\n<input type="checkbox" value="" class="checkable"/>\n<span></span>\n</label>'
          }
        }
      ]
    });
    $('#id_Reload3').click(function () {
        grid.ajax.reload();
    });
    t.on("change",".group-checkable",(function(){
        var t = $(this).closest("table").find("td:first-child .checkable"),
        a = $(this).is(":checked");
        $(t).each((function(){
            a?($(this).prop("checked",!0),$(this).closest("tr").addClass("active")): ($(this).prop("checked",!1),
            $(this).closest("tr").removeClass("active"))
            //alert(a);
        }))
    })),

    t.on("change","tbody tr .checkbox",(function(){
        $(this).parents("tr").toggleClass("active");
        
    }));

    $('#getDataBtn').on('click',function(){
        var code = '';
         //console.log(data);
        t.find('tr.active').each(function(){

            var rowData = grid.row(this).data().register_doc_id;
            code += rowData+"_";
         });
        $('#regNumAll').val(code.replace(/(^_)|(_$)/g, ""));        
    });

    $("#form_add").submit(function(event){
        var regNumAll = $('#regNumAll').val();
        if(regNumAll==""){
            $('#idExpedition').val('').trigger("change");
            UIToastr.init('warning', 'checkbox in table'); 
            $('#kt_modal_Add').modal('hide');
            
            $("#form_add")[0].reset();
            return false;
        }
        $('#btnDownload').addClass("spinner spinner-right spinner-white pr-15", "Please wait");
        event.preventDefault(); 
        dataString = $("#form_add").serialize();

        // console.log(dataString);
        window.location= "<?php echo base_url(); ?>download/delivery_internal_doc/downloadExcel/?"+dataString;
         $("#id_Reload3").trigger('click'); 
        $('#idExpedition').val('').trigger("change");
        $("#form_add")[0].reset();        
        $('#kt_modal_Add').modal('hide');
        $('#btnDownload').removeClass("spinner spinner-right spinner-white pr-15", "Please wait");      
    });
</script>
