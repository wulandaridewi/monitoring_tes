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
                <div class="row">
                    <div class="col-md-12">
                        <button id="id_Reload" style="display: none;"></button>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered table-hover table-checkable" id="kt_datatable_2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Register Id</th>
                                    <th>Register Date</th>
                                    <th>Type</th>
                                    <th>Document Description</th>
                                    <th>Owner</th>
                                    <th>Service</th>
                                    <th>Status Document</th>
                                    <th>Information</th>
                                    <th>Last Update</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>           
            </div>
        </div>    
    </div>
</div>
<!--end::Card-->

<script type="text/javascript">  
    jQuery(document).ready(function() {
        resetForm()
        KTDatatablesSearchOptionsColumnSearch.init();
    });

    var KTDatatablesSearchOptionsColumnSearch = function() {

        $.fn.dataTable.Api.register('column().title()', function() {
            return $(this.header()).text().trim();
        });

        var initTable1 = function() {

            // begin first table
            var table = $('#kt_datatable_2').DataTable({
                responsive: true,
                dom: "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                lengthMenu: [5, 10, 25, 50],
                pageLength: 10,
                language: {
                    'lengthMenu': 'Display _MENU_',
                },

                searchDelay: 500,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?php echo base_url("/report/report_regis/getDevAll"); ?>',
                    type: 'POST',
                    data: {
                        columnsDef: [
                            'no', 'register_doc_id', 'create_date', 'type', 'doc_description', 'name','service','status_doc', 'information', 'update_date', 'Actions',],
                    },
                },
                columns: [
                    {data: "no"},
                    {data: "register_doc_id"},
                    {data: "create_date"},
                    {data: "type"},
                    {data: "doc_description"},
                    {data: "name"},
                    {data: "service"},
                    {data: "status_doc"},
                    {data: "information"},
                    {data: "update_date"},
                    {data: "Actions", responsivePriority: -1},
                ],
                initComplete: function() {
                    var thisTable = this;
                    var rowFilter = $('<tr class="filter"></tr>').appendTo($(table.table().header()));

                    this.api().columns().every(function() {
                        var column = this;
                        var input;

                        switch (column.title()) {
                            case 'Register Id':
                            case 'Register Date':
                                input = $('<input type="text" class="form-control form-control-sm form-filter datatable-input" data-col-index="' + column.index() + '"/>');
                                break;

                            case 'Actions':
                                var search = $(`
                                    <button class="btn btn-primary kt-btn btn-sm kt-btn--icon d-block" id="id_btn_search">
                                        <span>
                                            <i class="flaticon-search"></i>
                                            <span>Search</span>
                                        </span>
                                    </button>`);

                                var reset = $(`
                                    <button class="btn btn-secondary kt-btn btn-sm kt-btn--icon">
                                        <span>
                                           <i class="flaticon2-cross"></i>
                                           <span>Reset</span>
                                        </span>
                                    </button>`);

                                $('<th>').append(search).append(reset).appendTo(rowFilter);
                                $(search).on('click', function(e) {
                                    e.preventDefault();
                                    var params = {};
                                    $(rowFilter).find('.datatable-input').each(function() {
                                        var i = $(this).data('col-index');

                                        if (params[i]) {
                                            params[i] += '|' + $(this).val();

                                        }
                                        else {
                                            params[i] = $(this).val();
                                        }
                                        //alert(params[i]);
                                    });
                                    $.each(params, function(i, val) {
                                        // apply search params to datatable
                                        table.column(i).search(val ? val : '', false, false);
                                    });
                                    table.table().draw();
                                });

                                $(reset).on('click', function(e) {
                                    e.preventDefault();
                                    $(rowFilter).find('.datatable-input').each(function(i) {
                                        $(this).val('');
                                        table.column($(this).data('col-index')).search('', false, false);
                                    });
                                    table.table().draw();
                                });
                                break;
                        }
                        if (column.title() !== 'Actions') {
                            $(input).appendTo($('<th>').appendTo(rowFilter));
                        }
                    });

                     // hide search column for responsive table
                     var hideSearchColumnResponsive = function () {
                       thisTable.api().columns().every(function () {
                           var column = this
                           if(column.responsiveHidden()) {
                               $(rowFilter).find('th').eq(column.index()).show();
                           } else {
                               $(rowFilter).find('th').eq(column.index()).hide();
                           }
                       })
                     };                     
                    // init on datatable load
                    hideSearchColumnResponsive();
                    // recheck on window resize
                    window.onresize = hideSearchColumnResponsive;
                    $('#kt_datepicker_1,#kt_datepicker_2').datepicker();
                },

            });

        };
        return {
            //main function to initiate the module
            init: function() {
                initTable1();
            },

        };
    }();

</script>
