<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $title; ?></h4>
</div>

<div class="modal-body wrap-modal wrap" style="max-height: 700px;">
    <div class="row">
        <div class="col-md-12">
            <form role="form" enctype="multipart/form-data" id="data_form" action="<?php echo $url_action; ?>" method="post">
                <input type="hidden" name="popup_id" value="<?php if(!empty($popup)) echo $popup->popup_id; ?>">
                <div class="form-group">
                    <label for="slider_title">Halaman <span class="required">*</span></label>
                    <select name="page_id" id="page_id" class="form-control">
                        <?php
                        if(count($page) > 0)
                        {
                            foreach ($page as $p)
                            {
                                $sel = '';
                                if(!empty($popup))
                                {
                                    if($p->page_id == $popup->page_id)
                                    {
                                        $sel = 'selected';
                                    }
                                }
                                echo '<option value="'.$p->page_id.'" '.$sel.'>'.$p->title.'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="slider_title">URL</label>
                    <input type="text" name="popup_url" id="popup_url" placeholder="URL"
                           value="<?php if(!empty($popup)) echo $popup->popup_url; ?>"
                           class="form-control">
                </div>

                <div class="form-group">
                    <label>Image</label>
                </div>
                <div class="form-group">
                    <input type="hidden" name="old_path"  value="<?php
                    if (!empty($popup->popup_image)) {
                        echo $popup->popup_image;
                    }
                    ?>">
                    <div class="fileinput fileinput-new"  data-provides="fileinput">
                        <div class="fileinput-new thumbnail g-logo-img" >
                            <?php if (!empty($popup->popup_image)): // if product image is exist then show  ?>
                                <img src="<?php echo base_url() . $popup->popup_image; ?>" >
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
                <div class="form-group">
                    <label for="slider_title">Keluar Sekali</label>
                    <select name="show_once" id="show_once" class="form-control" style="width: 50%;">
                        <option value="0" <?php
                        if(!empty($popup))
                        {
                            if($popup->show_once == '0')
                            {
                                echo 'selected';
                            }
                        }
                        ?>>TIDAK</option>
                        <option value="1" <?php
                        if(!empty($popup))
                        {
                            if($popup->show_once == '1')
                            {
                                echo 'selected';
                            }
                        }
                        ?>>YA</option>
                    </select>
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
