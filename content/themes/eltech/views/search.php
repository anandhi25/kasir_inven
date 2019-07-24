<div class="linking">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active"><?php
                if(!empty($category))
                {
                    echo $category->category_name;
                }
                else
                {
                    echo 'Semua Kategori';
                }
                ?></li>
        </ol>
    </div>
</div>
<?php
$get_category = get_product_category();
?>
<div id="content">

    <!-- Products -->
    <section class="padding-top-40 padding-bottom-60">
        <div class="container">
            <div class="row">

                <!-- Shop Side Bar -->
                <div class="col-md-3">
                    <div class="shop-side-bar">

                        <!-- Categories -->
                        <h6>Kategori</h6>
                        <div class="checkbox checkbox-primary">
                            <?php
                            if(count($get_category) > 0) {
                                echo '<ul>';
                                foreach ($get_category as $cat) {
                                    ?>
                                    <li>
                                        <input id="<?php echo $cat->category_id;?>" name="category[]" value="<?php echo $cat->category_id;?>" class="styled" type="checkbox">
                                        <label for="cate1"><?php echo $cat->category_name;?> </label>
                                    </li>
                                    <?php
                                }
                                echo '</ul>';
                            }
                            ?>


                        </div>

                    </div>
                </div>

                <!-- Products -->
                <div class="col-md-9">

                    <!-- Short List -->
                    <div class="short-lst">
                        <h2><?php echo $title;?></h2>
                        <ul>
                            <!-- Short List -->
                            <li>
                                <p>Filter</p>
                            </li>
                            <!-- Short  -->
                            <!-- by Default -->
                            <li class="sub-menu">
                                <ul>
                                    <li>
                                        <a class="dropdown-item" href="<?php echo $cat_url."low-to-high";?>">Price (Low to High)</a>
                                    </li>
                                    <li><a class="dropdown-item" href="<?php echo $cat_url."high-to-low";?>">Price (High to Low)</a></li>
                                    <li><a class="dropdown-item" href="<?php echo $cat_url."a-to-z";?>">Name (A to Z)</a></li>
                                </ul>
                        </ul>



                        <!-- Grid Layer -->
                        </ul>
                    </div>

                    <!-- Items -->
                    <div class="item-col-3">
                        <?php
                        if ($product) {
                            foreach ($product as $prod) {
                                echo show_single_product($prod);
                            }
                            ?>
                            <!-- pagination -->
                            <?php echo $links;
                        }
                        else
                        {
                            echo "<h3 style='text-align: center'>Produk yang anda cari tidak ditemukan</h3>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>