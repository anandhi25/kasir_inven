<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $title; ?></h4>
</div>

<div class="modal-body wrap-modal wrap" style="max-height: 700px;">
    <div class="row">
        <div class="col-md-12">
            <form role="form" enctype="multipart/form-data" id="data_form" action="<?php echo $url_action; ?>" method="post">
                <input type="hidden" name="district_id" value="<?php if(!empty($kecamatan)) echo $kecamatan->district_id; ?>">
                <div class="form-group">
                    <label for="district_name">Nama Kecamatan <span class="required">*</span></label>
                    <input type="text" name="district_name" id="district_name" placeholder="Nama Kecamatan"
                           value="<?php if(!empty($kecamatan)) echo $kecamatan->district_name; ?>"
                           class="form-control">
                </div>

                <div class="form-group">
                    <label for="city_id">Kota</label>
                    <select name="city_id" id="city_id" class="form-control select2" style="width: 98%;">
                        <?php
                        if(count($kecamatan) > 0)
                        {
                           echo $city;
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="fee">Tarif Ongkir <span class="required">*</span></label>
                    <input type="text" name="fee" id="fee" placeholder="00000"
                           value="<?php if(!empty($kecamatan)) echo number_format($kecamatan->fee); ?>"
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
        if($('#district_name').val() == '0')
        {
            $.notify("Nama kecamatan masih kosong!", {
                className:'error',
                clickToHide: false,
                autoHide: true,
                globalPosition: 'top center'});
            return false;
        }
        $('#data_form').submit();
    }
    $("#myModal").on('shown.bs.modal', function () {
        $('#fee').on('change input',function () {
            if($(this).val() != '')
            {
                var jumlah = removeCommas($(this).val());
                $('#fee').val(numberWithCommas(jumlah.toString()));
            }


        });

        $('#city_id').select2({
            ajax: {
                url: '<?php echo base_url('admin/customer/search_city'); ?>',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    })
</script>
