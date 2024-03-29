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

class Purchase extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('purchase_model');
        $this->load->model('order_model');
        $this->load->model('global_model');
        $this->load->model('outlet_model');
        $this->load->model('settings_model');
        $this->load->model('tax_model');

        $this->load->helper('ckeditor');
        $this->data['ckeditor'] = array(
            'id' => 'ck_editor',
            'path' => 'asset/js/ckeditor',
            'config' => array(
                'toolbar' => 'Full',
                'width' => '100%',
                'height' => '150px',
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

    /*** Add Supplier ***/
    public function add_supplier($id = null)
    {
        $this->tbl_supplier('supplier_id');

        if ($id) {//condition check
            $result = $this->global_model->get_by(array('supplier_id' => $id), true);

            if ($result) {
                $data['supplier'] = $result;
            } else {
                //msg
                $type = 'error';
                $message = 'Sorry, No Record Found!';
                set_message($type, $message);
                redirect('admin/purchase/manage_supplier');
            }
        }

        // view page
        $data['title'] = 'Add New Supplier';
        $data['editor'] = $this->data;
        $data['subview'] = $this->load->view('admin/purchase/add_supplier', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }


    public function add_supplier_modal()
    {
        $data['title'] = 'Tambah Supplier';
        $data['modal_subview'] = $this->load->view('admin/purchase/add_supplier_modal', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);
    }

    /*** Save Supplier ***/
    public function save_supplier($id = null)
    {
        $this->tbl_supplier('supplier_id');
        $data = $this->global_model->array_from_post(array('company_name', 'supplier_name' , 'email', 'address', 'phone'));

        $this->global_model->save($data, $id);
        //msg
        $this->message->save_success('admin/purchase/manage_supplier');

    }

    public function save_api_supplier()
    {
        $this->tbl_supplier('supplier_id');
        $data = $this->global_model->array_from_post(array('company_name', 'supplier_name' , 'email', 'address', 'phone'));

        $supp_id = $this->global_model->save($data);
        if($supp_id)
        {
            $q_supp = $this->global_model->get_by(array('supplier_id' => $supp_id),true);
            $arr = array(
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'supplier' => $q_supp
            );
        }
        else
        {
            $arr = array(
                'success' => false,
                'message' => 'Data gagal disimpan'
            );
        }
        echo json_encode($arr);

    }

    /*** Manage Supplier ***/
    public function manage_supplier($id = null)
    {
        $this->tbl_supplier('supplier_id', 'desc');
        $data['supplier'] = $this->global_model->get();
            // view page
        $data['title'] = 'Add New Supplier';
        $data['subview'] = $this->load->view('admin/purchase/manage_supplier', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Delete Supplier ***/
    public function delete_supplier($id)
    {
        $this->tbl_supplier('supplier_id');
        $this->global_model->delete($id);
        $this->message->delete_success('admin/purchase/manage_supplier');

    }

    public function edit_purchase($id=null)
    {
        $purchase_id = array(
            'id_purchase' => $id,
        );
        $this->session->set_userdata($purchase_id);
        redirect('admin/purchase/new_purchase/edit');
    }

    public function delete_purchase($id=null)
    {
        $res = $this->purchase_model->delete_purchase($id);
        if($res)
        {
            $this->message->delete_success('admin/purchase/purchase_list');
        }
        else
        {
            $this->message->custom_error_msg('admin/purchase/purchase_list','Data gagal disimpan');
        }
    }

    /*** New Purchase  ***/
    public function new_purchase($flag = null)
    {
        if(empty($flag))
        {
            $this->cart->destroy();
            $this->session->unset_userdata('nominal');
            $this->session->unset_userdata('tipe');
            $this->session->unset_userdata('id_purchase');
            $random_number = rand(10000000, 99999);
            if(empty($id)) {
                $order_no = array(
                    'order_no' => $random_number,
                );
                $this->session->set_userdata($order_no);
            }
        }
        //$data['product'] = $this->purchase_model->get_all_product_info();
        //$this->tbl_supplier('supplier_id');
       // $data['supplier'] = $this->global_model->get();

        // view page
        //$data['title'] = 'Add New Supplier';
        //$data['subview'] = $this->load->view('admin/purchase/purchase', $data, true);

        $title = 'Add New Purchase';
        $url_action = base_url().'admin/purchase/save_purchase';
        $data['order_purchase'] = '';
        if(!empty($this->session->userdata('id_purchase')))
        {
            $id = $this->session->userdata('id_purchase');
            $this->purchase_model->_table_name = 'tbl_purchase';
            $this->purchase_model->_order_by = 'purchase_id';
            $pembelian = $this->purchase_model->get_by(array('purchase_id' => $id),true);

            $title = "Edit Purchase";
            //$url_action = base_url().'admin/purchase/update_purchase';
            $order_no = array(
                'order_no' => $pembelian->order_no,
            );
            $this->session->set_userdata($order_no);
            $arr_diskon = array(
                'nominal' => $pembelian->discount,
                'tipe' => $pembelian->discount_type
            );
            $this->session->set_userdata($arr_diskon);
            $this->purchase_model->init_table('tbl_purchase_product','purchase_product_id');
            $beli_product = $this->purchase_model->get_by(array('purchase_id' => $id),false);
            if(count($beli_product) > 0) {
                if($flag == 'edit') {
                    $this->cart->destroy();
                    foreach ($beli_product as $beli) {
                        $res_product = $this->order_model->validate_add_cart_item($beli->product_code);
                        $where = array('product_id' => $res_product->product_id);
                        $res_attr = $this->order_model->check_by($where, 'tbl_attribute');
                        $has_attr = 'yes';
                        if (empty($res_attr)) {
                            $has_attr = 'no';
                        }

                        $this->purchase_model->init_table('tbl_purchase_attribute', 'id');
                        $res_pur_attr = $this->purchase_model->get_by(array('purchase_product_id' => $beli->purchase_product_id), false);
                        $arr_attr = array();
                        $arr = array();
                        if (count($res_pur_attr) > 0) {
                            foreach ($res_pur_attr as $re_attr) {
                                $arr_attr[] = $re_attr->attribute_id;
                            }
                        }

                        $this->purchase_model->init_table('tbl_purchase_serial', 'id');
                        $res_pur_serial = $this->purchase_model->get_by(array('purchase_product_id' => $beli->purchase_product_id), false);
                        if (count($res_pur_serial) > 0) {
                            foreach ($res_pur_serial as $re_serial) {
                                $arr[] = $re_serial->serial_no;
                            }
                        }

                        $data = array(
                            'id' => $beli->product_code,
                            'qty' => $beli->qty,
                            'price' => $beli->unit_price,
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
            $data['order_purchase'] = $pembelian;
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

        $data['person_div'] = $this->load->view('admin/order/cart/supplier_div',$data,true);
        //$data['cart_subtotal'] = $this->load->view('admin/order/cart/cart_subtotal',$data);

        $data['url_method'] = $url_action;
        $data['cart_iden'] = 'purchase';

        $data['subview'] = $this->load->view('admin/order/new_order', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Add to cart item ***/
    public function add_cart_item(){

        $this->purchase_model->validate_add_cart_item();

        if($this->purchase_model->validate_add_cart_item() == TRUE){
                redirect('admin/purchase/new_purchase/'.$flag = 'purchase');

        }
    }

    /*** Add new product add to cart ***/
    public function add_new_product_to_cart()
    {
        $product_name = $this->input->post('product_name');
        $qty = $this->input->post('qty');
        $price = $this->input->post('price');

       $id = rand(100, 99999);

        $data = array(
            'id' => 'sku-'.$id,
            'qty' => $qty,
            'price' => $price,
            'name' => $product_name,
            'tax'   => 'tax',
            'price_option' => 'price_option'

        );
        $this->cart->insert($data);

        if($this->input->post('ajax') != '1'){
            redirect('admin/purchase/new_purchase'); // If javascript is not enabled, reload the page with new data
        }else{
            echo 'true'; // If javascript is enabled, return true, so the cart gets updated
        }
    }

    /*** Update cart item ***/
    public function update_cart_item()
    {
        $rowid = $this->input->post('rowid');
        $qty = $this->input->post('qty');
        $price = $this->input->post('price');

        if($qty !=0 )
        {
            $data = array(
                'rowid' => $rowid,
                'qty' => $qty,
                'price' => $price,
                'tax'   => 'tax',
                'price_option' => 'price_option'

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
            redirect('admin/purchase/new_purchase'); // If javascript is not enabled, reload the page with new data
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
            echo json_encode($arr); // If javascript is enabled, return true, so the cart gets updated
        }
    }

    /*** Delete Cart Item ***/
    public function delete_cart_item($id)
    {
        $data = array(
            'rowid' => $id,
            'qty' => 0,
        );
        $this->cart->update($data);
        redirect('admin/purchase/new_purchase/'.$flag = 'delete');
    }

    function show_cart(){
        $data['cart_iden'] = 'purchase';
      //  $this->load->view('admin/purchase/cart/cart',$data);
        $this->load->view('admin/order/cart/cart',$data);
    }

    public function update_purchase()
    {
        $data = $this->global_model->array_from_post(array('supplier_id', 'note', 'payment_method', 'due_date','outlet_id'));
    }

    /*** Save Purchase Item Item ***/
    public function save_purchase()
    {

        $data = $this->global_model->array_from_post(array('supplier_id', 'note', 'payment_method', 'due_date','outlet_id','order_no'));

        //find out supplier details
        $this->tbl_supplier('supplier_id');
        $supplier = $this->global_model->get_by(array('supplier_id'=> $data['supplier_id']), true);
        $data['supplier_name'] = $supplier->company_name;
        $data['subtotal']  = $this->cart->total();
        $data['purchase_by'] = $this->session->userdata('name');
        $data['tax'] = remove_commas($this->input->post('total_tax'));
        $diskon = 0;
        if($this->input->post('discount') != '')
        {
            $diskon = $this->input->post('discount');
        }
        $data['discount_amount'] = remove_commas($this->input->post('discount_amount'));
        $data['discount'] = $diskon;
        $data['discount_type'] = $this->input->post('discount_type');
        $data['grand_total'] = remove_commas($this->input->post('grand_total'));
        $dp =0;
        $jumlah_uang = 0;
        if($data['payment_method'] == 'kredit')
        {
            $dp = $this->input->post('down_payment');
            $data['status_purchase'] = BELUM_LUNAS;
        }
        else
        {
            $jumlah_uang = $this->input->post('down_payment');
            $data['status_purchase'] = LUNAS;
        }
        $data['down_payment'] = $dp;
        $data_order['jumlah_uang'] = $jumlah_uang;
        $id = null;
        if(!empty($this->session->userdata('id_purchase'))) {
            $id = $this->session->userdata('id_purchase');

        }
        //save to purchase table
        $this->tbl_purchase('purchase_id');
        $purchase_id = $this->global_model->save($data,$id);

        if(!empty($this->session->userdata('id_purchase'))) {
            $this->tbl_purchase_product('purchase_product_id');
            $beli_product = $this->global_model->get_by(array('purchase_id' => $id),false);
            if(count($beli_product) > 0)
            {
                foreach ($beli_product as $beli)
                {
                    $this->global_model->_table_name = 'tbl_purchase_attribute';
                    $this->global_model->delete_all(array('purchase_product_id' => $beli->purchase_product_id));
                    $this->global_model->_table_name = 'tbl_purchase_serial';
                    $this->global_model->delete_all(array('purchase_product_id' => $beli->purchase_product_id));
                }
            }
            $this->tbl_purchase_product('purchase_product_id');
            $this->global_model->delete_all(array('purchase_id' => $id));

        }

        $data= array();
        $cart = $this->cart->contents();
        foreach($cart as $item)
        {
            $this->tbl_purchase_product('purchase_product_id');
            $data['purchase_id'] = $purchase_id;
            $data['product_code'] = $item['id'];
            $data['product_name'] = $item['name'];
            $data['qty'] = $item['qty'];
            $data['unit_price'] = $item['price'];
            $data['sub_total'] = $item['subtotal'];
            $data['sisa_qty'] = $item['qty'];
            $pur_detail_id = $this->global_model->save($data);

            if($item['has_attribute'] == 'yes')
            {

                if(count($item['attribute']) > 0)
                {
                    foreach ($item['attribute'] as $attr)
                    {
                        $this->global_model->_table_name = 'tbl_purchase_attribute';
                        $this->global_model->_order_by = 'id';
                        $this->global_model->_primary_key = 'id';
                        $data_attr['purchase_product_id'] = $pur_detail_id;
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
                        $this->global_model->_table_name = 'tbl_purchase_serial';
                        $this->global_model->_order_by = 'id';
                        $this->global_model->_primary_key = 'id';
                        $data_serial['purchase_product_id'] = $pur_detail_id;
                        $data_serial['serial_no'] = $serial;

                        $this->global_model->save($data_serial);
                    }
                }
            }

            // update product Quantity
           // $this->tbl_product('product_id');
          //  $product = $this->global_model->get_by(array('product_code'=>$item['id'] ), true);

            /*if(!empty($product)) {
                $product_id = $product->product_id;

                $this->tbl_inventory('inventory_id');
                $inventory = $this->global_model->get_by(array('product_id' => $product_id), true);
                $inventory_id = $inventory->inventory_id;
                $inventory_qty['product_quantity'] = $item['qty'] + $inventory->product_quantity;
                $this->global_model->save($inventory_qty, $inventory_id);
            }*/
        }

        //destroy cart
        $this->cart->destroy();
        redirect('admin/purchase/purchase_invoice/'.$purchase_id);

    }
    /*** view purchase invoice ***/
    public function purchase_invoice($id)
    {
        $data['purchase'] = $this->purchase_model->select_purchase_by_id($id);

        $this->tbl_purchase_product('purchase_product_id');
        $data['product'] = $this->global_model->get_by(array('purchase_id'=>$id), false);

        $data['title'] = 'Purchase Invoice';
        $data['subview'] = $this->load->view('admin/purchase/purchase_invoice', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** make pdf purchase invoice ***/
    public function pdf_invoice($id)
    {
        $data['purchase'] = $this->purchase_model->select_purchase_by_id($id);

        $this->tbl_purchase_product('purchase_product_id');
        $data['product'] = $this->global_model->get_by(array('purchase_id'=>$id), false);

        $view_file = $this->load->view('admin/purchase/pdf_invoice', $data, true);
        $file_name =  'PUR-'.$data['purchase']->order_no.'.pdf';
        $this->load->library('pdf');
        $pdf = $this->pdf->load();

        $pdf->WriteHTML($view_file);
        $pdf->Output($file_name, 'D');


    }

    /*** make pdf purchase invoice ***/
    public function purchase_list()
    {

        $this->tbl_purchase('purchase_id', 'desc');
        $data['purchase'] = $this->global_model->get();

        $data['title'] = 'Purchase History';
        $data['subview'] = $this->load->view('admin/purchase/purchase_list', $data, true);
        $this->load->view('admin/_layout_main', $data);

    }

    /*** Supplier History ***/
    public function supplier_history($id){
        if(empty($id)){
            $this->message->norecord_found('admin/purchase/manage_supplier');
        }

        $this->tbl_supplier('supplier_id');
        $data['supplier'] = $this->global_model->get_by(array('supplier_id' => $id), true);

        if(empty($data['supplier'])){
            $this->message->norecord_found('admin/purchase/manage_supplier');
        }

        $this->tbl_purchase('purchase_id');
        $data['purchase'] = $this->global_model->get_by(array('supplier_id' => $id), false);

        $data['title'] = 'Supplier History';
        $data['subview'] = $this->load->view('admin/purchase/supplier_history', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function modal_supplier()
    {
        $data['title'] = 'Cari Supplier';
        $data['modal_subview'] = $this->load->view('admin/purchase/modal_supplier', $data, false);
        $this->load->view('admin/_layout_modal', $data);
    }

    public function supplier_table()
    {
        $getData = array();
        $where = '';
        $limit = '';
        $orderby = '';
        $arrCol = array(
            0 => 'company_name',
            1 => 'supplier_name',
        );
        if(isset($_GET["search"]["value"]))
        {
            if ($where == '') {
                $where = "WHERE company_name LIKE '%".$_GET["search"]["value"]."%' OR supplier_name LIKE '%".$_GET["search"]["value"]."%'";
            } else {
                $where .= " AND company_name LIKE '%".$_GET["search"]["value"]."%' OR supplier_name LIKE '%".$_GET["search"]["value"]."%'";
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
            $orderby = " ORDER BY supplier_name ASC";
        }

        if(isset($_GET["length"])) {
            if ($_GET["length"] != -1) {
                $limit = " LIMIT ".$_GET['start'] . ',' . $_GET['length'];
            }
        }
        $list = $this->global_model->get_by_sql("SELECT * FROM tbl_supplier ".$where.' '.$orderby.' '.$limit);
        $listAll = $this->global_model->get_by_sql("SELECT * FROM tbl_supplier ".$where);
        $total = count($listAll);
        foreach ($list as $post) {
            $subdata = array();
            $subdata[] = $post->company_name;
            $subdata[] = $post->supplier_name;
            $subdata[] = $post->phone;
            $subdata[] = '<a href="#" onclick="'.htmlspecialchars('choose_supplier('.json_encode($post).')', ENT_QUOTES).'"><i class="fa fa-plus"></i>Pilih</a>';
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

    public function purchase_tables()
    {
        $getData = array();
        $where = "";
        $limit = '';
        $orderby = '';
        $arrCol = array(
            0 => 'purchase_id',
            1 => 'order_no',
            2 => 'datetime'
        );
        if(isset($_GET["search"]["value"]))
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
            $orderby = " ORDER BY datetime DESC";
        }

        if(isset($_GET["length"])) {
            if ($_GET["length"] != -1) {
                $limit = " LIMIT ".$_GET['start'] . ',' . $_GET['length'];
            }
        }

        $list = $this->global_model->get_by_sql("SELECT * FROM tbl_purchase ".$where.' '.$orderby.' '.$limit);
        $listAll = $this->global_model->get_by_sql("SELECT * FROM tbl_purchase ".$where);
        $total = count($listAll);
        $i = $_GET['start'];
        foreach ($list as $v_purchase) {
            $i = $i + 1;
            $str = btn_view('admin/purchase/purchase_invoice/' . $v_purchase->purchase_id);
            if(check_if_sold($v_purchase->purchase_id))
            {
                $str .= " ".btn_edit_disable('admin/purchase/edit_purchase/'. $v_purchase->purchase_id);
            }
            else
            {
                $str .= " ".btn_edit('admin/purchase/edit_purchase/'. $v_purchase->purchase_id);
            }
            ?>
            <?php
            if(check_if_sold($v_purchase->purchase_id))
            {
                $str .= " ".btn_delete_disable('admin/purchase/delete_purchase/'. $v_purchase->purchase_id);
            }
            else
            {
                $str .= " ".btn_delete('admin/purchase/delete_purchase/'. $v_purchase->purchase_id);
            }
            $subdata = array();
            $subdata[] = $i;
            $subdata[] = "PUR-".$v_purchase->order_no;
            $subdata[] = $v_purchase->supplier_name;
            $subdata[] = date('Y-m-d', strtotime($v_purchase->datetime ));
            $subdata[] = "Rp" .' '. number_format($v_purchase->grand_total,0);
            $subdata[] = $v_purchase->payment_method;
            $subdata[] = $v_purchase->purchase_by;
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

    public function supplier_hutang_table()
    {
        $getData = array();
        $where = '';
        $limit = '';
        $orderby = '';
        $arrCol = array(
            0 => 'company_name',
            1 => 'supplier_name',
        );
        if(isset($_GET["search"]["value"]))
        {
            if ($where == '') {
                $where = "WHERE company_name LIKE '%".$_GET["search"]["value"]."%' OR supplier_name LIKE '%".$_GET["search"]["value"]."%'";
            } else {
                $where .= " AND company_name LIKE '%".$_GET["search"]["value"]."%' OR supplier_name LIKE '%".$_GET["search"]["value"]."%'";
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
            $orderby = " ORDER BY supplier_name ASC";
        }

        if(isset($_GET["length"])) {
            if ($_GET["length"] != -1) {
                $limit = " LIMIT ".$_GET['start'] . ',' . $_GET['length'];
            }
        }
        $list = $this->global_model->get_by_sql("SELECT * FROM tbl_supplier ".$where.' '.$orderby.' '.$limit);
        $listAll = $this->global_model->get_by_sql("SELECT * FROM tbl_supplier ".$where);
        $total = count($listAll);
        foreach ($list as $post) {
            $tot_hutang = $this->purchase_model->get_total_hutang_by_supplier($post->supplier_id);
            $list_nota = $this->purchase_model->get_nota_by_supplier($post->supplier_id,'0');
            $subdata = array();
            $subdata[] = $post->company_name;
            $subdata[] = $post->supplier_name;
            $subdata[] = number_format($tot_hutang);
            $subdata[] = '<a href="#" onclick="'.htmlspecialchars('choose_supplier('.json_encode($post).','.$tot_hutang.','.json_encode($list_nota).')', ENT_QUOTES).'"><i class="fa fa-plus"></i>Pilih</a>';
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