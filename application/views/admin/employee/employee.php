
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>


<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary ">
                <div class="box-header box-header-background with-border">
                    <h3 class="box-title ">Manage User</h3>
                </div>


                <div class="box-body">

                    <!-- Table -->
                    <table class="table table-bordered table-striped" id="dataTables-example">
                        <thead ><!-- Table head -->
                        <tr>
                            <th class="col-sm-1 active">#</th>
                            <th class="active">Nama User</th>
                            <th class="col-sm-1 active">Login</th>
                            <th class="col-sm-1 active">Tipe User</th>
                            <th class="col-sm-2 active">Action</th>

                        </tr>
                        </thead><!-- / Table head -->
                        <tbody>
                        <?php $key = 1 ?>
                        <?php if (count($all_employee_info)): foreach ($all_employee_info as $v_employee) : ?>

                            <tr>
                                <td><?php echo $key ?></td>
                                <td><?php echo $v_employee->name ?></td>
                                <td><?php echo $v_employee->user_name ?></td>
                                <td><?php echo $v_employee->flag == 1 ? 'Admin' : 'User' ?></td>
                                <td>
                                    <?php echo btn_edit('admin/employee/add_employee/' . urlencode(base64_encode($v_employee->user_id))); ?>
                                    <?php echo btn_delete('admin/employee/delete_user/' . urlencode(base64_encode($v_employee->user_id))); ?>
                                </td>

                            </tr>
                            <?php
                            $key++;
                        endforeach;
                            ?>
                        <?php endif; ?>
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




