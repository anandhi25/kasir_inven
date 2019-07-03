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
        $this->tbl_outlet('id');
        $data['outlet_info'] = $this->global_model->get();

        if (!empty($id)) { //condition check
            $where = array('id' => $id);
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


}