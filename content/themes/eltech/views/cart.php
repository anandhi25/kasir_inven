<style>
    .button {
        padding:5px; cursor:pointer; background:grey; color:white; width:25px; height:30px; text-align:center; display:inline-block;
    }

    .button:hover {
        background:black;
    }
    .input-qty{
        padding-top: 1px;width:50px;height:30px; text-align:center;
    }
</style>

<div id="content">

    <!-- Ship Process -->
    <div class="ship-process padding-top-30 padding-bottom-30">
        <div class="container">
            <ul class="row">

                <!-- Step 1 -->
                <li class="col-sm-3 current">
                    <div class="media-left"> <i class="flaticon-shopping"></i> </div>
                    <div class="media-body"> <span>Step 1</span>
                        <h6>Shopping Cart</h6>
                    </div>
                </li>

                <!-- Step 2 -->
                <li class="col-sm-3">
                    <div class="media-left"> <i class="flaticon-business"></i> </div>
                    <div class="media-body"> <span>Step 2</span>
                        <h6>Payment Methods</h6>
                    </div>
                </li>

                <!-- Step 3 -->
                <li class="col-sm-3">
                    <div class="media-left"> <i class="flaticon-delivery-truck"></i> </div>
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
    <?php
    if ($this->cart->contents()) {
        ?>
        <section class="shopping-cart padding-bottom-60">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th class="text-center">Harga</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Total</th>
                        <th><i class="mdi mdi-delete-forever"></i></th>
                    </tr>
                    </thead>
                    <tbody id="cart_body">
                    <?php $i = 1; ?>
                    <?php foreach ($this->cart->contents() as $items): ?>
                        <input type="hidden" name="row_id[]"
                               id="row_id<?php echo $items['rowid']; ?>"
                               value="<?php echo $items['rowid'] ?>">
                        <tr>
                            <td>
                                <input type="hidden" name="product_id[]"
                                       id="product_id<?php echo $items['rowid']; ?>"
                                       value="<?php echo $items['product_id'] ?>">
                                <div class="media">
                                    <div class="media-left"> <a href="<?php echo base_url() . "p/" . $items['product_id'] . '/' . seo_title($items['name']); ?>"> <img class="img-responsive" src="<?php echo base_url() . $items['image']; ?>" alt="" > </a> </div>
                                    <div class="media-body">
                                        <p><?php echo $items['name']; ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center padding-top-60">
                                <span><?php echo(($position == 0) ? $currency . number_format($items['price']) : number_format($items['price']) . $currency) ?></span>
                            </td>
                            <td class="qty text-center ">
                                <div class="input-group padding-top-20">
                                    <span class="plus button" onclick="update_qty('kurang','<?php echo $items['rowid']; ?>')">-</span>
                                    <input type="text" id="qty<?php echo $items['rowid']; ?>" max="10"
                                           min="1" value="<?php echo $items['qty'] ?>"
                                          class="input-qty"
                                           name="quant[]">
                                    <span class="min button"  onclick="update_qty('tambah','<?php echo $items['rowid']; ?>')">+</span>
                                </div>
                            </td>
                            <td class="price text-right padding-top-60">
                                <span><?php echo(($position == 0) ? $currency . number_format($items['subtotal']) : number_format($items['subtotal']) . $currency) ?></span>
                            </td>
                            <td class="action text-center padding-top-60">
                                <a href="#" class="remove" onclick="hapus_cart('<?php echo $items['rowid']; ?>')"><i class="fa fa-close"></i></a>

                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot id="cart_footer">
                    <tr>
                        <td class="text-right" colspan="3"><strong>Subtotal :</strong></td>
                        <td class="text-right"
                           ><?php echo(($position == 0) ? $currency . number_format($this->cart->total()) : number_format($this->cart->total()) . $currency) ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <form class="form-inline float-right"
                                  action="<?php echo base_url('web/apply_coupon') ?>" method="post">
                                <div class="form-group">
                                    <input type="text" name="coupon_code"
                                           placeholder="<?php echo 'Masukkan kode kupon'; ?>"
                                           class="form-control border-form-control form-control-sm">
                                </div>
                                &nbsp;
                                <button class="btn btn-success float-left btn-sm"
                                        type="submit"><?php echo 'Apply kupon'; ?></button>
                            </form>
                        </td>
                        <td colspan="2" class="text-right"><strong>Diskon</strong></td>
                        <td class="text-right">
                            <?php
                            $coupon_amnt = $this->session->userdata('coupon_amnt');
                            if ($coupon_amnt > 0) {
                                echo(($position == 0) ? $currency . " " . number_format($coupon_amnt) : number_format($coupon_amnt) . " " . $currency);
                            } else {
                                echo '0';
                                $coupon_amnt = 0;
                            }
                            ?>
                        </td>
                        <td></td>
                    </tr>
                    <?php
                    $sub_total = $this->cart->total() - $coupon_amnt;
                    if (get_tax() != '') {
                        $hit_pajak = (get_tax()->tax_rate / 100) * $sub_total;
                        $sub_total = $sub_total + $hit_pajak;
                        ?>
                        <tr>
                            <td colspan="1"></td>
                            <td></td>
                            <td class="text-right">PPN</td>

                            <td
                                class="text-right"><?php echo(($position == 0) ? $currency . " " . number_format($hit_pajak) : number_format($hit_pajak) . " " . $currency); ?></td>
                            <td></td>
                        </tr>
                        <?php
                    }
                    ?>

                    <tr>
                        <td class="text-right" colspan="3"><strong>Total Belanja</strong></td>
                        <td class="text-danger text-right">
                            <strong><?php echo(($position == 0) ? $currency . " " . number_format($sub_total) : number_format($sub_total) . " " . $currency); ?> </strong>
                        </td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>
                    </div>
                </div>
                <div class="pro-btn"><a href="#." class="btn-round btn-light">Continue Shopping</a>
                    <a href="<?php echo base_url('payment');?>" class="btn-round">Payment Methods</a></div>
            </div>
        </section>
        <?php
    }
    else
    {
        ?>
    <section class="shopping-cart padding-bottom-60">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center;"><center>
                        <img src="<?php echo base_url()?>assets/website/img/oops.png" alt="oops image">
                        <h2 class="page_title"><?php echo 'Daftar belanja anda masih kosong';?></h2>
                        <a href="<?php echo base_url()?>" class="base_button btn btn-secondary"><?php echo 'Belanja Sekarang';?></a>
                    </center>
                </div>
            </div>
        </div>
    </section>
    <?php
    }
    ?>
