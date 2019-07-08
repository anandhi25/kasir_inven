
//==========================================================
//  Time and Date Pickers
//==========================================================

$(function() {
    $('.timepicker').timepicker();

    $('.datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayBtn: "linked"
    });

    $('.monthyear').datepicker({
        autoclose: true,
        startView: 1,
        format: 'yyyy-mm',
        minViewMode: 1
    });
    $('.years').datepicker({
        startView: 2,
        format: 'yyyy',
        minViewMode: 2,
        autoclose: true
    });
});


//==========================================================
//  Tooltips icon
//==========================================================

$(function() {
    $('[data-toggle="tooltip"]').tooltip()
})

//==========================================================
//  Alert hide time set
//==========================================================

setTimeout(function() {
    $(".alert").fadeOut("slow", function() {
        $(".alert").remove();
    });

}, 3000);

//==========================================================
//  Select All Checkbox
//==========================================================

$(function() {

    $('#parent_present').on('change', function() {
        $('.child_present').prop('checked', $(this).prop('checked'));
    });
    $('.child_present').on('change', function() {
        $('#parent_present').prop($('.child_present:checked').length ? true : false);
    });
    $('#parent_absent').on('change', function() {
        $('.child_absent').prop('checked', $(this).prop('checked'));
    });
    $('.child_absent').on('change', function() {
        $('#parent_absent').prop($('.child_absent:checked').length ? true : false);
    });
});


//==========================================================
//  Print Area Select
//==========================================================
function print_invoice(printableArea) {

    var table = $('#dataTables-example').DataTable();
    table.destroy();

    //$('#dataTables-example').attr('id','none');
    var printContents = document.getElementById(printableArea).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    //$('table').attr('id','dataTables-example');
    location.reload(document.body.innerHTML = originalContents);
    //document.body.innerHTML = originalContents;
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function removeCommas(x) {
    var num1 = parseFloat(x.replace(/,/g, ''));
    return num1;
}

function show_notification(pesan,tipe='info') {
    $.notify({

        icon: 'glyphicon glyphicon-ok-sign',
        message: pesan
    },{
        // settings
        element: 'body',
        position: null,
        type: tipe,
        allow_dismiss: true,
        newest_on_top: false,
        showProgressbar: false,
        placement: {
            from: "top",
            align: "right"
        },
        offset: 60,
        spacing: 10,
        z_index: 1031,
        delay: 5000,
        timer: 1000,
        mouse_over: null,
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        },
        onShow: null,
        onShown: null,
        onClose: null,
        onClosed: null,
        icon_type: 'class',
        template: '<div data-notify="container" class="col-xs-11 col-sm-2 alert alert-{0}" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
            '</div>'
    });
}
