<?php $cart = $this->cart->contents() ; ?>
<?php
$info = $this->session->userdata('business_info');
if(!empty($info->currency))
{
    $currency = $info->currency ;
}else
{
    $currency = '$';
}
?>
<style>
    #order .form-control[readonly]{
        background-color: #CACBC5;
        font-style: unset;
        font-weight: bold;
        font-size: 18px;
        color: #000;
    }

</style>
<form method="post" id="form_order" action="<?php echo $url_method;?>">
<div class="box-background">
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">


                <div class="form-group">
                    <label class="col-sm-4 control-label">Order No.</label>

                    <div class="col-sm-8">
                        <input type="text" value="<?php echo $this->session->userdata('order_no'); ?>" disabled class="form-control ">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Outlet.</label>

                    <div class="col-sm-8">
                        <?php
                       // print_r($outlets);
                        ?>
                            <select name="outlet" id="outlet" class="form-control">
                                <?php

                                if(!empty($outlets))
                                {
                                    foreach ($outlets as $outlet)
                                    {
                                ?>
                                         <option value="<?php echo $outlet->id?>"><?php echo $outlet->name;?></option>
                                    <?php
                                    }
                                }
                                ?>
                            </select>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="box-body">

    <div class="row">

        <div class="col-md-12">
            <?php
            echo $person_div;
            ?>

        </div>
    </div>
