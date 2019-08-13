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
                    <form role="form" enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/product/save_images" method="post">
                        <input name="id_product" type="hidden" value="<?php echo $id_product; ?>">
                        <div class="row">

                            <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">

                                <div class="box-body" >
                                    <!-- /.category -->
                                    <div class="form-group">
                                        <label>Image 1</label>
                                    </div>
                                    <div class="form-group">
                                        <!-- hidden  old_path when update  -->
                                        <input type="hidden" name="old_path"  value="<?php
                                        if (!empty($images[0])) {
                                            echo $images[0]->filename;
                                        }
                                        ?>">
                                        <input type="hidden" name="full_path"  value="<?php
                                        if (!empty($images[0])) {
                                            echo $images[0]->image_path;
                                        }
                                        ?>">
                                        <div class="fileinput fileinput-new"  data-provides="fileinput">
                                            <div class="fileinput-new thumbnail g-logo-img" >
                                                <?php if (!empty($images[0])): // if product image is exist then show  ?>
                                                    <img src="<?php echo base_url() . $images[0]->filename; ?>" >
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

                                    <div class="form-group">
                                        <label>Image 2</label>
                                    </div>
                                    <div class="form-group">
                                        <!-- hidden  old_path when update  -->
                                        <input type="hidden" name="old_path_1"  value="<?php
                                        if (!empty($images[1])) {
                                            echo $images[1]->filename;
                                        }
                                        ?>">
                                        <input type="hidden" name="full_path_1"  value="<?php
                                        if (!empty($images[1])) {
                                            echo $images[1]->image_path;
                                        }
                                        ?>">
                                        <div class="fileinput fileinput-new"  data-provides="fileinput">
                                            <div class="fileinput-new thumbnail g-logo-img" >
                                                <?php if (!empty($images[1])): // if product image is exist then show  ?>
                                                    <img src="<?php echo base_url() . $images[1]->filename; ?>" >
                                                <?php else: // if product image is not exist then defualt a image ?>
                                                    <img src="<?php echo base_url() ?>img/category.png" alt="Product Image">
                                                <?php endif; ?>
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail g-logo-img"  ></div>
                                            <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">
                                                            <input type="file" name="logo1" /></span>
                                                        <span class="fileinput-exists">Change</span>
                                                    </span>
                                                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                            </div>
                                            <div id="valid_msg" class="required"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Image 3</label>
                                    </div>
                                    <div class="form-group">
                                        <!-- hidden  old_path when update  -->
                                        <input type="hidden" name="old_path_2"  value="<?php
                                        if (!empty($images[2])) {
                                            echo $images[2]->filename;
                                        }
                                        ?>">
                                        <div class="fileinput fileinput-new"  data-provides="fileinput">
                                            <div class="fileinput-new thumbnail g-logo-img" >
                                                <?php if (!empty($images[2])): // if product image is exist then show  ?>
                                                    <img src="<?php echo base_url() . $images[2]->filename; ?>" >
                                                <?php else: // if product image is not exist then defualt a image ?>
                                                    <img src="<?php echo base_url() ?>img/category.png" alt="Product Image">
                                                <?php endif; ?>
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail g-logo-img"  ></div>
                                            <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">
                                                            <input type="file" name="logo2" /></span>
                                                        <span class="fileinput-exists">Change</span>
                                                    </span>
                                                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                            </div>
                                            <div id="valid_msg" class="required"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Image 4</label>
                                    </div>
                                    <div class="form-group">
                                        <!-- hidden  old_path when update  -->
                                        <input type="hidden" name="old_path_3"  value="<?php
                                        if (!empty($images[3])) {
                                            echo $images[3]->filename;
                                        }
                                        ?>">
                                        <div class="fileinput fileinput-new"  data-provides="fileinput">
                                            <div class="fileinput-new thumbnail g-logo-img" >
                                                <?php if (!empty($images[3])): // if product image is exist then show  ?>
                                                    <img src="<?php echo base_url() . $images[3]->filename; ?>" >
                                                <?php else: // if product image is not exist then defualt a image ?>
                                                    <img src="<?php echo base_url() ?>img/category.png" alt="Product Image">
                                                <?php endif; ?>
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail g-logo-img"  ></div>
                                            <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">
                                                            <input type="file" name="logo3" /></span>
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
            </div>
        </div>
    </div>
</section>