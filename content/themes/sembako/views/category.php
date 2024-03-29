<section class="pt-3 pb-3 page-info section-padding border-bottom bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="<?php echo base_url(); ?>"><strong><span class="mdi mdi-home"></span> Home</strong></a> <span class="mdi mdi-chevron-right"></span> <a href="#"><?php echo $title;?></a>
            </div>
        </div>
    </div>
</section>

<section class="shop-list section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="shop-filters">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Kategori <span class="mdi mdi-chevron-down float-right"></span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body card-shop-filters">
                                    <?php
                                    if(empty($sub_category)) {
                                        $sub_kat = db_get_all_data('tbl_subcategory', array('category_id' => $category->category_id));
                                        if (count($sub_kat) > 0) {
                                            foreach ($sub_kat as $sub) {
                                                ?>
                                                <div class="custom-control custom-checkbox">
                                                    <label class="custom-control-label" for="cb8"><a
                                                                href="<?php echo base_url('sub/' . $sub->subcategory_id . '/' . seo_title($sub->subcategory_name)); ?>"><?php echo $sub->subcategory_name; ?></a></label>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                    else
                                    {
                                        if(count($category) > 0)
                                        {
                                            foreach ($category as $cat)
                                            {
                                                ?>
                                                <div class="custom-control custom-checkbox">
                                                    <label class="custom-control-label" for="cb8"><a
                                                                href="<?php echo base_url('c/' . $cat->category_id . '/' . seo_title($cat->category_name)); ?>"><?php echo $cat->category_name; ?></a></label>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>

                                </div>
                            </div>
                            <div class="card-header" id="headingTwo">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                        Brand <span class="mdi mdi-chevron-down float-right"></span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                <div class="card-body card-shop-filters">
                                    <?php
                                    $brands = db_get_all_data('tbl_brand');
                                    if(count($brands) > 0)
                                    {
                                        foreach ($brands as $brand)
                                        {
                                            ?>
                                            <div class="custom-control custom-checkbox">
                                                <label class="custom-control-label" for="cb8"><a href="<?php echo base_url('brand/'.$brand->brand_id.'/'.seo_title($brand->name)); ?>"><?php echo $brand->name; ?></a></label>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="shop-head">
                    <a href="<?php echo base_url(); ?>"><span class="mdi mdi-home"></span> Home</a> <span class="mdi mdi-chevron-right"></span> <a href="#"><?php echo $title?></a>
                    <div class="btn-group float-right mt-2">
                        <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Sort by Products &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="<?php echo $cat_url."low-to-high";?>">Price (Low to High)</a>
                            <a class="dropdown-item" href="<?php echo $cat_url."high-to-low";?>">Price (High to Low)</a>
                            <a class="dropdown-item" href="<?php echo $cat_url."a-to-z";?>">Name (A to Z)</a>
                        </div>
                    </div>
                    <h5 class="mb-3"><?php echo $title?></h5>
                </div>
                <?php
                if (!(empty($product))) {
                ?>
                <?php
                if ($product) {
                ?>
                <div class="row no-gutters">
                    <?php
                    $index = 1;
                    foreach ($product as $prod) {
                        ?>
                        <div class="col-md-4">
                            <?php
                            show_single_product($prod);
                            ?>
                        </div>
                        <?php
                        if($index % 3 == 0)
                        {
                            $index = 1;
                            echo '</div><div class="row no-gutters">';
                        }
                        else
                        {
                            $index = $index + 1;
                        }
                    }
                    echo '</div>';
                    }
                    ?>

                    <?php
                    echo '<nav>
                                 '.$links.'
                              </nav>';
                    }
                    else
                    {
                        echo '<div class="row no-gutters">
                            <div class="col-md-12 text-center">
                                <img src="'.base_url().'asset/img/oops.png" alt="produk kosong">
                                <h2 class="page_title">Produk dari kategori ini kosong</h2>
                            </div>
                        </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
</section>