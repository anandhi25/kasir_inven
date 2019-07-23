<div id="content">

    <!-- Linking -->
    <div class="linking">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">Customer Login</li>
            </ol>
        </div>
    </div>

    <section class="login-sec padding-top-30 padding-bottom-100">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <!-- Login Your Account -->
                    <h5>Login Your Account</h5>
                    <?php echo message_box('success'); ?>
                    <?php echo message_box('error'); ?>
                    <!-- FORM -->
                    <form method="POST" action="<?php echo base_url('account/do_login')?>">
                        <ul class="row">
                            <li class="col-sm-12">
                                <label>Email
                                    <input type="text" class="form-control" name="email" placeholder="" required>
                                </label>
                            </li>
                            <li class="col-sm-12">
                                <label>Password
                                    <input type="password" class="form-control" name="password" placeholder="" required>
                                </label>
                            </li>
                            <li class="col-sm-6">
                            </li>
                            <li class="col-sm-6"> <a href="#." class="forget">Forgot password?</a> </li>
                            <li class="col-sm-12 text-left">
                                <button type="submit" class="btn-round">Login</button>
                            </li>
                        </ul>
                    </form>
                </div>

                <!-- Don’t have an Account? Register now -->
                <div class="col-md-6">
                    <h5>Belum punya akun? Daftar sekarang</h5>

                    <!-- FORM -->
                    <form id="signup_form" action="<?php echo base_url('account/user_signup')?>" method="post">
                        <ul class="row">
                            <li class="col-sm-12">
                                <label>Nama Lengkap
                                    <input type="text" required class="form-control" id="customer_name" name="customer_name" placeholder="Nama lengkap anda">
                                    <span style="color:red;" id="name_error"></span>
                                </label>
                            </li>
                            <li class="col-sm-12">
                                <label>Email
                                    <input type="text" class="form-control" name="email" id="email" placeholder="customer@email.com">
                                    <span style="color:red;" id="email_error"></span>
                                </label>
                            </li>
                            <li class="col-sm-12">
                                <label>No Telp
                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="+62817262762726">
                                    <span style="color:red;" id="phone_error"></span>
                                </label>
                            </li>
                            <li class="col-sm-12">
                                <label>Password
                                    <input type="password" name="password" class="form-control" placeholder="********">
                                </label>
                            </li>
                            <li class="col-sm-12 text-left">
                                <button type="button" class="btn-round" onclick="submit_order();">Register</button>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

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