<!--Massage-->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<!--/ Massage-->


<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary ">
                <div class="box-header box-header-background with-border">
                    <h3 class="box-title "><?php echo $title;?></h3>
                    <div class="box-tools">
                        <?php
                        echo btn_add_modal(base_url('admin/transaction/add_transaction/'.$type),'myModal',$add_btn);
                        ?>
                    </div>
                </div>


                <div class="box-body">

                    <!-- Table -->
                    <table class="table table-bordered table-striped" id="income_tables">
                        <thead ><!-- Table head -->
                        <tr>
                            <th class="active">Nomor Transaksi</th>
                            <th class="active">Tanggal</th>
                            <th class="active">Nominal</th>
                            <th class="active">Akun</th>
                            <th class="active">Kategori</th>
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
    $('#income_tables').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        aaSorting: [[0, 'desc']],
        "ajax": {
            url: '<?php echo base_url("admin/transaction/transaction_tables/".$type);?>',
            "data": function (d) {

            }
        }
    });
</script>


