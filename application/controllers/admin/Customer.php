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

class Customer extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_model');
        $this->load->model('global_model');

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

    }

    public function modal()
    {
        $data['title'] = 'Cari Customer';
        $data['modal_subview'] = $this->load->view('admin/customer/modal', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);
    }

    public function customer_table()
    {
        $getData = array();
        $where = '';
        $limit = '';
        $orderby = '';
        $arrCol = array(
            0 => 'customer_code'
        );
        if(isset($_GET["search"]["value"]))
        {
            if ($where == '') {
                $where = "WHERE customer_code LIKE '%".$_GET["search"]["value"]."%' OR customer_name LIKE '%".$_GET["search"]["value"]."%'";
            } else {
                $where .= " AND customer_code LIKE '%".$_GET["search"]["value"]."%' OR customer_name LIKE '%".$_GET["search"]["value"]."%'";
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
            $orderby = " ORDER BY customer_name ASC";
        }

        if(isset($_GET["length"])) {
            if ($_GET["length"] != -1) {
                $limit = " LIMIT ".$_GET['start'] . ',' . $_GET['length'];
            }
        }
        $list = $this->global_model->get_by_sql("SELECT * FROM tbl_customer ".$where.' '.$orderby.' '.$limit);
        $listAll = $this->global_model->get_by_sql("SELECT * FROM tbl_customer ".$where);
        $total = count($listAll);
        foreach ($list as $post) {
            $subdata = array();
            $subdata[] = $post->customer_code;
            $subdata[] = $post->customer_name;
            $subdata[] = $post->phone;
            $subdata[] = '<a href="#" onclick="'.htmlspecialchars('choose_customer('.json_encode($post).')', ENT_QUOTES).'"><i class="fa fa-plus"></i>Pilih</a>';
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

    public function add_modal()
    {
        $data['title'] = 'Tambah Customer';
        $data['code'] = rand(10000000, 99999);
        $data['modal_subview'] = $this->load->view('admin/customer/add_modal', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);
    }


    /*** Add Customer ***/
    public function add_customer($id = null)
    {
        $this->tbl_customer('customer_id');

        if ($id) {
            $data['customer'] = $this->global_model->get_by(array('customer_id'=>$id), true);
            if(empty($data['customer'])){
                $type = 'error';
                $message = 'There is no Record Found!';
                set_message($type, $message);
                redirect('admin/customer/manage_customer');
            }
        }


        $data['code'] = $data['code'] = rand(10000000, 99999);

        $data['title'] = 'Add Customer';  // title page
        $data['editor'] = $this->data;
        $data['subview'] = $this->load->view('admin/customer/add_customer', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }


    public function save_api_customer()
    {
        $data = $this->customer_model->array_from_post(array(
            'customer_code',
            'customer_name',
            'email',
            'phone',
            'address',
            'discount'
        ));
        $data['address'] = '';
        $data['discount'] = '0';

        $this->tbl_customer('customer_id');
        $customer_id = $this->global_model->save($data);
        if($customer_id)
        {
            $q_cust = $this->global_model->get_by(array('customer_id' => $customer_id),true);
            $arr = array(
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'customer' => $q_cust
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

    /*** Save Customer ***/
    public function save_customer($id = null)
    {
        $data = $this->customer_model->array_from_post(array(
            'customer_name',
            'email',
            'phone',
            'address',
            'discount'
             ));

        $this->tbl_customer('customer_id');
        $customer_id = $this->global_model->save($data, $id);

        if(empty($id)) {
            $customer_code['customer_code'] = $this->input->post('customer_code').$customer_id;
            $this->global_model->save($customer_code, $customer_id);
        }

        $type = 'success';
        $message = 'Customer Information Saved Successfully!';
        set_message($type, $message);
        redirect('admin/customer/manage_customer');

    }

    /*** Manage Customer ***/
    public function manage_customer()
    {

        $this->tbl_customer('customer_id');
        $data['customer'] = $this->global_model->get();
        $data['title'] = 'Manage Customer';
        $data['subview'] = $this->load->view('admin/customer/manage_customer', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Delete Customer ***/
    public function delete_customer($id=null)
    {
        $this->customer_model->_table_name = 'tbl_customer';
        $this->customer_model->_primary_key = 'customer_id';
        $this->customer_model->delete($id);  // delete by id

        // massage for employee
        $type = 'error';
        $message = 'Customer Successfully Deleted from System';
        set_message($type, $message);
        redirect('admin/customer/manage_customer');
    }

    /*** Check Duplicate Customer  ***/
    public function check_customer_phone($phone=null, $customer_id = null)
    {
        $this->tbl_customer('customer_id');
        if(empty($customer_id))
        {
            $result = $this->global_model->get_by(array('phone'=>$phone), true);
        }else{
            //$result = $this->customer_model->check_customer_phone($phone, $customer_id);
            $result = $this->global_model->get_by(array('phone'=>$phone, 'customer_id !=' => $customer_id ), true);
        }

        if($result)
        {
            echo 'This phone number already exist!';
        }

    }
}
