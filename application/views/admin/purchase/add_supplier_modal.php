<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $title; ?></h4>
</div>
<div class="modal-body wrap-modal wrap" style="max-height: 700px;">
    <div class="row">
        <div class="col-md-12">
            <form role="form" enctype="multipart/form-data" id="addSupplierForm" action="<?php echo base_url(); ?>admin/purchase/save_api_supplier" method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">Company Name <span class="required">*</span></label>
                    <input type="text" name="company_name" placeholder="Company Name" value="" required class="form-control">
                </div>

                <!-- /.Company Name -->
                <div class="form-group">
                    <label for="exampleInputEmail1">Supplier Name <span class="required">*</span></label>
                    <input type="text" name="supplier_name" placeholder="Supplier Name" value="" required class="form-control">
                </div>

                <!-- /.Company Email -->
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="text" placeholder="Email" name="email" value="" class="form-control">
                </div>

                <!-- /.Phone -->
                <div class="form-group">
                    <label for="exampleInputEmail1">Phone<span class="required"> *</span></label>
                    <input type="text" placeholder="Phone" name="phone" required value="" class="form-control">
                </div>

                <!-- /.Address -->
                <div class="form-group">
                    <label for="exampleInputEmail1">Address</label>
                    <textarea name="address" class="form-control autogrow" rows="3" id="ck_editor" placeholder="Business Address"></textarea>
                </div>


            </form>
        </div>
    </div>
</div>

<div class="modal-footer" >

    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary pull-right" id="save_btn">Simpan</button>


</div>

<script>
    $("#modalSmall").on('shown.bs.modal', function () {
        $('#save_btn').on('click',function () {
            var form_post = $('#addSupplierForm');
            var data_post = form_post.serializeArray();
            $('.loading').show();

            $.ajax({
                url: form_post.attr('action'),
                type: 'POST',
                dataType: 'json',
                data: data_post,
            })
                .done(function(res) {
                    if (res.success) {
                        $('#form_order #supplier_name').val(res.supplier.customer_name);
                        $('#form_order #supplier_id').val(res.supplier.customer_id);
                        $('#modalSmall').modal('toggle');
                        $('#myModal').modal('toggle');

                    } else {
                        alert('Data gagal disimpan');
                    }

                })
                .fail(function() {
                    alert('Data gagal disimpan');
                })
                .always(function() {
                    $('.loading').hide();
                });

            return false;
        })  ;
    })
</script>