<style type="text/css">
    .switch-field {
        display: flex;
        margin-bottom: 36px;
        overflow: hidden;
    }

    .switch-field input {
        position: absolute !important;
        clip: rect(0, 0, 0, 0);
        height: 1px;
        width: 1px;
        border: 0;
        overflow: hidden;
    }

    .switch-field label {
        background-color: #e4e4e4;
        color: rgba(0, 0, 0, 0.6);
        font-size: 14px;
        line-height: 1;
        text-align: center;
        padding: 8px 16px;
        margin-right: -1px;
        border: 1px solid rgba(0, 0, 0, 0.2);
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
        transition: all 0.1s ease-in-out;
    }

    .switch-field label:hover {
        cursor: pointer;
    }

    .switch-field input:checked + label {
        background-color: #a5dc86;
        box-shadow: none;
    }

    .switch-field label:first-of-type {
        border-radius: 4px 0 0 4px;
    }

    .switch-field label:last-of-type {
        border-radius: 0 4px 4px 0;
    }
</style>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $title; ?></h4>
</div>
<div class="modal-body wrap-modal wrap" style="max-height: 900px;">
    <div class="row">
        <div class="col-md-12">
            <form id="form-attr" method="POST" action="<?php echo $url;?>">
                <input type="hidden" name="row_id" value="<?php echo $row_id; ?>">
                     <?php
                            $cart = $this->cart->contents() ;
                            $product_id = '';
                            $arr_data = '';
                            if (!empty($cart)){
                                foreach ($cart as $item)
                                {
                                    if($item['rowid'] == $row_id)
                                    {
                                        $product_id = $item['product_id'];
                                        $arr_data = $item['attribute'];
                                    }
                                }
                            }

                            if(!empty($all_attribute))
                            {
                                foreach ($all_attribute as $attr)
                                {

                                    $this->order_model->_table_name = 'tbl_attribute';
                                    $this->order_model->_order_by = 'attribute_id';
                                    $where_attr = array('product_id' => $product_id,'attribute_set_id' => $attr->attribute_set_id);
                                    $check_attrib = $this->order_model->get_by($where_attr);
                                    if(count($check_attrib) > 0) {
                                        echo '<h4>'.$attr->attribute_name.'</h4>';
                                        ?>
                                        <div class="box">
                                            <div class="box-body">
                                                <div class="switch-field">
                                                    <?php

                                                    foreach ($check_attrib as $attrib) {
                                                        $checked = '';
                                                        if(count($arr_data) > 0) {
                                                            foreach ($arr_data as $data_attr)
                                                            {
                                                                if($data_attr == $attrib->attribute_id)
                                                                {
                                                                    $checked = 'checked';
                                                                }
                                                            }

                                                        }
                                                        ?>
                                                        <input type="radio" <?php echo $checked;?>
                                                               id="<?php echo $attrib->attribute_id; ?>"
                                                               name="attribute[]"
                                                               value="<?php echo $attrib->attribute_id; ?>"
                                                        />
                                                        <label for="<?php echo $attrib->attribute_id; ?>"><?php echo $attrib->attribute_value; ?></label>&nbsp;&nbsp;&nbsp;
                                                        <?php
                                                    }
                                                        ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            }

                     ?>



            </form>
        </div>
    </div>
</div>
<div class="modal-footer" >

    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
    <span class="loading" style="display: none;"><img src="<?= base_url(); ?>/img/loading-spin-primary.svg"> <i>Loading proses simpan data...</i></span>
    <button type="button" class="btn btn-success" id="save_btn" onclick="simpan();">Save</button>

</div>


<script>
    function simpan()
    {
        var form_post = $('#form-attr');
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
