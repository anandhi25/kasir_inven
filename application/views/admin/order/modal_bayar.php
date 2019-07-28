<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $title; ?></h4>
</div>

<div class="modal-body wrap-modal wrap" style="max-height: 700px;">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">Total Bayar <span class="required">*</span></label>
                <input type="text" name="total_bayar" readonly id="total_bayar" class="form-control">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1" id="uang_muka_lbl">Uang Muka <span class="required">*</span></label>
                <input type="text" name="uang_muka" id="uang_muka" class="form-control" autofocus>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1" id="sisa">Sisa Bayar <span class="required">*</span></label>
                <input type="text" name="sisa_bayar" readonly id="sisa_bayar" class="form-control">
            </div>

        </div>
    </div>
</div>

<div class="modal-footer" >
    <button type="button" class="btn btn-default pull-left" onclick="close_modal_submit()">Close</button>
    <button type="button" class="btn btn-primary pull-right" id="save_order_btn" onclick="simpan_order();">Simpan</button>
</div>

<script>
    function close_modal_submit() {
        $('#modal_submit').modal('toggle');
    }

    $("#modal_submit").on('shown.bs.modal', function () {

        if($('#form_order #order_payment_type').val() == 'cash')
        {
            $('#uang_muka_lbl').html('Jumlah Uang');
            $('#sisa').html('Kembalian');
        }

        if($('#form_order #down_payment').val() != '')
        {
            $('#uang_muka').val(numberWithCommas($('#form_order #down_payment').val()));
        }
        $('#total_bayar').val($('#form_order #grand_total_txt').html());
        $('#sisa_bayar').val($('#form_order #grand_total_txt').html());
        $('#uang_muka').on('input change',function () {
            var uang_muka = $(this).val();
            var grand_total = $('#form_order #grand_total_txt').html();
            if(uang_muka != '')
            {
                var isi = removeCommas(uang_muka);
                var hit = removeCommas(grand_total) -  isi;
                $('#uang_muka').val(numberWithCommas(isi.toString()));
                $('#form_order #down_payment').val(isi.toString());

                $('#sisa_bayar').val(numberWithCommas(hit));
            }
            else
            {
                $('#sisa_bayar').val(numberWithCommas(grand_total));
            }

        });
    });

    function simpan_order() {
        $('#form_order').submit();
    }
</script>