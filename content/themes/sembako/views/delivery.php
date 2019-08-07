<style>
    .transportation .charges h6 {

        margin: 0px;

        margin-bottom: 5px;

        font-weight: 600;

        display: inline-block;

        font-size: 16px;

        color: #555555;

    }
    .transportation .charges {

        border: 2px solid #e2e2e2;

        padding: 15px 20px;

        cursor: pointer;

        margin-bottom: 30px;

    }

    .transportation .charges span {

        color: #888888;

    }

    .transportation span.deli-charges {

        color: #222222;

        font-size: 18px;

        font-weight: 600;

        float: right;

        width: auto;

        margin-top: -15px;

        border-left: 1px solid #e5e5e5;

        padding-left: 10px;

    }

    .transportation .charges:hover {

        border: 2px solid #0088cc;

    }

    .transportation .charges.select {

        border: 2px solid #0088cc;

    }
</style>

<section class="pt-3 pb-3 page-info section-padding border-bottom bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="<?php echo base_url(); ?>"><strong><span class="mdi mdi-home"></span> Home</strong></a> <span class="mdi mdi-chevron-right"></span> <a href="#">Alamat Pengiriman</a>
            </div>
        </div
    </div>
</section>

<div class="ship-process padding-top-30 padding-bottom-30">
    <div class="container">
        <ul class="row">

            <!-- Step 1 -->
            <li class="col-sm-3">
                <div class="media-left"> <i class="fa fa-shopping-cart"></i> </div>
                <div class="media-body"> <span>Step 1</span>
                    <h6>Shopping Cart</h6>
                </div>
            </li>

            <!-- Step 2 -->
            <li class="col-sm-3">
                <div class="media-left"> <i class="fa fa-credit-card"></i> </div>
                <div class="media-body"> <span>Step 2</span>
                    <h6>Payment Methods</h6>
                </div>
            </li>

            <!-- Step 3 -->
            <li class="col-sm-3 current">
                <div class="media-left"> <i class="fa fa-truck"></i> </div>
                <div class="media-body"> <span>Step 3</span>
                    <h6>Delivery Methods</h6>
                </div>
            </li>

            <!-- Step 4 -->
            <li class="col-sm-3">
                <div class="media-left"> <i class="fa fa-check"></i> </div>
                <div class="media-body"> <span>Step 4</span>
                    <h6>Confirmation</h6>
                </div>
            </li>
        </ul>
    </div>
</div>

<section class="account-page section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-6">

                <!-- Your information -->
                <div class="heading">
                    <h2>Data Pembeli</h2>
                    <hr>
                </div>
                <form method="post" action="<?php echo base_url('account/save_temp_address');?>" id="delivery_form">
                    <div class="row">
                        <!-- Name -->
                        <div class="col-sm-12">
                            <label> Nama Lengkap</label>
                                <input class="form-control" type="text" name="customer_name" id="customer_name" value="<?php echo $customer->customer_name; ?>">

                        </div>

                        <!-- Phone -->
                        <div class="col-sm-6">
                            <label> Phone</label>
                                <input class="form-control" type="text" name="phone" id="phone" value="<?php echo $customer->phone; ?>">

                        </div>

                        <!-- Number -->
                        <div class="col-sm-6">
                            <label> Email </label>
                                <input readonly class="form-control" type="email" name="email" id="email" value="<?php echo $customer->email; ?>">

                        </div>
                    </div>

            </div>

            <!-- Select Your Transportation -->
            <div class="col-md-6">
                <div class="heading">
                    <h2>Alamat Pengiriman</h2>
                    <hr>
                </div>
                <div class="transportation">
                    <div class="row">
                        <div class="col-sm-12">
                            <label> Nama Penerima</label>
                                <input class="form-control" type="text" name="nama_penerima" id="nama_penerima" value="<?php if(!empty($this->session->userdata('customer_accept'))) echo $this->session->userdata('customer_accept');else echo $customer->customer_name; ?>">

                        </div>
                        <div class="col-sm-6">
                            <label> Propinsi</label>
                                <select class="form-control" name="state" id="state" onchange="show_city(this.value);">
                                    <option value="0">Pilih Propinsi</option>
                                    <?php
                                    if(count($state) > 0)
                                    {
                                        foreach ($state as $prop)
                                        {
                                            $sel = '';
                                            if(!empty($this->session->userdata('customer_state')))
                                            {
                                                if($prop->state_id == $this->session->userdata('customer_state'))
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

                        <!-- Number -->
                        <div class="col-sm-6">
                            <label> Kota</label>
                                <select class="form-control" name="city" id="city" onchange="show_district(this.value);">
                                    <?php
                                    if(!empty($this->session->userdata('customer_city')))
                                    {
                                        $city_name = db_get_row_data('tbl_city',array('city_id' => $this->session->userdata('customer_city')));
                                        echo '<option value="'.$this->session->userdata('customer_city').'">'.$city_name->city_name.'</option>';
                                    }
                                    else
                                    {
                                        echo '<option value="0">Pilih Propinsi terlebih dulu</option>';
                                    }
                                    ?>


                                </select>

                        </div>

                        <div class="col-sm-6">
                            <label> Kecamatan</label>
                                <select class="form-control" name="district" id="district">
                                    <?php
                                    if(!empty($this->session->userdata('customer_district')))
                                    {
                                        $dist = db_get_row_data('tbl_district',array('district_id' => $this->session->userdata('customer_district')));
                                        echo '<option value="'.$this->session->userdata('customer_district').'">'.$dist->district_name.'</option>';
                                    }
                                    else
                                    {
                                        echo ' <option value="0">Pilih kota terlebih dulu</option>';
                                    }
                                    ?>

                                </select>

                        </div>

                        <div class="col-sm-6">
                            <label> Kode Pos
                                <input class="form-control" type="text" name="zip_code" id="zip_code" value="<?php if(!empty($this->session->userdata('customer_zip'))) echo $this->session->userdata('customer_zip'); ?>">
                            </label>
                        </div>
                        <div class="col-sm-12">
                            <label> Alamat</label>
                                <textarea name="address" id="address" class="form-control" rows="3"><?php if(!empty($this->session->userdata('customer_address'))) echo $this->session->userdata('customer_address'); ?></textarea>

                        </div>


                    </div>
                    </form>
                </div>
            </div>


        </div>
        <div class="pro-btn"> <a href="<?php echo base_url('payment');?>" class="btn btn-info">Metode Pembayaran</a> <a href="#" onclick="save_address();" class="btn btn-success">Konfirmasi Order</a> </div>
    </div>
</section>

<script>

    function save_address() {
        if($('#state').val() == '0')
        {
            alert('propinsi masih belum dipilih');
            return false;
        }
        if($('#city').val() == '0')
        {
            alert('kota masih belum dipilih');
            return false;
        }
        if($('#district').val() == '0')
        {
            alert('kecamatan masih belum dipilih');
            return false;
        }
        if($('textarea#address').val() == '')
        {
            alert('Alamat masih kosong');
            return false;
        }
        var form_delivery = $('#delivery_form');
        var data_post = form_delivery.serializeArray();

        $.ajax({
            url: form_delivery.attr('action'),
            type: 'POST',
            dataType: 'json',
            data: data_post,
        })
            .done(function(res) {
                if (res.success) {
                    window.location.href = "<?php echo base_url().'confirmation';?>";

                }
                else {

                }

            })
            .fail(function() {

            })
            .always(function() {

            });
    }


</script>