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
                        echo btn_add_modal(base_url('admin/settings/add_account'),'myModal','Tambah Account');
                        ?>
                    </div>
                </div>


                <div class="box-body">

                    <!-- Table -->
                    <table class="table table-bordered table-striped" id="account_tables">
                        <thead ><!-- Table head -->
                        <tr>
                            <th class="active">Nama Account</th>
                            <th class="active">Kode Account</th>
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
    $('#account_tables').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        aaSorting: [[0, 'desc']],
        "ajax": {
            url: '<?php echo base_url("admin/settings/account_table");?>',
            "data": function (d) {

            }
        }
    });
</script>


