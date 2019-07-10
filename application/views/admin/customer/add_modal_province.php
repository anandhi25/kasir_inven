<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $title; ?></h4>
</div>

<div class="modal-body wrap-modal wrap" style="max-height: 700px;">
    <div class="row">
        <div class="col-md-12">
            <form role="form" enctype="multipart/form-data" id="data_form" action="<?php echo $url_action; ?>" method="post">
                <input type="hidden" name="state_id" value="<?php if(!empty($state)) echo $state->state_id; ?>">
                <div class="form-group">
                    <label for="state_name">Nama Propinsi <span class="required">*</span></label>
                    <input type="text" name="state_name" id="state_name" placeholder="Nama Propinsi"
                           value="<?php if(!empty($state)) echo $state->state_name; ?>"
                           class="form-control">
                </div>

                <div class="form-group">
                    <label for="slider_url">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control" rows="3"><?php if(!empty($state)) echo $state->description;?></textarea>
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
        if($('#state_name').val() == '0')
        {
            $.notify("Nama propinsi masih kosong!", {
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
