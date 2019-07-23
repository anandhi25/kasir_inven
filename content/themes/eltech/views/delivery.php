<div id="content">

    <!-- Ship Process -->
    <div class="ship-process padding-top-30 padding-bottom-30">
        <div class="container">
            <ul class="row">

                <!-- Step 1 -->
                <li class="col-sm-3">
                    <div class="media-left"> <i class="fa fa-check"></i> </div>
                    <div class="media-body"> <span>Step 1</span>
                        <h6>Shopping Cart</h6>
                    </div>
                </li>

                <!-- Step 2 -->
                <li class="col-sm-3">
                    <div class="media-left"> <i class="fa fa-check"></i> </div>
                    <div class="media-body"> <span>Step 2</span>
                        <h6>Payment Methods</h6>
                    </div>
                </li>

                <!-- Step 3 -->
                <li class="col-sm-3 current">
                    <div class="media-left"> <i class="flaticon-delivery-truck"></i> </div>
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

    <!-- Payout Method -->
    <section class="padding-bottom-60">
        <div class="container">
            <!-- Payout Method -->
            <div class="pay-method">
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
                                    <label> Nama Lengkap
                                        <input class="form-control" type="text" name="customer_name" id="customer_name" value="<?php echo $customer->customer_name; ?>">
                                    </label>
                                </div>

                                <!-- Phone -->
                                <div class="col-sm-6">
                                    <label> Phone
                                        <input class="form-control" type="text" name="phone" id="phone" value="<?php echo $customer->phone; ?>">
                                    </label>
                                </div>

                                <!-- Number -->
                                <div class="col-sm-6">
                                    <label> Email
                                        <input readonly class="form-control" type="email" name="email" id="email" value="<?php echo $customer->email; ?>">
                                    </label>
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
                                    <label> Nama Penerima
                                        <input class="form-control" type="text" name="nama_penerima" id="nama_penerima" value="<?php if(!empty($this->session->userdata('customer_accept'))) echo $this->session->userdata('customer_accept');else echo $customer->customer_name; ?>">
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <label> Propinsi
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
                                    </label>
                                </div>

                                <!-- Number -->
                                <div class="col-sm-6">
                                    <label> Kota
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
                                    </label>
                                </div>

                                <div class="col-sm-6">
                                    <label> Kecamatan
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
                                    </label>
                                </div>

                                <div class="col-sm-6">
                                    <label> Kode Pos
                                        <input class="form-control" type="text" name="zip_code" id="zip_code" value="<?php if(!empty($this->session->userdata('customer_zip'))) echo $this->session->userdata('customer_zip'); ?>">
                                    </label>
                                </div>
                                <div class="col-sm-12">
                                    <label> Alamat
                                        <textarea name="address" id="address" class="form-control" rows="3"><?php if(!empty($this->session->userdata('customer_address'))) echo $this->session->userdata('customer_address'); ?></textarea>
                                    </label>
                                </div>


                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Button -->
            <div class="pro-btn"> <a href="<?php echo base_url('payment');?>" class="btn-round btn-light">Metode Pembayaran</a> <a href="#" onclick="save_address();" class="btn-round">Konfirmasi Order</a> </div>
        </div>
    </section>
</div>

<script>
    
    function save_address() {
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
    
    function show_city(str) {
        if(str == '0')
        {
            alert('Anda belum memilih propinsi');
            return false;
        }
        $.ajax({
            type: "post",
            url: '<?php echo base_url('account/show_city')?>',
            data: {state_id:str},
            success: function(data) {
                $("#city").html(data);



            },
            error: function() {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    }

    function show_district(str) {
        if(str == '0')
        {
            alert('Anda belum memilih kota');
            return false;
        }
        $.ajax({
            type: "post",
            url: '<?php echo base_url('account/show_district')?>',
            data: {city_id:str},
            success: function(data) {
                $("#district").html(data);



            },
            error: function() {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    }
</script>