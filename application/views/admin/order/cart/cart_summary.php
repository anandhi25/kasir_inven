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
<form method="post" id="form_order" action="<?php echo base_url()?>admin/order/save_order">
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
            <div class="input-group">
                  <span class="input-group-btn">
                    <button type="submit" class="btn bg-blue" type="button" data-placement="top" data-toggle="tooltip" data-original-title="Search Customer by ID/Number">Customer</button>
                  </span>
                <input type="text" name="customer" id="customer" class="form-control" placeholder="Customer" >
                <input type="hidden" name="customer_id" id="customer_id" value="0">
                <span class="input-group-btn">
                        <a href="<?php echo base_url('admin/customer/modal')?>" class="btn btn-success" data-toggle="modal" data-placement="top" title="View" data-target="#myModal"><span class="glyphicon glyphicon-search"></span></a>
                </span>
            </div>

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
                                <input type="text" value="<?php
                                if(empty($cart)){
                                    echo '0.00';
                                }else{ echo number_format($this->cart->total());  }

                                ?>" disabled  class="form-control unite" style="text-align: right;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-5 control-label">Discount <?php echo btn_add_modal(base_url('admin/order/modal_diskon')) ?></label>

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
                                <input type="text" value="<?php if(!empty($discount)) {echo number_format($discount_amount, 0, '.', ',') ; }else{ echo '0'; }
                                ?>" disabled class="form-control unite" style="text-align: right;">
                            </div>
                        </div>

                        <?php $total_tax = 0.00 ?>
                        <?php if (!empty($cart)): foreach ($cart as $item) : ?>
                            <?php $total_tax += $item['tax'] ?>
                        <?php endforeach; endif ?>

                        <div class="form-group">
                            <label class="col-sm-5 control-label">Tax</label>

                            <div class="col-sm-7">
                                <input type="text" value="<?php
                                if(empty($cart)){
                                    echo '0.00';
                                }else {
                                    echo number_format($total_tax, 0, '.', ',') ;
                                }
                                ?>" disabled class="form-control unite" style="text-align: right;">
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
                        <label class="col-sm-4 control-label" style="padding-top: 25px">Grand Total</label>
                            <?php $cart_total = $this->cart->total();
                            if(!empty($discount)){
                                $grand_total = $cart_total + $total_tax - $discount_amount;
                            }else{
                                $grand_total = $cart_total + $total_tax;
                            }
                            ?>
                        <div class="col-sm-8">
                            <h2 class="pull-right"><?php
                                if(empty($cart)){
                                    echo '0.00';
                                }else {
                                    echo number_format($grand_total , 0, '.', ',') ;
                                }
                                ?></h2>
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
                                    <option value="cash">Cash Payment</option>
                                    <option value="cheque">Cheque Payment</option>
                                    <option value="card">Credit Card</option>
                                    <option value="pending">Pending Order</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12" style="display: none" id="payment">

                        <div class="form-group">
                            <label class="col-sm-5 control-label">cheque/card Ref.</label>

                            <div class="col-sm-7">
                                <input class="form-control" name="payment_ref">
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
                    <button type="submit" id="btn_order" class="btn bg-navy btn-block " type="submit" <?php echo !empty($cart)?'':'disabled' ?>>Submit Order
                    </button>
                </div>
            </div>
        </div>

            <!-- hidden field -->

            <input type="hidden" name="customer_id" value="<?php  echo $this->session->userdata('customer_code') ?>">
            <input type="hidden" value="<?php echo $this->session->userdata('order_no'); ?>" name="order_no">
            <input type="hidden" value="<?php echo $grand_total; ?>" name="grand_total">
            <input type="hidden" value="<?php echo $total_tax; ?>" name="total_tax">
            <input type="hidden" value="<?php if(!empty($discount_amount)) echo $discount_amount ; ?>" name="discount_amount">
            <input type="hidden" value="<?php if(!empty($discount)) {echo number_format($discount, 0, '.', ',') ; }else{ echo '0'; }
            ?>" name="discount">


</form>