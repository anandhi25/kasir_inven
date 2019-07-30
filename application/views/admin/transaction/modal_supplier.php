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
                    <th class="active">Total Hutang</th>
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

</div>

<script>
    $("#myModal").on('shown.bs.modal', function () {
        $('#supplier_table').DataTable({
            processing: true,
            serverSide: true,
            "bDestroy": true,
            aaSorting: [[0, 'desc']],
            "ajax": {
                url: '<?php echo base_url("admin/purchase/supplier_hutang_table");?>',
                "data": function (d) {

                }
            }
        });
    });


    function close_mod() {
        $('#myModal').modal('toggle');
    }

    function choose_supplier(supplier,total_hutang,list_nota='') {
        console.log(list_nota);
        $('#pay_debt_form #supplier_name').val(supplier.supplier_name);
        $('#pay_debt_form #supplier_id').val(supplier.supplier_id);
        $('#pay_debt_form #sisa_hutang').val(numberWithCommas(total_hutang));
        $('#data_debt #debt_list').html(list_nota);
        load_data_table();
        hitung_total_bayar();
        $('#myModal').modal('toggle');

    }

</script>

