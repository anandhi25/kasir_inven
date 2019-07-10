<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $title; ?></h4>
</div>

<div class="modal-body wrap-modal wrap" style="max-height: 700px;">
    <div class="row">
        <div class="col-md-12">
            <form role="form" enctype="multipart/form-data" id="data_form" action="<?php echo $url_action; ?>" method="post">
                <input type="hidden" name="city_id" value="<?php if(!empty($city)) echo $city->city_id; ?>">
                <div class="form-group">
                    <label for="city_name">Nama Kota <span class="required">*</span></label>
                    <input type="text" name="city_name" id="city_name" placeholder="Nama Kota"
                           value="<?php if(!empty($city)) echo $city->city_name; ?>"
                           class="form-control">
                </div>

                <div class="form-group">
                    <label for="state_id">Propinsi</label>
                    <select name="state_id" id="state_id" class="form-control select2" style="width: 98%;">
                        <?php
                        if(count($state) > 0)
                        {
                            foreach ($state as $prop)
                            {
                                $sel = '';
                                if($prop->state_id == $city->state_id)
                                {
                                    $sel = 'selected';
                                }
                                echo '<option value="'.$prop->state_id.'" '.$sel.'>'.$prop->state_name.'</option>';
                            }
                        }
                        ?>
                    </select>
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
        if($('#city_name').val() == '0')
        {
            $.notify("Nama kota masih kosong!", {
                className:'error',
                clickToHide: false,
                autoHide: true,
                globalPosition: 'top center'});
            return false;
        }
        $('#data_form').submit();
    }
    $("#myModal").on('shown.bs.modal', function () {
        $('#state_id').select2();
    })
</script>
