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
                        <h3 class="box-title ">Manage Order</h3>
                    <div class="box-tools">
                        <a onclick="print_invoice('printableArea')" class="btn btn-default">Print</a>

                    </div>
                </div>



                <div class="box-body">

                    <div id="printableArea">

                        <!-- Table -->
                        <table class="table table-bordered table-striped" id="order_table">
                            <thead ><!-- Table head -->
                            <tr>
                                <th class="active">#</th>
                                <th class="active">No Order</th>
                                <th class="active">Tanggal</th>
                                <th class="active">Status Order</th>
                                <th class="active">Total</th>
                                <th class="active">Oleh</th>
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
    $('#order_table').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        aaSorting: [[0, 'desc']],
        "ajax": {
            url: '<?php echo base_url("admin/order/order_tables");?>',
            "data": function (d) {

            }
        }
    });
</script>



