<style>
    .check-item {

        margin: 0px;

        padding-bottom: 30px;

        margin-bottom: 30px;

        border-bottom: 1px solid #e8e8e8;

    }
</style>

<section class="pt-3 pb-3 page-info section-padding border-bottom bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="<?php echo base_url(); ?>"><strong><span class="mdi mdi-home"></span> Home</strong></a> <span class="mdi mdi-chevron-right"></span> <a href="#">Alamat Pengiriman</a>
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
            <li class="col-sm-3">
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
            <li class="col-sm-3 current">
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
        <form id="order_form" method="post" action="<?php echo base_url('web/save_order'); ?>">
            <div class="heading">
                <h2>Shopping Cart</h2>
                <hr>
            </div>

            <div class="table-responsive">
                <table class="table cart_summary">
                    <thead>
                    <tr>
                        <th class="cart_product">Product</th>
                        <th class="text-center">Nama Produk</th>
                        <th class="text-center">Harga</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">Total</th>
                    </tr>
                    </thead>
                    <tbody id="cart_body">
                    <?php $i = 1; ?>
                    <?php foreach ($this->cart->contents() as $items): ?>
                        <tr>
                            <td class="cart_product">
                                <input type="hidden" name="product_id[]"
                                       id="product_id<?php echo $items['rowid']; ?>"
                                       value="<?php echo $items['product_id'] ?>">
                                <img src="<?php echo base_url() . $items['image']; ?>" alt=""></td>
                            <td class="cart_description">
                                <h5 class="product-name"><a href="<?php echo base_url() . "p/" . $items['product_id'] . '/' . seo_title($items['name']); ?>"><?php echo $items['name']; ?> </a></h5>
                                <?php
                                $attr = get_arr_attribute($items['attribute']);
                                if(!empty($attr))
                                {
                                    echo '<p>'.$attr.'</p>';
                                }
                                ?>

                            </td>
                            <td class="price text-right"><span><?php echo (($position==0)?$currency . number_format($items['price']):number_format($items['price']). $currency) ?></span></td>
                            <td class="qty text-center ">
                                <span><?php echo $items['qty']; ?></span>

                            </td>
                            <td class="price text-right">
                                <span><?php echo(($position == 0) ? $currency . number_format($items['subtotal']) : number_format($items['subtotal']) . $currency) ?></span>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="heading col-sm-12 margin-top-50">
                <h2>Metode Pembayaran</h2>
                <hr>
            </div>
            <div class="col-sm-12">
            <!-- Check Item List -->
            <ul class="row check-item">
                <?php
                if(!empty($this->session->userdata('cart_payment')))
                {
                    $detail_pay = db_get_row_data('tbl_payment_method',array('payment_id' => $this->session->userdata('cart_payment')));

                    ?>
                    <li class="col-xs-6">
                        <p> <?php echo $detail_pay->payment_name;?></p>
                        <?php echo $detail_pay->description; ?>
                    </li>
                    <?php
                }
                ?>

            </ul>
            </div>

            <!-- Delivery infomation -->
            <div class="heading col-sm-12 margin-top-50">
                <h2>Alamat Pengiriman</h2>
                <hr>
            </div>
            <div class="col-sm-12">
            <!-- Information -->
                <ul class="row check-item infoma">
                    <li class="col-sm-4">
                        <h6>Nama Pembeli</h6>
                        <span><?php echo $customer->customer_name;?></span> </li>
                    <li class="col-sm-4">
                        <h6>No Telp</h6>
                        <span><?php
                            if(!empty($this->session->userdata('customer_phone')))
                            {
                                echo $this->session->userdata('customer_phone');
                            }
                            else
                            {
                                echo $customer->phone;
                            }
                            ?></span> </li>
                    <li class="col-sm-4">
                        <h6>Email</h6>
                        <span><?php echo $customer->email;?></span> </li>
                    <li class="col-sm-4">
                        <h6>Nama Penerima</h6>
                        <span><?php
                            if(!empty($this->session->userdata('customer_accept')))
                            {
                                echo $this->session->userdata('customer_accept');
                            }
                            else
                            {
                                echo $customer->customer_name;
                            }?></span> </li>
                    <li class="col-sm-4">
                        <h6>Propinsi</h6>
                        <span><?php
                            if(!empty($this->session->userdata('customer_state')))
                            {
                                $q_state = db_get_row_data('tbl_state',array('state_id' => $this->session->userdata('customer_state')));
                                echo $q_state->state_name;
                            }
                            else
                            {
                                echo '';
                            }?></span> </li>

                    <li class="col-sm-4">
                        <h6>Kota</h6>
                        <span><?php
                            if(!empty($this->session->userdata('customer_city')))
                            {
                                $q_city = db_get_row_data('tbl_city',array('city_id' => $this->session->userdata('customer_city')));
                                echo $q_city->city_name;
                            }
                            else
                            {
                                echo '';
                            }?></span> </li>
                    <li class="col-sm-4">
                        <h6>Kecamatan</h6>
                        <span><?php
                            $ongkir = 0;
                            if(!empty($this->session->userdata('customer_district')))
                            {
                                $q_disrict = db_get_row_data('tbl_district',array('district_id' => $this->session->userdata('customer_district')));
                                $ongkir = $q_disrict->fee;
                                echo $q_disrict->district_name;
                            }
                            else
                            {
                                echo '';
                            }?></span> </li>

                    <li class="col-sm-4">
                        <h6>Kode Pos</h6>
                        <span><?php
                            if(!empty($this->session->userdata('customer_zip')))
                            {
                                echo $this->session->userdata('customer_zip');
                            }
                            else
                            {
                                echo '';
                            }?></span> </li>

                    <li class="col-sm-4">
                        <h6>Alamat</h6>
                        <span><?php
                            if(!empty($this->session->userdata('customer_address')))
                            {
                                echo $this->session->userdata('customer_address');
                            }
                            else
                            {
                                echo '';
                            }?></span> </li>
                </ul>
            </div>

            <!-- Totel Price -->
            <div class="totel-price">
                <div class="row">
                    <div class="col-sm-6">
                        <label><strong>Note</strong></label>
                        <textarea name="note" id="note" class="form-control" rows="6"></textarea>
                    </div>
                    <div class="col-sm-6">
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
                                $sub_total = $sub_total + $ongkir;
                                ?>
                                <tr>
                                    <td><strong>PPN</strong></td>
                                    <td class="text-right"><?php echo(($position == 0) ? $currency . " " . number_format($hit_pajak) : number_format($hit_pajak) . " " . $currency); ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td><strong>Ongkos Kirim</strong></td>
                                <td class="text-right">
                                    <input type="hidden" name="ongkir" value="<?php echo $ongkir; ?>">
                                    <?php echo(($position == 0) ? $currency . " " . number_format($ongkir) : number_format($ongkir) . " " . $currency); ?>
                                </td>
                            </tr>
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
        <div class="pro-btn"> <a href="<?php echo base_url('delivery') ?>" class="btn btn-info">Alamat Pengiriman</a> <button type="button" onclick="submit_order();" class="btn btn-success">Checkout</button> </div>
    </div>
    </form>
</section>

<script>
    function submit_order() {
        bootbox.confirm({
            message: "Apakah data yang anda masukkan sudah benar?",
            buttons: {
                confirm: {
                    label: 'YA',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'TIDAK',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if(result)
                {
                    $('#order_form').submit();
                }
            }
        });
    }
</script>