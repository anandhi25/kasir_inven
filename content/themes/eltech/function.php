<?php
if(!function_exists('show_single_product')) {
    function show_single_product($product)
    {
        $stok = get_stock($product->product_code,get_frontend_store());
        $price_discount = get_discount_offer($product->product_id);
        $price = get_product_price($product->product_id);
        $get_image = get_product_image($product->product_id);
        $img =base_url('asset/img/no_img_avaliable');
        if(count($get_image) > 0)
        {
            $img = base_url().$get_image[0]->filename;
        }
        $arrcur = get_profile()->currency;
        $mataUang = 'Rp';
        if($arrcur != '')
        {
            $mataUang = $arrcur;
        }
        ?>
        <div class="product">
            <article>
                <img class="img-responsive" src="<?php echo $img;?>" alt="" >
                <!-- Content -->
                <span class="tag"><?php echo $product->category_name; ?></span>
                <a href="<?php echo base_url()."p/".$product->product_id."/".seo_title($product->product_name); ?>" class="tittle"><?php echo $product->product_name;?></a>
                <!-- Reviews -->
                <p class="rev">&nbsp;</p>
                <div class="price">
                    <?php
                    if($price_discount != '') {
                        echo  $mataUang." ".number_format($price_discount).' <span>'.$mataUang.' '.number_format($price).'</span>';
                    }
                    else
                    {
                        echo $mataUang.' '.number_format($price);
                    }
                    ?>
                </div>
                <a href="javascript:void(0)" onclick="add_to_cart_btn('<?php echo $product->product_code;?>')" class="cart-btn"><i class="icon-basket-loaded"></i></a>
            </article>
        </div>
        <?php
    }
}

if(!function_exists('get_product_variations')) {
    function get_product_variations($product_id)
    {
        $get_attribute_set = db_get_all_data('tbl_attribute_set');
        $html ='';
        if(count($get_attribute_set) > 0)
        {
            foreach ($get_attribute_set as $attr_set)
            {
                $get_attribute = db_get_all_data('tbl_attribute',array('product_id' => $product_id,'attribute_set_id' => $attr_set->attribute_set_id));
                if(count($get_attribute) > 0)
                {
                    $html .= '
                        <div class="form-group row ">
                        <div class="col-sm-4">
                            <label style="margin-top: 8px;">
                                <strong>'.$attr_set->attribute_name.'</strong>
                            </label>
                        </div>
                            <div class="col-sm-8">
                    ';
                    foreach ($get_attribute as $attrib)
                    {
                        $html .= '<div class="radio">
                                    <input type="radio"
                                        name="attribute[]"
                                        value="'.$attrib->attribute_id.'"
                                        id="'.$attrib->attribute_id.'">
                    
                                    <label for="'.$attrib->attribute_id.'">
                                        '.$attrib->attribute_value.' <span class="value-price"></span>
                                    </label>
                                </div>';
                       // $html .= '<option value="'.$attrib->attribute_id.'">'.$attrib->attribute_value.'</option>';
                    }

                    $html .= '</div></div>';

                }
            }
        }
        else
        {
            $html = '';
        }
        return $html;
    }
}