/**
 * DECLARATION
 */
$("#id_btnSimpan").click(function () {
    $('#idTmpAksiBtn').val('1');
});

$('#id_btnUbah').click(function () {
    $('#idTmpAksiBtn').val('2');
});
$('#id_btnHapus').click(function () {
    $('#idTmpAksiBtn').val('3');
});
var tgltrans = $('#id_sessTgltrans').text();
        tgltrans = tgltrans.trim();
        $('.cls_tglhariini_static').val(tgltrans.trim());
        
function tglTransStart() {
    var tgltrans = $('#id_sessTgltrans').text();

    tgltrans = tgltrans.trim();
    $('#id_tgltrans').val(tgltrans.trim());
    $('.cls_tglhariini').val(tgltrans.trim());

    var parts = tgltrans.split("-");// tanggal displit
    var tglSekarang = new Date(parts[2], parts[1] - 1, parts[0]);
    tglSekarang.setMonth(tglSekarang.getMonth() + 1);
    var tglSekarangKemudian = new Date(parts[2], parts[1] - 1, parts[0]);
    tglSekarangKemudian.setMonth(tglSekarangKemudian.getMonth() + 1);

    //tglJadwal.setDate(tglJadwal.getDate() + 14);

    //==========================Tanggal 3 hari lalu===================================
    tglSekarang.setDate(tglSekarang.getDate() - 3);
    var tgl3HariLalu = tglSekarang;
    
    var hari = tgl3HariLalu.getDate();
     var bulan = tgl3HariLalu.getMonth();
     var tahun = tgl3HariLalu.getFullYear();
     
     if (hari < 10) {
     hari = '0' + hari
     }
     if (bulan < 10 && bulan > 0) {
     bulan = '0' + bulan
     } else if (bulan == 0) {
     bulan = '12';
     tahun = tahun - 1;
     }
     
     tgl3HariLalu = hari + '-' + bulan + '-' + tahun;
     $('.cls_3harilalu').val(tgl3HariLalu);
     //==========================End Tanggal 3 hari lalu===================================
     
     //==========================Tanggal 3 hari kemudian===================================
    tglSekarangKemudian.setDate(tglSekarangKemudian.getDate() + 3);
    var tgl3HariKemudian = tglSekarangKemudian;
    
    var hari = tgl3HariKemudian.getDate();
     var bulan = tgl3HariKemudian.getMonth();
     var tahun = tgl3HariKemudian.getFullYear();
     
     if (hari < 10) {
     hari = '0' + hari
     }
     if (bulan < 10 && bulan > 0) {
     bulan = '0' + bulan
     } else if (bulan == 0) {
     bulan = '12';
     tahun = tahun - 1;
     }
     
     tgl3HariKemudian = hari + '-' + bulan + '-' + tahun;
     $('.cls_3harikemudian').val(tgl3HariKemudian);
     //==========================End Tanggal 3 hari kemudian===================================
     

    //==========================Tanggal bulan lalu===================================
    /*
     var hari = tglSekarang.getDate();
     var bulan = tglSekarang.getMonth();
     bulan = bulan - 1;
     var tahun = tglSekarang.getFullYear();
     
     if (hari < 10) {
     hari = '0' + hari
     }
     if (bulan < 10 && bulan > 0) {
     bulan = '0' + bulan
     } else if (bulan == 0) {
     bulan = '12';
     tahun = tahun - 1;
     }
     
     tglJadwalBulanLalu = hari + '-' + bulan + '-' + tahun;
     
     $('.cls_tglbulanlalu').val(tglJadwalBulanLalu);
     */
    //========================End Tangga Bulan lalu======================================




}
function readyToStart() {
    //alert("");
    $(".nomor").val("0.00");
    $(".nomor").focus(function () {
        if ($(this).val() == '0.00') {
            $(this).val('');
        } else {
            this.select();
        }
    });
    $(".nomor").focusout(function () {
        if ($(this).val() == '') {
            $(this).val('0.00');
        } else {
            var angka = $(this).val();
            $(this).val(number_format(angka, 2));
        }
    });
    $(".nomor").keyup(function () {
        var val = $(this).val();
        if (isNaN(val)) {
            val = val.replace(/[^0-9\.]/g, '');
            if (val.split('.').length > 2)
                val = val.replace(/\.+$/, "");
        }
        $(this).val(val);

    });

    $(".nomor1").val("0");
    $(".nomor1").focus(function () {
        if ($(this).val() == '0') {
            $(this).val('');
        } else {
            this.select();
        }
    });
    $(".nomor1").focusout(function () {
        var val = $(this).val();
        if ($(this).val() == '') {
            $(this).val('0');
        } else {
            $(this).val(val);
        }
    });
    $(".nomor1").keyup(function () {
        var val = $(this).val();
        if (val>0) {
            val = val.replace(/[^0-9\.]/g, '');
            if (val.length > 2)
                val = val.replace(/\.+$/, "");
        }
        $(this).val(val);

    });
    $(".nomor3").val("0.000");
    $(".nomor3").focus(function () {
        if ($(this).val() == '0.000') {
            $(this).val('');
        } else {
            this.select();
        }
    });
    $(".nomor3").focusout(function () {
        if ($(this).val() == '') {
            $(this).val('0.000');
        } else {
            var angka = $(this).val();
            $(this).val(number_format(angka, 3));
        }
    });
    $(".nomor3").keyup(function () {
        var val = $(this).val();
        if (isNaN(val)) {
            val = val.replace(/[^0-9\.]/g, '');
            if (val.split('.').length > 2)
                val = val.replace(/\.+$/, "");
        }
        $(this).val(val);

    });
}
function startCheckBox() {
    $(".checker span").removeClass("checked");
}
function resetForm() {
    $("form input:text:not(.cls_tidakkosong)").val('');
    $("form input:password").val('');
    $("form input[type=email]").val('');
    $("form textarea").val('');
    $("form select").val('');
    $("#event_result").empty();
    //$("form select").select2("val","");
    //$('.select2me').select2("val", "");
}
/**
 * FUNCTION
 */
