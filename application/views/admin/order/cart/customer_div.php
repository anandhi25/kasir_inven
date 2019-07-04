<div class="input-group">
                  <span class="input-group-btn">
                    <button type="submit" class="btn bg-blue" type="button" data-placement="top" data-toggle="tooltip" data-original-title="Search Customer by ID/Number">Customer</button>
                  </span>
    <input type="text" name="customer" id="customer" class="form-control" placeholder="Customer" >
    <input type="hidden" name="customer_id" id="customer_id" value="0">
    <span class="input-group-btn">
                        <a href="<?php echo base_url('admin/customer/modal')?>" class="btn btn-success" data-toggle="modal" data-placement="top" title="View" data-target="#myModal"><span class="glyphicon glyphicon-search"></span></a>
                </span>
</div>