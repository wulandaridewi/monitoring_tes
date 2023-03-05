<style type="text/css">
    .buttons-excel{border-style: solid;
  border-color: white;}
  .buttons-pdf{border-style: solid;
  border-color: white;}
</style>
<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon kt-font-brand kt-font-bold">
                <i class="<?php echo $menu_icon; ?>"></i>
            </span>
            <h3 class="kt-portlet__head-title">
                <span class="kt-font-brand kt-font-bold"><h5><?php echo strtoupper($menu_nama); ?></h5></span>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-wrapper">
                <div class="kt-portlet__head-actions">
                    <!-- <div class="dropdown dropdown-inline">
                        <button type="button" class="btn btn-brand btn-icon-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="la la-download"></i> Export
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <ul class="kt-nav">
                                <li class="kt-nav__section kt-nav__section--first">
                                    <span class="kt-nav__section-text">Export Tools</span>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link" id="export_print">
                                        <i class="kt-nav__link-icon la la-print"></i>
                                        <span class="kt-nav__link-text">Print</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link" id="export_copy">
                                        <i class="kt-nav__link-icon la la-copy"></i>
                                        <span class="kt-nav__link-text">Copy</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link" id="export_excel">
                                        <i class="kt-nav__link-icon la la-file-excel-o"></i>
                                        <span class="kt-nav__link-text">Excel</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link" id="export_csv">
                                        <i class="kt-nav__link-icon la la-file-text-o"></i>
                                        <span class="kt-nav__link-text">CSV</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link" id="export_pdf">
                                        <i class="kt-nav__link-icon la la-file-pdf-o"></i>
                                        <span class="kt-nav__link-text">PDF</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div> -->
                    <a href="#" class="btn btn-brand btn-pill btn-sm" id="btnBackId" style="float: right;display: none;">
                        <i class="flaticon2-fast-back"></i>Back
                    </a>
                    <!-- <a href="#" class="btn btn-brand btn-elevate btn-icon-sm">
                        <i class="la la-plus"></i>
                        New Record
                    </a> -->
                </div>
            </div>
        </div>
    </div>
    <div class="kt-portlet__body">
            <div class="row" id="idFormDesc" style="display: none;">
                <div class="col-md-12">
                    <h4><center><b>DAFTAR ARSIP PT PERTAMINA (PERSERO) - DIREKTORAT MANAJEMEN ASET</b></center></h4>
                    <h4><center><b>DAFTAR BERKAS</b></center></h4>
                    <label>&nbsp;</label>
                    <form class="cls_id_form_add" id="form_add" method="post" action="javascript:;" style="font-size: 14px;">
                        <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <span>Perusahaan</span>
                                        <span style="padding-right:1em;padding-left:7.6em">:</span>
                                        <span id="perusahaanIDReadOnly"></span>
                                    </div> 
                                    <div class="form-group">
                                        <span>Direktorat</span>
                                        <span style="padding-right:1em;padding-left:8.6em"display>:</span>
                                        <span id="direktoratIDReadOnly"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">                                 
                                    <div class="form-group">
                                        <span>Fungsi Pengelola Arsip</span>
                                        <span style="padding-right:1em;padding-left:2.5em">:</span>
                                        <span id="fungsiArsipIDReadOnly"></span>
                                    </div> 
                                    <div class="form-group">
                                        <span>Bulan, Tahun Pengolahan</span>
                                        <span style="padding-right:1em;padding-left:1em">:</span>
                                        <span id="bulanTahunIDReadOnly"></span>
                                    </div> 
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <span>Lokasi Pengolahan</span>
                                        <span style="padding-right:1em;padding-left:1.8em">:</span>
                                        <span id="lokasiIDReadOnly"></span>
                                    </div> 
                                </div>
                            </div>
                    </form>
                    <div class="kt-separator kt-separator--md kt-separator--dashed"></div>
                </div>
            </div>
            
            <!--begin: Search Form -->
            <div class="row" id="idFormSearch" style="display: none;">
                <div class="col-md-12">
                    <h5><u>Search :</u></h5>
                    <form class="kt-form kt-form--fit kt-margin-b-20">
                        <div class="row kt-margin-b-20">
                            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                                <label>Kode Klasifikasi:</label>
                                <input type="text" class="form-control kt-input" placeholder="" data-col-index="2">
                            </div>
                            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                                <label>Subjek Masalah:</label>
                                <input type="text" class="form-control kt-input" placeholder="" data-col-index="3">
                            </div>
                            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                                <label>Provinsi:</label>
                                <input type="text" class="form-control kt-input" placeholder="" data-col-index="4">
                            </div>
                            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                                <label>Kota / Kabupaten:</label>
                                <input type="text" class="form-control kt-input" placeholder="" data-col-index="5">
                            </div>
                        </div>
                        <div class="row kt-margin-b-20">
                            
                            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                                <label>Index Masalah:</label>
                                <input type="text" class="form-control kt-input" placeholder="" data-col-index="6">
                            </div>
                            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                                <label>Alamat:</label>
                                <input type="text" class="form-control kt-input" placeholder="" data-col-index="7">
                            </div>
                            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                                <label>Nama:</label>
                                <input type="text" class="form-control kt-input" placeholder="" data-col-index="8">
                            </div>
                            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                                <label>No. Pekerja:</label>
                                <input type="text" class="form-control kt-input" placeholder="" data-col-index="9">
                            </div>
                        </div>
    <!--                     <div class="kt-separator kt-separator--md kt-separator--dashed"></div>
     -->                    <div class="row">
                            <div class="col-lg-12">
                                <button class="btn btn-brand btn-brand--icon" id="kt_search">
                                    <span>
                                        <i class="la la-search"></i>
                                        <span>Search</span>
                                    </span>
                                </button>
                                &nbsp;&nbsp;
                                <button class="btn btn-secondary btn-secondary--icon" id="kt_reset">
                                    <span>
                                        <i class="la la-close"></i>
                                        <span>Reset</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>            
            </div>
            <div class="row" id="idDivHeader">
                <div class="col-md-12"> 
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1" width="100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>header id</th>
                                <th>Perusahaan</th>
                                <th>Direktorat</th>
                                <th>Fungsi Pengelola Arsip</th>
                                <th>Bulan, Tahun Pengolahan</th>
                                <th>Lokasi Pengolahan</th>
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
                 <div class="col-md-12"> 
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_2">
                        <thead>
                            <th>No.</th>
                                <th>Id Data Arsip</th>
