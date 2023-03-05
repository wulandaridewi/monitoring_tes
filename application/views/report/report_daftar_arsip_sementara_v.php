<style type="text/css">
    .btn-secondary{border-style: solid;
  border-color: white;}
</style>
<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                <span class="kt-font-brand kt-font-bold"><h5><i class="<?php echo $menu_icon; ?>"></i>&nbsp;&nbsp;<?php echo strtoupper($menu_nama); ?></h5></span>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-wrapper">
                <div class="kt-portlet__head-actions">
                    <a href="#" class="btn btn-brand btn-pill btn-sm" id="btnBackId" style="float: right;display: none;">
                        <i class="flaticon2-fast-back"></i>Back
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="tab-content">
            <div class="row" id="idDivHeader">
                <div class="col-md-12">                     
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>header id</th>
                                <th>Provinsi</th>
                                <th>Kota</th>
                                <th>Klasifikasi</th>
                                <th>Retensi</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <!-- <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>header id</th>
                                <th>Provinsi</th>
                                <th>Kota</th>
                                <th>Klasifikasi</th>
                                <th>Retensi</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot> -->
                    </table>
                </div>
            </div>  
            <div class="row" id="idDivData" style="display: none;">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_2">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Id Arsip Sementara</th>
                                        <th>Id Header</th>
                                        <th>Kode Lokasi</th>
                                        <th>Lokasi</th>
                                        <th>Deskripsi Dokumen</th>
                                        <th>Jumlah Map</th>
                                        <th>Jumlah Halaman</th>
                                        <th>No.Box</th>
                                        <th>Keterangan</th>
<!--                                         <th>Actions</th>
 -->                                    </tr>
                                </thead>
                                <tfoot>
                                    <!-- <tr>
                                        <th>No.</th>                                        
                                        <th>Id Arsip Sementara</th>
                                        <th>Id Header</th>
                                        <th>Kode Lokasi</th>
                                        <th>Lokasi</th>
                                        <th>Deskripsi Dokumen</th>
                                        <th>Jumlah Map</th>
                                        <th>Jumlah Halaman</th>
                                        <th>No.Box</th>
                                        <th>Keterangan</th>
                                        <th>Actions</th>
                                    </tr> -->
                                </tfoot>
                            </table>
                    </div>
                </div>            
            </div> 
        </div>
    </div>
</div>


<script type="text/javascript">
     jQuery(document).ready(function() {
        KTDatatablesSearchOptionsAdvancedSearch.init();

        
    });
