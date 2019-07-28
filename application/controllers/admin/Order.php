<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 *	@author : CodesLab
 *  @support: support@codeslab.net
 *	date	: 05 June, 2015
 *	Easy Inventory
 *	http://www.codeslab.net
 *  version: 1.0
 */

class Order extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('order_model');
        $this->load->model('outlet_model');
        $this->load->model('global_model');
        $this->load->model('settings_model');
        $this->load->model('tax_model');
        $this->load->model('purchase_model');

        $this->load->helper('ckeditor');
        $this->data['ckeditor'] = array(
            'id' => 'ck_editor',
            'path' => 'asset/js/ckeditor',
            'config' => array(
                'toolbar' => 'Full',
                'width' => '100%',
                'height' => '100px',
            ),
        );
        $this->data2['ckeditor2'] = array(
            'id' => 'ck_editor2',
            'path' => 'asset/js/ckeditor',
            'config' => array(
                'toolbar' => 'Full',
                'width' => '100%',
                'height' => '100px',
            ),
        );

    }

    public function modal_variasi($row_id)
    {
        $data['title'] = 'Pilih Variasi Product';
        $data['row_id'] = $row_id;
        $this->order_model->_table_name = 'tbl_attribute_set';
        $this->order_model->_order_by = 'attribute_set_id';
        $data['all_attribute'] = $this->order_model->get();
        $data['url'] = base_url('admin/order/update_variasi');
        $data['modal_subview'] = $this->load->view('admin/order/modal_qty_product', $data, FALSE);
        $this->load->view('admin/_layout_custom_modal', $data);
    }

    public function modal_serial($row_id)
    {
        $data['title'] = 'Input Serial';
        $data['row_id'] = $row_id;
        $data['url'] = base_url('admin/order/update_serial');
        $data['modal_subview'] = $this->load->view('admin/order/modal_serial_product', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);
    }

    public function modal_diskon()
    {
        $data['title'] = 'Tambah Diskon';
        $data['nominal_diskon'] = $this->session->userdata('nominal');
        $data['tipe_diskon'] = $this->session->userdata('tipe');
        $data['modal_subview'] = $this->load->view('admin/order/modal_diskon', $data, FALSE);
        $this->load->view('admin/_layout_custom_modal', $data);
    }

    public function modal_payment()
    {
        $data['title'] = 'Pembayaran';
        $data['modal_subview'] = $this->load->view('admin/order/modal_bayar', $data, FALSE);
        $this->load->view('admin/_layout_custom_modal', $data);
    }

    public function save_diskon()
    {
        $nominal = $this->input->post('nominal_diskon');
        $tipe = $this->input->post('tipe_diskon');
        $arr = array(
            'nominal' => $nominal,
            'tipe' => $tipe
        );
        $this->session->set_userdata($arr);
        echo json_encode(array('success' => true));
    }

    public function update_serial()
    {
        $row_id = $this->input->post('row_id');
        $serial = $this->input->post('serial');
        $arr = array();
        for($i=0;$i<count($serial);$i++)
        {
            $arr[] = $serial[$i];
        }
        $data = array(
            'rowid' => $row_id,
            'serial' => $arr,
        );

        $this->cart->update($data);
        $blk['success'] = true;
        echo json_encode($blk);
    }

    public function update_variasi()
    {
        $row_id = $this->input->post('row_id');
        $attribute = $this->input->post('attribute');
        $arr = array();
        for($i=0;$i<count($attribute);$i++)
        {
            if(!empty($attribute[$i]))
            {
                $arr[] = $attribute[$i];
            }

        }
        $data = array(
            'rowid' => $row_id,
            'attribute' => $arr,
        );

        $this->cart->update($data);
        $blk['success'] = true;
        echo json_encode($blk);
    }

    public function edit_order($id)
    {
        $order_id = array(
            'id_order' => $id,
        );
        $this->session->set_userdata($order_id);
        redirect('admin/order/new_order/edit');
    }

    /*** New Order ***/
    public function new_order($flag=null)
    {

        //$data['product'] = $this->order_model->get_all_product_info();

        $customer = $this->input->post('customer', true);
        $customer_flag = $this->input->post('flag', true);
        $customer_remove_flag = $this->input->post('remove_flag', true);

        //remove customer
        if(!empty($customer_remove_flag)){
            $customer_session = array('customer_name' => '', 'customer_code' => '', 'discount' => '');
            $this->session->unset_userdata($customer_session);
            $flag = 'customer';
        }
        //search customer
        if(!empty($customer_flag)) {
            if (!empty($customer))
            {
                $result = $this->order_model->get_customer_details($customer);
                if(!empty($result)) {
                    $customer = array(
                        'customer_code' => $result->customer_code,
                        'customer_name' => $result->customer_name,
                        'discount' => $result->discount,
                    );

                    $this->session->set_userdata($customer);
                }
            }
            $flag = 'customer';
        }
        //destroy cart and session data
        if(empty($flag)){
            $customer_session = array('customer_name' => '', 'customer_code' => '', 'discount' => '', 'order_no' => '');
            $this->session->unset_userdata($customer_session);
            $this->cart->destroy();
            $this->session->unset_userdata('nominal');
            $this->session->unset_userdata('tipe');
            $this->session->unset_userdata('id_order');
            $random_number = rand(10000000, 99999);

            $order_no = array(
                'order_no'  => $random_number,
            );
            $this->session->set_userdata($order_no);
        }
        $title = 'Tambah order penjualan';
        if(!empty($this->session->userdata('id_order')))
        {
           $id = $this->session->userdata('id_order');
            $this->order_model->_table_name = 'tbl_order';
            $this->order_model->_order_by = 'order_id';
            $penjualan = $this->order_model->get_by(array('order_id' => $id),true);

            $title = "Edit order penjualan";

            $order_no = array(
                'order_no'  => $penjualan->order_no,
            );
            $this->session->set_userdata($order_no);
            $arr_diskon = array(
                'nominal' => $penjualan->discount,
                'tipe' => $penjualan->discount_type
            );
            $this->session->set_userdata($arr_diskon);
            $this->order_model->init_table('tbl_order_details','order_details_id');
            $jual_product = $this->order_model->get_by(array('order_id' => $id),false);
            if(count($jual_product) > 0) {
                if($flag == 'edit') {
                    $this->cart->destroy();
                    foreach ($jual_product as $beli) {
                        $res_product = $this->order_model->validate_add_cart_item($beli->product_code);
                        $where = array('product_id' => $res_product->product_id);
                        $res_attr = $this->order_model->check_by($where, 'tbl_attribute');
                        $has_attr = 'yes';
                        if (empty($res_attr)) {
                            $has_attr = 'no';
                        }

                        $this->order_model->init_table('tbl_order_attribute', 'id');
                        $res_pur_attr = $this->order_model->get_by(array('order_detail_id' => $beli->order_details_id), false);
                        $arr_attr = array();
                        $arr = array();
                        if (count($res_pur_attr) > 0) {
                            foreach ($res_pur_attr as $re_attr) {
                                $arr_attr[] = $re_attr->attribute_id;
                            }
                        }

                        $this->order_model->init_table('tbl_order_serial', 'id');
                        $res_pur_serial = $this->order_model->get_by(array('order_detail_id' => $beli->order_details_id), false);
                        if (count($res_pur_serial) > 0) {
                            foreach ($res_pur_serial as $re_serial) {
                                $arr[] = $re_serial->serial_no;
                            }
                        }

                        $data = array(
                            'id' => $beli->product_code,
                            'qty' => $beli->product_quantity,
                            'price' => $beli->selling_price,
                            'name' => $res_product->product_name,
                            'product_id' => $res_product->product_id,
                            'tax' => '0',
                            'price_option' => 'general',
                            'has_serial' => $res_product->serial,
                            'has_attribute' => $has_attr,
                            'attribute' => $arr_attr,
                            'serial' => $arr
                        );
                        $this->cart->insert($data);

                    }
                }
            }

            $data['order_purchase'] = $penjualan;
        }
        $data['outlets'] = $this->outlet_model->get_outlet_info();
        $this->settings_model->_table_name = 'tbl_business_profile';
        $this->settings_model->_order_by = 'business_profile_id';
        $result = $this->settings_model->get_by(array('business_profile_id' => 1), true);
        $persen_tax = 0;
        if($result) {
            if ($result->tax_sale != '0') {
                $this->tax_model->_table_name = 'tbl_tax';
                $this->tax_model->_order_by = 'tax_id';
                $res_tax = $this->tax_model->get_by(array('tax_id' => $result->tax_sale), true);
                $persen_tax = $res_tax->tax_rate;
            }
        }
        $data['persen_tax'] = $persen_tax;
        // view page
        $data['title'] = $title;
        $data['editor'] = $this->data;
        $data['editor2'] = $this->data2;
        $data_mod['modal_id'] = 'id="modal_diskon" >';
        $data['modal_div'] = $this->load->view('admin/_layout_custom_modal',$data_mod,true);
        $data_submit['modal_id'] = 'id="modal_submit" >';
        $data['modal_submit_div'] = $this->load->view('admin/_layout_custom_modal',$data_submit,true);

        $data_variasi['modal_id'] = 'id="modal_variasi" >';
        $data['modal_variasi_div'] = $this->load->view('admin/_layout_custom_modal',$data_variasi,true);

        $data['person_div'] = $this->load->view('admin/order/cart/customer_div',$data,true);

        $data['url_method'] = base_url().'admin/order/save_order';
        $data['cart_iden'] = 'order';

        $data['subview'] = $this->load->view('admin/order/new_order', $data, true);

        $this->load->view('admin/_layout_main', $data);
    }

    public function cart_system($product_code,$iden)
    {
        $result = $this->order_model->validate_add_cart_item($product_code);
        $qty = 1;
        if($result){

            //product price check
            $price = $this->check_product_rate($result->product_id, $qty=1);
            //product tax check
            $tax = $this->product_tax_calculate($result->tax_id, $qty=1, $price);

            $where = array('product_id' => $result->product_id);
            $res_attr = $this->order_model->check_by($where, 'tbl_attribute');
            $has_attr = 'yes';
            if(empty($res_attr))
            {
                $has_attr = 'no';
            }

            $arr = array();
            $arr_attr = array();
            if($iden == 'purchase')
            {
                $data = array(
                    'id' => $result->product_code,
                    'qty' => $qty,
                    'price' => $result->buying_price,
                    'name' => $result->product_name,
                    'product_id' => $result->product_id,
                    'tax' => $tax,
                    'price_option' => 'general',
                    'has_serial' => $result->serial,
                    'has_attribute' => $has_attr,
                    'attribute' => $arr_attr,
                    'serial' => $arr
                );
                $this->cart->insert($data);
            }
            else
            {
                $data = array(
                    'id' => $result->product_code,
                    'qty' => $qty,
                    'price' => $price,
                    'buying_price' => $result->buying_price,
                    'name' => $result->product_name,
                    'product_id' => $result->product_id,
                    'tax' => $tax,
                    'price_option' => 'general',
                    'has_serial' => $result->serial,
                    'has_attribute' => $has_attr,
                    'attribute' => $arr_attr,
                    'serial' => $arr
                );
                $this->cart->insert($data);
            }

            $this->session->set_flashdata('cart_msg', 'add');
        }
    }



    /*** Product add to cart ***/
    public function add_cart_item(){

            $product_code = $this->uri->segment(4);
            $iden = $this->uri->segment(5);
           // $qty = $this->input->post('qty');
            $this->cart_system($product_code,$iden);
            if($iden == 'purchase')
            {
                redirect('admin/purchase/new_purchase/'.$flag ='add');
            }
            else
            {
                redirect('admin/order/new_order/'.$flag ='add');
            }

    }

    /*** Multiple Product add to cart ***/
    public function add_cart_items(){
        $product_code = $this->input->post('product_barcode', true);
        $iden = $this->uri->segment(5);
        foreach($product_code as $v_barcode){
            $this->cart_system($v_barcode,$iden);

        }
        if($iden == 'purchase')
        {
            redirect('admin/purchase/new_purchase/'.$flag ='add');
        }
        else
        {
            redirect('admin/order/new_order/'.$flag ='add');
        }
    }

    /*** Product add to cart by barcode ***/
    public function add_cart_item_by_barcode(){

        $product_code = $this->input->post('barcode', true);
        $iden = $this->uri->segment(5);
        $this->cart_system($product_code,$iden);

        if($iden == 'purchase')
        {
            redirect('admin/purchase/new_purchase/'.$flag ='add');
        }
        else
        {
            redirect('admin/order/new_order/'.$flag ='add');
        }
    }

    /*** Check product general, offer, tire rate ***/
    public function check_product_rate($product_id=null, $qty=null)
    {
        //tier Price check
        $tire_price = $this->order_model->get_tire_price($product_id, $qty);

        if($tire_price)
        {
            return $price = $tire_price->tier_price ;
        }

        //special offer check
        $this->tbl_special_offer('special_offer_id');
        $offer_price = $this->global_model->get_by(array("product_id"=>$product_id), true);

        if(!empty($offer_price)) {
            $today = strtotime(date('Y-m-d'));
            $start_date = strtotime($offer_price->start_date);
            $end_date = strtotime($offer_price->end_date);
            if (($today >= $start_date) && ($today <= $end_date)) {
                return $price = $offer_price->offer_price;
            }
        }

        //return regular rate
        $this->tbl_product_price('product_price_id');
        $general_price = $this->global_model->get_by(array("product_id"=>$product_id), true);
        return $product_price = $general_price->selling_price;

    }

    /*** Product tax calculation ***/
    public function product_tax_calculate($tax_id, $qty ,$price)
    {
        $this->tbl_tax('tax_id');
        $tax = $this->global_model->get_by(array('tax_id'=>$tax_id), true);

        //1 = tax in %
        //2 = Fixed tax Rate

        if($tax){
            if($tax->tax_type == 1)
            {
                $subtotal = $price * $qty;
                $product_tax = $tax->tax_rate * ($subtotal / 100);

                //return $result = round($product_tax, 2);
                return $result = $product_tax;

            }else
            {

                //$product_tax = $tax->tax_rate * $qty;
                $product_tax = $tax->tax_rate * $qty;
                return $result = $product_tax;

            }
        }
    }

    /*** Update Product Cart ***/
    public function update_cart_item()
    {
        $rowid = $this->input->post('rowid');
        $qty = $this->input->post('qty');
        $product_price = $this->input->post('price');
        $product_code = $this->input->post('product_code');
        $custom_price = $this->input->post('custom_price');


        if($qty !=0 )
        {
            //tbl product
            $this->tbl_product('product_id');
            $result = $this->global_model->get_by(array('product_code'=> $product_code ), true);

            //product Inventory Check
            $this->tbl_inventory('inventory_id');
            $product_inventory = $this->global_model->get_by(array('product_id'=> $result->product_id ), true);

            if($qty > $product_inventory->product_quantity)
            {
                $type = 'error';
                $message = 'Sorry! This product has not enough stock.';
                set_message($type, $message);
                echo 'false';
                return;
            }


            if($custom_price == "on")
            {
                   $price = $product_price;
                   $price_option = 'custom_price';

            }
            else
            {
                //product price check
                $price = $this->check_product_rate($result->product_id, $qty);
                $price_option = 'general';
            }


            //product tax check
            $tax = $this->product_tax_calculate($result->tax_id, $qty, $price);

            $data = array(
                'rowid' => $rowid,
                'qty' => $qty,
                'price' => $price,
                'tax'   => $tax,
                'price_option' => $price_option

            );
        }else
        {
            $data = array(
                'rowid' => $rowid,
                'qty' => $qty,
            );
        }

        $this->cart->update($data);

        if($this->input->post('ajax') != '1'){
            redirect('admin/order/new_order'); // If javascript is not enabled, reload the page with new data
        }else{
            $ca = $this->cart->contents();
            $subtota = 0;
            foreach ($ca as $item)
            {
                if($item['rowid'] == $rowid)
                {
                    $subtota= $item['subtotal'];
                }
            }
            $arr = array(
                'subtotal' => number_format($subtota),
                'row' => $data['rowid'],
                'success' => true
            );
            echo json_encode($arr);
        }
    }
    /*** Show cart ***/
    function show_cart(){
        $data['cart_iden'] = 'order';
        $this->load->view('admin/order/cart/cart',$data);
    }
    /*** cart Summery ***/
    function show_cart_summary(){
        $data['cart'] = $this->cart->contents();
        $this->settings_model->_table_name = 'tbl_business_profile';
        $this->settings_model->_order_by = 'business_profile_id';
        $result = $this->settings_model->get_by(array('business_profile_id' => 1), true);
        $persen_tax = 0;
        if($result) {
            if ($result->tax_sale != '0') {
                $this->tax_model->_table_name = 'tbl_tax';
                $this->tax_model->_order_by = 'tax_id';
                $res_tax = $this->tax_model->get_by(array('tax_id' => $result->tax_sale), true);
                $persen_tax = $res_tax->tax_rate;
            }
        }
        $data['persen_tax'] = $persen_tax;
        $this->load->view('admin/order/cart/cart_subtotal',$data);
    }

    /*** Delete Cart Item ***/
    public function delete_cart_item($id,$iden)
    {
        $data = array(
            'rowid' => $id,
            'qty' => 0,
        );
        $this->cart->update($data);
        $this->session->set_flashdata('cart_msg', 'delete');
        if($iden == 'purchase')
        {
            redirect('admin/purchase/new_purchase/'.$flag ='delete');
        }
        else
        {
            redirect('admin/order/new_order/'.$flag ='delete');
        }

    }

    public function error_inventory(){
        redirect('admin/order/new_order/'.$flag ='delete');
    }

    /*** Save Order ***/
    public function save_order()
    {
        $data_order = $this->global_model->array_from_post(array('note', 'payment_ref', 'payment_method', 'due_date','outlet_id','order_no'));
        $order_code = $this->input->post('order_no', true);

        $data_order['subtotal']  = $this->cart->total();
        $data_order['sales_person'] = $this->session->userdata('name');

        //checking order pending or confirm
        $payment_method = $this->input->post('payment_method', true);
        if($payment_method != 'pending'){
            $data_order['payment_method'] = $payment_method;
            $data_order['order_status'] = 2;

        }
        $dp =0;
        $jumlah_uang = 0;
        if($data_order['payment_method'] == 'kredit')
        {
            $dp = $this->input->post('down_payment');
        }
        else
        {
            $jumlah_uang = $this->input->post('down_payment');
        }
        $data_order['down_payment'] = $dp;
        $data_order['jumlah_uang'] = $jumlah_uang;
       // $data_order['outlet_id'] = $this->input->post('outlet', true);

        //customer
        $customer_code =$this->input->post('customer_id', true);
        if($customer_code == '0')
        {
            $data_order['customer_name'] = 'walking Client';
        }else
        {
            $this->tbl_customer('customer_id');
            $customer_info = $this->global_model->get_by(array('customer_id'=> $customer_code), true);
            $data_order['customer_id']= $customer_info->customer_id;
            $data_order['customer_name']= $customer_info->customer_name;
            $data_order['customer_email']= $customer_info->email;
            $data_order['customer_phone']= $customer_info->phone;
            $data_order['customer_address']= $customer_info->address;
            $data_order['shipping_address']= $this->input->post('shipping_address', true);
        }

        $data_order['tax'] = remove_commas($this->input->post('total_tax'));
        $diskon = 0;
        if($this->input->post('discount') != '')
        {
            $diskon = $this->input->post('discount');
        }
        $data_order['discount_amount'] = remove_commas($this->input->post('discount_amount'));
        $data_order['discount'] = $diskon;
        $data_order['discount_type'] = $this->input->post('discount_type');
        $data_order['grand_total'] = remove_commas($this->input->post('grand_total'));
        $id = null;
        if(!empty($this->session->userdata('id_order'))) {
            $id = $this->session->userdata('id_order');

        }
        //save order
        $this->tbl_order('order_id');
        $order_id = $this->global_model->save($data_order,$id);

       // $order_number['order_no'] = $order_code.$order_id;
        //$this->global_model->save($order_number,$order_id );

        $cart = $this->cart->contents();

        if(!empty($this->session->userdata('id_order'))) {
            $this->tbl_order_details('order_details_id');
            $beli_product = $this->global_model->get_by(array('order_id' => $id),false);
            if(count($beli_product) > 0) {
                foreach($beli_product as $jual) {
                    $status_found = false;
                    foreach ($cart as $item) {
                        if($jual->product_code == $item['id'])
                        {
                            $status_found =  true;
                            $id_purchase_product = $jual->purchase_product_id;
                            $get_row_data = db_get_row_data('tbl_purchase_product',array('purchase_product_id' => $id_purchase_product));
                            $sisa = $get_row_data->sisa_qty + $jual->product_quantity;
                            $data_up = array(
                                'sisa_qty' => $sisa
                            );
                            $this->tbl_purchase_product('purchase_product_id');
                            $this->global_model->save($data_up,$id_purchase_product );
                        }
                    }
                    if($status_found == false)
                    {
                        $id_purchase_product = $jual->purchase_product_id;
                        $get_row_data = db_get_row_data('tbl_purchase_product',array('purchase_product_id' => $id_purchase_product));
                        $sisa = $get_row_data->sisa_qty + $jual->product_quantity;
                        $data_up = array(
                            'sisa_qty' => $sisa
                        );
                        $this->tbl_purchase_product('purchase_product_id');
                        $this->global_model->save($data_up,$id_purchase_product );
                    }
                    $this->global_model->_table_name = 'tbl_order_attribute';
                    $this->global_model->delete_all(array('order_detail_id' => $jual->order_details_id));
                    $this->global_model->_table_name = 'tbl_order_serial';
                    $this->global_model->delete_all(array('order_detail_id' => $jual->order_details_id));
                }
            }
            $this->tbl_order_details('order_details_id');
            $this->global_model->delete_all(array('order_id' => $id));
        }

        //save order details
        foreach($cart as $item)
        {
            $this->tbl_order_details('order_details_id');
            $fifo = $this->purchase_model->fifo($item['qty'],$item['id']);
            $buying_price = $item['buying_price'];
            $purchase_product_id = '0';
            if($fifo != '')
            {
                $buying_price = $fifo['unit_price'];
                $purchase_product_id = $fifo['purchase_product_id'];
            }
            $data_order_details['order_id'] = $order_id;
            $data_order_details['product_code'] = $item['id'];
            $data_order_details['product_name'] = $item['name'];
            $data_order_details['product_quantity'] = $item['qty'];
            $data_order_details['selling_price'] = $item['price'];
            $data_order_details['buying_price'] = $buying_price;
            $data_order_details['product_tax'] = $item['tax'];
            $data_order_details['sub_total'] = $item['subtotal'];
            $data_order_details['price_option'] = $item['price_option'];
            $data_order_details['purchase_product_id'] = $purchase_product_id;

            $order_details = $this->global_model->save($data_order_details);

            if($item['has_attribute'] == 'yes')
            {

                if(count($item['attribute']) > 0)
                {
                    foreach ($item['attribute'] as $attr)
                    {
                        $this->global_model->_table_name = 'tbl_order_attribute';
                        $this->global_model->_order_by = 'id';
                        $this->global_model->_primary_key = 'id';
                        $data_attr['order_detail_id'] = $order_details;
                        $data_attr['attribute_id'] = $attr;
                        /* $data_attr = array(
                             'purchase_product_id' => '4',
                             'attribute_id' => $attr
                         );*/
                        $this->global_model->save($data_attr);
                    }
                }
            }

            if($item['has_serial'] == '1')
            {
                if(count($item['serial']) > 0)
                {
                    foreach ($item['serial'] as $serial)
                    {
                        $this->global_model->_table_name = 'tbl_order_serial';
                        $this->global_model->_order_by = 'id';
                        $this->global_model->_primary_key = 'id';
                        $data_serial['order_detail_id'] = $order_details;
                        $data_serial['serial_no'] = $serial;

                        $this->global_model->save($data_serial);
                    }
                }
            }

            // update product Quantity
           /* $this->tbl_product('product_id');
            $product = $this->global_model->get_by(array('product_code'=>$item['id'] ), true);
            $product_id = $product->product_id;

            $this->tbl_inventory('inventory_id');
            $inventory = $this->global_model->get_by(array('product_id'=>$product_id ), true);
            $inventory_id = $inventory->inventory_id;
            $inventory_qty['product_quantity'] = $inventory->product_quantity - $item['qty'];
            $this->global_model->save($inventory_qty, $inventory_id);*/
        }

        //save invoice
        if($payment_method != 'pending'){
            $data_order_invoice['order_id'] = $order_id;

            $this->tbl_invoice('invoice_id');
            $invoice_id = $this->global_model->save($data_order_invoice);
            $invoice_code = rand(10000000, 99999);

            $invoice_number['invoice_no'] = $invoice_code.$invoice_id;
            $this->global_model->save($invoice_number,$invoice_id );

            //destroy cart
            $this->cart->destroy();
            $customer_session = array('customer_name' => '', 'customer_code' => '', 'discount' => '', 'order_no' => '');
            $this->session->unset_userdata($customer_session);

            redirect('admin/order/order_invoice/'.$invoice_number['invoice_no'] );
            //display invoice

        }

        //display order pending invoice
       // redirect('admin/order/view_order/'.$order_number['order_no']);

        //destroy cart
        $this->cart->destroy();
        $customer_session = array('customer_name' => '', 'customer_code' => '', 'discount' => '', 'order_no' => '');
        $this->session->unset_userdata($customer_session);

    }

    /*** View Order Invoice ***/
    public function order_invoice($id=null)
    {

        if(empty($id)){
            //redirect manage invoice
            $this->message->norecord_found('admin/order/manage_invoice');
        }

        //get order id
        $this->tbl_invoice('invoice_id');
        $data['invoice_info']= $this->global_model->get_by(array('invoice_no'=>$id), true);

        if(empty($data['invoice_info'])){
            //redirect manage invoice
            $this->message->norecord_found('admin/order/manage_invoice');
        }

        //order information
        $this->tbl_order('order_id');
        $data['order_info']= $this->global_model->get_by(array('order_id'=>$data['invoice_info']->order_id), true);

        //order details
        $this->tbl_order_details('order_details_id');
        $data['order_details']= $this->global_model->get_by(array('order_id'=>$data['invoice_info']->order_id), false);

        $data['title'] = 'Order Invoice';
        $data['subview'] = $this->load->view('admin/order/order_invoice', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Manage Order ***/
    public function manage_order(){
        $data['order'] = $this->order_model->get_all_order();
        $data['title'] = 'Manage Order';
        $data['subview'] = $this->load->view('admin/order/manage_order', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Pending Order ***/
    public function pending_order(){
        $data['title'] = 'Pending Order';
        $data['subview'] = $this->load->view('admin/order/pending_order', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Manage Invoice ***/
    public function manage_invoice(){
        $data['invoice'] = $this->order_model->get_all_invoice();
        $data['title'] = 'Manage Invoice';
        $data['subview'] = $this->load->view('admin/order/manage_invoice', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function delete_order($id=null)
    {
        $res = $this->order_model->delete_order($id);
        if($res)
        {
            $this->message->delete_success('admin/order/manage_order');
        }
        else
        {
            $this->message->custom_error_msg('admin/order/manage_order','Data gagal disimpan');
        }
    }

    /*** View Order  ***/
    public function view_order($id=null){
        if(empty($id)){
            //redirect manage invoice
            $this->message->norecord_found('admin/order/manage_order');
        }

        //get order
        $this->tbl_order('order_id');
        $data['order_info']= $this->global_model->get_by(array('order_no'=>$id), true);
        //order details
        $this->tbl_order_details('order_details_id');
        $data['order_details']= $this->global_model->get_by(array('order_id'=>$data['order_info']->order_id), false);

        if(empty($data['order_info'])){
            //redirect manage invoice
            $this->message->norecord_found('admin/order/manage_order');
        }

        //get invoice
        $data['order'] = $this->order_model->get_all_order();
        $data['title'] = 'View Order';
        $data['subview'] = $this->load->view('admin/order/order_view', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Order Reconfirmation  ***/
    public function order_re_confirmation()
    {
        $data['order_status'] = $this->input->post('order_status', true);

        $data['payment_method'] = $this->input->post('payment_method', true);
        $data['payment_ref'] = $this->input->post('payment_ref', true);
        $order_id = $this->input->post('order_id', true);
        $order_no = $this->input->post('order_no', true);

        if($data['order_status'] == 2)
        {
            //confirm order
            $this->tbl_order('order_id');
            $this->global_model->save($data,$order_id );


            //invoice generate
            $data_order_invoice['order_id'] = $order_id;

            $this->tbl_invoice('invoice_id');
            $invoice_id = $this->global_model->save($data_order_invoice);
            $invoice_code = rand(10000000, 99999);

            $invoice_number['invoice_no'] = $invoice_code.$invoice_id;
            $this->global_model->save($invoice_number,$invoice_id );

            redirect('admin/order/order_invoice/'.$invoice_number['invoice_no'] );

        }elseif($data['order_status'] == 1)
        {
            //cancel order
            $this->tbl_order('order_id');
            $this->global_model->save($data,$order_id );

            //product details
            $this->tbl_order_details('order_details_id');
            $order_details = $this->global_model->get_by(array('order_id'=> $order_id), false);

            foreach($order_details as $v_order_details){
                //tbl_product
                $this->tbl_product('product_id');
                $product = $this->global_model->get_by(array('product_code'=> $v_order_details->product_code), true);

                //tbl_product inventory
                $this->tbl_inventory('inventory_id');
                $inventory = $this->global_model->get_by(array('product_id'=> $product->product_id), true);

                $data_inventory['product_quantity'] = $inventory->product_quantity + $v_order_details->product_quantity;
                $this->global_model->save($data_inventory,$inventory->inventory_id );
            }
            redirect('admin/order/view_order/'.$order_no);

        }else{
            //redirect
            redirect('admin/order/manage_order');
        }

    }

    /*** PDF Invoice Generate  ***/
    public function pdf_invoice($id=null)
    {

        //get order id
        $this->tbl_invoice('invoice_id');
        $data['invoice_info']= $this->global_model->get_by(array('invoice_no'=>$id), true);

        if(empty($data['invoice_info'])){
            //redirect manage invoice
            $this->message->norecord_found('admin/order/manage_invoice');
        }

        //order information
        $this->tbl_order('order_id');
        $data['order_info']= $this->global_model->get_by(array('order_id'=>$data['invoice_info']->order_id), true);

        //order details
        $this->tbl_order_details('order_details_id');
        $data['order_details']= $this->global_model->get_by(array('order_id'=>$data['invoice_info']->order_id), false);
        $data['title'] = 'Order Invoice';

        $html = $this->load->view('admin/order/pdf_order_invoice', $data, true);
        $filename = 'INV-'.$id;
        $this->load->library('pdf');
        $pdf = $this->pdf->load();

        $pdf->WriteHTML($html);
        $pdf->Output($filename, 'D');

    }

    /*** Email Invoice to customer   ***/
    public function email_invoice($id=null){

        //get order id
        $this->tbl_invoice('invoice_id');
        $data['invoice_info']= $this->global_model->get_by(array('invoice_no'=>$id), true);

        if(empty($data['invoice_info'])){
            //redirect manage invoice
            $this->message->norecord_found('admin/order/manage_invoice');
        }

        //order information
        $this->tbl_order('order_id');
        $data['order_info']= $this->global_model->get_by(array('order_id'=>$data['invoice_info']->order_id), true);

        //order details
        $this->tbl_order_details('order_details_id');
        $data['order_details']= $this->global_model->get_by(array('order_id'=>$data['invoice_info']->order_id), false);


        $company_info = $this->session->userdata('business_info');

        if(!empty($company_info->email) && !empty($company_info->email)) {

            $company_email = $company_info->email;
            $company_name = $company_info->company_name;
            $from = array($company_email, $company_name);
            //sender email
            $to = $data['order_info']->customer_email;
            //subject
            $subject = 'Invoice no:' . $id;
            // set view page
            $view_page = $this->load->view('admin/order/pdf_order_invoice', $data, true);
            $send_email = $this->mail->sendEmail($from, $to, $subject, $view_page);
            if ($send_email) {
                $this->message->custom_success_msg('admin/order/order_invoice/' . $id,
                    'Your email has been send successfully!');
            } else {
                $this->message->custom_error_msg('admin/order/order_invoice/' . $id,
                    'Sorry unable to send your email!');
            }
        }else{
                 $this->message->custom_error_msg('admin/order/order_invoice/' . $id,
                'Sorry unable to send your email, without company email');
        }

    }

    public function order_tables()
    {
        $getData = array();
        $where = "";
        $limit = '';
        $orderby = '';
        $arrCol = array(
            0 => 'order_id',
            1 => 'order_no',
            2 => 'order_date'
        );
        if(!empty($_GET["search"]["value"]))
        {
            if ($where == '') {
                $where = "WHERE order_no LIKE '%".$_GET["search"]["value"]."%'";
            } else {
                $where .= " AND order_no LIKE '%".$_GET["search"]["value"]."%'";
            }
        }

        if(isset($_GET["order"]))
        {
            //$clsPdo->orderByCols = array($_GET['order']['0']['column']);
            //$clsPdo->orderByCols = array($arrCol[$_GET['order']['0']['column']]." ".$_GET['order'][0]['dir']);
            $orderby = " ORDER BY ".$arrCol[$_GET['order']['0']['column']]." ".$_GET['order'][0]['dir'];
        }
        else
        {
            $orderby = " ORDER BY order_date DESC";
        }

        if(isset($_GET["length"])) {
            if ($_GET["length"] != -1) {
                $limit = " LIMIT ".$_GET['start'] . ',' . $_GET['length'];
            }
        }
        $list = $this->global_model->get_by_sql("SELECT * FROM tbl_order ".$where.' '.$orderby.' '.$limit);
        $listAll = $this->global_model->get_by_sql("SELECT * FROM tbl_order ".$where);
        $total = count($listAll);
        $i = $_GET['start'];
        foreach ($list as $v_order) {
            $i = $i + 1;
            $str = btn_view('admin/order/view_order/' . $v_order->order_no)."  ".btn_edit('admin/order/edit_order/' . $v_order->order_id)." ".btn_delete('admin/order/delete_order/' . $v_order->order_id);
            $stat = '';
            if($v_order->order_status == 0){
                $stat = 'Pending Order';
            }elseif($v_order->order_status == 1){
                $stat = 'Cancel Order';
            }else{
                $stat = 'Confirm Order';
            }
            $subdata = array();
            $subdata[] = $i;
            $subdata[] = "ORD-".$v_order->order_no;
            $subdata[] = date('Y-m-d', strtotime($v_order->order_date ));
            $subdata[] = $stat;
            $subdata[] = "Rp" .' '. number_format($v_order->grand_total,0);
            $subdata[] = $v_order->sales_person;
            $subdata[] = $str;
            $getData[] = $subdata;
        }
        $data = array(
            "draw"            => intval( $_GET['draw'] ),
            "recordsTotal"    => $total,
            "recordsFiltered" => $total,
            "data"            => $getData
        );
        echo json_encode($data);
    }

    public function invoice_tables()
    {
        $getData = array();
        $where = "";
        $limit = '';
        $orderby = '';
        $arrCol = array(
            0 => 'invoice_id',
            1 => 'invoice_no',
            2 => 'invoice_date'
        );
        if(!empty($_GET["search"]["value"]))
        {
            if ($where == '') {
                $where = "WHERE invoice_no LIKE '%".$_GET["search"]["value"]."%'";
            } else {
                $where .= " AND invoice_no LIKE '%".$_GET["search"]["value"]."%'";
            }
        }
        $this->db->select('tbl_invoice.*, tbl_order.*', false);
        $this->db->from('tbl_invoice');
        $this->db->join('tbl_order', 'tbl_order.order_id  =  tbl_invoice.order_id ', 'left');
        if($where != '')
        {
            $this->db->where($where);
        }

        if(isset($_GET["order"]))
        {
            //$clsPdo->orderByCols = array($_GET['order']['0']['column']);
            //$clsPdo->orderByCols = array($arrCol[$_GET['order']['0']['column']]." ".$_GET['order'][0]['dir']);
            //$orderby = " ORDER BY ".$arrCol[$_GET['order']['0']['column']]." ".$_GET['order'][0]['dir'];
            $this->db->order_by($arrCol[$_GET['order']['0']['column']], $_GET['order'][0]['dir']);
        }
        else
        {
            $this->db->order_by('invoice_id', 'DESC');
        }
        if(isset($_GET["length"])) {
            if ($_GET["length"] != -1) {
                // $limit = " LIMIT ".$_GET['start'] . ',' . $_GET['length'];
                $this->db->limit($_GET['length'], $_GET['start']);
            }
        }
        $query_result = $this->db->get();
        $list = $query_result->result();
        //$list = $this->global_model->get_by_sql("SELECT * FROM tbl_order ".$where.' '.$orderby.' '.$limit);
        $listAll = $this->global_model->get_by_sql("SELECT * FROM tbl_invoice ".$where);
        $total = count($listAll);
        $i = $_GET['start'];
        foreach ($list as $v_invoice) {
            $i = $i + 1;
            $str = btn_view('admin/order/order_invoice/' . $v_invoice->invoice_no);
            $subdata = array();
            $subdata[] = $i;
            $subdata[] = "INV-".$v_invoice->invoice_no ;
            $subdata[] = "ORD-".$v_invoice->order_no ;
            $subdata[] = date('Y-m-d', strtotime($v_invoice->invoice_date));
            $subdata[] = $v_invoice->customer_name;
            $subdata[] = $v_invoice->payment_method;
            $subdata[] = "Rp" .' '. number_format($v_invoice->grand_total,2) ;
            $subdata[] = $str;
            $getData[] = $subdata;
        }
        $data = array(
            "draw"            => intval( $_GET['draw'] ),
            "recordsTotal"    => $total,
            "recordsFiltered" => $total,
            "data"            => $getData
        );
        echo json_encode($data);
    }


}
