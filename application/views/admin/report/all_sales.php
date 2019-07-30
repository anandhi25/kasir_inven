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
                        <h3 class="box-title ">Sales Report</h3>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-background">
                    <!-- form start -->
                    <form role="form" class="form-horizontal" enctype="multipart/form-data" action="<?php echo base_url() ?>admin/report/sales" autocomplete="off" method="post">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Start Date<span class="required"> *</span></label>

                                        <div class="input-group">
                                            <input type="text" value="<?php if(!empty($start_date)) echo $start_date ?>" class="form-control datepicker" name="start_date" data-format="yyyy/mm/dd" required>

                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-left: 10px;">
                                        <label class="control-label">End Date<span class="required"> *</span></label>
                                        <div class="input-group">
                                            <input type="text" value="<?php if(!empty($end_date)) echo $end_date ?>" class="form-control datepicker" name="end_date" data-format="yyyy/mm/dd" required>

                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-left: 10px;">
                                        <label class="control-label">Toko<span class="required"> *</span></label>
                                        <div class="input-group">
                                            <select name="outlet" id="outlet" class="form-control">
                                                <option value="0" <?php if(!empty($outlet)){ if($outlet == '0') echo 'selected';} ?>>Semua</option>
                                                <?php
                                                if(count($toko) > 0)
                                                {
                                                    foreach ($toko as $tok)
                                                    {
                                                        $sel = '';
                                                        if(!empty($outlet)){
                                                            if($outlet == $tok->outlet_id)
                                                            {
                                                                $sel = 'selected';
                                                            }
                                                        }
                                                        echo '<option value="'.$tok->outlet_id.'" '.$sel.'>'.$tok->name.'</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" >
                                        <label class="control-label">Filter<span class="required"> *</span></label>
                                        <div class="input-group">
                                            <select name="filter" id="filter" class="form-control">
                                                <option value="total" <?php if(!empty($filter)){ if($filter == 'total') echo 'selected';} ?>>Total</option>
                                                <option value="cash" <?php if(!empty($filter)){ if($filter == 'cash') echo 'selected';} ?>>Tunai</option>
                                                <option value="kredit" <?php if(!empty($filter)){ if($filter == 'kredit') echo 'selected';} ?>>Kredit</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <button type="submit" class="btn bg-navy" type="submit">Generate Report
                                    </button>

                                </div>
                            </div>
                        </div>
                        <br>

                    </form>
                </div>


                <div class="box-body">
                    <?php
                    if(!empty($start_date))
                    {
                    ?>
                    <div class="row ">
                        <div class="col-md-8 col-md-offset-2">
                            <form method="post" action="<?php echo base_url(); ?>admin/report/pdf_sales_report">
                                <div class="btn-group pull-right">
                                    <a onclick="print_invoice('printableArea')" class="btn btn-primary">Print</a>

                                    <button type="submit" class="btn bg-navy">
                                        PDF
                                    </button>
                                    <input type="hidden" id="start_date" name="start_date" value="<?php if(!empty($start_date)) echo $start_date ?>">
                                    <input type="hidden" id="end_date" name="end_date" value="<?php if(!empty($end_date)) echo $end_date ?>">
                                    <input type="hidden" id="outlet_id" name="outlet" value="<?php if(!empty($start_date)) echo $outlet ?>">
                                    <input type="hidden" id="filter_id" name="filter" value="<?php if(!empty($filter)) echo $filter ?>">

                                </div>
                            </form>

                        </div>
                    </div>

                    <br/>
                    <br/>

                    <div id="printableArea">
                        <table class="table table-bordered table-striped" id="order_table">
                            <thead ><!-- Table head -->
                            <tr>
                                <th class="active">#</th>
                                <th class="active">No Order</th>
                                <th class="active">Tanggal</th>
                                <th class="active">Customer</th>
                                <th class="active">Pembayaran</th>
                                <th class="active">Total</th>
                                <th class="active">Action</th>

                            </tr>
                            </thead><!-- / Table head -->
                            <tbody><!-- / Table body -->

                            </tbody><!-- / Table body -->
                        </table> <!-- / Table -->
                        <?php
                        }

                        ?>

                    </div>


                </div>

            </div>
            <!--/.col end -->
        </div>
        <!-- /.row -->
</section>
<script>
    <?php
    if(!empty($start_date))
    {
    ?>
        $('#order_table').DataTable({
            processing: true,
            serverSide: true,
            "bDestroy": true,
            aaSorting: [[0, 'desc']],
            "ajax": {
                url: '<?php echo base_url("admin/report/filter_order_tables");?>',
                "data": function (d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    d.outlet = $('#outlet_id').val();
                    d.filter = $('#filter_id').val();

                }
            }
        });
    <?php
    }
    ?>
</script>


