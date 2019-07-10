<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $title; ?></h4>
</div>

<div class="modal-body wrap-modal wrap" style="max-height: 700px;">
    <div class="row">
        <div class="col-md-12">
            <form role="form" enctype="multipart/form-data" id="data_form" action="<?php echo $url_action; ?>" method="post">
                <input type="hidden" name="slider_id" value="<?php if(!empty($slide)) echo $slide->id; ?>">
                <div class="form-group">
                    <label for="slider_title">Nama Slider <span class="required">*</span></label>
                    <input type="text" name="slider_title" id="slider_title" placeholder="Nama Slider"
                           value="<?php if(!empty($slide)) echo $slide->slider_title; ?>"
                           class="form-control">
                </div>

                <div class="form-group">
                    <label for="slider_url">URL Slider <span class="required">*</span></label>
                    <input type="text" name="slider_url" id="slider_url" placeholder="URL slider"
                           value="<?php if(!empty($slide)) echo $slide->slider_url; ?>"
                           class="form-control">
                </div>

                <div class="form-group">
                    <label>Image</label>
                </div>
                <div class="form-group">
                    <input type="hidden" name="old_path"  value="<?php
                    if (!empty($transaction->attach_image)) {
                        echo $transaction->attach_image;
                    }
                    ?>">
                    <div class="fileinput fileinput-new"  data-provides="fileinput">
                        <div class="fileinput-new thumbnail g-logo-img" >
                            <?php if (!empty($slide->slider_image)): // if product image is exist then show  ?>
                                <img src="<?php echo base_url() . $slide->slider_image; ?>" >
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
    <button type="button" class="btn btn-default pull-left" onclick="close_modal_diskon();">Close</button>
    <button type="button" class="btn btn-primary pull-right" onclick="simpan_new_data()" id="save_data_btn">Simpan</button>
</div>

<script>

    function close_modal_diskon() {
        $('#myModal').modal('toggle');
    }
    function simpan_new_data()
    {
        if($('#slider_title').val() == '0')
        {
            $.notify("Anda Belum Memilih Nama Akun!", {
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
