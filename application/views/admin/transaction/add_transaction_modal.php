

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $title; ?></h4>
</div>

<div class="modal-body wrap-modal wrap" style="max-height: 700px;">
    <div class="row">
        <div class="col-md-12">
            <form role="form" enctype="multipart/form-data" id="data_form" action="<?php echo $url_action; ?>" method="post">
                <input type="hidden" name="trans_id" value="<?php if(!empty($transaction)) echo $transaction->trans_id; ?>">
                <input type="hidden" name="type_trans" value="<?php echo $type; ?>">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="trans_name">No Transaksi <span class="required">*</span></label>
                        <input type="text" name="trans_name" id="trans_name" placeholder="" readonly
                               value="<?php if(!empty($transaction)) echo $transaction->trans_name;else echo $no_trans; ?>"
                               class="form-control" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="trans_date">Tanggal <span class="required">*</span></label>
                        <input type="text" name="trans_date" id="trans_date" data-format="yyyy-mm-dd"
                               value="<?php if(!empty($transaction)) echo $transaction->trans_date;else echo date("Y-m-d"); ?>"
                               class="form-control datepicker">
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <label for="nominal">Nominal <span class="required">*</span></label>
                    <input type="text" name="nominal" id="nominal"
                           value="<?php if(!empty($transaction)) echo number_format($transaction->nominal); ?>"
                           class="form-control">
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="category_id">Category <span class="required">*</span></label>
                        <select name="category_id" id="category_id" class="form-control select2">
                            <?php
                            if(empty($transaction))
                            {
                                echo '<option value="0">Pilih Kategori Transaksi</option>';
                            }
                            else
                            {
                                echo '<option value="'.$category->category_id.'">'.$category->trans_name.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="account_id">Account <span class="required">*</span></label>
                        <select name="account_id" id="account_id" class="form-control select2">
                            <?php
                            if(empty($transaction))
                            {
                                echo '<option value="0">Pilih Akun Transaksi</option>';
                            }
                            else
                            {
                                echo '<option value="'.$account->account_id.'">'.$account->account_name.'</option>';
                            }
                            ?>

                        </select>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <label for="note">Note</label>
                    <textarea name="note" id="note" class="form-control" rows="2"><?php if(!empty($transaction)) echo $transaction->note; ?></textarea>
                </div>

                <div class="form-group col-sm-12">
                    <label>Attach</label>
                </div>
                <div class="form-group col-sm-12">
                    <input type="hidden" name="old_path"  value="<?php
                    if (!empty($transaction->attach_image)) {
                        echo $transaction->attach_image;
                    }
                    ?>">
                    <div class="fileinput fileinput-new"  data-provides="fileinput">
                        <div class="fileinput-new thumbnail g-logo-img" >
                            <?php if (!empty($transaction->attach_image)): // if product image is exist then show  ?>
                                <img src="<?php echo base_url() . $transaction->attach_image; ?>" >
                            <?php else: // if product image is not exist then defualt a image ?>
                                <img src="<?php echo base_url() ?>img/category.png" alt="Product Image">
                            <?php endif; ?>
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail g-logo-img"  ></div>
                        <div>
                            <span class="btn btn-default btn-file">
                                <span class="fileinput-new">
                                    <input type="file" name="attach_image" /></span>
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
<script src="<?php echo base_url() ?>asset/js/notify.js"></script>
<script>

    function simpan_new_data()
    {
        if($('#account_id').val() == '0')
        {
            $.notify("Anda Belum Memilih Nama Akun!", {
                className:'error',
                clickToHide: false,
                autoHide: true,
                globalPosition: 'top center'});
            return false;
        }
        if($('#category_id').val() == '0')
        {
            $.notify("Anda Belum Memilih Kategori!", {
                className:'error',
                clickToHide: false,
                autoHide: true,
                globalPosition: 'top center'});
            return false;
        }
        if($('#nominal').val() == '')
        {
            $.notify("Nominal Transaksi Masih Kosong!", {
                className:'error',
                clickToHide: false,
                autoHide: true,
                globalPosition: 'top center'});
            return false;
        }
        $('#data_form').submit();
    }

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
    });

    $("#myModal").on('shown.bs.modal', function () {

        $('#nominal').on('change input',function () {
            if($(this).val() != '')
            {
                var jumlah = removeCommas($(this).val());
                $('#nominal').val(numberWithCommas(jumlah.toString()));
            }


        });

        $("#category_id").select2({
            ajax: {
                url: '<?php echo base_url('admin/transaction/search_category/'.$type); ?>',
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

        $("#account_id").select2({
            ajax: {
                url: '<?php echo base_url('admin/settings/search_account'); ?>',
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
    });

</script>