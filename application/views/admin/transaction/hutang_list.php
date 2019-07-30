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
<!--Massage-->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<!--/ Massage-->


<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary ">
                <div class="box-header box-header-background with-border">
                    <h3 class="box-title ">Daftar Pembayaran Hutang</h3>
                    <div class="box-tools">
                        <a href="<?php echo base_url('admin/transaction/add_pay_debt') ?>" class="btn btn-default">Tambah Pembayaran</a>

                    </div>
                </div>

                <div class="box-body">

                    <div id="printableArea">

                        <!-- Table -->
                        <table class="table table-bordered table-striped" id="pay_table">
                            <thead ><!-- Table head -->
                            <tr>
                                <th class="active">#</th>
                                <th class="active">No Pembayaran</th>
                                <th class="active">Tanggal</th>
                                <th class="active">Supplier</th>
                                <th class="active">Denda</th>
                                <th class="active">Total</th>
                                <th class="active">Action</th>

                            </tr>
                            </thead><!-- / Table head -->
                            <tbody><!-- / Table body -->

                            </tbody><!-- / Table body -->
                        </table> <!-- / Table -->
                    </div>

                </div><!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!--/.col end -->
    </div>
    <!-- /.row -->
</section>

<script>
    $('#pay_table').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        aaSorting: [[0, 'desc']],
        "ajax": {
            url: '<?php echo base_url("admin/transaction/pay_tables");?>',
            "data": function (d) {

            }
        }
    });
</script>



