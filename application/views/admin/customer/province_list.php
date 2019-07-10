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
                        echo btn_add_modal(base_url('admin/customer/add_province'),'myModal','Tambah Propinsi');
                        ?>
                    </div>
                </div>


                <div class="box-body">

                    <!-- Table -->
                    <table class="table table-bordered table-striped" id="dataTables-example">
                        <thead ><!-- Table head -->
                        <tr>
                            <th class="active">Nama Propinsi</th>
                            <th class="active">Deskripsi</th>
                            <th class="active">Status</th>
                            <th class="active">Action</th>

                        </tr>
                        </thead><!-- / Table head -->
                        <tbody><!-- / Table body -->
                        <?php
                        if(count($state) > 0)
                        {
                            foreach ($state as $post)
                            {
                                ?>
                                <tr>
                                    <td><?php echo $post->state_name;?></td>
                                    <td><?php echo $post->description;?></td>
                                    <td><?php
                                        if($post->state_status == '1')
                                            echo 'Aktif';
                                        else
                                            echo 'Tidak Aktif';
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo btn_edit_modal('admin/customer/add_province/'.$post->state_id)."  ";
                                        echo btn_delete('admin/customer/delete_province/'.$post->state_id)."  ";
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
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


