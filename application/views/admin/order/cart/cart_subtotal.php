<?php
$discount = $this->session->userdata('nominal');
$tipe = $this->session->userdata('tipe');
$discount_amount = 0;
$cart_total = $this->cart->total();
$total_tax = 0;
$ck_tax = '';
?>
<div class="box-background">
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