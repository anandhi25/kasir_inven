<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<section class="pt-3 pb-3 page-info section-padding border-bottom bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="<?php echo base_url();?>"><strong><span class="mdi mdi-home"></span> Home</strong></a> <span class="mdi mdi-chevron-right"></span> <a href="<?php echo base_url('c/'.$product->category_id)?>"><?php echo $product->category_name?></a> <span class="mdi mdi-chevron-right"></span> <a href="#"><?php echo $product->product_name?></a>
            </div>
        </div>
    </div>
</section>

<section class="shop-single section-padding pt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="shop-detail-left">
                    <div class="shop-detail-slider">
                        <div class="favourite-icon">
                            <a class="fav-btn" title="" data-placement="bottom" data-toggle="tooltip" href="#" data-original-title="59% OFF"><i class="mdi mdi-tag-outline"></i></a>
                        </div>

                        <div id="sync1" class="owl-carousel">
                            <?php
                            if ($product_gallery_img) {
                                foreach ($product_gallery_img as $gallery) {
                                    ?>
                                    <div class="item"><img alt="" src="<?php echo base_url().$gallery->filename?>" class="img-fluid img-center"></div>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <div class="item"><img alt="" src="<?php echo base_url().$product->filename;?>" class="img-fluid img-center"></div>
                                <?php
                            }
                            ?>
                        </div>
                        <div id="sync2" class="owl-carousel">
                            <?php
                            if ($product_gallery_img) {
                                foreach ($product_gallery_img as $gallery) {
                                    ?>
                                    <div class="item"><img alt="" src="<?php echo base_url().$gallery->filename?>" class="img-fluid img-center"></div>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <div class="item"><img alt="" src="<?php echo base_url().$product->filename;?>" class="img-fluid img-center"></div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="shop-detail-right">
                    <?php
                    $price_discount = get_discount_offer($product->product_id);
                    $price = get_product_price($product->product_id);
                    if($price_discount != '0')
                    {
                        $persen = ($price_discount / $price) * 100;
                        echo '<span class="badge badge-success">'.$persen.'% OFF</span>';
                    }
                    ?>

                    <h2><?php echo $product->product_name?></h2>
                    <?php
                    if($price_discount != '0') {
                        ?>
                        <p class="regular-price"><i class="mdi mdi-tag-outline"></i> <?php echo number_format($price);?></p>
                        <p class="offer-price mb-0">Harga Diskon : <span class="text-success"><?php echo number_format($price_discount);?></span></p>
                        <?php
                    }
                    else
                    {

                        ?>
                        <p class="offer-price mb-0"><span class="text-success">Rp <?php echo number_format($price);?></span></p>
                        <?php
                    }
                    ?>
                    <?php
                    $stok = get_stock($product->product_code,get_frontend_store());
                    $text_stok = 'Tersedia';
                    $badge_stok = 'badge badge-success';
                    $btn_stok = 'class="btn btn-secondary btn-lg"';
                    if($stok <= 0)
                    {
                        $text_stok = 'Kosong';
                        $badge_stok = 'badge-danger';
                        $btn_stok = 'disabled class="btn btn-default btn-lg"';
                    }
                    ?>
                    <?php
                    if(get_product_variations($product->product_id) != '')
                    {
                    ?>
                    <p>&nbsp;</p>
                    <table class="variations" cellspacing="0">
                        <tbody>
                        <?php
                        echo get_product_variations($product->product_id);
                        ?>
                        </tbody>
                    </table>
                    <?php
                    }
                    ?>
                    <button type="button" onclick="add_to_cart_btn('<?php echo $product->product_id;?>')" <?php echo $btn_stok;?>><i class="mdi mdi-cart-outline"></i> Add To Cart</button>

                    <div class="short-description">
                        <h5>
                            Quick Overview
                            <p class="float-right">Availability: <span class="<?php echo $badge_stok;?>"><?php echo $text_stok;?></span></p>
                        </h5>
                        <?php if (!empty($product->product_note)) { ?>
                            <p class="mb-0"><?php echo character_limiter(strip_tags($product->product_note), 300);?></p>
                        <?php }
                        else
                        {
                            echo '<p class="mb-0">Deskripsi produk masih kosong</p>';
                        }
                        ?>

                    </div>
                    <div class="product_meta">
                        <span class="sku_wrapper">SKU: <span class="sku" style="color: #9f2b1e;"><?php echo $product->product_code;?></span></span>
                        <span class="posted_in">Kategori: <a style="color: #9f2b1e;" href="<?php echo base_url('c/'.$product->category_id)?>"><?php echo $product->category_name?></a></span>
                    </div>
                    <h6 class="mb-3 mt-4">Kenapa harus belanja disini?</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="feature-box">
                                <i class="mdi mdi-truck-fast"></i>
                                <h6 class="text-info">Free Delivery</h6>
                                <p>Lorem ipsum dolor...</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-box">
                                <i class="mdi mdi-basket"></i>
                                <h6 class="text-info">100% Guarantee</h6>
                                <p>Rorem Ipsum Dolor sit...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">

    $( document ).ready(function() {
        var stok = $('#stok').val();
        if (stok == "none") {
            alert('Anda belum memilih toko');
        }
    });

    //Add wishlist
    $('body').on('click', '.wishlist', function() {
        var product_id  = $(this).attr('name');
        var customer_id = '<?php echo $this->session->userdata('customer_id')?>';
        if (customer_id == 0) {
            alert('Silahkan login terlebih dahulu');
            return false;
        }
        $.ajax({
            type: "post",
            async: true,
            url: '<?php echo base_url('website/Home/add_wishlist')?>',
            data: {product_id:product_id,customer_id:customer_id},
            success: function(data) {
                if (data == '1') {
                    alert('Tambah product ke wishlist');
                }else if(data == '2'){
                    alert('Product sudah ada di wishlist anda')
                }else if(data == '3'){
                    alert('Silahkan login terlebih dahulu')
                }
            },
            error: function() {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    });
</script>