<!--                                         <th>Id Header Data Arsip</th>
-->                                        <th>Kode Klasifikasi</th>
                                <!-- <th>Perusahaan</th>
                                <th>Direktorat</th> -->
                                <th>Subjek Masalah</th>
                                <th>Provinsi</th>
                                <th>Kota/Kabupaten</th>
                                <th>Index Masalah</th>
                                <th>Alamat</th>
                                <th>Nama</th>
                                <th>No. Pekerja</th>
                                <th>Kurun Waktu</th>
                                <th>Tingkat Perkembangan</th>
                                <th>No.Berkas</th>
                                <th>Jumlah Berkas</th>
                                <th>Jumlah Halaman</th>
                                <th>Gedung</th>
                                <th>Ruang</th>
                                <th>Rak</th>
                                <th>Baris</th>
                                <th>Box</th>
                                <th>No. Box Sementara</th>
                                <th>Keterangan</th>
                                <th>Tunjuk Silang</th>
<!--                                 <th>Actions</th>
 -->                        </thead>
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
        <!--end: Datatable -->
    </div>
</div>
<!-- begin:: Content -->
<script type="text/javascript">
jQuery(document).ready(function() {
    //alert('Masih eror button back');
    //KTDatatablesSearchOptionsAdvancedSearch.init();
    $.fn.dataTable.Api.register('column().title()', function() {
        return $(this.header()).text().trim();
    });


    initTable1();
    // var id_daftar_arsip = '2020061700002';
    // initTable2(id_daftar_arsip);
});
Inputmask().mask("kurunWaktuID");
var initTable1 = function() {

    $.fn.dataTable.Api.register('column().title()', function() {
        return $(this.header()).text().trim();
    });

    // begin first table
    var table = $('#kt_table_1').DataTable({
        responsive: true,

        // Pagination settings
        dom: "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
        // read more: https://datatables.net/examples/basic_init/dom.html


        lengthMenu: [5, 10, 25, 50],

        pageLength: 10,

        language: {
            'lengthMenu': 'Display _MENU_',
        },

        searchDelay: 500,
        processing: true,
        serverSide: true,
        ajax: {
                url: '<?php echo base_url("/report/report_daftar_berkas/getHeaderArsip"); ?>',
                type: 'POST',
                data: {
                    // parameters for custom backend script demo
                    columnsDef: [
                        'no', 'header_id_data_arsip', 'perusahaan', 'direktorat', 'fungsi_arsip', 'bulan_tahun', 'lokasi', 'Actions',],
                },
            },
        columns: [
            {data: 'no'},
            {data: 'header_id_data_arsip'},
            {data: 'perusahaan'},
            {data: 'direktorat'},
            {data: 'fungsi_arsip'},
            {data: 'bulan_tahun'},
            {data: 'lokasi'},
            {data: 'Actions', responsivePriority: -1},
        ],
        initComplete: function() {
            var thisTable = this;
            var rowFilter = $('<tr class="filter"></tr>').appendTo($(table.table().header()));

            this.api().columns().every(function() {
                var column = this;
                var input;

                switch (column.title()) {
                    case 'Perusahaan':
                    case 'Direktorat':
                    case 'Fungsi Pengelola Arsip': 
                    case 'Bulan, Tahun Pengolahan':                       
                    case 'Lokasi Pengolahan':
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
                width: '220px',
                render: function(ddata, type, row) {
                    return '<button type="button" class="btn btn-brand btn-elevate btn-pill btn-elevate-air btn-sm" onclick=view("'+row.header_id_data_arsip+'") title="View">'+
                                   'Daftar Berkas &nbsp;<i class="fa fa-folder-open" style="font-size: 14px;"></i></button> ';
                    // return '<a class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">'+
                    //        '<i class="flaticon-eye" onclick=view("'+row.id_daftar_arsip+'")></i></a> ';
                },
            },
            {
                targets: 1,                    
                visible: false,
                searchable: false,
            },

        ],
    });

};
function initTable2(header_id_data_arsip,perusahaan,direktorat,fungsi_arsip,bulan_tahun,lokasi) {
    // begin first table
    var table = $('#kt_table_2').DataTable({
        //responsive: true,
        // Pagination settings
        destroy : true,
        // dom: `<'row'<'col-sm-12'tr>>
        // <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
        // read more: https://datatables.net/examples/basic_init/dom.html
        dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
            <'row'<'col-sm-12'tr>>
            <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,

        lengthMenu: [5, 10, 25, 50],

        pageLength: 10,

        language: {
            'lengthMenu': 'Display _MENU_',
        },
        buttons: [
                //'print',
                //'copyHtml5',
                {
                    extend: 'excelHtml5',
                    className: "btn btn-brand",
                    text: '<i class="fa fa-file-excel"></i>&nbsp;Excel',
                    filename: 'Report Daftar Berkas',
                    title: '',
                    exportOptions: {
                        columns: [ 0, 2, 3, 4, 5, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22 ]
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

                        mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                          attr: {
                            ref: 'A9:B9',
                          }
                        } ) );

                        mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                          attr: {
                            ref: 'C9:D9',
                          }
                        } ) );
         
                        mergeCells.attr( 'count', mergeCells.attr( 'count' )+1 );

                        // //add row
                        var numrows = 9;
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
                        var r1 = Addrow(1, [{ key: 'A', value: 'DAFTAR ARSIP PT PERTAMINA (PERSERO) - DIREKTORAT MANAJEMEN ASET' }]);
                        var r2 = Addrow(2, [{ key: 'A', value: 'DAFTAR BERKAS' }]);
                        var r3 = Addrow(4, [ { key: 'A', value: 'Perusahaan' }]);
                        var r4 = Addrow(4, [{ key: 'C', value: ':' + perusahaan + '' }]);
                        var r5 = Addrow(5, [ { key: 'A', value: 'Direktorat' }]);
                        var r6 = Addrow(5, [{ key: 'C', value: ':' + direktorat + '' }]);
                        var r7 = Addrow(6, [ { key: 'A', value: 'Fungsi Pengelola Arsip' }]);
                        var r8 = Addrow(6, [{ key: 'C', value: ':' + fungsi_arsip + '' }]);
                        var r9 = Addrow(7, [ { key: 'A', value: 'Bulan, Tahun Pengolahan' }]);
                        var r10 = Addrow(7, [{ key: 'C', value: ':' + bulan_tahun + '' }]);
                        var r11 = Addrow(8, [ { key: 'A', value: 'Lokasi Pengolahan' }]);
                        var r12 = Addrow(8, [{ key: 'C', value: ': ' + lokasi + '' }]);
                        sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2 + r3 + r4 + r5 + r6 + r7 + r8 + r9 + r10 + r11 + r12 + sheet.childNodes[0].childNodes[1].innerHTML;
                    },
                },
                //'csvHtml5',
                {
                    extend: 'pdfHtml5',
                    className: "btn btn-brand",
                    text: '<i class="fa fa-file-pdf"></i>&nbsp;PDF',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    filename: 'Report Daftar Berkas',
                    title:'',
                    exportOptions: {
                        columns: [ 0, 2, 3, 4, 5, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22 ]
                    },
                    customize: function ( doc ) {                         
                        doc.content.splice( 0, 0, {
                            text: [{
                            text: 'DAFTAR ARSIP PT PERTAMINA (PERSERO) - DIREKTORAT MANAJEMEN ASET\n',
                            fontSize: 12,                            
                            alignment: 'center'
                          }, {
                            text: 'DAFTAR BERKAS \n\n\n',
                            //bold: true,
                            fontSize: 12,
                            alignment: 'center'
                          }, {
                            text: 'Perusahaan                         : ' + perusahaan + '\n',
                            fontSize: 11
                          }, {
                            text: 'Direktorat                             : ' + direktorat + '\n',
                            fontSize: 11
                          }, {
                            text: 'Fungsi Pengelola Arsip     : ' + fungsi_arsip + '\n',
                            fontSize: 11
                          }, {
                            text: 'Bulan, Tahun Pengolahan : ' + bulan_tahun + '\n',
                            fontSize: 11
                          }, {
                            text: 'lokasi                                    : ' + lokasi + '\n\n',
                            fontSize: 11
                          }],
                          margin: [0, 0, 0, 0],
                        } );
                        doc.defaultStyle.fontSize = 9; //<-- set fontsize to 16 instead of 10 
                        doc.styles.tableHeader.fontSize = 9;
                    }
                }
            ],
        // buttons: [
        //      'print',
        //      'copyHtml5',
        //      'excelHtml5',
        //      'csvHtml5',
        //      'pdfHtml5',
        //  ],
        searchDelay: 500,
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?php echo base_url("/report/report_daftar_berkas/getDataArsip"); ?>',
            type: 'POST',
            data: { header_id_data_arsip: header_id_data_arsip }, 
        },
        //scrollY: '50vh',
        scrollX: true,
        scrollCollapse: true,
        columns: [
            {data: 'no'},
            {data: 'id_daftar_arsip'},
            // {data: 'header_id_data_arsip'},
            {data: 'kode_klasifikasi'},
            // {data: 'perusahaan'},
            // {data: 'direktorat'},
            {data: 'subjek_masalah'},
            {data: 'provinsi'},
            {data: 'kota'},
            {data: 'indeks_masalah'},
            {data: 'alamat'},
            {data: 'nama'},
            {data: 'no_pekerja'},
            {data: 'kurun_waktu'},
            {data: 'tingkat_perkembangan'},
            {data: 'no_berkas'},
            {data: 'jumlah_berkas'},
            {data: 'jumlah_halaman'},
            {data: 'gedung'},
            {data: 'ruang'},
            {data: 'rak'},
            {data: 'baris'},
            {data: 'box'},
            {data: 'no_box_sementara'},
            {data: 'keterangan'},
            {data: 'tunjuk_silang'},
            // {data: 'Actions', responsivePriority: -1},
        ],

        initComplete: function() {
            this.api().columns().every(function() {
                var column = this;

                switch (column.title()) {
                    // case 'Alamat':
                    // case 'Nama':
                    // case 'No. Pekerja':
                    // case 'Kurun Waktu':
                    //                 input = $('<input type="text" class="form-control form-control-sm form-filter kt-input" data-col-index="' + column.index() + '"/>');
                    //                 break;
                }
            });
        },

        columnDefs: [
            {
                targets: 1,                    
                visible: false,
                searchable: false,
            },
            // {
            //     targets: 2,                    
            //     visible: false,
            //     searchable: false,
            // },
            //  {
            //     targets: 7,                    
            //     width:'20%',
            // },
            // {
            //     targets: 20,                    
            //     visible: false,
            //     searchable: false,
            // },
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

    // $('#kt_datepicker').datepicker({
    //  todayHighlight: true,
    //  templates: {
    //      leftArrow: '<i class="la la-angle-left"></i>',
    //      rightArrow: '<i class="la la-angle-right"></i>',
    //  },
    // });

    // $('#export_print').on('click', function(e) {
    //  e.preventDefault();
    //  table.button(0).trigger();
    // });

    // $('#export_copy').on('click', function(e) {
    //  e.preventDefault();
    //  table.button(1).trigger();
    // });

    // $('#export_excel').on('click', function(e) {
    //  //alert(e);
    //  e.preventDefault();
    //  table.button(2).trigger();
    // });

    // $('#export_csv').on('click', function(e) {
    //  e.preventDefault();
    //  table.button(3).trigger();
    // });

    // $('#export_pdf').on('click', function(e) {
    //  e.preventDefault();
    //  table.button(4).trigger();
    // });

};

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

