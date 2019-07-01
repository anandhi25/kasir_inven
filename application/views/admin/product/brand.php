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
                        <h3 class="box-title ">Brand</h3>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-background">
                    <!-- form start -->
                    <form role="form" enctype="multipart/form-data"
                          action="<?php echo base_url(); ?>admin/product/save_brand/<?php
                          if (!empty($brand_info->brand_id)) {
                              echo $brand_info->brand_id;
                          }
                          ?>" method="post">

                        <div class="row">

                            <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">

                                <div class="box-body" >
                                    <!-- /.category -->
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Brand Name <span class="required">*</span></label>
                                        <input type="text" required name="name" placeholder="brand name"
                                               value="<?php
                                               if (!empty($brand_info->name)) {
                                                   echo $brand_info->name;
                                               }
                                               ?>"
                                               class="form-control" required>

                                    </div>

                                    <!-- /.category -->

                                    <!-- /.subcategory -->
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Description</label>
                                        <textarea class="form-control" name="description" rows="3"><?php
                                            if(!empty($brand_info->description))
                                            {
                                                echo $brand_info->description;
                                            }

                                            ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Image</label>
                                    </div>
                                    <div class="form-group">
                                        <!-- hidden  old_path when update  -->
                                        <input type="hidden" name="old_path"  value="<?php
                                        if (!empty($brand_info->logo)) {
                                            echo $brand_info->logo;
                                        }
                                        ?>">
                                        <div class="fileinput fileinput-new"  data-provides="fileinput">
                                            <div class="fileinput-new thumbnail g-logo-img" >
                                                <?php if (!empty($brand_info->logo)): // if product image is exist then show  ?>
                                                    <img src="<?php echo base_url() . $brand_info->logo; ?>" >
                                                <?php else: // if product image is not exist then defualt a image ?>
                                                    <img src="<?php echo base_url() ?>img/category.png" alt="Product Image">
                                                <?php endif; ?>
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail g-logo-img"  ></div>
                                            <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">
                                                            <input type="file" name="logo" /></span>
                                                        <span class="fileinput-exists">Change</span>
                                                    </span>
                                                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                            </div>
                                            <div id="valid_msg" class="required"></div>
                                        </div>
                                    </div>
                                    <!-- /.subcategory -->

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

                        <!-- Table -->
                        <table class="table table-bordered table-striped" id="dataTables-example">
                            <thead ><!-- Table head -->
                            <tr>
                                <th class="col-sm-1 active">SL</th>
                                <th class="active">Brand Name</th>
                                <th class="active">Description</th>
                                <th class="col-sm-1 active">Action</th>

                            </tr>
                            </thead><!-- / Table head -->
                            <tbody><!-- / Table body -->
                            <?php $key = 1 ?>
                            <?php if (!empty($all_brand)): foreach ($all_brand as $v_brand) : ?><!--get all sub category if not this empty-->
                                <tr>
                                    <td><?php echo $key ?></td>
                                    <td><?php echo $v_brand->name ?></td>
                                    <td><?php echo $v_brand->description ?></td>
                                    <td>
                                        <?php echo btn_edit('admin/product/brand/' . $v_brand->brand_id); ?>
                                        <?php echo btn_delete('admin/product/delete_brand/' . $v_brand->brand_id); ?>
                                    </td>

                                </tr>
                            <?php
                            $key++;
                            endforeach;
                            ?><!--get all sub category if not this empty-->
                            <?php endif; ?>
                            </tbody><!-- / Table body -->
                        </table> <!-- / Table -->
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col end -->
    </div>
    <!-- /.row -->
</section>



