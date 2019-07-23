<section class="account-page section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="row no-gutters">
                    <?php echo message_box('success'); ?>
                    <?php echo message_box('error'); ?>
                    <div class="col-lg-12 text-center" style="margin-left: 10px;padding-right: 20px;padding-top: 10px;padding-bottom: 10px;">
                        <h2>Buat Akun Baru</h2>
                        <form class="login_content signup_content" id="signup_form" action="<?php echo base_url('account/user_signup')?>" method="post">
                            <fieldset class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" required class="form-control" id="customer_name" name="customer_name" placeholder="Nama lengkap anda">
                                <span style="color:red;" id="name_error"></span>
                            </fieldset>
                            <fieldset class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email" id="email" placeholder="customer@email.com">
                                <span style="color:red;" id="email_error"></span>
                            </fieldset>
                            <fieldset class="form-group">
                                <label>No Telp</label>
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="+62817262762726">
                                <span style="color:red;" id="phone_error"></span>
                            </fieldset>
                            <fieldset class="form-group">
                                <label>Masukkan Password</label>
                                <input type="password" name="password" class="form-control" placeholder="********">
                            </fieldset>
                            <div>
                                <label for="customCheck1">Dengan mendaftar, Anda menyetujui <a href="">Syarat dan Ketentuan</a> yang berlaku </label><br>
                            </div>
                            <fieldset class="form-group">
                                <button type="button" onclick="submit_order();" class="btn btn-lg btn-secondary btn-block">Buat Akun</button>
                            </fieldset>
                            <div>
                                <label for="belum_pnya_akun">Sudah Punya Akun ?</label>
                            </div>
                            <fieldset class="form-group">
                                <a href="<?php echo base_url()."account/signin" ?>" class="btn btn-lg btn-info btn-block">Login</a>
                            </fieldset>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function reset_field() {
        $('#name_error').html('');
        $('#email_error').html('');
        $('#phone_error').html('');
    }
    function submit_order()
    {
        reset_field();
        var email_txt = $('#email').val();
        var phone_txt = $('#phone').val();
        var name_txt = $('#customer_name').val();
        if(name_txt == '')
        {
            $('#name_error').html('Nama masih kosong');
            return false;
        }
        if(email_txt == '')
        {
            $('#email_error').html('Email masih kosong');
            return false;
        }
        if(phone_txt == '')
        {
            $('#phone_error').html('No telepon masih kosong');
            return false;
        }
        $.ajax({
            type: "post",
            url: '<?php echo base_url('account/cek_available')?>',
            data: {email:email_txt},
            success: function(data) {
                if(data == 'kosong')
                {
                    $('#signup_form').submit();
                }
                else
                {
                    $('#email_error').html('Email sudah terdaftar');
                }

            },
            error: function() {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    }
</script>