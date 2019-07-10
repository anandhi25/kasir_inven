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
                        echo btn_add_modal(base_url('admin/customer/add_district'),'myModal','Tambah Kecamatan');
                        ?>
                    </div>
                </div>


                <div class="box-body">

                    <!-- Table -->
                    <table class="table table-bordered table-striped" id="district_tables">
                        <thead ><!-- Table head -->
                        <tr>
                            <th class="active">Nama Kecamatan</th>
                            <th class="active">Kota</th>
                            <th class="active">Propinsi</th>
                            <th class="active">Tarif Ongkir</th>
                            <th class="active">Status</th>
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
    $('#district_tables').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        aaSorting: [[0, 'desc']],
        "ajax": {
            url: '<?php echo base_url("admin/customer/district_tables");?>',
            "data": function (d) {

            }
        }
    });
</script>


