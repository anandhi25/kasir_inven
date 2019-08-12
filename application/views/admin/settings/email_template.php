<!-- View massage -->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary">
                <div class="box-header box-header-background with-border">
                    <div class="col-md-offset-3">
                        <h3 class="box-title ">Email Template</h3>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-11" style="margin-left: 20px;">

                        <div class="box-body">
                            <div id="exTab2">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a  href="#1" data-toggle="tab">Registrasi Customer</a>
                                    </li>
                                    <li><a href="#2" data-toggle="tab">Lupa Password Customer</a>
                                    </li>
                                    <li><a href="#3" data-toggle="tab">Invoice</a>
                                    </li>
                                </ul>

                                <div class="tab-content ">
                                    <div class="tab-pane active" id="1">
                                        <h3>Registrasi Customer</h3>
                                        <?php
                                        $cek_registrasi = db_get_all_data('tbl_campaign',array('campaign_name' => 'registrasi'));
                                        ?>
                                        <form id="registrasi_form" method="post" action="<?php echo base_url('admin/settings/save_registrasi'); ?>">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="registrasi_subject">Subject <span class="required">*</span></label>
                                                        <input type="text" name="registrasi_subject" id="registrasi_subject" required value="<?php

                                                        if(count($cek_registrasi) > 0)
                                                        {
                                                            echo $cek_registrasi[0]->subject;
                                                        }
                                                        else
                                                        {
                                                            echo 'Pendaftaran akun berhasil';
                                                        }
                                                        ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Content <span class="required">*</span></label>
                                                <textarea name="registrasi_content" class="form-control"><?php
                                                    if(count($cek_registrasi) > 0)
                                                    {
                                                        echo $cek_registrasi[0]->email_body;
                                                    }
                                                    ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" name="save_registrasi" class="btn btn-primary">Update</button>

                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="2">
                                        <h3>Lupa Password</h3>
                                        <form id="forgot_form" method="post" action="<?php echo base_url('admin/settings/save_forgot'); ?>">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="forgot_subject">Subject <span class="required">*</span></label>
                                                        <input type="text" name="forgot_subject" id="forgot_subject" required value="<?php
                                                        $cek_forgot = db_get_all_data('tbl_campaign',array('campaign_name' => 'forgot'));
                                                        if(count($cek_forgot) > 0)
                                                        {
                                                            echo $cek_forgot[0]->subject;
                                                        }
                                                        else
                                                        {
                                                            echo 'Request Reset Password';
                                                        }
                                                        ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Content <span class="required">*</span></label>
                                                <textarea name="forgot_content" class="form-control"><?php
                                                    if(count($cek_forgot) > 0)
                                                    {
                                                        echo $cek_forgot[0]->email_body;
                                                    }
                                                    ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" name="save_forgot" class="btn btn-primary">Update</button>

                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="3">
                                        <h3>Email Invoice</h3>
                                        <form id="forgot_form" method="post" action="<?php echo base_url('admin/settings/save_invoice'); ?>">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="invoice_subject">Subject <span class="required">*</span></label>
                                                        <input type="text" name="invoice_subject" id="invoice_subject" required value="<?php
                                                        $cek_invoice = db_get_all_data('tbl_campaign',array('campaign_name' => 'invoice'));
                                                        if(count($cek_invoice) > 0)
                                                        {
                                                            echo $cek_invoice[0]->subject;
                                                        }
                                                        else
                                                        {
                                                            echo 'Nota Pembelian';
                                                        }
                                                        ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Content <span class="required">*</span></label>
                                                <textarea name="invoice_content" class="form-control"><?php
                                                    if(count($cek_invoice) > 0)
                                                    {
                                                        echo $cek_invoice[0]->email_body;
                                                    }
                                                    ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" name="save_invoice" class="btn btn-primary">Update</button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: "textarea",
        theme: "modern",
        height: 300,
        relative_urls: false,
        remove_script_host: false,

        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor responsivefilemanager"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | responsivefilemanager | print preview media fullpage | forecolor backcolor emoticons",
        style_formats: [
            {title: 'Bold text', inline: 'b'},
            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
            {title: 'Example 1', inline: 'span', classes: 'example1'},
            {title: 'Example 2', inline: 'span', classes: 'example2'},
            {title: 'Table styles'},
            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
        ],

        external_filemanager_path:"<?php echo base_url() ?>filemanager/",
        filemanager_title:"File Manager " ,
        external_plugins: { "filemanager" : "<?php echo base_url() ?>filemanager/plugin.min.js"}



    });
</script>