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

            <div class="box box-primary">
                <div class="box-header box-header-background with-border">
                        <h3 class="box-title ">Daftar Pembelian</h3>
                </div>


                <div class="box-body">

                        <!-- Table -->
                    <table class="table table-bordered table-striped" id="purchase_table">
                        <thead ><!-- Table head -->
                        <tr>
                            <th class="active">#</th>
                            <th class="active">No Pembelian</th>
                            <th class="active">Nama Supplier</th>
                            <th class="active">Tanggal</th>
                            <th class="active">Grand Total</th>
                            <th class="active">Pembayaran</th>
                            <th class="active">Oleh</th>
                            <th class="active">Action</th>

                        </tr>
                        </thead><!-- / Table head -->
                        <tbody><!-- / Table body -->

                        </tbody><!-- / Table body -->
                    </table> <!-- / Table -->

                </div><!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!--/.col end -->
    </div>
    <!-- /.row -->
</section>

<script>
    $('#purchase_table').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        aaSorting: [[0, 'desc']],
        "ajax": {
            url: '<?php echo base_url("admin/purchase/purchase_tables");?>',
            "data": function (d) {

            }
        }
    });
</script>




