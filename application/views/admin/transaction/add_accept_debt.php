<!-- View massage -->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary">
                <div class="box-header box-header-background with-border">
                    <div class="col-md-offset-3">
                        <h3 class="box-title "><?php echo $title;?></h3>
                    </div>
                </div>
                <!-- /.box-header -->

                <!-- form start -->
                <form role="form" enctype="multipart/form-data" id="pay_debt_form" action="<?php echo $action_url;?>" method="post">
                    <input type="hidden" name="piutang_id" id="piutang_id" value="<?php if(!empty($pay)) echo $pay->piutang_id; ?>">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="col-xs-12">
                                    <div class="col-xs-9">
                                        <div class="form-group">
                                            <label for="customer_name">Customer <span class="required">*</span></label>
                                            <input type="text" name="customer_name" id="customer_name" placeholder="" readonly
                                                   value="<?php if(!empty($pay)) echo $pay->customer_name; ?>"
                                                   class="form-control" required>
                                            <input type="hidden" name="customer_id" id="customer_id" value="<?php if(!empty($pay)) echo $pay->customer_id; ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                            <label style="margin-top: 30px;">&nbsp;</label>
                                            <?php
                                            echo btn_view_custom('admin/transaction/modal_customer','btn btn-primary',"Cari");
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer_name">No Pembayaran <span class="required">*</span></label>
                                    <input type="text" name="no_pembayaran" id="no_pembayaran" placeholder="" readonly
                                           value="<?php if(!empty($pay)) echo $pay->piutang_no;else echo $code; ?>"
                                           class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="col-xs-12">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label for="customer_name">Tanggal <span class="required">*</span></label>
                                            <input type="text" name="tanggal" id="tanggal" placeholder=""
                                                   value="<?php if(!empty($pay)) echo $pay->piutang_date;else echo date('Y-m-d') ?>"
                                                   class="form-control datepicker" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer_name">Total Piutang <span class="required">*</span></label>
                                    <input type="text" name="sisa_piutang" id="sisa_piutang" placeholder="" readonly
                                           value="<?php if(!empty($pay)) echo number_format($sisa_piutang); ?>"
                                           class="form-control" required>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-xs-12">
                                <table class="table table-bordered table-striped" id="data_debt">
                                    <thead ><!-- Table head -->
                                    <tr>
                                        <th class="active">No Nota</th>
                                        <th class="active">Saldo Piutang</th>
                                        <th class="active">PPN</th>
                                        <th class="active">Potongan</th>
                                        <th class="active">Bayar</th>
                                        <th class="active">Sisa</th>
                                        <th class="active"></th>

                                    </tr>
                                    </thead><!-- / Table head -->
                                    <tbody id="debt_list"><!-- / Table body -->
                                    <?php
                                    if(!empty($pay)) {
                                        $get_all_detail = db_get_all_data('tbl_penerimaan_piutang_order', array('penerimaan_piutang_id' => $pay->piutang_id));
                                        if (count($get_all_detail) > 0) {
                                            foreach ($get_all_detail as $order) {
                                                echo '<tr>
                                                        <td style="vertical-align: middle;"><input type="hidden" name="order_no[]" value="'.$order->order_no.'"><input type="hidden" name="order_id[]" value="'.$order->order_id.'">'.$order->order_no.'</td>
                                                        <td><input type="text" name="saldo_piutang[]" readonly class="form-control input-saldo" value="'.number_format($order->saldo_piutang).'"></td>
                                                        <td style="vertical-align: middle;"><input type="hidden" name="pajak[]" value="'.number_format($order->ppn).'">'.number_format($order->ppn).'</td>
                                                        <td><input type="text" name="potongan[]" class="form-control input-potongan" value="'.number_format($order->potongan).'"></td>
                                                        <td><input type="text" name="bayar[]" class="form-control input-bayar" value="'.number_format($order->bayar).'"></td>
                                                        <td><input type="text" name="sisa_piutang[]" class="form-control input-sisa" value="'.number_format($order->sisa_piutang).'"></td>
                                                        <td><button type="button" name="hapus" id="hapus" class="btn btn-danger remove_row"><i class="fa fa-trash"></i></button></td>
                                                      </tr> ';
                                            }
                                        }
                                    }
                                    else
                                    {
                                        echo '<tr>
                                                <td colspan="6" style="text-align: center;">
                                                    Data masih kosong
                                                </td>
                                            </tr>';
                                    }
                                    ?>

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="4" style="text-align: right;vertical-align: middle;"><strong>Jumlah Pembayaran(Rp)</strong></td>
                                        <td colspan="2"><input type="text" class="form-control" style="text-align: right;" readonly name="jumlah_bayar" id="jumlah_bayar" value="<?php
                                            if(!empty($pay))
                                            {
                                                echo number_format($pay->total_bayar);
                                            }
                                            else
                                            {
                                                echo '0';
                                            }
                                            ?>"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: right;vertical-align: middle;"><strong>Jumlah Denda(Rp)</strong></td>
                                        <td colspan="2"><input type="text" class="form-control" style="text-align: right;" name="jumlah_denda" id="jumlah_denda" value="<?php
                                            if(!empty($pay))
                                            {
                                                echo number_format($pay->total_denda);
                                            }
                                            else
                                            {
                                                echo '0';
                                            }
                                            ?>"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: right;vertical-align: middle;"><strong>Total Pembayaran</strong></td>
                                        <td colspan="2"><input type="text" class="form-control" style="text-align: right;" readonly name="total_bayar" id="total_bayar" value="<?php
                                            if(!empty($pay))
                                            {
                                                echo number_format($pay->grand_total);
                                            }
                                            else
                                            {
                                                echo '0';
                                            }
                                            ?>"></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>

                        </div>
                    </div>
                    <br>

                </form>

            </div>
        </div>
    </div>
