<section class="pt-3 pb-3 page-info section-padding border-bottom bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="<?php echo base_url(); ?>"><strong><span class="mdi mdi-home"></span> Home</strong></a> <span class="mdi mdi-chevron-right"></span> <a href="#">Checkout</a>
            </div>
        </div
    </div>
</section>

<div class="ship-process padding-top-30 padding-bottom-30">
    <div class="container">
        <ul class="row">

            <!-- Step 1 -->
            <li class="col-sm-3 current">
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
            <li class="col-sm-3">
                <div class="media-left"> <i class="fa fa-check"></i> </div>
                <div class="media-body"> <span>Step 4</span>
                    <h6>Confirmation</h6>
                </div>
            </li>
        </ul>
    </div>
</div>

<section class="cart-page section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-body cart-table">
                    <div class="table-responsive">
                        <table class="table cart_summary">
                            <thead>
                            <tr>
                                <th class="cart_product">Product</th>
                                <th class="text-center">Nama Produk</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Total</th>
                                <th class="action text-center"><i class="mdi mdi-delete-forever"></i></th>
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
                                    <td class="qty">
                                        <div class="input-group">
                                            <span class="input-group-btn"><button class="btn btn-theme-round btn-number" type="button" onclick="update_qty('kurang','<?php echo $items['rowid'];  ?>')">-</button></span>
                                            <input type="text" id="qty<?php echo $items['rowid']; ?>" max="10" min="1" value="<?php echo $items['qty'] ?>" class="form-control border-form-control form-control-sm input-number" name="quant[]">
                                            <span class="input-group-btn"><button class="btn btn-theme-round btn-number" type="button" onclick="update_qty('tambah','<?php echo $items['rowid'];  ?>')">+</button>
                                       </span>
                                        </div>
                                    </td>
                                    <td class="price text-right"><span><?php echo (($position==0)?$currency . number_format($items['subtotal']):number_format($items['subtotal']). $currency) ?></span></td>
                                    <td class="action text-center">
                                        <a class="btn btn-sm btn-danger" data-original-title="Remove" href="#" title="" data-placement="top" data-toggle="tooltip" onclick="hapus_cart('<?php echo $items['rowid'];?>')"><i class="mdi mdi-close-circle-outline"></i></a>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot id="cart_footer">
                            <tr>
                                <td class="text-right" colspan="4"><strong>Subtotal :</strong></td>
                                <td class="text-right"
                                ><?php echo(($position == 0) ? $currency . number_format($this->cart->total()) : number_format($this->cart->total()) . $currency) ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2">
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
                                    <td colspan="2"></td>
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
                                <td class="text-right" colspan="4"><strong>Total Belanja</strong></td>
                                <td class="text-danger text-right">
                                    <strong><?php echo(($position == 0) ? $currency . " " . number_format($sub_total) : number_format($sub_total) . " " . $currency); ?> </strong>
                                </td>
                                <td></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="pro-btn">
                    <a href="#." class="btn btn-info">Lanjut Belanja</a>
                    <a href="<?php echo base_url('payment');?>" class="btn btn-success">Pembayaran</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">


    function update_qty(jenis,row_id)
    {

        var qty = $('#qty'+row_id).val();
        var jum_qty = 0;
        if(jenis == 'kurang')
        {
            jum_qty = parseInt(qty) - 1;
        }
        else
        {
            jum_qty = parseInt(qty) + 1;
        }



        if (row_id == 0) {
            alert('<?php echo 'Ada kesalahan';?>');
            return false;
        }
        if (jum_qty <= 0) {
            alert('<?php echo 'quantity tidak boleh dibawah 0';?>');
            return false;
        }
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('web/update_cart_item')?>',
            data: {row_id:row_id,qnty:jum_qty},
            success: function(data) {
                //console.log(data);
                $('#qty'+row_id).val(jum_qty);
                $(".cart-value").html(data);
                $("#cart-total-items").html("("+data+") item");
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







