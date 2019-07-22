<section class="section-padding bg-white border-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-6">
                <div class="feature-box">
                    <i class="mdi mdi-truck-fast"></i>
                    <h6>Dikirim hari itu juga</h6>
                    <p>Anda pesan langsung kami kirim</p>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="feature-box">
                    <i class="mdi mdi-basket"></i>
                    <h6>100% Garansi kepuasan</h6>
                    <p>Dapatkan garansi kepuasan produk dari kami</p>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="feature-box">
                    <i class="mdi mdi-tag-heart"></i>
                    <h6>Harga murah dan diskon tiap hari</h6>
                    <p>Dapatkan harga murah dan diskon setiap hari</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-padding footer bg-white border-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <?php
                if(get_profile()->logo != '')
                {
                    ?>
                    <h4 class="mb-5 mt-0"><a class="logo" href="<?php echo base_url()?>"><img src="<?php echo base_url().get_profile()->logo;?>" alt="company-logo"></a></h4>
                <?php
                }
                ?>

                <p class="mb-0"><a class="text-dark" href="#"><i class="mdi mdi-phone"></i> <?php echo get_profile()->email;?></a></p>
                <p class="mb-0"><a class="text-success" href="#"><i class="mdi mdi-email"></i> <?php echo get_profile()->phone;?></a></p>
                <p class="mb-0"><a class="text-primary" href="#"><i class="mdi mdi-web"></i> <?php echo get_profile()->company_name;?></a></p>
            </div>
            <div class="col-lg-2 col-md-2">
                <h6 class="mb-4">Bantuan </h6>
                <?php
                $footer_bantuan = get_footer_menu('footer bantuan');
                if(count($footer_bantuan) > 0)
                {
                ?>
                <ul>
                    <?php
                    foreach ($footer_bantuan as $foot)
                    {
                        echo '<li><a href="'.$foot->link.'">'.$foot->label.'</a></li>';
                    }
                    ?>
                <ul>
                <?php
                }
                ?>
            </div>
            <div class="col-lg-2 col-md-2">
                <h6 class="mb-4">My Account</h6>
                <?php
                $footer_account = get_footer_menu('footer account');
                if(count($footer_account) > 0)
                {
                ?>
                <ul>
                    <?php
                    foreach ($footer_account as $foot)
                    {
                        echo '<li><a href="'.$foot->link.'">'.$foot->label.'</a></li>';
                    }
                    ?>
                <ul>
                <?php
                }
                ?>
            </div>

            <div class="col-lg-2 col-md-2">
                <h6 class="mb-4">Tentang Kami</h6>
                <?php
                $footer_about = get_footer_menu('footer about us');
                if(count($footer_about) > 0)
                {
                ?>
                <ul>
                    <?php
                    foreach ($footer_about as $foot)
                    {
                        echo '<li><a href="'.$foot->link.'">'.$foot->label.'</a></li>';
                    }
                    ?>
                    <ul>
                <?php
                }
                ?>
            </div>
            <div class="col-lg-3 col-md-3">
                <h6 class="mb-4">Download App</h6>
                <div class="app">
                    <a href="#"><img src="<?php echo base_url()."asset/img/google.png"; ?>" alt=""></a>
                    <a href="#"><img src="<?php echo base_url()."asset/img/apple.png"; ?>" alt=""></a>
                </div>
                <h6 class="mb-3 mt-4">GET IN TOUCH</h6>
                <div class="footer-social">
                    <a class="btn-facebook" href="#"><i class="mdi mdi-facebook"></i></a>
                    <a class="btn-twitter" href="#"><i class="mdi mdi-twitter"></i></a>
                    <a class="btn-instagram" href="#"><i class="mdi mdi-instagram"></i></a>
                    <a class="btn-whatsapp" href="#"><i class="mdi mdi-whatsapp"></i></a>
                    <a class="btn-messenger" href="#"><i class="mdi mdi-facebook-messenger"></i></a>
                    <a class="btn-google" href="#"><i class="mdi mdi-google"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pt-4 pb-4 footer-bottom">
    <div class="container">
        <div class="row no-gutters">
            <div class="col-lg-6 col-sm-6">
                <p class="mt-1 mb-0">&copy; Copyright <?php echo date('Y');?> <?php if(get_profile()->company_name){echo '<strong class="text-dark">'.get_profile()->company_name.'</strong>';}?> All Rights Reserved<br>
                </p>
            </div>
            <div class="col-lg-6 col-sm-6 text-right">
                <img alt="logo sembako" src="<?php echo base_url()."asset/img/payment_methods.png"; ?>">
            </div>
        </div>
    </div>
</section>