function view(header_id_data_arsip){

        // $('#form_header_arsip')[0].reset(); 
        $('#idTextHidden').val('1');
        //$('#idHeaderRow').val(id_daftar_arsip);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>report/report_daftar_berkas/getDataRowTable",
            data: { header_id_data_arsip: header_id_data_arsip }, 
            success: function(data)
            {
                document.getElementById( 'idDivHeader' ).style.display = 'none';
                var perusahaan = data.perusahaan;
                var direktorat = data.direktorat;
                var fungsi_arsip = data.fungsi_arsip;
                var bulan_tahun = data.bulan_tahun;
                var lokasi = data.lokasi;
                document.getElementById('perusahaanIDReadOnly').textContent = data.perusahaan;
                document.getElementById('direktoratIDReadOnly').textContent = data.direktorat;
                document.getElementById('fungsiArsipIDReadOnly').textContent = data.fungsi_arsip;
                document.getElementById('bulanTahunIDReadOnly').textContent = data.bulan_tahun;
                document.getElementById('lokasiIDReadOnly').textContent = data.lokasi;
                //document.getElementById( 'idBtnHeader' ).style.display = 'block';
                document.getElementById( 'idDivData' ).style.display = 'block';
                document.getElementById( 'idFormSearch' ).style.display = 'block';
                document.getElementById( 'idFormDesc' ).style.display = 'block';
                document.getElementById( 'btnBackId' ).style.display = 'block';
                initTable2(header_id_data_arsip,perusahaan,direktorat,fungsi_arsip,bulan_tahun,lokasi);
                document.getElementById("kt_table_2_filter").style.visibility = "hidden";

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    $('#btnBackId').on('click', function() {
        //alert('aaa');
        //$('#idFilter').closest("tr").remove(); 
        $('#kt_table_2').empty();
        //$('#kt_table_2').button(2).remove();

        document.getElementById( 'idDivHeader' ).style.display = 'block';
        document.getElementById( 'idFormSearch' ).style.display = 'none';
        document.getElementById( 'btnBackId' ).style.display = 'none';
        document.getElementById( 'idDivData' ).style.display = 'none';
        document.getElementById( 'idFormDesc' ).style.display = 'none';
    });


</script>