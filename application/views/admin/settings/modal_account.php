<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $title; ?></h4>
</div>

<div class="modal-body wrap-modal wrap" style="max-height: 700px;">
    <div class="row">
        <div class="col-md-12">
            <form role="form" enctype="multipart/form-data" id="diskon_form" action="<?php echo $url_action; ?>" method="post">
                <input type="hidden" name="account_id" value="<?php if(!empty($account)) echo $account->account_id; ?>">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama Account <span class="required">*</span></label>
                    <input type="text" name="account_name" id="account_name" placeholder="Nama Account"
                           value="<?php if(!empty($account)) echo $account->account_name; ?>"
                           class="form-control">
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Kode Account <span class="required">*</span></label>
                    <input type="text" name="account_code" id="account_code" placeholder="Kode Account"
                           value="<?php if(!empty($account)) echo $account->account_code; ?>"
                           class="form-control">
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
        var form_post = $('#diskon_form');
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
                    window.location.href = 'account';
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
