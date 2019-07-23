<section class="slid-sec with-bg-wide" >
    <!-- Main Slider Start -->
    <div class="tp-banner-container">
        <div class="tp-banner-full">
            <ul>
                <?php
                $slider_list = get_slider();
                if ($slider_list) {
                    foreach ($slider_list as $slider) {
                        ?>
                        <li data-transition="random" data-slotamount="7" data-masterspeed="300"  data-saveperformance="off" >
                            <!-- MAIN IMAGE -->
                            <img src="<?php echo theme_asset();?>images/trans-bg.png"  alt="slider"  data-bgposition="center bottom" data-bgfit="cover" data-bgrepeat="no-repeat">

                            <!-- LAYER NR. 1 -->
                            <div class="tp-caption sfl tp-resizeme"
                                 data-x="left" data-hoffset="300"
                                 data-y="center" data-voffset="0"
                                 data-speed="800"
                                 data-start="1300"
                                 data-easing="Power3.easeInOut"
                                 data-elementdelay="0.1"
                                 data-endelementdelay="0.1"
                                 data-endspeed="300"
                                 data-scrolloffset="0"
                                 style="z-index: 1;"><img src="<?php echo base_url().$slider->slider_image;?>" alt="" > </div>

                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</section>
<?php
$get_category = get_product_category();
if(count($get_category) > 0) {
 ?>
<section class="padding-top-30 padding-bottom-30">
    <div class="container">
        <!-- heading -->
        <div class="heading">
            <h2>Featured Categories</h2>
            <hr>
        </div>
        <section class="row">
            <?php
                $i=0;
                foreach ($get_category as $cat) {
                    ?>
                        <div class="col-md-4">
                            <div class="some-cate">
                                <h5><?php echo $cat->category_name; ?></h5>
                                <?php
                                $get_subcategory = db_get_all_data('tbl_subcategory', array('category_id' => $cat->category_id));
                                if (count($get_subcategory) > 0) {
                                    echo '<ul>';
                                    foreach ($get_subcategory as $sub_cat)
                                    {
                                        echo '<li><a href="'.base_url('c/'.$sub_cat->subcategory_id.'/'.seo_title($sub_cat->subcategory_name)).'"> '.$sub_cat->subcategory_name.'</a></li>';
                                    }
                                    echo '</ul>';
                                }
                                $i = $i + 1;
                                if($i % 3 == 0)
                                {
                                    echo '
                                    </div>
                                    <div class="row"> ';
                                }
                                else
                                {
                                    echo '</div>
                                      </div>';
                                }
                }

                ?>
    </div>
</div>
</section>
<?php
}
?>
<section class="padding-bottom-60">
    <div class="container">

        <!-- heading -->
        <div class="heading">
            <h2>Produk Terbaru</h2>
            <hr>
        </div>
        <!-- Items Slider -->
        <div class="item-slide-4 with-nav">
            <?php
                if(count($latest) > 0)
                {
                    foreach ($latest as $prod)
                    {
                        echo show_single_product($prod);
                    }
                }
            ?>
        </div>
    </div>
</section>
