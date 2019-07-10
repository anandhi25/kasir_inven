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

<!--Massage-->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<!--/ Massage-->


<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary">
                <div class="box-header box-header-background with-border">
                    <div class="col-md-offset-3">
                        <h3 class="box-title "><?php echo $title;?></h3>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-background">
                    <!-- form start -->
                    <form role="form" enctype="multipart/form-data" action="<?php echo base_url() ?>admin/report/profit_loss_report" method="post">

                        <div class="row">

                            <div class="col-md-4 col-sm-12 col-xs-12 col-md-offset-3">

                                <div class="box-body">


                                    <div class="form-group">
                                        <label class="control-label">Start Date<span class="required"> *</span></label>

                                        <div class="input-group">
                                            <input type="text" value="" class="form-control datepicker" name="start_date" data-format="yyyy/mm/dd" required>

                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">End Date<span class="required"> *</span></label>
                                        <div class="input-group">
                                            <input type="text" value="" class="form-control datepicker" name="end_date" data-format="yyyy/mm/dd" required>

                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn bg-navy" type="submit">Generate Report
                                    </button><br/><br/>
                                </div>
                                <!-- /.box-body -->

                            </div>
                        </div>

                    </form>
                </div>

                <?php if (!empty($profit_loss)) :?>
                    <div class="box-body">

                        <div class="row ">
                            <div class="col-md-8 col-md-offset-2">
                                <form method="post" action="<?php echo base_url(); ?>admin/report/pdf_purchase_report">
                                    <div class="btn-group pull-right">
                                        <a onclick="print_invoice('printableArea')" class="btn btn-primary">Print</a>

                                        <button type="submit" class="btn bg-navy">
                                            PDF
                                        </button>
                                        <input type="hidden" name="start_date" value="<?php echo $start_date ?>">
                                        <input type="hidden" name="end_date" value="<?php echo $end_date ?>">

                                    </div>
                                </form>

                            </div>
                        </div>

                        <br/>
                        <br/>

                        <div id="printableArea">
                            <link href="<?php echo base_url(); ?>asset/css/sales_report.css" rel="stylesheet" type="text/css" />



                            <div class="row ">
                                <div class="col-md-8 col-md-offset-2">

                                    <header class="clearfix">
                                        <div id="logo">
                                            <img src="<?php  echo base_url(). $logo?>">
                                        </div>
                                        <div id="company">
                                            <h2 class="name"><?php echo $company_name?></h2>
                                            <div><?php echo $company_phone?></div>
                                            <div><?php echo $company_email?></div>
                                        </div>

                                    </header>
                                    <hr/>

                                    <main class="invoice_report">

                                        <h4 style="text-align: center">Laporan Laba Rugi: <strong><?php echo $start_date ?></strong> to <strong><?php echo $end_date ?></strong></h4>
                                        <br/>
                                        <br/>
                                        <table cellpadding="0" cellspacing="0" style="width: 100%;float: left;">
                                            <tr>
                                                <td colspan="3" style="text-align: left"><strong>Pendapatan</strong></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left">Penjualan Bersih</td>
                                                <td>Rp <?php echo number_format($jual_bersih);?></td>
                                                <td></td>
                                            </tr>
                                            <?php
                                            $total_pendapatan = $jual_bersih;
                                            if(count($pendapatan) > 0)
                                            {
                                                foreach ($pendapatan as $inc)
                                                {
                                                    $total_pendapatan = $total_pendapatan + $inc['total'];
                                                    echo ' <tr>
                                                            <td style="text-align: left">'.$inc['trans_name'].'</td>
                                                            <td>Rp '.number_format($inc['total']).'</td>
                                                            <td></td>
                                                        </tr>';
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <td style="text-align: left">Total Pendapatan</td>
                                                <td></td>
                                                <td>Rp <?php echo number_format($total_pendapatan);?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="text-align: left"><strong>Biaya</strong></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left">Harga Pokok Penjualan</td>
                                                <td>Rp <?php echo number_format($hpp);?></td>
                                                <td></td>
                                            </tr>
                                            <?php
                                            $total_beban = $hpp;
                                            if(count($beban) > 0)
                                            {
                                                foreach ($beban as $inc)
                                                {
                                                    $total_beban = $total_beban + $inc['total'];
                                                    echo ' <tr>
                                                            <td style="text-align: left">'.$inc['trans_name'].'</td>
                                                            <td>Rp '.number_format($inc['total']).'</td>
                                                            <td></td>
                                                        </tr>';
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <td style="text-align: left">Total Biaya</td>
                                                <td></td>
                                                <td>Rp <?php echo number_format($total_beban);?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <?php
                                                       $laba = $total_pendapatan-$total_beban;
                                                 ?>
                                                <td style="text-align: left"><strong>Laba Bersih</strong></td>
                                                <td></td>
                                                <td>Rp <?php echo number_format($laba); ?></td>
                                            </tr>
                                        </table>


                                    </main>
                                    <hr/>
                                    <footer class="text-center">
                                        <strong><?php echo $company_name?></strong>&nbsp;&nbsp;&nbsp;<?php echo $address ?>
                                    </footer>


                                </div>
                            </div>

                        </div>


                    </div>
                    <!-- /.box -->
                <?php endif ?>
            </div>
            <!--/.col end -->
        </div>
        <!-- /.row -->
</section>