</section>

<script>
    $( document ).ready(function() {
        load_data_table();
        hitung_total_bayar();
    });

    function load_data_table() {
        $('table#data_debt tbody').on('change input', 'input.input-potongan', function() {
            var potonganEl = $(this);
            if(potonganEl.val() != '')
            {
                var tr = $(this).parents('tr');
                var saldoEl = tr.find('input.input-saldo');
                var bayarEl = tr.find('input.input-bayar');
                var saldo = 0;
                if(saldoEl.val() != '')
                {
                    saldo = removeCommas(saldoEl.val());
                }
                var potongan = removeCommas(potonganEl.val());
                var hitung_bayar = saldo - potongan;
                bayarEl.val(numberWithCommas(hitung_bayar));
                potonganEl.val(numberWithCommas(potongan.toString()));
            }
        });

        $('table#data_debt tbody').on('change input', 'input.input-bayar', function() {
            var bayarEl = $(this);
            if(bayarEl.val() != '')
            {
                var tr = $(this).parents('tr');
                var saldoEl = tr.find('input.input-saldo');
                var potonganEl = tr.find('input.input-potongan');
                var sisaEl = tr.find('input.input-sisa');
                var saldo = 0;
                if(saldoEl.val() != '')
                {
                    saldo = removeCommas(saldoEl.val());
                }

                var potongan = 0;
                if(potonganEl.val() != '')
                {
                    potongan = removeCommas(potonganEl.val());
                }
                var bayar = removeCommas(bayarEl.val());
                var hitung_bayar = saldo - potongan;
                var hitung_sisa = hitung_bayar - bayar;
                sisaEl.val(numberWithCommas(hitung_sisa));
                bayarEl.val(numberWithCommas(bayar.toString()));
            }
        });

        $('table#data_debt tbody').on('click', 'button.remove_row', function() {
            //console.log('tes');
            var tr = $(this).parents('tr');
            tr.remove();
            hitung_total_bayar();
        });

        $('#jumlah_denda').on('change input',function () {
            var dendaEl = $(this);
            if(dendaEl.val() != '')
            {
                var jumlah_bayar = 0;
                if($('#jumlah_bayar').val() != '')
                {
                    jumlah_bayar = removeCommas($('#jumlah_bayar').val());
                }
                var denda = removeCommas(dendaEl.val());
                var hitung_total_bayar = jumlah_bayar + denda;
                $('#total_bayar').val(numberWithCommas(hitung_total_bayar.toString()));
                $('#jumlah_denda').val(numberWithCommas(denda.toString()));
            }
        })
    }

    function hitung_total_bayar() {
        var sub = 0;
        $('table#data_debt tbody tr').each(function() {
            var subTotal = $(this).find('input.input-saldo');
            if (subTotal.val() != '') {
                var subTot = removeCommas(subTotal.val());
                sub = sub + subTot;
            }
        });
        var denda = 0;
        if($('#jumlah_denda').val() != '')
        {
            denda = removeCommas($('#jumlah_denda').val());
        }
        var hitung_total_bayar = sub + denda;
        $('#jumlah_bayar').val(numberWithCommas(sub.toString()));
        $('#total_bayar').val(numberWithCommas(hitung_total_bayar.toString()));
    }
</script>