<!--Massage-->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<!--/ Massage-->

<?php $info = $this->session->userdata('business_info'); ?>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary">
                <div class="box-header box-header-background with-border">
                    <div class="col-md-offset-3">
                        <h3 class="box-title ">Manage Outlets</h3>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-background">
                    <!-- form start -->
                    <form role="form" enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/settings/save_outlet/<?php
                          if (!empty($outlet->id)) {
                              echo $outlet->id;
                          }
                          ?>" method="post">

                        <div class="row">

                            <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">

                                <div class="box-body">

                                    <!-- /.tax title -->
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Outlet Name <span class="required">*</span></label>
                                        <input type="text" required name="outlet_name" placeholder="Outlet Name"
                                               value="<?php
                                               if (!empty($outlet->name)) {
                                                   echo $outlet->name;
                                               }
                                               ?>"
                                               class="form-control">
                                    </div>

                                    <!-- /.tax title -->
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Phone</label>
                                        <input type="text" name="phone" placeholder="phone number"
                                               value="<?php
                                               if (!empty($outlet->contact_number)) {
                                                   echo $outlet->contact_number;
                                               }
                                               ?>"
                                               class="form-control">
                                    </div>

                                    <!-- /.Tax type -->
                                    <div class="form-group">
                                        <label>Address </label>
                                        <textarea name="address" class="form-control autogrow" id="ck_editor"
                                                  placeholder="Address"><?php
                                            if (!empty($outlet->address)) {
                                                echo $outlet->address;
                                            }
                                            ?></textarea>

                                    </div>
                                    <input type="checkbox" name="default" value="yes" <?php if(!empty($outlet->status)){if($outlet->status == '2') echo 'checked';} ?>> Default
                                    <br><br>
                                    <button type="submit" class="btn bg-navy" type="submit">Save
                                    </button>
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
                                <th class="active">Name</th>
                                <th class="active">Phone</th>
                                <th class="active">Address</th>
                                <th class="active">Default</th>
                                <th class="col-sm-2 active">Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php $key = 1 ?>
                            <?php if (!empty($outlet_info)): foreach ($outlet_info as $info) : ?>
                                <tr>
                                    <td><?php echo $key ?></td>
                                    <td><?php echo $info->name ?></td>
                                    <td><?php echo $info->contact_number ?></td>
                                    <td><?php echo $info->address ?></td>
                                    <td><?php
                                        if($info->status == '2')
                                        {
                                            echo "YA";
                                        }
                                        else
                                        {
                                            echo "TIDAK";
                                        }
                                        ?></td>
                                    <td>
                                        <?php echo btn_edit('admin/settings/outlet/' . $info->outlet_id); ?>
                                        <?php echo btn_delete('admin/settings/delete_outlet/' . $info->outlet_id); ?>
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



