<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $title; ?></h4>
</div>
<div class="modal-body wrap-modal wrap" style="max-height: 700px;">
    <div class="row">
        <div class="col-md-12">
            <form role="form" enctype="multipart/form-data" id="addCustomerForm" action="<?php echo base_url(); ?>admin/customer/save_api_customer" method="post">
                <input type="hidden" name="customer_code" value="<?php echo $code;?>">
                <div class="form-group">
                    <label for="exampleInputEmail1">Customer Name <span class="required">*</span></label>
                    <input type="text" name="customer_name" placeholder="Customer Name"
                           value=""
                           class="form-control">
                </div>

                <!-- /.Company Email -->
                <div class="form-group">
                    <label for="exampleInputEmail1">Email <span
                            class="required">*</span></label>
                    <input type="text" placeholder="Email" name="email"
                           value=""
                           class="form-control">
                </div>

                <!-- /.Phone -->
                <div class="form-group">
                    <label for="exampleInputEmail1">Phone</label>
                    <input type="text" placeholder="Phone" name="phone"
                           value=""
                           class="form-control">
                    <div style=" color: #E13300" id="phone_result"></div>
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
    $(document).ready(function() {
      $('#save_btn').on('click',function () {
          var form_post = $('#addCustomerForm');
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
                      $('#form_order #customer').val(res.customer.customer_name);
                      $('#form_order #customer_id').val(res.customer.customer_id);
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