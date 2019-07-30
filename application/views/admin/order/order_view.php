<script src="<?php echo base_url(); ?>asset/js/ajax.js" xmlns="http://www.w3.org/1999/html"></script>
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

<?php
//company logo
if(!empty($info->logo)){
    $logo = $info->logo;
}else{
    $logo = 'img/logo.png';
}

//company details
if(!empty($info->company_name)){
    $company_name = $info->company_name;
}else{
    $company_name = 'Your Company Name';
}
//company phone
if(!empty($info->phone)){
    $company_phone = $info->phone;
}else{
    $company_phone = 'Company Phone';
}
//company email
if(!empty($info->email)){
    $company_email = $info->email;
}else{
    $company_email = 'Company Email';
}
//company address
if(!empty($info->address)){
    $address = $info->address;
}else{
    $address = 'Company Address';
}



?>

<div class="box">
    <div class="box-header box-header-background with-border">
        <h3 class="box-title">View Order</h3>
        <div class="box-tools pull-right">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
            <div class="box-tools">
                <div class="btn-group" role="group" >
                    <a onclick="print_invoice('printableArea2')" class="btn btn-default ">Print</a>
                    <a onclick="print_invoice('printableAreaDO')" class="btn btn-default ">Print Surat Jalan</a>

                </div>
            </div>

        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">

        <div id="printableArea2" style="display: none;">
            <div class="row ">
                <div class="col-md-8 col-md-offset-2">
                    <h2 class="name"><?php echo $company_name ?></h2>
                    <div><?php echo $company_phone?></div>
                    <div><?php echo $company_email?></div>
                </div>
            </div>
            <hr style="border-top: dashed 1px black;">
            <p>   </p>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <table style="width: 95%;">
                        <tbody>
                        <?php $counter = 1?>
                        <?php foreach($order_details as $v_order){
                            echo '<tr>';
                            echo '<td colspan="5">'.$v_order->product_name.'</td>
                        </tr><tr>';
                            echo '<td style="width: 20%;text-align: right;">'.number_format($v_order->selling_price, 0)."</td>".'<td style="width: 20%;text-align: center;"> x </td><td style="width: 20%;text-align: center;;">'.$v_order->product_quantity.'</td><td style="width: 20%;text-align: center;"> = </td>'.'<td style="width: 20%;text-align: right;">'.number_format($v_order->selling_price * $v_order->product_quantity, 0).'</td>';
                            echo '</tr>';
                        } ?>
                        </tbody>
                        <tfoot>
                        <tr style="border-top: dashed 1px black;">
                            <td colspan="5"> </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: right;">SUBTOTAL</td>
                            <td style="text-align: right;">Rp</td>
                            <td style="text-align: right;"><?php echo number_format($order_info->subtotal,0) ?></td>
                        </tr>

                        <?php if($order_info->discount):?>
                            <tr>
                                <td colspan="3" style="text-align: right;">Diskon</td>
                                <td style="text-align: right;">Rp</td>
                                <td style="text-align: right;"><?php echo number_format($order_info->discount_amount,0) ?></td>
                            </tr>
                        <?php endif; ?>

                        <tr>
                            <td colspan="3" style="text-align: right;">Pajak</td>
                            <td style="text-align: right;">Rp</td>
                            <td style="text-align: right;"><?php echo number_format($order_info->tax,0) ?></td>
                        </tr>

                        <tr>
                            <td colspan="3" style="text-align: right;">GRAND TOTAL</td>
                            <td style="text-align: right;">Rp</td>
                            <td style="text-align: right;"><?php echo number_format($order_info->grand_total,0) ?></td>
                        </tr>
                        </tfoot>
                    </table>
                    <br>
                </div>
            </div>
        </div>


        <div id="printableArea">
            <link href="<?php echo base_url(); ?>asset/css/invoice.css" rel="stylesheet" type="text/css" />
            <div class="row ">
                <div class="col-md-8 col-md-offset-2">

                    <main>
                        <div id="details" class="clearfix">
                            <div id="client" style="margin-right: 100px">
                                <div class="to">CUSTOMER BILLING INFO:</div>
                                <h2 class="name"><?php echo $order_info->customer_name ?></h2>
                                <div class="address"><?php echo $order_info->customer_address ?></div>
                                <div class="address"><?php echo $order_info->customer_phone ?></div>
                                <div class="email"><?php echo $order_info->customer_email ?></div>
                            </div>


                            <div id="invoice">
                                <h1>ORDER <?php echo $order_info->order_no ?></h1>
                                <div class="date">Tanggal: <?php echo date('Y-m-d', strtotime($order_info->order_date))  ?></div>
                                <div class="date">Sales: <?php echo $order_info->sales_person ?></div>

                            </div>
                        </div>
                        <table border="0" cellspacing="0" cellpadding="0">
                            <thead>
                            <tr>
                                <th class="no text-right">#</th>
                                <th class="desc">PRODUK</th>
                                <th class="unit text-right">HARGA</th>
                                <th class="qty text-right">QUANTITY</th>
                                <th class="total text-right ">TOTAL</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $counter = 1?>
                            <?php foreach($order_details as $v_order): ?>
                            <tr>
                                <td class="no"><?php echo $counter ?></td>
                                <td class="desc"><h3><?php echo $v_order->product_name ?></h3></td>
                                <td class="unit"><?php echo number_format($v_order->selling_price, 2); ?></td>
                                <td class="qty"><?php echo $v_order->product_quantity ?></td>
                                <td class="total"><?php echo number_format($v_order->sub_total,2) ?></td>
                            </tr>
                                <?php $counter ++?>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">SUBTOTAL</td>
                                <td><?php echo number_format($order_info->subtotal,2) ?></td>
                            </tr>

                            <?php if($order_info->discount):?>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">DISKON</td>
                                    <td><?php echo number_format($order_info->discount_amount,2) ?></td>
                                </tr>
                            <?php endif; ?>

                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">PAJAK</td>
                                <td><?php echo number_format($order_info->tax,2) ?></td>
                            </tr>


                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">GRAND TOTAL</td>
                                <td><?php echo $currency.' '.number_format($order_info->grand_total,2) ?></td>
                            </tr>
                            <?php
                            if($order_info->payment_method == 'kredit') {
                                ?>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">UANG MUKA</td>
                                    <td><?php echo $currency . ' ' . number_format($order_info->down_payment, 0) ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tfoot>
                        </table>

                    </main>
                    <hr/>
                    <footer class="text-center">
                        <strong><?php echo $company_name?></strong>&nbsp;&nbsp;&nbsp;<?php echo $address ?>
                    </footer>


                </div>
            </div>
        </div>

        <div id="printableAreaDO" style="display: none;">
            <link href="<?php echo base_url(); ?>asset/css/invoice.css" rel="stylesheet" type="text/css" />
            <div class="row ">
                <div class="col-md-8 col-md-offset-2">

                    <main>
                        <div id="details" class="clearfix">
                            <div id="client" style="margin-right: 100px">
                                <div class="to">CUSTOMER INFO:</div>
                                <h2 class="name"><?php echo $order_info->customer_name ?></h2>
                                <div class="address"><?php echo $order_info->customer_address ?></div>
                                <div class="address"><?php echo $order_info->customer_phone ?></div>
                                <div class="email"><?php echo $order_info->customer_email ?></div>
                            </div>


                            <div id="invoice">
                                <h1>ORDER <?php echo $order_info->order_no ?></h1>
                                <div class="date">Tanggal: <?php echo date('Y-m-d', strtotime($order_info->order_date))  ?></div>
                                <div class="date">Sales: <?php echo $order_info->sales_person ?></div>

                            </div>
                        </div>
                        <table border="0" cellspacing="0" cellpadding="0">
                            <thead>
                            <tr>
                                <th class="no text-right">#</th>
                                <th class="desc">PRODUK</th>
                                <th class="qty text-right">QUANTITY</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $counter = 1?>
                            <?php foreach($order_details as $v_order): ?>
                                <tr>
                                    <td class="no"><?php echo $counter ?></td>
                                    <td class="desc"><h3><?php echo $v_order->product_name ?></h3></td>
                                    <td class="qty"><?php echo $v_order->product_quantity ?></td>
                                </tr>
                                <?php $counter ++?>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>

                    </main>
                    <hr/>
                    <footer class="text-center">
                        <strong><?php echo $company_name?></strong>&nbsp;&nbsp;&nbsp;<?php echo $address ?>
                    </footer>


                </div>
            </div>
        </div>


    </div><!-- /.box-body -->
</div><!-- /.box -->





