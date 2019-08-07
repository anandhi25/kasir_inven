<section class="pt-3 pb-3 page-info section-padding border-bottom bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="<?php echo base_url(); ?>"><strong><span class="mdi mdi-home"></span> Home</strong></a> <span class="mdi mdi-chevron-right"></span> <a href="#">Akun Saya</a>
            </div>
        </div
    </div>
</section>

<section class="account-page section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-11 mx-auto">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <div class="card account-left">
                            <div class="user-profile-header">
                                <img alt="logo" src="<?php echo base_url(); ?>img/user.jpg">
                                <h5 class="mb-1 text-secondary"><strong>Hi </strong> <?php echo $customer->customer_name; ?></h5>
                                <p> <?php echo $customer->phone; ?></p>
                            </div>
                            <div class="list-group">
                                <?php
                                $act_profile = '';
                                $act_address = '';
                                $act_order = '';
                                if($page == 'profile')
                                {
                                    $act_profile = 'active';
                                }
                                else if($page == 'address')
                                {
                                    $act_address = 'active';
                                }
                                else if($page == 'order')
                                {
                                    $act_order = 'active';
                                }
                                ?>
                                <a href="<?php echo base_url('account/my');?>" class="list-group-item list-group-item-action <?php echo $act_profile; ?>"><i aria-hidden="true" class="mdi mdi-account-outline"></i>  Profil Saya</a>
                                <a href="<?php echo base_url('account/my/address');?>" class="list-group-item list-group-item-action <?php echo $act_address; ?>"><i aria-hidden="true" class="mdi mdi-map-marker-circle"></i>  Alamat Saya</a>
                                <a href="<?php echo base_url('account/my/order');?>" class="list-group-item list-group-item-action <?php echo $act_order; ?>"><i aria-hidden="true" class="mdi mdi-format-list-bulleted"></i>  Daftar Order</a>
                                <a href="<?php echo base_url('account/logout');?>" class="list-group-item list-group-item-action"><i aria-hidden="true" class="mdi mdi-lock"></i>  Logout</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                    <?php
                        if($page == 'profile')
                        {
                    ?>
                        <div class="card card-body account-right">
                            <div class="widget">
                                <div class="section-header">
                                    <h5 class="heading-design-h5">
                                        Profil Saya
                                    </h5>
                                </div>
                                <?php echo message_box('success'); ?>
                                <?php echo message_box('error'); ?>
                                <form id="profile_form" method="post" action="<?php echo base_url('account/update_profile');?>">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label">Nama Lengkap <span class="required">*</span></label>
                                                <input class="form-control border-form-control" name="customer_name" value="<?php echo $customer->customer_name; ?>" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Telepon <span class="required">*</span></label>
                                                <input class="form-control border-form-control" name="phone" value="<?php echo $customer->phone; ?>" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Email <span class="required">*</span></label>
                                                <input class="form-control border-form-control" name="email" value="<?php echo $customer->email; ?>" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Password</label>
                                                <input class="form-control border-form-control" name="passwd" value="" type="password">

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Confirm Password </label>
                                                <input class="form-control border-form-control" name="confirmpasswd" value="" type="password">
                                            </div>
                                        </div>
                                        <span class="col-sm-12" style="color: red;">biarkan kosong jika tidak ingin merubah password anda</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 text-right">
                                            <button type="submit" class="btn btn-success btn-lg"> Save Changes </button>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                        <?php
                        }
                        else if($page == 'address')
                        {
                            ?>
                            <div class="card card-body account-right">
                                <div class="widget">
                                    <div class="section-header">
                                        <h5 class="heading-design-h5">
                                            Alamat Saya
                                        </h5>
                                    </div>
                                    <?php echo message_box('success'); ?>
                                    <?php echo message_box('error'); ?>
                                    <form id="profile_form" method="post" action="<?php echo base_url('account/update_address');?>">

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">Propinsi <span class="required">*</span></label>
                                                    <select class="form-control" name="state" id="state" onchange="show_city(this.value);">
                                                        <option value="0">Pilih Propinsi</option>
                                                        <?php
                                                        if(count($state) > 0)
                                                        {
                                                            foreach ($state as $prop)
                                                            {
                                                                $sel = '';
                                                                if($customer_meta)
                                                                {
                                                                    if($prop->state_id == $customer_meta->state_id)
                                                                    {
                                                                        $sel = 'selected';
                                                                    }
                                                                }
                                                                echo '<option value="'.$prop->state_id.'" '.$sel.'>'.$prop->state_name.'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">Kota <span class="required">*</span></label>
                                                    <select class="form-control" name="city" id="city" onchange="show_district(this.value);">
                                                        <?php
                                                        if($customer_meta)
                                                        {
                                                            $city_name = db_get_row_data('tbl_city',array('city_id' => $customer_meta->city_id));
                                                            echo '<option value="'. $customer_meta->city_id.'">'.$city_name->city_name.'</option>';
                                                        }
                                                        else
                                                        {
                                                            echo '<option value="0">Pilih Propinsi terlebih dulu</option>';
                                                        }
                                                        ?>


                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">Kecamatan</label>
                                                    <select class="form-control" name="district" id="district">
                                                        <?php
                                                        if($customer_meta)
                                                        {
                                                            $dist = db_get_row_data('tbl_district',array('district_id' => $customer_meta->district_id));
                                                            echo '<option value="'.$customer_meta->district_id.'">'.$dist->district_name.'</option>';
                                                        }
                                                        else
                                                        {
                                                            echo ' <option value="0">Pilih kota terlebih dulu</option>';
                                                        }
                                                        ?>

                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">Kode Pos </label>
                                                    <input class="form-control border-form-control" name="zip_code" value="<?php
                                                    if($customer_meta)
                                                    {
                                                        echo $customer_meta->zip_code;
                                                    }
                                                    ?>" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label">Alamat <span class="required">*</span></label>
                                                    <textarea class="form-control" name="address" id="address" rows="4"><?php
                                                        if($customer_meta)
                                                        {
                                                            echo $customer_meta->address;
                                                        }
                                                        ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 text-right">
                                                <button type="submit" class="btn btn-success btn-lg"> Save Changes </button>
                                            </div>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        <?php
                        }
                        else if($page == 'order')
                        {
                        ?>
                        <div class="card card-body account-right">
                            <div class="widget">
                                <div class="section-header">
                                    <h5 class="heading-design-h5">
                                        Order Saya
                                    </h5>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-striped table-bordered order-list-tabel" id="order_table" width="100%" cellspacing="0">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>No Order #</th>
                                                <th>Tanggal</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <link href="<?php echo theme_asset().'vendor/datatables/datatables.min.css';?>" rel="stylesheet" />
                            <script src="<?php echo theme_asset().'vendor/datatables/datatables.min.js';?>"></script>
                            <script>
                                $('#order_table').DataTable({
                                    processing: true,
                                    serverSide: true,
                                    "bDestroy": true,
                                    aaSorting: [[0, 'desc']],
                                    "ajax": {
                                        url: '<?php echo base_url("account/order_tables");?>',
                                        "data": function (d) {
                                            d.customer_id = '<?php echo $customer->customer_id; ?>';
                                        }
                                    }
                                });
                            </script>
                                <?php
                                }
                    else if($page == 'detail_order')
                    {
                        ?>
                        <div class="card card-body account-right">
                            <div class="widget">
                                <div class="section-header">
                                    <h5 class="heading-design-h5">
                                        Detail Order #<?php echo $order->order_no; ?>
                                    </h5>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <link href="<?php echo base_url(); ?>asset/css/invoice.css" rel="stylesheet" type="text/css" />
                                        <div class="row ">
                                            <div class="col-md-12 col-md-offset-2">

                                                <main>
                                                    <div id="details" class="clearfix">
                                                        <div id="client">
                                                            <div class="to">CUSTOMER BILLING INFO:</div>
                                                            <h2 class="name"><?php echo $order->customer_name ?></h2>
                                                            <div class="address"><?php echo $order->customer_address ?></div>
                                                            <div class="address"><?php echo $order->customer_phone ?></div>
                                                            <div class="email"><?php echo $order->customer_email ?></div>
                                                        </div>

                                                        <div id="invoice" class="pull-right">
                                                            <h3>ORDER: #<?php echo $order->order_no ?></h3>
                                                            <div class="date">Tanggal: <?php echo date('Y-m-d', strtotime($order->order_date))  ?></div>

                                                        </div>

                                                    </div>
                                                    <table border="0" cellspacing="0" cellpadding="0">
                                                        <thead>
                                                        <tr>
                                                            <th class="no text-right">#</th>
                                                            <th class="desc">PRODUK</th>
                                                            <th class="unit">HARGA</th>
                                                            <th class="qty">QUANTITY</th>
                                                            <th class="total ">TOTAL</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $counter = 1?>
                                                        <?php foreach($detail_order as $v_order): ?>
                                                            <tr>
                                                                <td class="no"><?php echo $counter ?></td>
                                                                <td class="desc"><h3><?php echo $v_order->product_name ?></h3></td>
                                                                <td class="unit"><?php echo number_format($v_order->selling_price, 0); ?></td>
                                                                <td class="qty"><?php echo $v_order->product_quantity ?></td>
                                                                <td class="total"><?php echo number_format($v_order->sub_total,0) ?></td>
                                                            </tr>
                                                            <?php $counter ++?>
                                                        <?php endforeach; ?>
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td colspan="2">SUBTOTAL</td>
                                                            <td><?php echo number_format($order->subtotal,0) ?></td>
                                                        </tr>

                                                        <?php if($order->discount):?>
                                                            <tr>
                                                                <td colspan="2"></td>
                                                                <td colspan="2">DISKON</td>
                                                                <td><?php echo number_format($order->discount_amount,0) ?></td>
                                                            </tr>
                                                        <?php endif; ?>

                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td colspan="2">PAJAK</td>
                                                            <td><?php echo number_format($order->tax,0) ?></td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td colspan="2">ONGKOS KIRIM</td>
                                                            <td><?php echo number_format($order->ongkir,0) ?></td>
                                                        </tr>


                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td colspan="2">GRAND TOTAL</td>
                                                            <td style="text-align: right;"><?php echo $currency.' '.number_format($order->grand_total,0) ?></td>
                                                        </tr>

                                                        </tfoot>
                                                    </table>
                                                </main>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                                ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>