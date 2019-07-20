<section class="pt-3 pb-3 page-info section-padding border-bottom bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="<?php echo base_url(); ?>"><strong><span class="mdi mdi-home"></span> Home</strong></a> <span class="mdi mdi-chevron-right"></span> <a href="#"><?php echo $category->category_name;?></a>
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
                                        Category <span class="mdi mdi-chevron-down float-right"></span>
                                    </button>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="shop-head">
                    <a href="<?php echo base_url(); ?>"><span class="mdi mdi-home"></span> Home</a> <span class="mdi mdi-chevron-right"></span> <a href="#"><?php echo $category->category_name?></a>
                    <div class="btn-group float-right mt-2">
                        <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Sort by Products &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="<?php echo $url_sort."/low_to_high";?>">Price (Low to High)</a>
                            <a class="dropdown-item" href="<?php echo $url_sort."/high_to_low";?>">Price (High to Low)</a>
                            <a class="dropdown-item" href="<?php echo $url_sort."/a_to_z";?>">Name (A to Z)</a>
                        </div>
                    </div>
                    <h5 class="mb-3"><?php echo $category->category_name?></h5>
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
                    foreach ($products as $product) {
                        ?>
                        <div class="col-md-4">
                            <?php
                            show_single_product($product);
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
                                <img src="'.base_url().'assets/website/img/oops.png" alt="oops image">
                                <h2 class="page_title">'.display('category_product_not_found').'</h2>
                            </div>
                        </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
</section>