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

class Settings extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('settings_model');
        $this->load->model('global_model');
        $this->load->model('login_model');

    }

    /*** Business Settings ***/
    public function business_profile($val = null)
    {
        $this->settings_model->_table_name = 'tbl_business_profile';
        $this->settings_model->_order_by = 'business_profile_id';

        $result = $this->settings_model->get_by(array('business_profile_id' => 1), true);
        if ($result) {
            $data['business_info'] = $result;
        }
        $this->tbl_tax('tax_id');
        $data['tax_info'] = $this->global_model->get();
        // view page
        $data['title'] = 'Business Profile';
        $data['subview'] = $this->load->view('admin/settings/business_profile', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Save Business Information ***/
    public function save_business_profile($id = null)
    {
        $this->settings_model->_table_name = 'tbl_business_profile';
        $this->settings_model->_primary_key = 'business_profile_id';
        $data = $this->settings_model->array_from_post(array('company_name', 'email', 'address', 'phone', 'currency','tax_sale','tax_purchase'));

        //logo Upload
        if ($_FILES['logo']['name']) { // logo name is exist
            $old_path = $this->input->post('old_path');
            if ($old_path) {
                unlink($old_path);
            }
            $val = $this->settings_model->uploadImage('logo'); // upload the image
            $val == true || redirect('admin/dashboard/general_settings');
            $data['logo'] = $val['path'];
            $data['full_path'] = $val['fullPath'];
        }
        $this->settings_model->save($data, $id); // save
        // redirect with msg
        $type = 'success';
        $message = 'Business Information Successfully Save!';
        set_message($type, $message);
        redirect('admin/settings/business_profile');
    }

    /*** New Tax Rule ***/
    public function tax($id = null)
    {
        $this->tbl_tax('tax_id');
        $data['tax_info'] = $this->global_model->get();

        if (!empty($id)) { //condition check
            $where = array('tax_id' => $id);
            $data['tax'] = $this->settings_model->check_by($where, 'tbl_tax');

            if (empty($data['tax'])) {
                // massage
                $type = 'error';
                $message = 'No Record Found';
                set_message($type, $message);
                redirect('admin/settings/tax');
            }
        }

        //view page
        $data['title'] = 'Manage Tax Rules';
        $data['subview'] = $this->load->view('admin/settings/tax', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Save tax rule ***/
    public function save_tax($id = null)
    {
        $this->tbl_tax('tax_id');
        $data = $this->settings_model->array_from_post(array('tax_title', 'tax_rate', 'tax_type'));

        // update root category
        $where = array('tax_title' => $data['tax_title']);
        // duplicate value check
        if (!empty($id)) {
            $tax_id = array('tax_id !=' => $id);
        } else {
            $tax_id = null;
        }

        // duplicate value check
        $check_category = $this->settings_model->check_update('tbl_tax', $where, $tax_id);
        if (!empty($check_category)) {
            $type = 'error';
            $message = 'Tax Rule Already Exist!';
        } else { // save and update
            $this->global_model->save($data, $id);
            // massage
            $type = 'success';
            $message = 'Tax Rule Saved Successfully!';
        }
        set_message($type, $message);
        redirect('admin/settings/tax');
    }

    /*** Delete Tax Rule ***/
    public function delete_tax($id=null){
        $this->tbl_tax('tax_id');
        $this->global_model->delete($id);
        $this->message->delete_success('admin/settings/tax');
    }

    public function outlet($id = null)
    {
        $this->tbl_outlet('outlet_id');
        $data['outlet_info'] = $this->global_model->get();

        if (!empty($id)) { //condition check
            $where = array('outlet_id' => $id);
            $data['outlet'] = $this->settings_model->check_by($where, 'tbl_outlets');

            if (empty($data['outlet'])) {
                // massage
                $type = 'error';
                $message = 'No Record Found';
                set_message($type, $message);
                redirect('admin/settings/outlet');
            }
        }

        //view page
        $data['title'] = 'Manage Outlets';
        $data['subview'] = $this->load->view('admin/settings/outlet', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Save tax rule ***/
    public function save_outlet($id = null)
    {
        $this->tbl_outlet('id');
        $check = $this->global_model->get();
        if(count($check) > 0)
        {
            $data_status = array(
                'status' => '1'
            );
            $this->db->update('tbl_outlets', $data_status);
        }

        $status = '1';
        if(!empty($this->input->post('default')))
        {
            if($this->input->post('default') == 'yes')
            {
                $status = '2';
            }
        }

        if (!empty($id)) {
            $data = array(
                'name' => $this->input->post('outlet_name'),
                'address' => $this->input->post('address'),
                'contact_number' => $this->input->post('phone'),
                'receipt_header' => '',
                'receipt_footer' => '',
                'updated_user_id' => $this->login_model->get_user_id(),
                'updated_datetime' => date('Y-m-d h:i:s'),
                'status' => $status
            );
            $this->db->where('id', $id);
            $this->db->update('tbl_outlets', $data);
            $where = array('id' => $id);
            $data['outlet'] = $this->settings_model->check_by($where, 'tbl_outlets');
            $type = 'success';
            $message = 'Data Outlet Successfully!';
        } else {
           $data = array(
               'name' => $this->input->post('outlet_name'),
               'address' => $this->input->post('address'),
               'contact_number' => $this->input->post('phone'),
               'receipt_header' => '',
               'receipt_footer' => '',
               'created_user_id' => $this->login_model->get_user_id(),
               'created_datetime' => date('Y-m-d h:i:s'),
               'updated_user_id' => $this->login_model->get_user_id(),
               'updated_datetime' => date('Y-m-d h:i:s'),
               'status' => $status
           );
            $this->db->insert('tbl_outlets', $data);
            $type = 'success';
            $message = 'Data Outlet Successfully!';
        }

        set_message($type, $message);
        redirect('admin/settings/outlet');
    }

    /*** Delete Tax Rule ***/
    public function delete_outlet($id=null){
        $this->tbl_outlet('id');
        $this->global_model->delete($id);
        $this->message->delete_success('admin/settings/outlet');
    }

    public function account()
    {
        $data['title'] = 'Account List';
        $data['subview'] = $this->load->view('admin/settings/account_list', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function account_table()
    {
        $getData = array();
        $where = '';
        $limit = '';
        $orderby = '';
        $arrCol = array(
            0 => 'account_name',
            1 => 'account_code'
        );
        if(isset($_GET["search"]["value"]))
        {
            if ($where == '') {
                $where = "WHERE account_code LIKE '%".$_GET["search"]["value"]."%' OR account_name LIKE '%".$_GET["search"]["value"]."%'";
            } else {
                $where .= " AND account_code LIKE '%".$_GET["search"]["value"]."%' OR account_name LIKE '%".$_GET["search"]["value"]."%'";
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
            $orderby = " ORDER BY account_name ASC";
        }

        if(isset($_GET["length"])) {
            if ($_GET["length"] != -1) {
                $limit = " LIMIT ".$_GET['start'] . ',' . $_GET['length'];
            }
        }
        $list = $this->global_model->get_by_sql("SELECT * FROM tbl_account ".$where.' '.$orderby.' '.$limit);
        $listAll = $this->global_model->get_by_sql("SELECT * FROM tbl_account ".$where);
        $total = count($listAll);
        foreach ($list as $post) {
            $subdata = array();
            $subdata[] = $post->account_name;
            $subdata[] = $post->account_code;
            $subdata[] = btn_edit_modal(base_url('admin/settings/add_account/'.$post->account_id)).' '.btn_delete(base_url('admin/settings/delete_account/'.$post->account_id));
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

    public function add_account($id='')
    {
        $judul = 'Tambah Account';
        $url_action = base_url('admin/settings/save_account');
        if(!empty($id))
        {
            $judul = 'Edit Account';
            //$url_action = base_url('admin/settings/edit_account');
            $where = array('account_id' => $id);
            $data['account'] = $this->settings_model->check_by($where, 'tbl_account');
        }
        $data['title'] = $judul;
        $data['url_action'] = $url_action;
        $data['modal_subview'] = $this->load->view('admin/settings/modal_account', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);
    }

    public function save_account()
    {
        $data_simpan = array(
            'account_name' => $this->input->post('account_name'),
            'account_code' => $this->input->post('account_code'),
            'opening_balance' => '0'
        );
        $id = null;
        if(!empty($this->input->post('account_id')))
        {
            $id = $this->input->post('account_id');
        }
        $this->settings_model->init_table('tbl_account','account_id');
        $this->settings_model->_primary_key = 'account_id';
        $res = $this->settings_model->save($data_simpan,$id);
        if($res)
        {
            $arr = array(
                'success' => true
            );

        }
        else
        {
            $arr = array(
                'success' => false
            );
        }
        echo json_encode($arr);
    }

    public function add_slider($id='')
    {
        $judul = 'Tambah Slider';
        $url_action = base_url('admin/settings/save_slider');
        if(!empty($id))
        {
            $judul = 'Edit Slider';
            //$url_action = base_url('admin/settings/edit_account');
            $where = array('id' => $id);
            $data['slide'] = $this->settings_model->check_by($where, 'tbl_slider');
        }
        $data['title'] = $judul;
        $data['url_action'] = $url_action;
        $data['modal_subview'] = $this->load->view('admin/settings/add_modal_slider', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);
    }

    public function slider()
    {
        $data['title'] = 'Daftar Slider';
        $data['slider'] = db_get_all_data('tbl_slider');
        $data['subview'] = $this->load->view('admin/settings/slider_list', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }
    public function save_slider()
    {
        $id = null;
        if(!empty($this->input->post('slider_id')))
        {
            $id = $this->input->post('slider_id');
        }
        $image_upload = '';
        if (!empty($_FILES['slider_image']['name'])) {
            $old_path = $this->input->post('old_path');
            if ($old_path) { // if old path is no empty
                unlink($old_path);
            } // upload file
            $val = $this->settings_model->uploadImage('slider_image');
            // $val == true || redirect('admin/product/category');

            $image_upload = $val['path'];
        }
        else
        {
            $old_path = $this->input->post('old_path');
            $image_upload = $old_path;
        }

        $data_simpan = array(
            'slider_title' => $this->input->post('slider_title'),
            'slider_url' => $this->input->post('slider_url'),
            'slider_image' => $image_upload,
            'sub_cat' => '0',
            'slider_status' => '1'
        );

        $this->settings_model->init_table('tbl_slider','id');
        $this->settings_model->_primary_key = 'id';
        $res = $this->settings_model->save($data_simpan,$id);
        if($res)
        {
            $this->message->save_success('admin/settings/slider');
        }
        else
        {
            $this->message->custom_error_msg('admin/settings/slider','Data Gagal disimpan');
        }
    }

    public function delete_account($id=null)
    {
        $this->settings_model->init_table('tbl_account','account_id');
        $this->settings_model->_primary_key = 'account_id';
        $this->settings_model->delete($id);
        $this->message->delete_success('admin/settings/account');
    }

    public function delete_slider($id=null)
    {
        $this->settings_model->init_table('tbl_slider','id');
        $this->settings_model->_primary_key = 'id';
        $this->settings_model->delete($id);
        $this->message->delete_success('admin/settings/slider');
    }

    public function search_account()
    {
        if(!isset($_POST['searchTerm'])){
            $sql = "SELECT * FROM tbl_account ORDER BY account_name LIMIT 10";
            $row = db_get_all_data_by_query($sql);
        }else{
            $search = $_POST['searchTerm'];
            $sql = "SELECT * FROM tbl_account WHERE account_name LIKE '%".$search."%' OR account_code LIKE '%".$search."%' LIMIT 10";
            $row = db_get_all_data_by_query($sql);
        }
        $data = array();
        foreach ($row as $post)
        {
            $data[] = array("id"=>$post->account_id, "text"=>$post->account_name);
        }
        echo json_encode($data);
    }

    public function payment()
    {
        $data['title'] = 'Daftar Metode Pembayaran';
        $data['payment'] = db_get_all_data('tbl_payment_method');
        $data['subview'] = $this->load->view('admin/settings/payment_list', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function add_payment($id='')
    {
        $judul = 'Tambah Pembayaran';
        $url_action = base_url('admin/settings/save_payment');
        if(!empty($id))
        {
            $judul = 'Edit Pembayaran';
            //$url_action = base_url('admin/settings/edit_account');
            $where = array('payment_id' => $id);
            $data['bayar'] = $this->settings_model->check_by($where, 'tbl_payment_method');
        }
        $data['title'] = $judul;
        $data['url_action'] = $url_action;
        $data['modal_subview'] = $this->load->view('admin/settings/add_modal_payment', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);
    }

    public function save_payment()
    {
        $id = null;
        if(!empty($this->input->post('payment_id')))
        {
            $id = $this->input->post('payment_id');
        }
        $image_upload = '';
        if (!empty($_FILES['slider_image']['name'])) {
            $old_path = $this->input->post('old_path');
            if ($old_path) { // if old path is no empty
                unlink($old_path);
            } // upload file
            $val = $this->settings_model->uploadImage('slider_image');
            // $val == true || redirect('admin/product/category');

            $image_upload = $val['path'];
        }
        else
        {
            $old_path = $this->input->post('old_path');
            $image_upload = $old_path;
        }

        $data_simpan = array(
            'payment_name' => $this->input->post('payment_name'),
            'description' => $this->input->post('description'),
            'payment_logo' => $image_upload,
            'slider_status' => '1'
        );

        $this->settings_model->init_table('tbl_payment_method','payment_id');
        $this->settings_model->_primary_key = 'payment_id';
        $res = $this->settings_model->save($data_simpan,$id);
        if($res)
        {
            $this->message->save_success('admin/settings/payment');
        }
        else
        {
            $this->message->custom_error_msg('admin/settings/payment','Data Gagal disimpan');
        }
    }

    public function delete_payment($id=null)
    {
        $this->settings_model->init_table('tbl_payment_method','payment_id');
        $this->settings_model->_primary_key = 'payment_id';
        $this->settings_model->delete($id);
        $this->message->delete_success('admin/settings/payment');
    }

    public function popup()
    {
        $data['title'] = 'Daftar Popup';
        $sql = "SELECT b.*,p.title as title FROM tbl_page p,tbl_popup b WHERE b.page_id=p.page_id";
        $data['popup'] = db_get_all_data_by_query($sql);
        $data['subview'] = $this->load->view('admin/settings/popup_list', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function add_popup($id='')
    {
        $judul = 'Tambah Popup';
        $url_action = base_url('admin/settings/save_popup');
        if(!empty($id))
        {
            $judul = 'Edit Popup';
            //$url_action = base_url('admin/settings/edit_account');
            $where = array('popup_id' => $id);
            $data['popup'] = $this->settings_model->check_by($where, 'tbl_payment_method');
        }
        $data['page'] = db_get_all_data('tbl_page');
        $data['title'] = $judul;
        $data['url_action'] = $url_action;
        $data['modal_subview'] = $this->load->view('admin/settings/add_modal_popup', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);
    }

    public function save_popup()
    {
        $id = null;
        if(!empty($this->input->post('popup_id')))
        {
            $id = $this->input->post('popup_id');
        }
        $image_upload = '';
        if (!empty($_FILES['slider_image']['name'])) {
            $old_path = $this->input->post('old_path');
            if ($old_path) { // if old path is no empty
                unlink($old_path);
            } // upload file
            $val = $this->settings_model->uploadImage('slider_image');
            // $val == true || redirect('admin/product/category');

            $image_upload = $val['path'];
        }
        else
        {
            $old_path = $this->input->post('old_path');
            $image_upload = $old_path;
        }

        $data_simpan = array(
            'page_id' => $this->input->post('page_id'),
            'popup_url' => $this->input->post('popup_url'),
            'popup_image' => $image_upload,
            'show_once' => $this->input->post('show_once')
        );

        $this->settings_model->init_table('tbl_popup','popup_id');
        $this->settings_model->_primary_key = 'popup_id';
        $res = $this->settings_model->save($data_simpan,$id);
        if($res)
        {
            $this->message->save_success('admin/settings/popup');
        }
        else
        {
            $this->message->custom_error_msg('admin/settings/popup','Data Gagal disimpan');
        }
    }

    public function delete_popup($id=null)
    {
        $this->settings_model->init_table('tbl_popup','popup_id');
        $this->settings_model->_primary_key = 'popup_id';
        $this->settings_model->delete($id);
        $this->message->delete_success('admin/settings/popup');
    }

}