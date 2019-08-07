<div class="linking">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li><a href="<?php echo base_url('c/'.$product->category_id.'/'.seo_title($product->category_name));?>"><?php echo $product->category_name; ?></a></li>
            <li class="active"><?php echo $product->product_name?></li>
        </ol>
    </div>
</div>
<div id="content">
    <section class="padding-top-40 padding-bottom-60">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-detail">
                        <form id="detail_form" method="post" action="<?php echo base_url('web/add_to_cart_web');?>">
                        <div class="product">
                            <div class="row">
                                <!-- Slider Thumb -->
                                <div class="col-xs-5">
                                    <article class="slider-item on-nav">
                                        <div id="slider" class="flexslider">
                                            <?php
                                            if ($product_gallery_img) {
                                                echo '<ul class="slides">';
                                                foreach ($product_gallery_img as $gallery) {
                                                    ?>
                                                    <li>
                                                        <img src="<?php echo base_url().$gallery->filename?>" alt="">
                                                    </li>

                                                    <?php
                                                }
                                                echo '</ul>';
                                            }
                                            else
                                            {
                                                echo '<ul class="slides">';
                                            ?>
                                                <li>
                                                    <img src="<?php echo base_url().$gallery->filename?>" alt="">
                                                </li>
                                            <?php
                                                echo '</ul>';
                                            }
                                            ?>
                                        </div>
                                        <div id="carousel" class="flexslider">
                                            <?php
                                            if ($product_gallery_img) {
                                                echo '<ul class="slides">';
                                                foreach ($product_gallery_img as $gallery) {
                                                    ?>
                                                    <li>
                                                        <img src="<?php echo base_url().$gallery->filename?>" alt="">
                                                    </li>

                                                    <?php
                                                }
                                                echo '</ul>';
                                            }
                                            else
                                            {
                                                echo '<ul class="slides">';
                                                ?>
                                                <li>
                                                    <img src="<?php echo base_url().$gallery->filename?>" alt="">
                                                </li>
                                                <?php
                                                echo '</ul>';
                                            }
                                            ?>
                                        </div>
                                    </article>
                                </div>
                                <?php
                                $str_stok = '<span class="in-stock">Tersedia</span>';
                                $stok = get_stock($product->product_code,get_frontend_store());
                                if($stok < 1)
                                {
                                    $str_stok = '<span class="out-stock">Habis</span>';
                                }
                                $price_discount = get_discount_offer($product->product_id);
                                $price = get_product_price($product->product_id);
                                ?>
                                <div class="col-xs-7">
                                    <span class="tags"><?php echo $product->category_name;?></span>
                                    <h5><?php echo $product->product_name;?></h5>
                                    <div class="row">
                                        <div class="col-sm-6"><span class="price">
                                            <?php
                                            if($price_discount != '') {
                                                echo $currency.' '.number_format($price_discount).' <span>'.$currency.' '.number_format($price).'</span>';
                                            }
                                            else
                                            {
                                                echo $currency.' '.number_format($price);
                                            }
                                            ?>
                                            </span></div>
                                        <div class="col-sm-6">
                                            <p>Availability: <?php echo $str_stok;?></p>
                                        </div>
                                    </div>
                                    <?php
                                    if(get_product_variations($product->product_id) != '')
                                    {
                                        ?>
                                        <div class="row">
                                            <div class="col-xs-5">
                                                <p>&nbsp;</p>
                                                <table class="variations" cellspacing="0">
                                                    <tbody>
                                                    <?php
                                                    echo get_product_variations($product->product_id);
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <ul class="cmp-list">
                                    </ul>
                                    <div class="quinty">
                                        <input type="number" value="01">
                                    </div>
                                    <a href="#." class="btn-round"><i class="icon-basket-loaded margin-right-5"></i> Add to Cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="item-tabs-sec">
                            <!-- Nav tabs -->
                            <ul class="nav" role="tablist">
                                <li role="presentation" class="active"><a href="#pro-detil"  role="tab" data-toggle="tab">Product Details</a></li>

                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="pro-detil">
                                    <?php
                                    echo $product->product_note;
                                    ?>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



