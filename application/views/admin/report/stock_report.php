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
                </div>


                <div class="box-body">

                    <!-- Table -->
                    <table class="table table-bordered table-striped" id="stock_tables">
                        <thead ><!-- Table head -->
                        <tr>
                            <th class="active">Nama Produk</th>
                            <th class="active">Kode Produk</th>
                            <?php
                            if(!empty($outlets))
                            {
                                foreach ($outlets as $outlet)
                                {
                                    echo '<th class="active">'.$outlet->name.'</th>';
                                }
                            }
                            ?>

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
    $('#stock_tables').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        aaSorting: [[0, 'desc']],
        "ajax": {
            url: '<?php echo base_url("admin/report/stock_table");?>',
            "data": function (d) {

            }
        }
    });
</script>


