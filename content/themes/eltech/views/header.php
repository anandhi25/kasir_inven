<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="digitaindomedia" />
    <!-- Document Title -->
    <title><?php echo (isset($title)) ? $title :"Jual Beli Online" ?></title>

    <!-- Favicon -->
    <!--<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">-->

    <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
    <link rel="stylesheet" type="text/css" href="<?php echo theme_asset();?>rs-plugin/css/settings.css" media="screen" />

    <!-- StyleSheets -->
    <link rel="stylesheet" href="<?php echo theme_asset();?>css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo theme_asset();?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo theme_asset();?>css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo theme_asset();?>css/main.css">
    <link rel="stylesheet" href="<?php echo theme_asset();?>css/style.css">
    <link rel="stylesheet" href="<?php echo theme_asset();?>css/responsive.css">

    <!-- Fonts Online -->
    <link href="https://fonts.googleapis.com/css?family=Lato:100i,300,400,700,900" rel="stylesheet">

    <!-- JavaScripts -->
    <script src="<?php echo theme_asset();?>js/vendors/modernizr.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="wrap" <?php if($content == 'home') echo 'class="layout-3"';?>>

    <!-- Top bar -->
    <div class="top-bar">
        <div class="container">
            <p>Selamat datang</p>
            <div class="right-sec">
                <ul>
                    <li><a href="<?php echo base_url().'account/signin'?>">Login/Register </a></li>
                    <li><a href="#.">Store Location </a></li>
                </ul>
                <div class="social-top"> <a href="#."><i class="fa fa-facebook"></i></a> <a href="#."><i class="fa fa-twitter"></i></a> <a href="#."><i class="fa fa-linkedin"></i></a> <a href="#."><i class="fa fa-dribbble"></i></a> <a href="#."><i class="fa fa-pinterest"></i></a> </div>
            </div>
        </div>
    </div>

    <header class="header-style-3">
        <div class="container">
            <div class="logo"> <a href="index.html">
                    <?php
                    if(get_profile()->logo != '')
                    {
                        ?>
                        <img src="<?php echo base_url().get_profile()->logo;?>" alt="company-logo">
                        <?php
                    }
                    ?>
                </a> </div>

            <!-- Nav Header -->
            <nav class="navbar ownmenu">

                <!-- Categories -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-open-btn" aria-expanded="false"> <span><i class="fa fa-navicon"></i></span> </button>
                </div>

                <!-- NAV -->
                <div class="collapse navbar-collapse" id="nav-open-btn">
                    <ul class="nav">
                        <?php
                        foreach (get_menu('main menu') as $menu):
                            ?>
                            <li class="nav-item">
                                <a href="<?= site_url($menu->link); ?>" class="nav-link"><?= strtoupper($menu->label); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </nav>
            <!-- Cart Part -->
            <ul class="nav navbar-right cart-pop">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="itm-cont"><?php echo $this->cart->total_items();?></span> <i class="flaticon-shopping-bag"></i> <strong>My Cart</strong> <br>
                        <span id="cart-total-items"><?php echo $this->cart->total_items();?> item(s)</span></a>
                    <ul class="dropdown-menu" id="cart-body">
                        <?php
                        if ($this->cart->contents()) {
                        $row = 0;
                        foreach ($this->cart->contents() as $items): ?>
                        <li>
                            <div class="media-left"> <a href="#." class="thumb"> <img src="<?php echo base_url().$items['image']?>" class="img-responsive" alt="" > </a> </div>
                            <div class="media-body"> <a href="<?php echo base_url('p/'.$items['product_id'].'/'.seo_title($items['name']));?>" class="title"><?php echo $items['name']; ?></a> <span><?php echo number_format($items['price']); ?> x <?php echo $items['qty']; ?></span> </div>
                        </li>
                            <?php
                            $row = $row + 1;
                        endforeach; }?>
                        <li class="btn-cart"> <a href="<?php echo base_url()."checkout"?>" class="btn-round">View Cart</a> </li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="nav-uder-bar">
            <div class="container">
                <?php
                $get_category = get_product_category();
                ?>

                <!-- Categories -->
                <div class="cate-lst"> <a  data-toggle="collapse" class="cate-style" href="#cater"><i class="fa fa-list-ul"></i> Our Categories </a>
                    <div class="cate-bar-in">
                        <div id="cater" class="collapse <?php if($content == 'home') echo 'in';?>">
                            <ul>
                                <?php
                                if(count($get_category) > 0)
                                {
                                    foreach ($get_category as $cat)
                                    {
                                        $get_subcategory = db_get_all_data('tbl_subcategory',array('category_id' => $cat->category_id));
                                        if(count($get_subcategory) > 0)
                                        {
                                            echo '<li class="sub-menu"><a href="'.base_url('c/'.$cat->category_id.'/'.seo_title($cat->category_name)).'">'.$cat->category_name.'</a>
                                                <ul>';
                                            foreach ($get_subcategory as $sub_cat)
                                            {
                                                echo '<li><a href="'.base_url('c/'.$sub_cat->subcategory_id.'/'.seo_title($sub_cat->subcategory_name)).'">'.$sub_cat->subcategory_name.'</a></li>';
                                            }
                                            echo '</ul>';
                                        }
                                        else
                                        {
                                            echo '<li><a href="'.base_url('c/'.$cat->category_id.'/'.seo_title($cat->category_name)).'">'.$cat->category_name.'</a></li>';
                                        }
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- search -->
                <form name="search_form" id="search_form" method="get" action="<?php echo base_url('web/search')?>"
                    <div class="search-cate">
                        <select class="selectpicker" name="product_category">
                            <?php
                            if(count($get_category) > 0)
                            {
                                echo '<option value="0">Semua</option>';
                                foreach ($get_category as $cat)
                                {
                                    echo '<option value="'.$cat->category_id.'">'.$cat->category_name.'</option>';
                                }
                            }
                            ?>
                        </select>
                        <input type="search" name="search_product" placeholder="cari produk yang anda inginkan">
                        <button class="submit" type="submit"><i class="icon-magnifier"></i></button>
                    </div>
                </form>
                <!-- NAV RIGHT -->
                <div class="nav-right"> <span class="call-mun"><i class="fa fa-phone"></i> <strong>Hotline:</strong> (+100) 123 456 7890</span> </div>
            </div>
        </div>
    </header>