<div class="cart-sidebar" id="cart-side">
    <div class="cart-sidebar-header">
        <h5>
            My Cart <span class="text-success" id="cart-total-items">(<?php echo $this->cart->total_items();?> item)</span> <a data-toggle="offcanvas" class="float-right" href="#"><i class="mdi mdi-close"></i>
            </a>
        </h5>
    </div>
    <div class="cart-sidebar-body" id="cart-body">
        <?php
        $total_belanja = 0;
        if ($this->cart->contents()) {
            $row = 0;
            foreach ($this->cart->contents() as $items): ?>
                <div class="cart-list-product">
                    <a class="float-right remove-cart delete_cart_item" href="#" onclick="hapus_cart('<?php echo $items['rowid'];?>')"><i class="mdi mdi-close"></i></a>
                    <img class="img-fluid" src="<?php echo base_url().$items['image']?>" alt="">
                    <?php
                    if($items['discount'] != '0')
                    {
                        echo '<span class="badge badge-success">'.$items['discount'].'% OFF</span>';
                    }
                    ?>
                    <h5><a href="#"><?php echo $items['name']; ?></a></h5>
                    <h6><strong><span class="mdi mdi-approval"></span> Tersedia</strong></h6>
                    <?php
                    $subtotal = $items['qty'] * $items['price'];
                    if($items['discount'] == '0')
                    {
                        $harga = (($position==0)?$currency.' '.$this->cart->format_number($items['price']):$this->cart->format_number($items['price']).' '.$currency);
                        $total_belanja = $total_belanja + $subtotal;
                        echo '<p class="offer-price mb-0">'.$harga.'</p>';
                    }
                    else
                    {
                        $diskon = ($items['discount'] / 100) * $subtotal;
                        $hit_diskon = $subtotal - $diskon;
                        $harga = (($position==0)?$currency.' '.number_format($items['price']):number_format($items['price']).' '.$currency);
                        $harga_diskon = (($position==0)?$currency.' '.number_format($hit_diskon):number_format($hit_diskon).' '.$currency);
                        $total_belanja = $total_belanja + $hit_diskon;
                        echo '<p class="offer-price mb-0">'.$harga_diskon.' <i class="mdi mdi-tag-outline"></i> <span class="regular-price">'.$harga.'</span></p>';
                    }
                    ?>

                </div>
                <?php
                $row = $row + 1;
            endforeach; }?>
    </div>
    <div class="cart-sidebar-footer" id="cart-footer">
        <div class="cart-store-details">
            <?php
            $total_belanja = (($position==0)?$currency.' '.number_format($total_belanja):number_format($total_belanja).' '.$currency);
            ?>
            <p>Total Belanja <strong class="float-right"><?php echo $total_belanja;?></strong></p>
            <h6>Grand Total <strong class="float-right text-danger"><?php echo $total_belanja;?></strong></h6>
        </div>
        <a href="<?php echo base_url()."website/home/checkout"?>"><button class="btn btn-secondary btn-lg btn-block text-left" type="button"><span class="float-left"><i class="mdi mdi-cart-outline"></i> Proceed to Checkout </span><span class="float-right"><strong><?php echo $total_belanja;?></strong> <span class="mdi mdi-chevron-right"></span></span></button></a>
    </div>
</div>




<a href="#0" class="cd-top">
    <i class="fa fa-arrow-up"></i>
</a>

<!-- Bootstrap  -->
<script src="<?php echo theme_asset().'vendor/bootstrap/js/bootstrap.bundle.min.js';?>" type="text/javascript"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>

<!-- Include SmartWizard JavaScript source -->
<script type="text/javascript" src="<?php echo theme_asset(),'vendor/SmartWizard-master/dist/js/jquery.smartWizard.min.js';?>"></script>

<!-- Owl Carousel -->
<script src="<?php echo theme_asset().'vendor/owl-carousel/owl.carousel.js';?>" type="text/javascript"></script>

<!-- EasyZoom -->
<script src="<?php echo theme_asset().'vendor/easyzoom/easyzoom.min.js';?>" type="text/javascript"></script>

<!-- DSCount JS -->
<script src="<?php echo theme_asset().'vendor/dscountdown/dscountdown.min.js';?>" type="text/javascript"></script>

<!-- WoW js -->
<script src="<?php echo theme_asset().'vendor/wow-js/wow.min.js';?>"></script>
<script src="<?php echo theme_asset().'vendor/select2/js/select2.min.js';?>"></script>

<!-- Lightbox js -->
<script src="<?php echo theme_asset().'vendor/lightbox/js/lightbox.min.js';?>"></script>

<!-- Simple Share js -->
<script src="<?php echo theme_asset().'js/jquery.simpleSocialShare.min.js';?>"></script>
<script src="<?php echo theme_asset().'js/custom.min.js';?>"></script>

<!-- Custom scripts for this template -->
<script src="<?php echo theme_asset().'js/theme.js';?>"></script>

<link href="<?php echo theme_asset().'vendor/datatables/datatables.min.css';?>" rel="stylesheet" />
<script src="<?php echo theme_asset().'vendor/datatables/datatables.min.js';?>"></script>
<script>
    $(document).ready(function() {
        $('.datatabel').DataTable();
    } );

    function add_to_cart_btn(product_id) {
        $.ajax({
            type: "post",
            url: '<?php echo base_url('web/add_to_cart_web')?>',
            data: {product_code:product_id},
            success: function(data) {
                $(".cart-value").html(data);
                $("#cart-total-items").html("("+data+") item");
                // $("#cart-side").load(location.href+" #cart-side>*","");
                // loadAwal();
                $("#cart-body").load(location.href+" #cart-body>*","");
                $("#cart-footer").load(location.href+" #cart-footer>*","");

            },
            error: function() {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    }

    function hapus_cart(cartid) {
        $.ajax({
            type: "post",
            url: '<?php echo base_url('web/remove_cart_web')?>',
            data: {row_id:cartid},
            success: function(data) {
                $(".cart-value").html(data);
                $("#cart-total-items").html("("+data+") item");
                // $("#cart-side").load(location.href+" #cart-side>*","");
                // loadAwal();
                $("#cart-body").load(location.href+" #cart-body>*","");
                $("#cart-footer").load(location.href+" #cart-footer>*","");

            },
            error: function() {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    }
</script>

</body>

</html>