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
                        echo btn_add_modal(base_url('admin/settings/add_popup'),'myModal','Tambah Popup');
                        ?>
                    </div>
                </div>


                <div class="box-body">

                    <!-- Table -->
                    <table class="table table-bordered table-striped" id="dataTables-example">
                        <thead ><!-- Table head -->
                        <tr>
                            <th class="active">Halaman</th>
                            <th class="active">URL</th>
                            <th class="active">Image</th>
                            <th class="active">Keluar Sekali</th>
                            <th class="active">Action</th>

                        </tr>
                        </thead><!-- / Table head -->
                        <tbody><!-- / Table body -->
                        <?php
                        if(count($popup) > 0)
                        {
                            foreach ($popup as $post)
                            {
                                ?>
                                <tr>
                                    <td><?php echo $post->title;?></td>
                                    <td><?php echo $post->popup_url;?></td>
                                    <td>
                                        <div class="fileinput-new thumbnail g-logo-img" >
                                            <?php if (!empty($post->popup_image)): // if product image is exist then show  ?>
                                                <img width="60" height="60" src="<?php echo base_url() . $post->popup_image; ?>" >
                                            <?php else: // if product image is not exist then defualt a image ?>
                                                <img src="<?php echo base_url() ?>img/category.png" alt="Product Image">
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td><?php
                                        if($post->show_once == '1')
                                            echo 'YA';
                                        else
                                            echo 'TIDAK';
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo btn_edit_modal('admin/settings/add_popup/'.$post->popup_id)."  ";
                                        echo btn_delete('admin/settings/delete_popup/'.$post->popup_id)."  ";
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


