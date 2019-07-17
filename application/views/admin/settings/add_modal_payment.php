<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $title; ?></h4>
</div>

<div class="modal-body wrap-modal wrap" style="max-height: 700px;">
    <div class="row">
        <div class="col-md-12">
            <form role="form" enctype="multipart/form-data" id="data_form" action="<?php echo $url_action; ?>" method="post">
                <input type="hidden" name="payment_id" value="<?php if(!empty($bayar)) echo $bayar->payment_id; ?>">
                <div class="form-group">
                    <label for="slider_title">Nama Pembayaran <span class="required">*</span></label>
                    <input type="text" name="payment_name" id="payment_name" placeholder="Nama Pembayaran"
                           value="<?php if(!empty($bayar)) echo $bayar->payment_name; ?>"
                           class="form-control">
                </div>

                <div class="form-group">
                    <label for="slider_title">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control">
                        <?php
                        if(!empty($bayar))
                        {
                            echo $bayar->description;
                        }
                        ?>
                    </textarea>
                </div>

                <div class="form-group">
                    <label>Logo Pembayaran</label>
                </div>
                <div class="form-group">
                    <input type="hidden" name="old_path"  value="<?php
                    if (!empty($bayar->payment_logo)) {
                        echo $bayar->payment_logo;
                    }
                    ?>">
                    <div class="fileinput fileinput-new"  data-provides="fileinput">
                        <div class="fileinput-new thumbnail g-logo-img" >
                            <?php if (!empty($bayar->payment_logo)): // if product image is exist then show  ?>
                                <img src="<?php echo base_url() . $bayar->payment_logo; ?>" >
                            <?php else: // if product image is not exist then defualt a image ?>
                                <img src="<?php echo base_url() ?>img/category.png" alt="Product Image">
                            <?php endif; ?>
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail g-logo-img"  ></div>
                        <div>
                            <span class="btn btn-default btn-file">
                                <span class="fileinput-new">
                                    <input type="file" name="slider_image" /></span>
                                <span class="fileinput-exists">Change</span>
                            </span>
                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                        </div>
                        <div id="valid_msg" class="required"></div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>


<div class="modal-footer" >
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary pull-right" onclick="simpan_new_data()" id="save_data_btn">Simpan</button>
</div>

<script>


    function simpan_new_data()
    {
        if($('#payment_name').val() == '0')
        {
            $.notify("Nama pembayaran masih kosong!", {
                className:'error',
                clickToHide: false,
                autoHide: true,
                globalPosition: 'top center'});
            return false;
        }
        $('#data_form').submit();
    }
    $(document).ready(function() {

    })
</script>


<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: "#description",
        theme: "modern",
        height: 100,
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