function btnStart() {
    $('#id_btnSimpan').attr("disabled", false);
    $('#id_btnUbah').attr("disabled", true);
    $('#id_btnHapus').attr("disabled", true);

}
var UIBootbox = function () {
    var o = function () {

    };
    return{init: function () {
            o();
        }};
}();
function ajaxModal() {
    $(document).ajaxStart(function () {
        $('.modal_json').fadeIn('fast');
    }).ajaxStop(function () {
        $('.modal_json').fadeOut('fast');
    });
}
function CleanNumber(value) {
    newValue = value.replace(/\,/g, '');
    return newValue;
}
var UIToastr = function () {
    return {
        //main function to initiate the module
        init: function (tipeAlert, pesan) {
            var i = -1,
                    toastCount = 0

            var shortCutFunction = tipeAlert;//"success";
            var msg = pesan;//"Data berhasil disimpan.";
            var title = 'Notification';
            var $showDuration = 300;
            var $hideDuration = 300;
            var $timeOut = 2000;
            var $extendedTimeOut = 500;
            var $showEasing = "swing";
            var $hideEasing = "linear";
            var $showMethod = "fadeIn";
            var $hideMethod = "fadeOut";
            var toastIndex = toastCount++;

            toastr.options = {
                closeButton: "checked",
                debug: "checked",
                positionClass: 'toast-top-right',
                onclick: null
            };
            var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists

        }

    };

}();

function validatedate(inputText, vbl) {
    var dateformat = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
    // Match the date format through regular expression  
    if (inputText.match(dateformat)) {
        // document.form1.text1.focus();  
        //Test which seperator is used '/' or '-'  
        var opera1 = inputText.split('/');
        var opera2 = inputText.split('-');
        lopera1 = opera1.length;
        lopera2 = opera2.length;
        // Extract the string into month, date and year  
        if (lopera1 > 1) {
            //var pdate = inputText.split('/');  
            alert('Format tanggal salah!');
            $(vbl).focus();
            return false;
        } else if (lopera2 > 1) {
            var pdate = inputText.split('-');
            var dd = parseInt(pdate[0]);
            var mm = parseInt(pdate[1]);
            var yy = parseInt(pdate[2]);
            // Create list of days of a month [assume there is no leap year by default]  
            var ListofDays = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
            if (mm == 1 || mm > 2) {
                if (dd > ListofDays[mm - 1]) {
                    alert('Format tanggal salah!');
                    $(vbl).focus();
                    return false;
                }
            }
            if (mm == 2) {
                var lyear = false;
                if ((!(yy % 4) && yy % 100) || !(yy % 400)) {
                    lyear = true;
                }
                if ((lyear == false) && (dd >= 29)) {
                    alert('Format tanggal salah!');
                    $(vbl).focus();
                    return false;
                }
                if ((lyear == true) && (dd > 29)) {
                    alert('Format tanggal salah!');
                    $(vbl).focus();
                    return false;
                }
            }//if (mm==2){  
        }

    } else {
        alert("Format tanggal salah!");
        $(vbl).focus();
        return false;
    }
}  //function validatedate(inputText)
function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

var th = ['', 'ribu', 'juta', 'milyar', 'trilyun'];
var dg = ['nol', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'];
var tn = ['sepuluh', 'sebelas', 'dua belas', 'tiga belas', 'empat belas', 'lima belas', 'enam belas', 'tujuh belas', 'delapan belas', 'sembilan belas'];
var tw = ['dua puluh', 'tiga puluh', 'empat puluh', 'lima puluh', 'enam puluh', 'tujuh puluh', 'delapan puluh', 'sembilan puluh'];
function toWords(s) {
    s = s.toString();
    s = s.replace(/[\, ]/g, '');
    if (s != parseFloat(s))
        return 'bukan angka';
    var x = s.indexOf('.');
    if (x == -1)
        x = s.length;
    if (x > 15)
        return 'terlalu besar';
    var n = s.split('');
    var str = '';
    var sk = 0;
    for (var i = 0; i < x; i++) {
        if ((x - i) % 3 == 2) {
            if (n[i] == '1') {
                str += tn[Number(n[i + 1])] + ' ';
                i++;
                sk = 1;
            } else if (n[i] != 0) {
                str += tw[n[i] - 2] + ' ';
                sk = 1;
            }
        } else if (n[i] != 0) {
            str += dg[n[i]] + ' ';
            if ((x - i) % 3 == 0)
                str += 'ratus ';
            sk = 1;
        }
        if ((x - i) % 3 == 1) {
            if (sk)
                str += th[(x - i - 1) / 3] + ' ';
            sk = 0;
        }
    }
    if (x != s.length) {
        var y = s.length;
        str += 'koma ';
        for (var i = x + 1; i < y; i++)
            str += dg[n[i]] + ' ';
    }
    return str.replace(/\s+/g, ' ');
}
var UIBootbox = function () {
    var o = function () {

    };
    return{init: function () {
            o();
        }};
}();
var ComponentsSelect2 = function () {
    var e = function () {

    };
    return{init: function () {
            e();
        }};
}();
var ComponentsDateTimePickers = function () {
    var t = function () {
        jQuery().datepicker && $(".date-picker").datepicker({rtl: App.isRTL(), orientation: "bottom", autoclose: !0}), $(document).scroll(function () {
            //$("#form_modal2 .date-picker").datepicker("place")
        });
    };
    return{init: function () {
            t();
        }};
}();

