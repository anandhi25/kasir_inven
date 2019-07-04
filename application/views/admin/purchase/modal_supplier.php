<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $title; ?></h4>
</div>
<div class="modal-body wrap-modal wrap" style="max-height: 700px;">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-striped" id="supplier_table">
                <thead ><!-- Table head -->
                <tr>
                    <th class="active">Nama Perusahaan</th>
                    <th class="active">Nama Supplier</th>
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
    <a href="<?php echo base_url('admin/purchase/add_supplier_modal')?>" class="btn btn-success" data-toggle="modal" data-placement="top" title="View" data-target="#modalSmall"><span class="glyphicon glyphicon-plus"></span>Tambah Supplier</a>

</div>

<script>
    $("#myModal").on('shown.bs.modal', function () {
        $('#supplier_table').DataTable({
            processing: true,
            serverSide: true,
            "bDestroy": true,
            aaSorting: [[0, 'desc']],
            "ajax": {
                url: '<?php echo base_url("admin/purchase/supplier_table");?>',
                "data": function (d) {

                }
            }
        });
    });


    function close_mod() {
        $('#myModal').modal('toggle');
    }

    function choose_supplier(supplier) {
        $('#form_order #supplier_name').val(supplier.supplier_name);
        $('#form_order #supplier_id').val(supplier.supplier_id);
        $('#myModal').modal('toggle');

    }

</script>

