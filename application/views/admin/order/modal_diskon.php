<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $title; ?></h4>
</div>

<div class="modal-body wrap-modal wrap" style="max-height: 700px;">
    <div class="row">
        <div class="col-md-12">
            <form role="form" enctype="multipart/form-data" id="diskon_form" action="<?php echo base_url(); ?>admin/order/save_diskon" method="post">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nominal Diskon <span class="required">*</span></label>
                        <input type="text" name="nominal_diskon" id="nominal_diskon" placeholder="00"
                               value="<?php if(!empty($nominal_diskon)) echo $nominal_diskon; ?>"
                               class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tipe Diskon <span class="required">*</span></label>
                        <select class="form-control" name="tipe_diskon" id="tipe_diskon">
                            <option value="persen" <?php if(!empty($tipe_diskon)) { if($tipe_diskon == 'persen') echo 'selected'; }?> >Persentase</option>
                            <option value="fix" <?php if(!empty($tipe_diskon)) { if($tipe_diskon == 'fix') echo 'selected'; }?> >Fix</option>
                        </select>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>


<div class="modal-footer" >
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary pull-right" onclick="simpan_disk();" id="save_btn">Simpan</button>
</div>

<script>
    function simpan_disk()
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
                    $("#order").load(location.href + " #order");
                    $("#div_grand_total").load(location.href + " #div_grand_total");
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