</div>

        <div class="box-background" id="order">
            <div class="box-body">
                <div class="row">

                    <div class="col-md-12">


                       <div class="form-group">
                            <label class="col-sm-5 control-label">Sub Total</label>

                            <div class="col-sm-7">
                                <input type="text" name="subtotal_txt" id="subtotal_txt" value="<?php
                                if(empty($cart)){
                                    echo '0';
                                }else{ echo number_format($this->cart->total());  }

                                ?>" readonly  class="form-control unite" style="text-align: right;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-5 control-label">Discount <?php echo btn_add_modal(base_url('admin/order/modal_diskon'),'modal_diskon') ?></label>

                            <div class="col-sm-7">
                                <?php
                                  $discount = $this->session->userdata('nominal');
                                  $tipe = $this->session->userdata('tipe');
                                  $discount_amount = 0;
                                  $cart_total = $this->cart->total();
                                  if(!empty($discount))
                                  {
                                      if($tipe == 'persen')
                                      {
                                          $discount_amount = ($discount / 100) * $cart_total;
                                      }
                                      else
                                      {
                                          $discount_amount = $discount;
                                      }
                                  }

                                ?>
                                <input type="hidden" value="<?php if(!empty($discount)) {echo $discount; }else{ echo '0'; } ?>" name="discount">
                                <input type="text" name="discount_amount" id="diskon_txt" value="<?php if(!empty($discount)) {echo number_format($discount_amount, 0, '.', ',') ; }else{ echo '0'; }
                                ?>" readonly class="form-control unite" style="text-align: right;">
                                <input type="hidden" value="<?php if(!empty($tipe)) {echo $tipe; }else{ echo ''; } ?>" name="discount_type">
                            </div>
                        </div>

                        <?php
                        $total_tax = 0;
                        $ck_tax = '';
                        ?>
                        <?php
                            if($persen_tax != '0')
                            {
                                $ck_tax = 'checked';

                                $total_all = $cart_total - $discount_amount;
                                $total_tax = ($persen_tax / 100) * $total_all;
                            }
                        ?>

                        <div class="form-group">
                            <label class="col-sm-5 control-label">Tax <input type="checkbox" <?php echo $ck_tax;?> name="pajak_ck" id="pajak_ck" value="yes" onclick="tax_ck(this)"></label>

                            <div class="col-sm-7">
                                <input type="hidden" name="persen_pajak" id="persen_pajak" value="<?php echo $persen_tax;?>">
                                <input type="text" name="total_tax" id="tax_sale" value="<?php
                                if(empty($cart)){
                                    echo '0';
                                }else {
                                    echo number_format($total_tax, 0, '.', ',') ;
                                }
                                ?>" readonly class="form-control unite" style="text-align: right;">
                            </div>
                        </div>

                    </div>


                </div>

            </div>
            <!-- /.box-body -->
        </div>



        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group" id="div_grand_total">
                        <label class="col-sm-5 control-label" style="padding-top: 25px">Grand Total</label>
                            <?php $cart_total = $this->cart->total();
                            if(!empty($discount)){
                                $grand_total = ($cart_total - $discount_amount) + $total_tax;
                            }else{
                                $grand_total = $cart_total + $total_tax;
                            }
                            ?>
                        <div class="col-sm-7">
                            <h2 class="pull-right" id="grand_total_txt"><?php
                                if(empty($cart)){
                                    echo '0';
                                }else {
                                    echo number_format($grand_total , 0, '.', ',') ;
                                }
                                ?></h2>
                            <input type="hidden" value="<?php echo $grand_total; ?>" name="grand_total" id="grand_total">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box-background">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group">
                            <label class="col-sm-5 control-label">Payment Method</label>

                            <div class="col-sm-7">
                                <select name="payment_method" class="form-control" id="order_payment_type">
                                    <option value="cash">Tunai</option>
                                    <option value="kredit">Kredit</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12" style="display: none" id="payment">

                        <div class="form-group">
                            <label class="col-sm-5 control-label">Tanggal Jatuh Tempo</label>

                            <div class="col-sm-7 input-group">
                                <input type="text" class="form-control datepicker" name="due_date" data-format="yyyy-mm-dd" value="<?php echo date("Y-m-d");?>">

                                <div class="input-group-addon">
                                    <a href="#"><i class="entypo-calendar"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 order-panel"  id="shipping">
                            <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                                <li class="active"><a href="#note" data-toggle="tab">Order Note</a>
                                </li>
                                <li><a href="#shipping_address" data-toggle="tab">Shipping</a></li>
                            </ul>
                        <div id="my-tab-content" class="tab-content">

                            <!-- ***************  Cart Tab Start ****************** -->
                                <div class="tab-pane active" id="note">
                                    <div class="form-group">
                                        <label>Order Note</label>
                                        <textarea class="form-control" name="note" rows="3" placeholder="Enter ..." id="ck_editor"></textarea>
                                    </div>
                                </div>

                            <div class="tab-pane" id="shipping_address">
                                <div class="form-group">
                                    <label>Shipping Address</label>
                                    <textarea class="form-control" rows="3" name="shipping_address" placeholder="Enter ..." id="ck_editor2"></textarea>

                                </div>
                            </div>
                    </div>


                </div>
            </div>
        </div>


        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    echo btn_submit_modal(base_url('admin/order/modal_payment'),'modal_submit');
                    ?>
                </div>
            </div>
        </div>

            <!-- hidden field -->

            <input type="hidden" name="customer_id" value="<?php  echo $this->session->userdata('customer_code') ?>">
            <input type="hidden" value="<?php echo $this->session->userdata('order_no'); ?>" name="order_no">



</form>
<script>
    function tax_ck(comp) {
        if(comp.checked == true)
        {
            var sub_total = removeCommas($('#subtotal_txt').val());
            var disk = removeCommas($('#diskon_txt').val());
            var total = sub_total - disk;
            var tax_persen = '<?php echo $persen_tax;?>';
            var hit_tax = (parseFloat(tax_persen) / 100) * total;
            var grand = total + hit_tax;
            $('#grand_total_txt').html(numberWithCommas(grand));
            $('#grand_total').val(grand);
            $('#tax_sale').val(numberWithCommas(hit_tax));
        }
        else
        {
            $('#tax_sale').val('0');
            var sub_total = removeCommas($('#subtotal_txt').val());
            var disk = removeCommas($('#diskon_txt').val());
            var total = sub_total - disk;
            $('#grand_total_txt').html(numberWithCommas(total));
            $('#grand_total').val(total);

        }
    }
</script>