</div>

<script type="text/javascript">


    function update_qty(jenis,row_id)
    {
        var qty = $('#qty'+row_id).val();
        var row_id = $('#row_id'+row_id).val();
        var jum_qty = 0;
        if(jenis == 'kurang')
        {
            jum_qty = parseInt(qty) - 1;
        }
        else
        {
            jum_qty = parseInt(qty) + 1;
        }
        //  console.log(jum_qty);
        //add_to_cart_btn(product_id,jum_qty);


        if (row_id == 0) {
            alert('<?php echo 'Ada kesalahan';?>');
            return false;
        }
        if (jum_qty <= 0) {
            alert('<?php echo 'quantity tidak boleh dibawah 0';?>');
            return false;
        }


        $.ajax({
            type: "post",
            async: true,
            url: '<?php echo base_url('web/update_cart_item')?>',
            data: {row_id:row_id,qnty:jum_qty},
            success: function(data) {
                $('#qty'+row_id).val(jum_qty);
                $(".cart-value").html(data);
                $("#cart-total-items").html("("+data+") item");
                $(".itm-cont").html(data);
                // $("#cart-side").load(location.href+" #cart-side>*","");
                // loadAwal();
                $("#cart-body").load(location.href+" #cart-body>*","");
                $("#cart-footer").load(location.href+" #cart-footer>*","");
                $("#cart_body").load(location.href+" #cart_body>*","");
                $("#cart_footer").load(location.href+" #cart_footer>*","");

            },
            error: function() {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    }
</script>