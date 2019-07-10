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
                        echo btn_add_modal(base_url('admin/settings/add_slider'),'myModal','Tambah Slider');
                        ?>
                    </div>
                </div>


                <div class="box-body">

                    <!-- Table -->
                    <table class="table table-bordered table-striped" id="dataTables-example">
                        <thead ><!-- Table head -->
                        <tr>
                            <th class="active">Nama Slider</th>
                            <th class="active">URL</th>
                            <th class="active">Image</th>
                            <th class="active">Status</th>
                            <th class="active">Action</th>

                        </tr>
                        </thead><!-- / Table head -->
                        <tbody><!-- / Table body -->
                        <?php
                        if(count($slider) > 0)
                        {
                            foreach ($slider as $post)
                            {
                                ?>
                                <tr>
                                    <td><?php echo $post->slider_title;?></td>
                                    <td><?php echo $post->slider_url;?></td>
                                    <td>
                                        <div class="fileinput-new thumbnail g-logo-img" >
                                            <?php if (!empty($post->slider_image)): // if product image is exist then show  ?>
                                                <img width="60" height="60" src="<?php echo base_url() . $post->slider_image; ?>" >
                                            <?php else: // if product image is not exist then defualt a image ?>
                                                <img src="<?php echo base_url() ?>img/category.png" alt="Product Image">
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td><?php
                                        if($post->slider_status == '1')
                                            echo 'Aktif';
                                        else
                                            echo 'Tidak Aktif';
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo btn_edit_modal('admin/settings/add_slider/'.$post->id)."  ";
                                        echo btn_delete('admin/settings/delete_slider/'.$post->id)."  ";
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


