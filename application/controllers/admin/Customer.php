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
        $data['modal_subview'] = $this->load->view('admin/customer/modal', $data, false);
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

    public function province()
    {
        $data['title'] = 'Daftar Provinsi';
        $data['state'] = db_get_all_data('tbl_state');
        $data['subview'] = $this->load->view('admin/customer/province_list', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function add_province($id='')
    {
        $judul = 'Tambah Propinsi';
        $url_action = base_url('admin/customer/save_province');
        if(!empty($id))
        {
            $judul = 'Edit Propinsi';
            //$url_action = base_url('admin/settings/edit_account');
            $where = array('state_id' => $id);
            $data['state'] = $this->customer_model->check_by($where, 'tbl_state');
        }
        $data['title'] = $judul;
        $data['url_action'] = $url_action;
        $data['modal_subview'] = $this->load->view('admin/customer/add_modal_province', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);
    }

    public function save_province()
    {
        $id = null;
        if(!empty($this->input->post('state_id')))
        {
            $id = $this->input->post('state_id');
        }

        $data_simpan = array(
            'state_name' => $this->input->post('state_name'),
            'description' => $this->input->post('description'),
            'state_status' => '1'
        );

        $this->customer_model->init_table('tbl_state','state_id');
        $this->customer_model->_primary_key = 'state_id';
        $res = $this->customer_model->save($data_simpan,$id);
        if($res)
        {
            $this->message->save_success('admin/customer/province');
        }
        else
        {
            $this->message->custom_error_msg('admin/customer/province','Data Gagal disimpan');
        }
    }

    public function add_city($id='')
    {
        $judul = 'Tambah Kota';
        $url_action = base_url('admin/customer/save_city');
        if(!empty($id))
        {
            $judul = 'Edit Kota';
            //$url_action = base_url('admin/settings/edit_account');
            $where = array('city_id' => $id);
            $data['city'] = $this->customer_model->check_by($where, 'tbl_city');
        }
        $data['title'] = $judul;
        $data['url_action'] = $url_action;
        $data['state'] = db_get_all_data('tbl_state');
        $data['modal_subview'] = $this->load->view('admin/customer/add_modal_city', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);
    }

    public function save_city()
    {
        $id = null;
        if(!empty($this->input->post('city_id')))
        {
            $id = $this->input->post('city_id');
        }

        $data_simpan = array(
            'city_name' => $this->input->post('city_name'),
            'state_id' => $this->input->post('state_id'),
            'city_status' => '1'
        );

        $this->customer_model->init_table('tbl_city','city_id');
        $this->customer_model->_primary_key = 'city_id';
        $res = $this->customer_model->save($data_simpan,$id);
        if($res)
        {
            $this->message->save_success('admin/customer/city');
        }
        else
        {
            $this->message->custom_error_msg('admin/customer/city','Data Gagal disimpan');
        }
    }

    public function save_district()
    {
        $id = null;
        if(!empty($this->input->post('district_id')))
        {
            $id = $this->input->post('district_id');
        }

        $data_simpan = array(
            'district_name' => $this->input->post('district_name'),
            'city_id' => $this->input->post('city_id'),
            'fee' => remove_commas($this->input->post('fee')),
            'district_status' => '1'
        );

        $this->customer_model->init_table('tbl_district','district_id');
        $this->customer_model->_primary_key = 'district_id';
        $res = $this->customer_model->save($data_simpan,$id);
        if($res)
        {
            $this->message->save_success('admin/customer/district');
        }
        else
        {
            $this->message->custom_error_msg('admin/customer/district','Data Gagal disimpan');
        }
    }

    public function delete_province($id=null)
    {
        $this->customer_model->init_table('tbl_state','state_id');
        $this->customer_model->_primary_key = 'state_id';
        $this->customer_model->delete($id);
        $this->message->delete_success('admin/customer/province');
    }

    public function delete_city($id=null)
    {
        $this->customer_model->init_table('tbl_city','city_id');
        $this->customer_model->_primary_key = 'city_id';
        $this->customer_model->delete($id);
        $this->message->delete_success('admin/customer/city');
    }

    public function delete_district($id=null)
    {
        $this->customer_model->init_table('tbl_district','district_id');
        $this->customer_model->_primary_key = 'district_id';
        $this->customer_model->delete($id);
        $this->message->delete_success('admin/customer/district');
    }

    public function city()
    {
        $data['title'] = 'Daftar Kota';
        $data['subview'] = $this->load->view('admin/customer/city_list', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function district()
    {
        $data['title'] = 'Daftar Kecamatan';
        $data['subview'] = $this->load->view('admin/customer/district_list', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function add_district($id='')
    {
        $judul = 'Tambah Kecamatan';
        $url_action = base_url('admin/customer/save_district');
        if(!empty($id))
        {
            $judul = 'Edit Kecamatan';
            //$url_action = base_url('admin/settings/edit_account');
            $where = array('district_id' => $id);
            $data['kecamatan'] = $this->customer_model->check_by($where, 'tbl_district');
            $kota = db_get_all_data('tbl_city',array('city_id' => $data['kecamatan']->city_id));
            $opt_kota = '<option value="0">Pilih Kota</option>';
            if(count($kota) > 0)
            {
                $opt_kota = '<option value="'.$kota[0]->city_id.'">'.$kota[0]->city_name.'</option>';
            }
            $data['city'] = $opt_kota;
        }
        $data['title'] = $judul;
        $data['url_action'] = $url_action;
       // $data['city'] = db_get_all_data('tbl_city');
        $data['modal_subview'] = $this->load->view('admin/customer/add_modal_district', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);
    }

    public function district_tables()
    {
        $getData = array();
        $where = 'WHERE c.state_id = p.state_id AND d.city_id = c.city_id';
        $limit = '';
        $orderby = '';
        $arrCol = array(
            0 => 'd.district_name',
            1 => 'c.city_name'
        );
        if(!empty($_GET["search"]["value"]))
        {
            if ($where == '') {
                $where = "WHERE d.district_name LIKE '%".$_GET["search"]["value"]."%' OR c.city_name LIKE '%".$_GET["search"]["value"]."%' OR p.state_name LIKE '%".$_GET["search"]["value"]."%'";
            } else {
                $where .= " AND d.district_name LIKE '%".$_GET["search"]["value"]."%' OR c.city_name LIKE '%".$_GET["search"]["value"]."%' OR p.state_name LIKE '%".$_GET["search"]["value"]."%'";
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
            $orderby = " ORDER BY c.district_name ASC";
        }

        if(isset($_GET["length"])) {
            if ($_GET["length"] != -1) {
                $limit = " LIMIT ".$_GET['start'] . ',' . $_GET['length'];
            }
        }
        $list = $this->global_model->get_by_sql("SELECT d.district_id as district_id,d.district_name as district_name,d.fee as fee,d.district_status as district_status,c.city_id as city_id,p.state_name as state_name,c.city_name as city_name,c.city_status as city_status FROM tbl_district d,tbl_city c,tbl_state p ".$where.' '.$orderby.' '.$limit);
        $listAll = $this->global_model->get_by_sql("SELECT d.district_id as district_id,d.district_name as district_name,d.fee as fee,d.district_status as district_status,c.city_id as city_id,p.state_name as state_name,c.city_name as city_name,c.city_status as city_status FROM tbl_district d, tbl_city c,tbl_state p ".$where);
        $total = count($listAll);
        foreach ($list as $post) {
            $subdata = array();
            $subdata[] = $post->district_name;
            $subdata[] = $post->city_name;
            $subdata[] = $post->state_name;
            $subdata[] = number_format($post->fee);
            $stat = 'Tidak Aktif';
            if($post->district_status == '1')
            {
                $stat = "Aktif";
            }
            $subdata[] = $stat;
            $subdata[] = btn_edit_modal(base_url('admin/customer/add_district/'.$post->district_id)).' '.btn_delete(base_url('admin/customer/delete_district/'.$post->district_id));
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

    public function city_table()
    {
        $getData = array();
        $where = 'WHERE c.state_id = p.state_id';
        $limit = '';
        $orderby = '';
        $arrCol = array(
            0 => 'c.city_name',
            1 => 'p.state_name'
        );
        if(!empty($_GET["search"]["value"]))
        {
            if ($where == '') {
                $where = "WHERE c.city_name LIKE '%".$_GET["search"]["value"]."%' OR p.state_name LIKE '%".$_GET["search"]["value"]."%'";
            } else {
                $where .= " AND c.city_name LIKE '%".$_GET["search"]["value"]."%' OR p.state_name LIKE '%".$_GET["search"]["value"]."%'";
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
            $orderby = " ORDER BY c.city_name ASC";
        }

        if(isset($_GET["length"])) {
            if ($_GET["length"] != -1) {
                $limit = " LIMIT ".$_GET['start'] . ',' . $_GET['length'];
            }
        }
        $list = $this->global_model->get_by_sql("SELECT c.city_id as city_id,p.state_name as state_name,c.city_name as city_name,c.city_status as city_status FROM tbl_city c,tbl_state p ".$where.' '.$orderby.' '.$limit);
        $listAll = $this->global_model->get_by_sql("SELECT c.city_id as city_id,p.state_name as state_name,c.city_name as city_name,c.city_status as city_status FROM tbl_city c,tbl_state p ".$where);
        $total = count($listAll);
        foreach ($list as $post) {
            $subdata = array();
            $subdata[] = $post->city_name;
            $subdata[] = $post->state_name;
            $stat = 'Tidak Aktif';
            if($post->city_status == '1')
            {
                $stat = "Aktif";
            }
            $subdata[] = $stat;
            $subdata[] = btn_edit_modal(base_url('admin/customer/add_city/'.$post->city_id)).' '.btn_delete(base_url('admin/customer/delete_city/'.$post->city_id));
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

    public function search_city()
    {
        if(!isset($_POST['searchTerm'])){
            $sql = "SELECT c.city_id as city_id,c.city_name as city_name,c.city_status as city_status,s.state_id as state_id,s.state_name as state_name FROM tbl_state s,tbl_city c WHERE s.state_id = c.state_id  ORDER BY c.city_name LIMIT 10";
            $row = db_get_all_data_by_query($sql);
        }else{
            $search = $_POST['searchTerm'];
            $sql = "SELECT c.city_id as city_id,c.city_name as city_name,c.city_status as city_status,s.state_id as state_id,s.state_name as state_name FROM tbl_state s,tbl_city c WHERE s.state_id = c.state_id AND c.city_name LIKE '%".$search."%' LIMIT 10";
            $row = db_get_all_data_by_query($sql);
        }
        $data = array();
        foreach ($row as $post)
        {
            $data[] = array("id"=>$post->city_id, "text"=>$post->city_name.' ( '.$post->state_name.' )');
        }
        echo json_encode($data);
    }
}
