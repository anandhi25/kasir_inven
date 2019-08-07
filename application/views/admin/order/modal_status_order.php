<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $title; ?></h4>
</div>

<div class="modal-body wrap-modal wrap" style="max-height: 700px;">
    <div class="row">
        <div class="col-md-12">
            <form role="form" enctype="multipart/form-data" id="status_form" action="<?php echo $url_action; ?>" method="post">
                <input type="hidden" name="order_id" value="<?php echo $order_info->order_id; ?>">
                <div class="form-group">
                    <label for="exampleInputEmail1">Status Order <span class="required">*</span></label>
                    <select name="status_order" id="status_order" class="form-control">
                        <option value="0" <?php
                        if($order_info->order_status == '0')
                        {
                            echo 'selected';
                        }
                        ?>>Pending</option>
                        <option value="1" <?php
                        if($order_info->order_status == '1')
                        {
                            echo 'selected';
                        }
                        ?>>Batal</option>
                        <option value="2" <?php
                        if($order_info->order_status == '2')
                        {
                            echo 'selected';
                        }
                        ?>>Confirm</option>
                    </select>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal-footer" >
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary pull-right" onclick="simpan_diskon_br()" id="save_diskon_btn">Simpan</button>
</div>

<script>
    function simpan_diskon_br()
    {
        var form_post = $('#status_form');
        var data_post = form_post.serializeArray();
        $('.loading').show();

        $.ajax({
            url: form_post.attr('action'),
            type: 'POST',
            dataType: 'json',
            data: data_post,
        })
            .done(function(res) {
                if (res.success) {
                    window.location.href = 'manage_order';

                } else {
                    alert('Data gagal disimpan');
                }

            })
            .fail(function() {
                alert('Data gagal disimpan');
            })
            .always(function() {
                $('.loading').hide();
            });

        return false;
    }
</script>