<section class="pt-3 pb-3 page-info section-padding border-bottom bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="<?php echo base_url();?>"><strong><span class="mdi mdi-home"></span> Home</strong></a> <span class="mdi mdi-chevron-right"></span> <a href="#">Cart</a>
            </div>
        </div>
    </div>
</section>
<?php
if ($this->cart->contents()) {
    ?>
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
                                    ?>
                                    <input type="hidden" name="row_id[]"
                                           id="row_id<?php echo $items['rowid']; ?>"
                                           value="<?php echo $items['rowid'] ?>">
                                    <tr>
                                        <td class="cart_product">
                                            <input type="hidden" name="product_id[]"
                                                   id="product_id<?php echo $items['rowid']; ?>"
                                                   value="<?php echo $items['product_id'] ?>">
                                            <img src="<?php echo base_url() . $items['image']; ?>" alt=""></td>
                                        <td class="cart_description">
                                            <h5 class="product-name"><a
                                                    href="<?php echo base_url() . "p/" . $items['product_id'] . '/' . seo_title($items['name']); ?>"><?php echo $items['name']; ?> </a>
                                            </h5>

                                        </td>
                                        <td class="price text-right">
                                            <span><?php echo(($position == 0) ? $currency . number_format($items['price']) : number_format($items['price']) . $currency) ?></span>
                                        </td>
                                        <td class="qty">
                                            <div class="input-group">
                                                <span class="input-group-btn"><button
                                                        class="btn btn-theme-round btn-number" type="button"
                                                        onclick="update_qty('kurang','<?php echo $items['rowid']; ?>')">-</button></span>
                                                <input type="text" id="qty<?php echo $items['rowid']; ?>" max="10"
                                                       min="1" value="<?php echo $items['qty'] ?>"
                                                       class="form-control border-form-control form-control-sm input-number"
                                                       name="quant[]">
                                                <span class="input-group-btn"><button
                                                        class="btn btn-theme-round btn-number" type="button"
                                                        onclick="update_qty('tambah','<?php echo $items['rowid']; ?>')">+</button>
                                       </span>
                                            </div>
                                        </td>
                                        <td class="price text-right">
                                            <span><?php echo(($position == 0) ? $currency . number_format($items['subtotal']) : number_format($items['subtotal']) . $currency) ?></span>
                                        </td>
                                        <td class="action text-center">
                                            <a class="btn btn-sm btn-danger" data-original-title="Remove" href="#"
                                               title="" data-placement="top" data-toggle="tooltip"
                                               onclick="hapus_cart('<?php echo $items['rowid']; ?>')"><i
                                                    class="mdi mdi-close-circle-outline"></i></a>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                                </tbody>
                                <tfoot id="cart_footer">
                                <tr>
                                    <td class="text-right" colspan="4"><strong>Subtotal :</strong></td>
                                    <td class="text-right"
                                        colspan="3"><?php echo(($position == 0) ? $currency . number_format($this->cart->total()) : number_format($this->cart->total()) . $currency) ?></td>
                                </tr>
                                <tr>
                                    <td colspan="1"></td>
                                    <td colspan="3">
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
                                    <td>Diskon</td>
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
                                </tr>
                                <?php
                                $sub_total = $this->cart->total() - $coupon_amnt;
                                if (get_tax() != '') {
                                    $hit_pajak = (get_tax()->tax_rate / 100) * $sub_total;
                                    $sub_total = $sub_total + $hit_pajak;
                                    ?>
                                    <tr>
                                        <td colspan="1"></td>
                                        <td class="text-right" colspan="3">PPN</td>
                                        <td></td>
                                        <td colspan="2"
                                            class="text-right"><?php echo(($position == 0) ? $currency . " " . number_format($hit_pajak) : number_format($hit_pajak) . " " . $currency); ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>

                                <tr>
                                    <td class="text-right" colspan="4"><strong>Total Belanja</strong></td>
                                    <td class="text-danger text-right" colspan="3">
                                        <strong><?php echo(($position == 0) ? $currency . " " . number_format($sub_total) : number_format($sub_total) . " " . $currency); ?> </strong>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <a href="<?php echo base_url() . "checkout"; ?>">
                            <button class="btn btn-secondary btn-lg btn-block text-left" type="button"><span
                                    class="float-left"><i
                                        class="mdi mdi-cart-outline"></i> Proceed to Checkout </span><span
                                    class="float-right"><strong><?php echo(($position == 0) ? $currency . " " . number_format($sub_total) : number_format($sub_total) . " " . $currency); ?></strong> <span
                                        class="mdi mdi-chevron-right"></span></span></button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}
else
{
    ?>
    <section class="cart-page section-padding">
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
