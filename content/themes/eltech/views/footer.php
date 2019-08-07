</div>
<!-- End Content -->

<!-- Footer -->
<footer>
    <div class="container">

        <!-- Footer Upside Links -->

        <div class="row">

            <!-- Contact -->
            <div class="col-md-4">
                <h4><?php echo get_profile()->company_name; ?></h4>
                <p><?php echo get_profile()->address; ?></p>
                <p>Phone: <?php echo get_profile()->phone; ?></p>
                <p>Email: <?php echo get_profile()->email; ?></p>
                <div class="social-links"> <a href="#."><i class="fa fa-facebook"></i></a> <a href="#."><i class="fa fa-twitter"></i></a> <a href="#."><i class="fa fa-linkedin"></i></a> <a href="#."><i class="fa fa-pinterest"></i></a> <a href="#."><i class="fa fa-instagram"></i></a> <a href="#."><i class="fa fa-google"></i></a> </div>

            </div>

            <!-- Categories -->
            <div class="col-md-3">
                <h4>Bantuan</h4>
                <?php
                $footer_bantuan = get_footer_menu('footer bantuan');
                if(count($footer_bantuan) > 0)
                {
                ?>
                <ul class="links-footer">
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

            <!-- Categories -->
            <div class="col-md-3">
                <h4>My Account</h4>
                <?php
                $footer_account = get_footer_menu('footer account');
                if(count($footer_account) > 0)
                {
                ?>
                <ul class="links-footer">
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

            <!-- Categories -->
            <div class="col-md-2">
                <h4>Information</h4>
                <?php
                $footer_about = get_footer_menu('footer about us');
                if(count($footer_about) > 0)
                {
                ?>
                <ul class="links-footer">
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
        </div>
    </div>
</footer>

<!-- Rights -->
<div class="rights">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <p>Copyright © 2019 <a href="<?php echo base_url();?>" class="ri-li"> <?php echo get_profile()->company_name;?></a>. All rights reserved</p>
            </div>
            <div class="col-sm-6 text-right"> <img src="<?php echo theme_asset();?>images/card-icon.png" alt=""> </div>
        </div>
    </div>
</div>

<!-- End Footer -->

<!-- GO TO TOP  -->
<a href="#" class="cd-top"><i class="fa fa-angle-up"></i></a>
<!-- GO TO TOP End -->
</div>
<!-- End Page Wrapper -->

<!-- JavaScripts -->
<script src="<?php echo theme_asset();?>js/vendors/jquery/jquery.min.js"></script>
<script src="<?php echo theme_asset();?>js/vendors/wow.min.js"></script>
<script src="<?php echo theme_asset();?>js/vendors/bootstrap.min.js"></script>
<script src="<?php echo theme_asset();?>js/vendors/own-menu.js"></script>
<script src="<?php echo theme_asset();?>js/vendors/jquery.sticky.js"></script>
<script src="<?php echo theme_asset();?>js/vendors/owl.carousel.min.js"></script>

<!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
<script type="text/javascript" src="<?php echo theme_asset();?>rs-plugin/js/jquery.tp.t.min.js"></script>
<script type="text/javascript" src="<?php echo theme_asset();?>rs-plugin/js/jquery.tp.min.js"></script>
<script src="<?php echo theme_asset();?>js/main.js"></script>
<script>
    function add_to_cart_btn_detail() {
        var form_post = $('#detail_form');
        var data_post = form_post.serializeArray();
        $.ajax({
            type: "post",
            url: form_post.attr('action'),
            data: data_post,
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