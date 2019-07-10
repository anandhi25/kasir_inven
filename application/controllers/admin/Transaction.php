<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Transaction extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaction_model');
        $this->load->model('settings_model');

    }

    public function category()
    {
        $data['title'] = 'Transaction Category';
        $data['subview'] = $this->load->view('admin/transaction/category_list', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function add_category($id='')
    {
        $judul = 'Tambah Category';
        $url_action = base_url('admin/transaction/save_category');
        if(!empty($id))
        {
            $judul = 'Edit Category';
            //$url_action = base_url('admin/settings/edit_account');
            $where = array('category_id' => $id);
            $data['category'] = $this->transaction_model->check_by($where, 'tbl_trans_category');
        }
        $data['title'] = $judul;
        $data['url_action'] = $url_action;
        $data['modal_subview'] = $this->load->view('admin/transaction/add_category_modal', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);
    }

    public function save_category()
    {
        $data_simpan = array(
            'trans_name' => $this->input->post('category_name'),
            'description' => $this->input->post('description'),
            'trans_type' => $this->input->post('trans_type'),
        );
        $id = null;
        if(!empty($this->input->post('category_id')))
        {
            $id = $this->input->post('category_id');
        }
        $this->transaction_model->init_table('tbl_trans_category','category_id');
        $this->transaction_model->_primary_key = 'category_id';
        $res = $this->transaction_model->save($data_simpan,$id);
        if($res)
        {
            $arr = array(
                'success' => true
            );
            $type = 'success';
            $message = 'Your record has been saved successfully!';
            set_message($type, $message);
        }
        else
        {
            $arr = array(
                'success' => false
            );
        }
        echo json_encode($arr);
    }

    public function delete_category($id=null)
    {
        $this->transaction_model->init_table('tbl_trans_category','category_id');
        $this->transaction_model->_primary_key = 'category_id';
        $this->transaction_model->delete($id);
        $this->message->delete_success('admin/transaction/category');
    }

    public function income()
    {
        $data['title'] = 'Transaksi Pendapatan';
        $data['add_btn'] = 'Tambah Pendapatan';
        $data['type'] = 'pendapatan';
        $data['subview'] = $this->load->view('admin/transaction/income_list', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function outcome()
    {
        $data['title'] = 'Transaksi Biaya';
        $data['add_btn'] = 'Tambah Biaya';
        $data['type'] = 'pengeluaran';
        $data['subview'] = $this->load->view('admin/transaction/income_list', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function add_transaction($type,$id=null)
    {
        $judul = 'Tambah Transaksi';
        $url_action = base_url('admin/transaction/save_transaksi');
        if(!empty($id))
        {
            $judul = 'Edit Transaksi';
            //$url_action = base_url('admin/settings/edit_account');
            $where = array('trans_id' => $id);
            $data['transaction'] = $this->transaction_model->check_by($where, 'tbl_transaction');
            $data['account'] = db_get_row_data('tbl_account',array('account_id' => $data['transaction']->account_id));
            $data['category'] = db_get_row_data('tbl_trans_category',array('category_id' => $data['transaction']->category_id));
        }
        $data['type'] = $type;
        $data['no_trans'] =  rand(10000000, 99999);
        $data['title'] = $judul;
        $data['url_action'] = $url_action;
        $data['modal_subview'] = $this->load->view('admin/transaction/add_transaction_modal', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);
    }

    public function save_transaksi()
    {
        $id = null;
        if(!empty($this->input->post('trans_id')))
        {
            $id = $this->input->post('trans_id');
        }
        $image_upload = '';
        if (!empty($_FILES['attach_image']['name'])) {
            $old_path = $this->input->post('old_path');
            if ($old_path) { // if old path is no empty
                unlink($old_path);
            } // upload file
            $val = $this->transaction_model->uploadImage('attach_image');
            // $val == true || redirect('admin/product/category');

            $image_upload = $val['path'];
        }
        else
        {
            $old_path = $this->input->post('old_path');
            $image_upload = $old_path;
        }

        $data_simpan = array(
            'trans_name' => $this->input->post('trans_name'),
            'trans_date' => $this->input->post('trans_date'),
            'nominal' => remove_commas($this->input->post('nominal')),
            'account_id' => $this->input->post('account_id'),
            'category_id' => $this->input->post('category_id'),
            'note' => $this->input->post('note'),
            'attach_image' => $image_upload,
            'trans_created_by' => $this->session->userdata('employee_id'),
            'trans_edit_by' => $this->session->userdata('employee_id'),
            'trans_type' => $this->input->post('type_trans'),
            'trans_edit_at' => date('Y-m-d H:i:s'),
        );
        $this->transaction_model->init_table('tbl_transaction','trans_id');
        $this->transaction_model->_primary_key = 'trans_id';
        $res = $this->transaction_model->save($data_simpan,$id);
        if($res)
        {
            //$message = 'Your record has been saved successfully!';
            if($this->input->post('type_trans') == 'pendapatan')
            {
                $this->message->save_success('admin/transaction/income');
            }
            else
            {
                $this->message->save_success('admin/transaction/outcome');
            }

        }
        else
        {
            if($this->input->post('type_trans') == 'pendapatan')
            {
                $this->message->custom_error_msg('admin/transaction/income','Data Gagal disimpan');
            }
            else
            {
                $this->message->custom_error_msg('admin/transaction/outcome','Data Gagal disimpan');
            }

        }

    }

    public function delete_transaction($id=null,$type)
    {
        $tipe = 'income';
        if($type == 'pengeluaran')
        {
            $tipe = 'outcome';
        }
        $this->transaction_model->init_table('tbl_transaction','trans_id');
        $this->transaction_model->_primary_key = 'trans_id';
        $this->transaction_model->delete($id);
        $this->message->delete_success('admin/transaction/'.$tipe);
    }

    public function transaction_tables($type)
    {
        $getData = array();
        $where = "WHERE trans_type ='$type'";
        $limit = '';
        $orderby = '';
        $arrCol = array(
            0 => 'trans_name',
            1 => 'trans_date'
        );
        if(isset($_GET["search"]["value"]))
        {
            if ($where == '') {
                $where = "WHERE trans_name LIKE '%".$_GET["search"]["value"]."%'";
            } else {
                $where .= " AND trans_name LIKE '%".$_GET["search"]["value"]."%'";
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
            $orderby = " ORDER BY trans_name ASC";
        }

        if(isset($_GET["length"])) {
            if ($_GET["length"] != -1) {
                $limit = " LIMIT ".$_GET['start'] . ',' . $_GET['length'];
            }
        }
        $list = $this->global_model->get_by_sql("SELECT * FROM tbl_transaction ".$where.' '.$orderby.' '.$limit);
        $listAll = $this->global_model->get_by_sql("SELECT * FROM tbl_transaction ".$where);
        $total = count($listAll);
        foreach ($list as $post) {
            $subdata = array();
            $q_account = db_get_row_data('tbl_account',array('account_id' => $post->account_id));
            $q_category = db_get_row_data('tbl_trans_category',array('category_id' => $post->category_id));
            $subdata[] = $post->trans_name;
            $subdata[] = $post->trans_date;
            $subdata[] = number_format($post->nominal);
            $subdata[] = $q_account->account_name;
            $subdata[] = $q_category->trans_name;
            $subdata[] = btn_edit_modal(base_url('admin/transaction/add_transaction/pendapatan/'.$post->trans_id)).' '.btn_delete(base_url('admin/transaction/delete_transaction/'.$post->trans_id.'/'.$type));
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

    public function category_table()
    {
        $getData = array();
        $where = '';
        $limit = '';
        $orderby = '';
        $arrCol = array(
            0 => 'trans_name'
        );
        if(isset($_GET["search"]["value"]))
        {
            if ($where == '') {
                $where = "WHERE trans_name LIKE '%".$_GET["search"]["value"]."%'";
            } else {
                $where .= " AND trans_name LIKE '%".$_GET["search"]["value"]."%'";
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
            $orderby = " ORDER BY trans_name ASC";
        }

        if(isset($_GET["length"])) {
            if ($_GET["length"] != -1) {
                $limit = " LIMIT ".$_GET['start'] . ',' . $_GET['length'];
            }
        }
        $list = $this->global_model->get_by_sql("SELECT * FROM tbl_trans_category ".$where.' '.$orderby.' '.$limit);
        $listAll = $this->global_model->get_by_sql("SELECT * FROM tbl_trans_category ".$where);
        $total = count($listAll);
        foreach ($list as $post) {
            $subdata = array();
            $subdata[] = $post->trans_name;
            $subdata[] = $post->description;
            $subdata[] = strtoupper($post->trans_type);
            $subdata[] = btn_edit_modal(base_url('admin/transaction/add_category/'.$post->category_id)).' '.btn_delete(base_url('admin/transaction/delete_category/'.$post->category_id));
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

    public function search_category($type)
    {
        if(!isset($_POST['searchTerm'])){
            $sql = "SELECT * FROM tbl_trans_category WHERE trans_type = '$type' ORDER BY trans_name LIMIT 10";
            $row = db_get_all_data_by_query($sql);
        }else{
            $search = $_POST['searchTerm'];
            $sql = "SELECT * FROM tbl_trans_category WHERE trans_name LIKE '%".$search."%' AND trans_type = '$type' LIMIT 10";
            $row = db_get_all_data_by_query($sql);
        }
        $data = array();
        foreach ($row as $post)
        {
            $data[] = array("id"=>$post->category_id, "text"=>$post->trans_name);
        }
        echo json_encode($data);
    }
}


?>