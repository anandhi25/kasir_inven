<section class="account-page section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="row no-gutters">

                    <div class="col-lg-12 text-center" style="margin-left: 10px;padding-right: 20px;padding-top: 10px;padding-bottom: 10px;">
                        <?php echo message_box('success'); ?>
                        <?php echo message_box('error'); ?>
                        <form class="login_content" action="<?php echo base_url('account/do_login')?>" method="post">
                            <h5 class="heading-design-h5">Login to your account</h5>
                            <fieldset class="form-group">
                                <label>Masukkan Email</label>
                                <center><input type="text" class="form-control" name="email" placeholder="customer@email.com"></center>
                            </fieldset>
                            <fieldset class="form-group">
                                <label>Masukkan Password</label>
                                <input type="password" name="password" class="form-control" placeholder="********">
                            </fieldset>
                            <fieldset class="form-group">
                                <button type="submit" class="btn btn-lg btn-secondary btn-block">Login</button>
                            </fieldset>

                            <div>
                                <label for="customCheck1">Lupa Password ?</label><a href="">Klik disini</a><br>
                                <label for="belum_pnya_akun">Belum Punya Akun ?</label>
                            </div>
                            <fieldset class="form-group">
                                <a href="<?php echo base_url()."account/signup" ?>" class="btn btn-lg btn-info btn-block">Daftar Baru</a>
                            </fieldset>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>