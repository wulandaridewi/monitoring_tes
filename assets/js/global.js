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
            var $timeOut = 1000;
            var $extendedTimeOut = 200;
            var $showEasing = "swing";
            var $hideEasing = "linear";
            var $showMethod = "fadeIn";
            var $hideMethod = "fadeOut";
            var toastIndex = toastCount++;

            toastr.options = {
                closeButton: "checked",
                debug: "checked",
                positionClass: 'toast-top-right',
                //progressBar: 'true',
                onclick: null,
                //onHidden : setTimeout(function(){ location.reload(); }, 1000),
            };
            var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists

        }

    };

}();

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