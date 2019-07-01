<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $title; ?></h4>
</div>
<div class="modal-body wrap-modal wrap" style="max-height: 700px;">
    <div class="row">
        <div class="col-md-12">
            <form id="form-serial" method="POST" action="<?php echo $url;?>">
                <input type="hidden" name="row_id" value="<?php echo $row_id; ?>">
            <?php
            $cart = $this->cart->contents() ;
            $qty = 0;
            $arr_data = '';
            if (!empty($cart)){
                foreach ($cart as $item)
                {
                    if($item['rowid'] == $row_id)
                    {
                        $qty = $item['qty'];
                        $arr_data = $item['serial'];
                    }
                }
            }
            for ($i=0;$i<$qty;$i++)
            {
                $inp_serial = '';
                if(count($arr_data) > 0)
                {
                    if(!empty($arr_data[$i]))
                    {
                        $inp_serial = $arr_data[$i];
                    }
                }
                echo '<div class="form-group">
                        <input type="text" name="serial[]" class="form-control" value="'.$inp_serial.'">
                      </div>';
            }

            ?>
        </div>
        </form>
    </div>

</div>
<div class="modal-footer" >

    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
    <span class="loading" style="display: none;"><img src="<?= base_url(); ?>/img/loading-spin-primary.svg"> <i>Loading proses simpan data...</i></span>
    <button type="button" class="btn btn-success" id="save_btn" onclick="simpan_serial();">Save</button>

</div>


<script>
    function simpan_serial()
    {
        var form_post = $('#form-serial');
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


</script>