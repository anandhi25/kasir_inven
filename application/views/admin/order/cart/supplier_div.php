<div class="input-group">
    <span class="input-group-btn">
        <button type="submit" class="btn bg-blue" type="button" data-placement="top" data-toggle="tooltip" data-original-title="Search Supplier by ID/Number">Supplier</button>
    </span>
    <input type="text" name="supplier_name" id="supplier_name" class="form-control" placeholder="Supplier" value="<?php
    if(!empty($order_purchase))
    {
        echo $order_purchase->supplier_name;
    }
    ?>" >
    <input type="hidden" name="supplier_id" id="supplier_id" value="<?php
    if(!empty($order_purchase))
    {
        echo $order_purchase->supplier_id;
    }
    ?>">
    <span class="input-group-btn">
        <a href="<?php echo base_url('admin/purchase/modal_supplier')?>" class="btn btn-success" data-toggle="modal" data-placement="top" title="View" data-target="#myModal"><span class="glyphicon glyphicon-search"></span></a>
    </span>
</div>