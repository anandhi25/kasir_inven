<section class="pt-3 pb-3 page-info section-padding border-bottom bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="<?php echo base_url(); ?>"><strong><span class="mdi mdi-home"></span> Home</strong></a> <span class="mdi mdi-chevron-right"></span> <a href="#">Payment</a>
            </div>
        </div
    </div>
</section>

<div class="ship-process padding-top-30 padding-bottom-30">
    <div class="container">
        <ul class="row">

            <!-- Step 1 -->
            <li class="col-sm-3">
                <div class="media-left"> <i class="fa fa-shopping-cart"></i> </div>
                <div class="media-body"> <span>Step 1</span>
                    <h6>Shopping Cart</h6>
                </div>
            </li>

            <!-- Step 2 -->
            <li class="col-sm-3 current">
                <div class="media-left"> <i class="fa fa-credit-card"></i> </div>
                <div class="media-body"> <span>Step 2</span>
                    <h6>Payment Methods</h6>
                </div>
            </li>

            <!-- Step 3 -->
            <li class="col-sm-3">
                <div class="media-left"> <i class="fa fa-truck"></i> </div>
                <div class="media-body"> <span>Step 3</span>
                    <h6>Delivery Methods</h6>
                </div>
            </li>

            <!-- Step 4 -->
            <li class="col-sm-3">
                <div class="media-left"> <i class="fa fa-check"></i> </div>
                <div class="media-body"> <span>Step 4</span>
                    <h6>Confirmation</h6>
                </div>
            </li>
        </ul>
    </div>
</div>

<section class="account-page section-padding">
    <div class="container">
        <div class="row">
                    <div class="col-md-8">
                        <form method="post" action="<?php echo base_url('account/save_temp_payment');?>" id="payment_form">
                        <div class="heading">
                            <h2>Metode Pembayaran</h2>
                            <hr>
                        </div>

                        <?php
                        if(count($payment_list) > 0)
                        {
                            foreach ($payment_list as $pay)
                            {
                                $check = '';
                                if(!empty($this->session->userdata('cart_payment')))
                                {
                                    if($this->session->userdata('cart_payment') == $pay->payment_id)
                                    {
                                        $check = 'checked';
                                    }
                                }
                                ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="radio">
                                            <input type="radio"
                                                   name="metode_bayar" <?php echo $check;?>
                                                   value="<?php echo $pay->payment_id; ?>"
                                                   id="<?php echo $pay->payment_id; ?>">

                                            <label for="<?php echo $pay->payment_id; ?>">
                                                <?php echo $pay->payment_name; ?> <span class="value-price"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        </form>
                    </div>


                    <div class="col-md-4">

                        <!-- Your information -->
                        <div class="heading">
                            <h2>Ringkasan Belanja</h2>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table">
                                    <tr>
                                        <td><strong>Subtotal :</strong></td>
                                        <td class="text-right"><?php echo(($position == 0) ? $currency . number_format($this->cart->total()) : number_format($this->cart->total()) . $currency) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Diskon :</strong></td>
                                        <td class="text-right"><?php
                                            $coupon_amnt = $this->session->userdata('coupon_amnt');
                                            if ($coupon_amnt > 0) {
                                                echo(($position == 0) ? $currency . " " . number_format($coupon_amnt) : number_format($coupon_amnt) . " " . $currency);
                                            } else {
                                                echo '0';
                                                $coupon_amnt = 0;
                                            }
                                            ?></td>
                                    </tr>
                                    <?php
                                    $sub_total = $this->cart->total() - $coupon_amnt;
                                    if (get_tax() != '') {
                                        $hit_pajak = (get_tax()->tax_rate / 100) * $sub_total;
                                        $sub_total = $sub_total + $hit_pajak;
                                        ?>
                                        <tr>
                                            <td><strong>PPN</strong></td>
                                            <td class="text-right"><?php echo(($position == 0) ? $currency . " " . number_format($hit_pajak) : number_format($hit_pajak) . " " . $currency); ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <td><strong>Total Belanja</strong></td>
                                        <td class="text-danger text-right">
                                            <strong><?php echo(($position == 0) ? $currency . " " . number_format($sub_total) : number_format($sub_total) . " " . $currency); ?> </strong>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </div>

        </div>
        <div class="pro-btn"> <a href="<?php echo base_url('cart');?>" class="btn btn-info">Keranjang belanja</a> <a href="#" onclick="save_payment();" class="btn btn-success">Alamat Pengiriman</a> </div>
    </div>
</section>

<script>
    function save_payment() {
        var form_payment = $('#payment_form');
        var data_post = form_payment.serializeArray();

        $.ajax({
            url: form_payment.attr('action'),
            type: 'POST',
            dataType: 'json',
            data: data_post,
        })
            .done(function(res) {
                if (res.success) {
                    window.location.href = "<?php echo base_url().'delivery';?>";

                }
                else {

                }

            })
            .fail(function() {

            })
            .always(function() {

            });
    }

</script>