var KTDatatablesSearchOptionsAdvancedSearch = function() {

    $.fn.dataTable.Api.register('column().title()', function() {
        return $(this.header()).text().trim();
    });

    var initTable1 = function() {
        // begin first table
        var table = $('#kt_table_1').DataTable({
            responsive: true,
            destroy : true,
            // Pagination settings
            dom: "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
            // dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
            // <'row'<'col-sm-12'tr>>
            // <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,

            // buttons: [
                
            // ],
            // bFilter: false, 
            // bInfo: false,
            lengthMenu: [5, 10, 25, 50],

            pageLength: 10,

            language: {
                'lengthMenu': 'Display _MENU_',
            },

            searchDelay: 500,
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?php echo base_url("/report/report_daftar_arsip_sementara/getHeaderArsipSementara"); ?>',
                type: 'POST',
                data: {
                    // parameters for custom backend script demo
                    columnsDef: [
                        'no', 'id_header', 'provinsi', 'kota', 'klasifikasi', 'retensi', 'Actions',],
                },
            },
            scrollY: '50vh',
            scrollX: true,
            scrollCollapse: true,
            columns: [
                {data: 'no'},
                {data: 'id_header'},
                {data: 'provinsi'},
                {data: 'kota'},
                {data: 'klasifikasi'},
                {data: 'retensi'},
                {data: 'Actions', responsivePriority: -1},
            ],

            initComplete: function() {
                    var thisTable = this;
                    var rowFilter = $('<tr class="filter"></tr>').appendTo($(table.table().header()));

                    this.api().columns().every(function() {
                        var column = this;
                        var input;

                        switch (column.title()) {
                            case 'Provinsi':
                            case 'Kota':
                            case 'Klasifikasi':
                            case 'Retensi':
                                input = $('<input type="text" class="form-control form-control-sm form-filter kt-input" data-col-index="' + column.index() + '"/>');
                                break;

                            case 'Actions':
                                var search = $('<button class="btn btn-brand kt-btn btn-sm kt-btn--icon" id="id_btn_search"><span><i class="la la-search"></i><span>Search</span></span></button><span>&nbsp;</span>');

                                var reset = $('<button class="btn btn-secondary kt-btn btn-sm kt-btn--icon"><span><i class="la la-close"></i><span>Reset</span></span></button>');

                                $('<th>').append(search).append(reset).appendTo(rowFilter);

                                $(search).on('click', function(e) {
                                    e.preventDefault();
                                    var params = {};
                                    $(rowFilter).find('.kt-input').each(function() {
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
                                    $(rowFilter).find('.kt-input').each(function(i) {
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

            columnDefs: [
                {
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function(ddata, type, row) {
                            return '<button type="button" class="btn btn-brand btn-elevate btn-pill btn-elevate-air btn-sm" onclick=view("'+row.id_header+'") title="View">'+
                                   'Daftar Berkas &nbsp;<i class="fa fa-folder-open" style="font-size: 14px;"></i></button> ';
                    },
                },
            ],
        });

        var filter = function() {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            table.column($(this).data('col-index')).search(val ? val : '', false, false).draw();
        };

        var asdasd = function(value, index) {
            var val = $.fn.dataTable.util.escapeRegex(value);
            table.column(index).search(val ? val : '', false, true);
        };

        $('#kt_search').on('click', function(e) {
            e.preventDefault();
            var params = {};
            $('.kt-input').each(function() {
                var i = $(this).data('col-index');
                if (params[i]) {
                    params[i] += '|' + $(this).val();
                }
                else {
                    params[i] = $(this).val();
                }
            });
            $.each(params, function(i, val) {
                // apply search params to datatable
                table.column(i).search(val ? val : '', false, false);
            });
            table.table().draw();
        });

        $('#kt_reset').on('click', function(e) {
            e.preventDefault();
            $('.kt-input').each(function() {
                $(this).val('');
                table.column($(this).data('col-index')).search('', false, false);
            });
            table.table().draw();
        });

        $('#kt_datepicker').datepicker({
            todayHighlight: true,
            templates: {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>',
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

function view(idHeader){

    // $('table#kt_table_2 tr:last-child').removeClass("filter");
    //Ajax Load data from ajax
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url(); ?>report/report_daftar_arsip_sementara/getDataRowTable",
        data: { idHeader: idHeader }, 
        success: function(data)
        {

            document.getElementById( 'idDivHeader' ).style.display = 'none';
            document.getElementById( 'btnBackId' ).style.display = 'block';
            document.getElementById( 'idDivData' ).style.display = 'block';
            var provinsi = data.provinsi;
            var kota = data.kota;
            var klasifikasi = data.klasifikasi;
            var retensi = data.retensi;
            initTable2(idHeader,provinsi,kota,klasifikasi,retensi);

        document.getElementById("kt_table_2_filter").style.visibility = "hidden";
            // $('.filter').find('tr:last-child').remove();
            // $('#kt_table_2 tr:last-child').removeClass("filter");
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });

    function initTable2(idHeader,provinsi,kota,klasifikasi,retensi) {
    //alert(idHeader);
    // begin first table
    var table = $('#kt_table_2').DataTable({
        responsive: true,
        destroy : true,
        dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
            <'row'<'col-sm-12'tr>>
            <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,

            buttons: [
                //'print',
                //'copyHtml5',
                {
                    extend: 'excelHtml5',
                    className: "btn btn-brand",
                    text: '<i class="fa fa-file-excel"></i>&nbsp;Excel',
                    filename: 'Report arsip Sementara',
                    title: '',
                    exportOptions: {
                        columns: [ 0, 3, 4, 5, 7, 8, 9 ]
                    },
                    customize: function ( xlsx ) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        //merger cell
                        var mergeCells = $('mergeCells', sheet);
 
                        mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                          attr: {
                            ref: 'A1:Q1',
                          }
                        } ) );

                        mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                          attr: {
                            ref: 'A2:Q2',
                          }
                        } ) );

                        mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                          attr: {
                            ref: 'A4:B4',
                          }
                        } ) );

                        mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                          attr: {
                            ref: 'C4:D4',
                          }
                        } ) );
                         mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                          attr: {
                            ref: 'A5:B5',
                          }
                        } ) );

                        mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                          attr: {
                            ref: 'C5:D5',
                          }
                        } ) );
                         mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                          attr: {
                            ref: 'A6:B6',
                          }
                        } ) );

                        mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                          attr: {
                            ref: 'C6:D6',
                          }
                        } ) );
                         mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                          attr: {
                            ref: 'A7:B7',
                          }
                        } ) );

                        mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                          attr: {
                            ref: 'C7:D7',
                          }
                        } ) );
                        mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                          attr: {
                            ref: 'A8:B8',
                          }
                        } ) );

                        mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                          attr: {
                            ref: 'C8:D8',
                          }
                        } ) );
         
                        mergeCells.attr( 'count', mergeCells.attr( 'count' )+1 );

                        // //add row
                        var numrows = 8;
                        var clR = $('row', sheet);
         
                        //update Row
                        clR.each(function () {
                            var attr = $(this).attr('r');
                            var ind = parseInt(attr);
                            ind = ind + numrows;
                            $(this).attr("r", ind);
                        });
         
                        // Create row before data
                        $('row c ', sheet).each(function () {
                            var attr = $(this).attr('r');
                            var pre = attr.substring(0, 1);
                            var ind = parseInt(attr.substring(1, attr.length));
                            ind = ind + numrows;
                            $(this).attr("r", pre + ind);
                        });
         
                        function Addrow(index, data) {
                          var msg = '<row r="' + index + '">'
                            for (var i = 0; i < data.length; i++) {
                                var key = data[i].key;
                                var value = data[i].value;
                                msg += '<c t="inlineStr" r="' + key + index + '">';
                                msg += '<is>';
                                msg += '<t>' + value + '</t>';
                                msg += '</is>';
                                msg += '</c>';
                            }
                            msg += '</row>';
                            return msg;
                        }
         
         
                        //insert 
                        
                        //$('c[r=A1] t', sheet).text( 'Custom text' );
                        //$('row c[r^="A1"]', sheet).attr( 's', '51' );
                        var r1 = Addrow(1, [{ key: 'A', value: 'DAFTAR PENYIMPANAN BERKAS SEMENTARA' }]);
                        var r2 = Addrow(2, [{ key: 'A', value: 'PT PERTAMINA (PERSERO)-DIREKTORAT MANAJEMEN ASET' }]);
                        var r3 = Addrow(4, [ { key: 'A', value: 'Provinsi' }]);
                        var r4 = Addrow(4, [{ key: 'C', value: ':' + provinsi + '' }]);
                        var r5 = Addrow(5, [ { key: 'A', value: 'Kota' }]);
                        var r6 = Addrow(5, [{ key: 'C', value: ':' + kota + '' }]);
                        var r7 = Addrow(6, [ { key: 'A', value: 'Klasifikasi' }]);
                        var r8 = Addrow(6, [{ key: 'C', value: ':' + klasifikasi + '' }]);
                        var r9 = Addrow(7, [ { key: 'A', value: 'Retensi' }]);
                        var r10 = Addrow(7, [{ key: 'C', value: ':' + retensi + '' }]);
                        sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2 + r3 + r4 + r5 + r6 + r7 + r8 + r9 + r10 + sheet.childNodes[0].childNodes[1].innerHTML;
                    },
                },
                //'csvHtml5',
                {
                    extend: 'pdfHtml5',
                    className: "btn btn-brand",
                    text: '<i class="fa fa-file-pdf"></i>&nbsp;PDF',
                    filename: 'Report Arsip Sementara',
                    // orientation: 'landscape',
                    // pageSize: 'LEGAL',
                    title:'',
                    exportOptions: {
                        columns: [ 0, 3, 4, 5, 7, 8, 9 ]
                    },
                    customize: function ( doc ) {                         
                        doc.content.splice( 0, 0, {
                            text: [{
                            text: 'DAFTAR PENYIMPANAN BERKAS SEMENTARA\n',
                            fontSize: 12,                            
                            alignment: 'center'
                          }, {
                            text: 'PT PERTAMINA (PERSERO)-DIREKTORAT MANAJEMEN ASET \n\n\n',
                            //bold: true,
                            fontSize: 12,
                            alignment: 'center'
                          }, {
                            text: 'Provinsi      : ' + provinsi + '\n',
                            fontSize: 11
                          }, {
                            text: 'Kota            : ' + kota + '\n',
                            fontSize: 11
                          }, {
                            text: 'Klasifikasi  : ' + klasifikasi + '\n',
                            fontSize: 11
                          }, {
                            text: 'retensi        : ' + retensi + '\n\n\n',
                            fontSize: 11
                          }],
                          margin: [0, 0, 0, 0],
                        } );
                        doc.defaultStyle.fontSize = 11; //<-- set fontsize to 16 instead of 10 
                        doc.styles.tableHeader.fontSize = 11;
                    }
                }
            ],
        lengthMenu: [5, 10, 25, 50],

        pageLength: 10,

        language: {
            'lengthMenu': 'Display _MENU_',
        },

        searchDelay: 500,
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?php echo base_url("/report/report_daftar_arsip_sementara/getArsipSementara"); ?>',
            type: 'POST',
            data: { idHeader: idHeader }, 
        },
        columns: [
            {data: 'no'},
            {data: 'id_arsip_sementara'},
            {data: 'id_header'},
            {data: 'kode_lokasi'},
            {data: 'lokasi'},
            {data: 'deskripsi_dokumen'},
            {data: 'jumlah_map'},
            {data: 'jumlah_halaman'},
            {data: 'no_box'},
            {data: 'keterangan'},
            // {data: 'Actions', responsivePriority: -1},
        ],
        initComplete: function() {
            var thisTable = this;
            var rowFilter = $('<tr class="filter" id="idFilter"></tr>').appendTo($(table.table().header()));
            // $('.filter').find('tr:last-child').remove();
            this.api().columns().every(function() {
                var column = this;
                var input;

                switch (column.title()) {
                    case 'Kode Lokasi':
                    case 'Lokasi':
                    case 'Deskripsi Dokumen':
                    case 'No.Box':
                    case 'Keterangan':
                        input = $('<input type="text" class="form-control form-control-sm form-filter kt-input" data-col-index="' + column.index() + '"/>');
                        break;

                    case 'Actions':
                        var search = $('<button class="btn btn-brand kt-btn btn-sm kt-btn--icon" id="id_btn_search2"><span><i class="la la-search"></i><span>Search</span></span></button><span>&nbsp;</span>');

                        var reset = $('<button class="btn btn-secondary kt-btn btn-sm kt-btn--icon"><span><i class="la la-close"></i><span>Reset</span></span></button>');

                        $('<th>').append(search).append(reset).appendTo(rowFilter);

                        $(search).on('click', function(e) {
                            e.preventDefault();
                            var params = {};
                            $(rowFilter).find('.kt-input').each(function() {
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
                            $(rowFilter).find('.kt-input').each(function(i) {
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
        columnDefs: [
            {
                targets: 0,
                width: '50px',
            },
            {
                targets: 1,                    
                visible: false,
                searchable: false,
            },
            {
                targets: 2,                    
                visible: false,
                searchable: false,
            },
        ],
    });

    $('#export_excel').on('click', function(e) {
        e.preventDefault();
        table.button(2).trigger();
    });
};
}

$('#btnBackId').on('click', function() {
    //alert('aaa');
    $('#idFilter').closest("tr").remove(); 
    $('#kt_table_2').empty();
    document.getElementById( 'idDivHeader' ).style.display = 'block';
    document.getElementById( 'btnBackId' ).style.display = 'none';
    document.getElementById( 'idDivData' ).style.display = 'none';
});

function _createNode( doc, nodeName, opts ) {
    var tempNode = doc.createElement( nodeName );

    if ( opts ) {
        if ( opts.attr ) {
          $(tempNode).attr( opts.attr );
        }

        if ( opts.children ) {
          $.each( opts.children, function ( key, value ) {
            tempNode.appendChild( value );
          } );
        }

        if ( opts.text !== null && opts.text !== undefined ) {
          tempNode.appendChild( doc.createTextNode( opts.text ) );
        }
    }

  return tempNode;
}

</script>