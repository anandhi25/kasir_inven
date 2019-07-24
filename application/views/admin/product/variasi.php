<!--Massage-->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<!--/ Massage-->


<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary">
                <div class="box-header box-header-background with-border">
                    <div class="col-md-offset-3">
                        <h3 class="box-title "><?php echo $title;?></h3>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-background">
                    <!-- form start -->
                    <form role="form" enctype="multipart/form-data"
                          action="<?php echo base_url(); ?>admin/product/save_variasi/<?php
                          if (!empty($variasi_info->attribute_set_id)) {
                              echo $variasi_info->attribute_set_id;
                          }
                          ?>" method="post">

                        <div class="row">

                            <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">

                                <div class="box-body">

                                    <!-- /.Company Name -->
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nama Attribute <span class="required">*</span></label>
                                        <input type="text" required name="attribute_name" placeholder="Attribute Name"
                                               value="<?php
                                               if (!empty($variasi_info->attribute_name)) {
                                                   echo $variasi_info->attribute_name;
                                               }
                                               ?>"
                                               class="form-control">
                                    </div>

                                    <button type="submit" class="btn bg-navy" type="submit">Save
                                    </button><br/><br/>
                                </div>
                                <!-- /.box-body -->

                            </div>
                        </div>

                    </form>
                </div>
                <div class="box-footer">

                </div>

                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <table class="table table-bordered table-striped" id="dataTables-example">
                            <thead>
                            <tr>
                                <th class="active">SL</th>
                                <th class="active">Nama Attribute</th>
                                <th class=" active col-sm-2">Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php $key = 1 ?>
                            <?php if (!empty($all_variasi)): foreach ($all_variasi as $v_variasi) : ?><!--get all category if not this empty-->
                                <tr>
                                    <td><?php echo $key ?></td>
                                    <!--Serial No> -->
                                    <td><?php echo $v_variasi->attribute_name ?></td>
                                    <td>
                                        <?php echo btn_edit('admin/product/variasi/' . $v_variasi->attribute_set_id); ?>
                                        <?php echo btn_delete('admin/product/delete_variasi/' . $v_variasi->attribute_set_id); ?>
                                    </td>

                                </tr>
                            <?php
                            $key++;
                            endforeach;
                            ?><!--get all category if not this empty-->

                            <?php
                            endif; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col end -->
    </div>
    <!-- /.row -->
</section>



