<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $title; ?></h4>
</div>

<div class="modal-body wrap-modal wrap" style="max-height: 700px;">
    <div class="row">
        <div class="col-md-12">
            <form role="form" enctype="multipart/form-data" id="data_form" action="<?php echo $url_action; ?>" method="post">
                <input type="hidden" name="category_id" value="<?php if(!empty($category)) echo $category->category_id; ?>">
                <div class="form-group">
                    <label for="category_name">Nama Kategori <span class="required">*</span></label>
                    <input type="text" name="category_name" id="category_name" placeholder="Nama Account"
                           value="<?php if(!empty($category)) echo $category->trans_name; ?>"
                           class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="trans_type">Tipe Kategori <span class="required">*</span></label>
                    <select name="trans_type" id="trans_type" class="form-control">
                        <option value="pendapatan" <?php if(!empty($category)) {if($category->trans_type == 'pendapatan') echo 'selected';} ?>>Pendapatan</option>
                        <option value="pengeluaran" <?php if(!empty($category)) {if($category->trans_type == 'pengeluaran') echo 'selected';} ?>>Pengeluaran</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="category_name">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control" rows="3"><?php if(!empty($category)) echo $category->description; ?></textarea>
                </div>


            </form>
        </div>
    </div>
</div>


<div class="modal-footer" >
    <button type="button" class="btn btn-default pull-left" onclick="close_modal_diskon();">Close</button>
    <button type="button" class="btn btn-primary pull-right" onclick="simpan_new_data()" id="save_data_btn">Simpan</button>
</div>
<script src="<?php echo base_url() ?>asset/js/notify.js"></script>

<script>

    function close_modal_diskon() {
        $('#myModal').modal('toggle');
    }
    function simpan_new_data()
    {
        if($('#category_name').val() == '')
        {
            $.notify("Nama Kategori Masih kosong!", "error");
            //show_notification('Nama Kategori Masih Kosong','danger');
            return false;
        }
        var form_post = $('#data_form');
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
                    window.location.href = 'category';
                    $('#myModal').modal('toggle');

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
    $(document).ready(function() {

    })
</script>
