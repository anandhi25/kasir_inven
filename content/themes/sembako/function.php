<?php
if(!function_exists('show_single_product')) {
    function show_single_product($product)
    {
        $stok = get_stock($product->product_code,get_frontend_store());
        $tersedia = 'Tersedia';
        $text_stok = 'veg text-success';
        $cls_button = 'class="btn btn-secondary btn-sm float-right"';
        if($stok <= 0)
        {
            $tersedia = "Stok Kosong";
            $text_stok = 'non-veg text-danger';
            $cls_button = 'disabled class="btn btn-default btn-sm float-right"';
        }
        ?>
        <div class="product">
            <a href="<?php echo base_url()."p/".$product->product_id."/".seo_title($product->product_name); ?>">
                <div class="product-header">
                    <?php
                    $price_discount = get_discount_offer($product->product_id);
                    $price = get_product_price($product->product_id);
                    $get_image = get_product_image($product->product_id);
                    if($price_discount != '0')
                    {
                        $persen = ($price_discount / $price) * 100;
                        echo '<span class="badge badge-success">'.$persen.'% OFF</span>';
                    }
                    ?>
                    <?php
                    $img =base_url('asset/img/no_img_avaliable');
                    if(count($get_image) > 0)
                    {
                        $img = base_url().$get_image[0]->filename;
                    }
                    ?>
                    <img class="img-fluid" src="<?php echo $img;?>" alt="">
                    <span class="<?php echo $text_stok;?>  mdi mdi-circle"></span>
                </div>
                <div class="product-body">
                    <h5><?php echo $product->product_name;?></h5>
                    <h6><strong><span class="mdi mdi-approval"></span> <?php echo $tersedia;?></strong></h6>
                </div>
            </a>
            <div class="product-footer">
                <button type="button" onclick="add_to_cart_btn('<?php echo $product->product_id;?>')" <?php echo $cls_button;?>><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
                <?php
                $arrcur = get_profile()->currency;
                $mataUang = 'Rp';
                if($arrcur != '')
                {
                    $mataUang = $arrcur;
                }
                if($price_discount != '') {
                    ?>
                    <p class="offer-price mb-0"><?php echo $mataUang." ".number_format($price_discount);?><i class="mdi mdi-tag-outline"></i><br><span
                            class="regular-price"><?php echo $mataUang." ".number_format($price);?></span></p>
                    <?php
                }
                else
                {
                    ?>
                    <p class="offer-price mb-0"><?php echo $mataUang." ".number_format($price);?></p>
                    <?php
                }
                ?>


            </div>
        </div>
    <?php
    }
}



?>