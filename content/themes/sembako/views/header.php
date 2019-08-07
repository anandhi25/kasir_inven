<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="sembakoku">
    <meta name="description" content="">

    <title><?php echo (isset($title)) ? $title :"Jual Beli Online" ?></title>

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="">

    <!-- Bootstrap core CSS -->
    <link href="<?php echo theme_asset().'vendor/bootstrap/css/bootstrap.min.css';?>" rel="stylesheet">

    <!-- FontAwesome Icon CSS -->
    <link href="<?php echo theme_asset().'vendor/font-awesome/css/font-awesome.min.css';?>" rel="stylesheet" type="text/css">

    <!-- Jquery UI CSS -->
    <link href="<?php echo theme_asset().'vendor/jquery-ui/jquery-ui.min.css';?>" rel="stylesheet">

    <!-- Owl Carousel CSS -->
    <link href="<?php echo theme_asset().'vendor/owl-carousel/owl.carousel.css';?>" rel="stylesheet">
    <link href="<?php echo theme_asset().'vendor/owl-carousel/owl.theme.css';?>" rel="stylesheet">

    <link href="<?php echo theme_asset().'vendor/icons/css/materialdesignicons.min.css';?>" media="all" rel="stylesheet">

    <!-- Animate CSS -->
    <link href="<?php echo theme_asset().'vendor/wow-js/animate.css';?>" rel="stylesheet">
    <link href="<?php echo theme_asset().'vendor/select2/css/select2-bootstrap.css';?>" rel="stylesheet">
    <link href="<?php echo theme_asset().'vendor/select2/css/select2.min.css';?>" rel="stylesheet">

    <!-- Lightbox CSS -->
    <link href="<?php echo theme_asset().'vendor/lightbox/css/lightbox.min.css';?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo theme_asset().'css/osahan.min.css';?>" rel="stylesheet">
    <link href="<?php echo theme_asset().'css/checkout_style.css';?>" rel="stylesheet">
    <!-- EasyZoom CSS -->
    <link rel="stylesheet" href="<?php echo theme_asset().'vendor/easyzoom/easyzoom.min.css';?>">

    <!-- Include SmartWizard CSS -->
    <link href="<?php echo theme_asset().'vendor/SmartWizard-master/dist/css/smart_wizard.css';?>" rel="stylesheet" type="text/css">

    <!-- Optional SmartWizard theme -->
    <link href="<?php echo theme_asset().'vendor/SmartWizard-master/dist/css/smart_wizard_theme_dots.css';?>" rel="stylesheet" type="text/css">

    <!-- Jquery  -->
    <script src="<?php echo theme_asset().'vendor/jquery/jquery.min.js';?>" type="text/javascript"></script>

    <!-- jquery-ui.min.js -->
    <script src="<?php echo theme_asset().'vendor/jquery-ui/jquery-ui.min.js';?>" type="text/javascript"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<body>

