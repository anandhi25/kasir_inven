<?php $this->load->view('admin/components/header'); ?>
<link href="<?php echo base_url(); ?>asset/css/animation.css" rel="stylesheet">

<body class="login-page">

<?php
$error = $this->session->flashdata('error');
?>
<div class="login-box">
    <div class="login-logo animated fadeInDown" data-animation="fadeInDown">
        <a href="<?php echo base_url() ?>"><b>Easy</b>Inventory </a>
    </div><!-- /.login-logo -->
    <div class="login-box-body  animated fadeInUp" data-animation="fadeInUp">
        <p class="login-box-msg">Sign in to start your session</p>
        <form action="<?php echo base_url('login/signin') ?>" method="POST">
            <?php echo validation_errors(); ?>
            <?php if (!empty($error)) { echo '<div class="alert alert-danger">'.$error.'</div>'; }?>
            <div class="form-group has-feedback">
                <input type="text" name="user_name" class="form-control" placeholder="Username" required="required" />
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Password" required="required" />
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <button type="submit" class="btn bg-orange btn-block btn-flat">Login</button>
            </div>
            <div class="row">

                <div class="col-xs-12">

                </div><!-- /.col -->
            </div>
        </form>



        <a href="<?php echo base_url()?>forget_password">I forgot my password</a><br>

    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->


</body>
</html>