<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $title; ?></h4>
</div>
<div class="modal-body wrap-modal wrap" style="max-height: 700px;">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-striped" id="customer_table">
                <thead ><!-- Table head -->
                <tr>
                    <th class="active">Kode Customer</th>
                    <th class="active">Nama Customer</th>
                    <th class="active">No Telp</th>
                    <th class="active">Action</th>

                </tr>
                </thead><!-- / Table head -->
                <tbody><!-- / Table body -->

                </tbody>
            </table>

        </div>
    </div>
</div>
<div class="modal-footer" >

    <button type="button" class="btn btn-default pull-left" onclick="close_mod();">Close</button>
    <a href="<?php echo base_url('admin/customer/add_modal')?>" class="btn btn-success" data-toggle="modal" data-placement="top" title="View" data-target="#modalSmall"><span class="glyphicon glyphicon-plus"></span>Tambah Customer</a>

</div>

<script>
    $("#myModal").on('shown.bs.modal', function () {
        $('#customer_table').DataTable({
            processing: true,
            serverSide: true,
            "bDestroy": true,
            aaSorting: [[0, 'desc']],
            "ajax": {
                url: '<?php echo base_url("admin/customer/customer_table");?>',
                "data": function (d) {

                }
            }
        });
    });


    function close_mod() {
        $('#myModal').modal('toggle');
    }

    function choose_customer(customer) {
        $('#form_order #customer').val(customer.customer_name);
        $('#form_order #customer_id').val(customer.customer_id);
        $('#myModal').modal('toggle');

    }

</script>