<div class="modal fade login-modal-main" id="bd-example-modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="login-modal">
                    <div class="row">
                        <div class="col-lg-6 pad-right-0">
                            <div class="col d-flex align-items-center justify-content-center">
                                <?php
                                if(get_profile()->logo != '')
                                {
                                    ?>
                                    <img class="img-responsive center-block" src="<?php echo base_url().get_profile()->logo;?>" alt="company-logo">
                                <?php
                                }
                                ?>

                            </div>
                        </div>
                        <div class="col-lg-6 pad-left-0">
                            <button type="button" class="close close-top-right" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="mdi mdi-close"></i></span>
                                <span class="sr-only">Close</span>
                            </button>
                            <div class="login-modal-right">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane active" id="login" role="tabpanel">
                                        <form id="login_form" action="<?php echo get_customer_login_url();?>">
                                            <h5 class="heading-design-h5">Login to your account</h5>
                                            <fieldset class="form-group">
                                                <label>Enter Email/Mobile number</label>
                                                <input type="text" class="form-control" name="email" placeholder="+62 123 456 7890">
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label>Enter Password</label>
                                                <input type="password" class="form-control" name="password" placeholder="********">
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <button type="submit" class="btn btn-lg btn-secondary btn-block">Enter to your account</button>
                                            </fieldset>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input">
                                                <label class="custom-control-label" for="customCheck1">Remember me</label>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane" id="register" role="tabpanel">
                                        <form id="register_form" action="<?php echo base_url('website/customer/signup/user_signup')?>">
                                            <h5 class="heading-design-h5"><?php echo 'Buat Akun'?></h5>
                                            <fieldset class="form-group">
                                                <label>Masukkan No Telp</label>
                                                <input type="text" name="phone" class="form-control" placeholder="+6281526252625" required>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label>Masukkan Email</label>
                                                <input type="text" name="email" class="form-control" placeholder="customer@email.com">
                                            </fieldset>

                                            <fieldset class="form-group">
                                                <label>Masukkan Nama Lengkap</label>
                                                <input type="text" name="first_name" class="form-control" placeholder="Nama Lengkap">
                                            </fieldset>

                                            <fieldset class="form-group">
                                                <label>Masukkan Password</label>
                                                <input type="password" name="password" class="form-control" placeholder="********">
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <button type="submit" class="btn btn-lg btn-secondary btn-block"><?php echo 'Buat Akun'?></button>
                                            </fieldset>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input">
                                                <label class="custom-control-label" for="customCheck2">I Agree with <a href="#">Term and Conditions</a></label>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="text-center login-footer-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#login" role="tab"><i class="mdi mdi-lock"></i> LOGIN</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#register" role="tab"><i class="mdi mdi-pencil"></i> REGISTER</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<nav class="navbar navbar-light navbar-expand-lg bg-dark bg-faded osahan-menu" id="header-atas">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo base_url();?>">
            <?php
            if(get_profile()->logo != '')
            {
                ?>
                <img src="<?php base_url(get_profile()->logo)?>" alt="logo">
            <?php
            }
            ?>

        </a>

        <button class="navbar-toggler navbar-toggler-white" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <form method="GET" action="<?php echo base_url('web/search')?>">
            <div class="navbar-collapse" id="navbarNavDropdown">
                <div class="navbar-nav mr-auto mt-2 mt-lg-0 margin-auto top-categories-search-main">
                    <div class="top-categories-search">
                        <div class="input-group">
                            <span class="input-group-btn categories-dropdown">
                               <select class="form-control-select" name="product_category">
                                   <?php
                                   if(count(get_product_category()) > 0)
                                   {
                                       echo '<option value="0">Semua</option>';
                                       foreach (get_product_category() as $cat)
                                       {
                                           echo '<option value="'.$cat->category_id.'">'.$cat->category_name.'</option>';
                                       }
                                   }
                                   ?>
                               </select>
                            </span>
                            <input class="form-control" placeholder="Cari produk yang saya inginkan" aria-label="Cari produk yang saya inginkan" type="text" name="search_product">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit"><i class="mdi mdi-file-find"></i> Cari</button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="my-2 my-lg-0" id="cart-indicator">
                    <ul class="list-inline main-nav-right">
                        <li class="list-inline-item">
                            <?php
                            if (!is_login()) {
                                ?>
                                <a href="#" data-target="#bd-example-modal" data-toggle="modal" class="btn btn-link"><i
                                            class="mdi mdi-account-circle"></i> Login/Sign Up</a>
                                <?php
                            }
                            else
                            {
                                ?>
                                <a href="<?php echo base_url('account/my') ?>" class="btn btn-link"><i
                                            class="mdi mdi-account"></i> Akun Saya</a>
                                <?php
                            }
                            ?>

                        </li>
                        <li class="list-inline-item cart-btn" >
                            <a href="#" data-toggle="offcanvas" class="btn btn-link border-none"><i class="mdi mdi-cart"></i> My Cart <small class="cart-value"><?php echo $this->cart->total_items()?></small></a>
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>
</nav>
<nav class="navbar navbar-expand-lg navbar-light osahan-menu-2 pad-none-mobile">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0 margin-auto">
                <?php
                 foreach (get_menu('main menu') as $menu):
                ?>
                <li class="nav-item">
                    <a href="<?= $menu->link; ?>" class="nav-link"><?= strtoupper($menu->label); ?></a>
                </li>
                 <?php endforeach; ?>

            </ul>
        </div>
    </div>
</nav>