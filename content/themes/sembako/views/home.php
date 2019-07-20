<link href="<?php echo theme_asset().'css/popup.css';?>" rel="stylesheet">

<section class="carousel-slider-main text-center border-top border-bottom bg-white">
    <div class="owl-carousel owl-carousel-slider">
        <?php
        $slider_list = get_slider();
        if ($slider_list) {
            foreach ($slider_list as $slider) {
                ?>
                <div class="item">
                    <a href="<?php echo $slider->slider_url;?>"><img class="img-fluid" src="<?php echo base_url().$slider->slider_image;?>" alt="slide"></a>
                </div>
                <?php
            }
        }
        ?>
    </div>
</section>

<section class="top-category section-padding">
    <div class="container">
        <div class="owl-carousel owl-carousel-category">
            <?php
            if(get_product_category())
            {
                foreach (get_product_category() as $cat_list)
                {
                    $img_url = base_url()."asset/img/no-category.jpg";
                    if($cat_list->cat_icon != '')
                    {
                        $img_url = base_url().$cat_list->cat_icon;
                    }
                    $qCatProduct = db_get_all_data('tbl_product',array('category_id' => $cat_list->category_id));
                    $jumlah_items = count($qCatProduct);
                    ?>
                    <div class="item">
                        <div class="category-item">
                            <a href="<?php echo base_url("c/".$cat_list->category_id.'/'.seo_title($cat_list->category_name)) ?>">
                                <img class="img-fluid" src="<?php echo $img_url;?>" alt="">
                                <h6><?php echo $cat_list->category_name; ?></h6>
                                <p><?php echo $jumlah_items;?> Items</p>
                            </a>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<section class="product-items-slider section-padding">
    <div class="container">
        <div class="section-header">
            <h4 class="heading-design-h5"><strong>PRODUK UNGGULAN</strong>
                <a class="float-right text-secondary" href="<?php echo base_url('website/home/shop/best_seller')?>">Lihat Semua</a>
            </h4>
        </div>
        <div class="owl-carousel owl-carousel-featured">
            <?php
            if($product)
            {
                foreach ($product as $sales)
                {

                    ?>
                    <div class="item">
                        <?php
                        show_single_product($sales);
                        ?>
                    </div>
                    <?php
                }
            }
            ?>

        </div>
    </div>
</section>