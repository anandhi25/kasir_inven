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
        $this->load->model('order_model');
        $this->load->model('purchase_model');

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

    public function hutang()
    {
        $data['title'] = 'Pembayaran Hutang';
        $data['add_btn'] = 'Tambah Pembayaran';
        $data['subview'] = $this->load->view('admin/transaction/hutang_list', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function piutang()
    {
        $data['title'] = 'Penerimaan Piutang';
        $data['add_btn'] = 'Tambah Penerimaan';
        $data['subview'] = $this->load->view('admin/transaction/piutang_list', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function pay_tables()
    {
        $getData = array();
        $where = '';
        $limit = '';
        $orderby = '';
        $arrCol = array(
            0 => 'hutang_no',
            1 => 'hutang_date'
        );
        if(isset($_GET["search"]["value"]))
        {
            if ($where == '') {
                $where = "WHERE (hutang_no LIKE '%".$_GET["search"]["value"]."%' OR supplier_name LIKE '%".$_GET["search"]["value"]."%')";
            } else {
                $where .= " AND (hutang_no LIKE '%".$_GET["search"]["value"]."%' OR supplier_name LIKE '%".$_GET["search"]["value"]."%')";
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
            $orderby = " ORDER BY hutang_date DESC";
        }

        if(isset($_GET["length"])) {
            if ($_GET["length"] != -1) {
                $limit = " LIMIT ".$_GET['start'] . ',' . $_GET['length'];
            }
        }
        $list = $this->global_model->get_by_sql("SELECT * FROM tbl_pembayaran_hutang ".$where.' '.$orderby.' '.$limit);
        $listAll = $this->global_model->get_by_sql("SELECT * FROM tbl_pembayaran_hutang ".$where);
        $total = count($listAll);
        $i= $_GET['start'];
        foreach ($list as $post) {
            $i = $i + 1;
            $subdata = array();
            $subdata[] = $i;
            $subdata[] = $post->hutang_no;
            $subdata[] = $post->hutang_date;
            $subdata[] = $post->supplier_name;
            $subdata[] = number_format($post->total_denda);
            $subdata[] = number_format($post->grand_total);
            $subdata[] = btn_edit(base_url('admin/transaction/add_pay_debt/'.$post->hutang_id)).' '.btn_delete(base_url('admin/transaction/delete_pay/'.$post->hutang_id));
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

    public function accpt_tables()
    {
        $getData = array();
        $where = '';
        $limit = '';
        $orderby = '';
        $arrCol = array(
            0 => 'piutang_no',
            1 => 'piutang_date'
        );
        if(isset($_GET["search"]["value"]))
        {
            if ($where == '') {
                $where = "WHERE (piutang_no LIKE '%".$_GET["search"]["value"]."%' OR customer_name LIKE '%".$_GET["search"]["value"]."%')";
            } else {
                $where .= " AND (piutang_no LIKE '%".$_GET["search"]["value"]."%' OR customer_name LIKE '%".$_GET["search"]["value"]."%')";
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
            $orderby = " ORDER BY piutang_date DESC";
        }

        if(isset($_GET["length"])) {
            if ($_GET["length"] != -1) {
                $limit = " LIMIT ".$_GET['start'] . ',' . $_GET['length'];
            }
        }
        $list = $this->global_model->get_by_sql("SELECT * FROM tbl_penerimaan_piutang ".$where.' '.$orderby.' '.$limit);
        $listAll = $this->global_model->get_by_sql("SELECT * FROM tbl_penerimaan_piutang ".$where);
        $total = count($listAll);
        $i= $_GET['start'];
        foreach ($list as $post) {
            $i = $i + 1;
            $subdata = array();
            $subdata[] = $i;
            $subdata[] = $post->piutang_no;
            $subdata[] = $post->piutang_date;
            $subdata[] = $post->customer_name;
            $subdata[] = number_format($post->total_denda);
            $subdata[] = number_format($post->grand_total);
            $subdata[] = btn_edit(base_url('admin/transaction/add_accept_debt/'.$post->piutang_id)).' '.btn_delete(base_url('admin/transaction/delete_debt/'.$post->piutang_id));
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

    public function add_accept_debt($id=null)
    {
        $data['code'] = $data['code'] = rand(10000000, 99999);
        $data['action_url'] = base_url('admin/transaction/save_accpt_debt');
        $data['title'] = 'Tambah Penerimaan Piutang';  // title page
        if(!empty($id))
        {
            $data['title'] = "Edit Penerimaan Piutang";
            $data['action_url'] = base_url('admin/transaction/update_accpt_debt');
            $data['pay'] = db_get_row_data('tbl_penerimaan_piutang',array('piutang_id' => $id));
            $data['sisa_piutang'] = $this->order_model->get_total_piutang_by_customer($data['pay']->customer_id);
        }
        $data['subview'] = $this->load->view('admin/transaction/add_accept_debt', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function add_pay_debt($id=null)
    {
        $data['code'] = rand(10000000, 99999);
        $data['action_url'] = base_url('admin/transaction/save_pay_debt');
        $data['title'] = 'Tambah Pembayaran Hutang';  // title page
        if(!empty($id))
        {
            $data['title'] = "Edit Pembayaran Hutang";
            $data['action_url'] = base_url('admin/transaction/update_pay_debt');
            $data['pay'] = db_get_row_data('tbl_pembayaran_hutang',array('hutang_id' => $id));
            $data['sisa_hutang'] = $this->purchase_model->get_total_hutang_by_supplier($data['pay']->supplier_id);
        }
        $data['subview'] = $this->load->view('admin/transaction/add_pay_debt', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function modal_customer()
    {
        $data['title'] = 'Cari Customer';
        $data['modal_subview'] = $this->load->view('admin/transaction/add_customer_modal', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);
    }

    public function modal_supplier()
    {
        $data['title'] = 'Cari Supplier';
        $data['modal_subview'] = $this->load->view('admin/transaction/modal_supplier', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);
    }

    public function save_accpt_debt()
    {
        $customer_id = $this->input->post('customer_id');
        $customer_name = $this->input->post('customer_name');
        $no_pembayaran = $this->input->post('no_pembayaran');
        $tanggal = $this->input->post('tanggal');
        $jumlah_bayar = remove_commas($this->input->post('jumlah_bayar'));
        $jumlah_denda = remove_commas($this->input->post('jumlah_denda'));
        $total_bayar = remove_commas($this->input->post('total_bayar'));
        $id = null;
        $data_bayar = array(
            'customer_id' => $customer_id,
            'customer_name' => $customer_name,
            'piutang_date' => $tanggal,
            'piutang_no' => $no_pembayaran,
            'total_bayar' => $jumlah_bayar,
            'total_denda' => $jumlah_denda,
            'grand_total' => $total_bayar,
            'status_piutang' => '1',
        );
        $this->transaction_model->init_table('tbl_penerimaan_piutang','piutang_id');
        $this->transaction_model->_primary_key = 'piutang_id';
        $id_pembayaran = $this->transaction_model->save($data_bayar,$id);
        if($id_pembayaran)
        {
            if(count($this->input->post('saldo_piutang')) > 0)
            {
                $i=0;
                $pajak = $this->input->post('pajak');
                $potongan = $this->input->post('potongan');
                $bayar = $this->input->post('bayar');
                $sisa_piutang = $this->input->post('sisa_piutang');
                $order_id = $this->input->post('order_id');
                $order_no = $this->input->post('order_no');
                foreach ($this->input->post('saldo_piutang') as $saldo)
                {
                    $data_simpan = array(
                        'penerimaan_piutang_id' => $id_pembayaran,
                        'order_id' => $order_id[$i],
                        'order_no' => $order_no[$i],
                        'saldo_piutang' => remove_commas($saldo),
                        'ppn' => remove_commas($pajak[$i]),
                        'potongan' => remove_commas($potongan[$i]),
                        'bayar' => remove_commas($bayar[$i]),
                        'sisa_piutang' => remove_commas($sisa_piutang[$i]),
                    );
                    $this->transaction_model->init_table('tbl_penerimaan_piutang_order','piutang_order_id');
                    $this->transaction_model->_primary_key = 'piutang_order_id';
                    $this->transaction_model->save($data_simpan);
                    if(remove_commas($sisa_piutang[$i]) == '0')
                    {
                        $update_nota = array(
                            'order_status' => LUNAS
                        );
                        $this->transaction_model->init_table('tbl_order','order_id');
                        $this->transaction_model->_primary_key = 'order_id';
                        $this->transaction_model->save($update_nota,$order_id[$i]);
                    }
                    $i = $i + 1;
                }
            }
            $this->message->save_success('admin/transaction/add_accept_debt');
        }
        else
        {
            $this->message->custom_error_msg('admin/transaction/add_accept_debt','Data Gagal disimpan');
        }
    }

    public function update_accpt_debt()
    {
        $customer_id = $this->input->post('customer_id');
        $customer_name = $this->input->post('customer_name');
        $no_pembayaran = $this->input->post('no_pembayaran');
        $tanggal = $this->input->post('tanggal');
        $jumlah_bayar = remove_commas($this->input->post('jumlah_bayar'));
        $jumlah_denda = remove_commas($this->input->post('jumlah_denda'));
        $total_bayar = remove_commas($this->input->post('total_bayar'));
        $id = remove_commas($this->input->post('piutang_id'));
        $data_bayar = array(
            'customer_id' => $customer_id,
            'customer_name' => $customer_name,
            'piutang_date' => $tanggal,
            'total_bayar' => $jumlah_bayar,
            'total_denda' => $jumlah_denda,
            'grand_total' => $total_bayar
        );
        $this->transaction_model->init_table('tbl_penerimaan_piutang','piutang_id');
        $this->transaction_model->_primary_key = 'piutang_id';
        $id_pembayaran = $this->transaction_model->save($data_bayar,$id);
        if($id_pembayaran)
        {
            $this->order_model->delete_debt($id,'yes');
            if(count($this->input->post('saldo_piutang')) > 0)
            {
                $i=0;
                $pajak = $this->input->post('pajak');
                $potongan = $this->input->post('potongan');
                $bayar = $this->input->post('bayar');
                $sisa_piutang = $this->input->post('sisa_piutang');
                $order_id = $this->input->post('order_id');
                $order_no = $this->input->post('order_no');
                foreach ($this->input->post('saldo_piutang') as $saldo)
                {
                    $data_simpan = array(
                        'penerimaan_piutang_id' => $id_pembayaran,
                        'order_id' => $order_id[$i],
                        'order_no' => $order_no[$i],
                        'saldo_piutang' => remove_commas($saldo),
                        'ppn' => remove_commas($pajak[$i]),
                        'potongan' => remove_commas($potongan[$i]),
                        'bayar' => remove_commas($bayar[$i]),
                        'sisa_piutang' => remove_commas($sisa_piutang[$i]),
                    );
                    $this->transaction_model->init_table('tbl_penerimaan_piutang_order','piutang_order_id');
                    $this->transaction_model->_primary_key = 'piutang_order_id';
                    $this->transaction_model->save($data_simpan);
                    if(remove_commas($sisa_piutang[$i]) == '0')
                    {
                        $update_nota = array(
                            'order_status' => LUNAS
                        );
                        $this->transaction_model->init_table('tbl_order','order_id');
                        $this->transaction_model->_primary_key = 'order_id';
                        $this->transaction_model->save($update_nota,$order_id[$i]);
                    }
                    $i = $i + 1;
                }
            }
            $this->message->save_success('admin/transaction/add_accept_debt/'.$id);
        }
        else
        {
            $this->message->custom_error_msg('admin/transaction/add_accept_debt/'.$id,'Data Gagal disimpan');
        }
    }

    public function save_pay_debt()
    {
        $supplier_id = $this->input->post('supplier_id');
        $supplier_name = $this->input->post('supplier_name');
        $no_pembayaran = $this->input->post('no_pembayaran');
        $tanggal = $this->input->post('tanggal');
        $jumlah_bayar = remove_commas($this->input->post('jumlah_bayar'));
        $jumlah_denda = remove_commas($this->input->post('jumlah_denda'));
        $total_bayar = remove_commas($this->input->post('total_bayar'));
        $id = null;

        $data_bayar = array(
            'supplier_id' => $supplier_id,
            'supplier_name' => $supplier_name,
            'hutang_date' => $tanggal,
            'hutang_no' => $no_pembayaran,
            'total_bayar' => $jumlah_bayar,
            'total_denda' => $jumlah_denda,
            'grand_total' => $total_bayar,
            'status_hutang' => '1',
        );
        $this->transaction_model->init_table('tbl_pembayaran_hutang','hutang_id');
        $this->transaction_model->_primary_key = 'hutang_id';
        $id_pembayaran = $this->transaction_model->save($data_bayar,$id);
        if($id_pembayaran)
        {
            if(count($this->input->post('saldo_hutang')) > 0)
            {
                $i=0;
                $pajak = $this->input->post('pajak');
                $potongan = $this->input->post('potongan');
                $bayar = $this->input->post('bayar');
                $sisa_hutang = $this->input->post('sisa_hutang');
                $purchase_id = $this->input->post('purchase_id');
                $order_no = $this->input->post('order_no');
                foreach ($this->input->post('saldo_hutang') as $saldo)
                {
                    $data_simpan = array(
                        'pembayaran_hutang_id' => $id_pembayaran,
                        'purchase_id' => $purchase_id[$i],
                        'purchase_no' => $order_no[$i],
                        'saldo_hutang' => remove_commas($saldo),
                        'ppn' => remove_commas($pajak[$i]),
                        'potongan' => remove_commas($potongan[$i]),
                        'bayar' => remove_commas($bayar[$i]),
                        'sisa_hutang' => remove_commas($sisa_hutang[$i]),
                    );
                    $this->transaction_model->init_table('tbl_pembayaran_hutang_purchase','hutang_purchase_id');
                    $this->transaction_model->_primary_key = 'hutang_purchase_id';
                    $this->transaction_model->save($data_simpan);
                    if(remove_commas($sisa_hutang[$i]) == '0')
                    {
                        $update_nota = array(
                            'status_purchase' => LUNAS
                        );
                        $this->transaction_model->init_table('tbl_purchase','purchase_id');
                        $this->transaction_model->_primary_key = 'purchase_id';
                        $this->transaction_model->save($update_nota,$purchase_id[$i]);
                    }
                    $i = $i + 1;
                }
            }
            $this->message->save_success('admin/transaction/add_pay_debt');
        }
        else
        {
            $this->message->custom_error_msg('admin/transaction/add_pay_debt','Data Gagal disimpan');
        }
    }

    public function update_pay_debt()
    {
        $supplier_id = $this->input->post('supplier_id');
        $supplier_name = $this->input->post('supplier_name');
        $no_pembayaran = $this->input->post('no_pembayaran');
        $tanggal = $this->input->post('tanggal');
        $jumlah_bayar = remove_commas($this->input->post('jumlah_bayar'));
        $jumlah_denda = remove_commas($this->input->post('jumlah_denda'));
        $total_bayar = remove_commas($this->input->post('total_bayar'));
        $id = $this->input->post('hutang_id');

        $data_bayar = array(
            'supplier_id' => $supplier_id,
            'supplier_name' => $supplier_name,
            'hutang_date' => $tanggal,
            'total_bayar' => $jumlah_bayar,
            'total_denda' => $jumlah_denda,
            'grand_total' => $total_bayar,
        );
        $this->transaction_model->init_table('tbl_pembayaran_hutang','hutang_id');
        $this->transaction_model->_primary_key = 'hutang_id';
        $id_pembayaran = $this->transaction_model->save($data_bayar,$id);
        if($id_pembayaran)
        {
            $this->purchase_model->delete_pay($id,'yes');
            if(count($this->input->post('saldo_hutang')) > 0)
            {
                $i=0;
                $pajak = $this->input->post('pajak');
                $potongan = $this->input->post('potongan');
                $bayar = $this->input->post('bayar');
                $sisa_hutang = $this->input->post('sisa_hutang');
                $purchase_id = $this->input->post('purchase_id');
                $order_no = $this->input->post('order_no');
                foreach ($this->input->post('saldo_hutang') as $saldo)
                {
                    $data_simpan = array(
                        'pembayaran_hutang_id' => $id,
                        'purchase_id' => $purchase_id[$i],
                        'purchase_no' => $order_no[$i],
                        'saldo_hutang' => remove_commas($saldo),
                        'ppn' => remove_commas($pajak[$i]),
                        'potongan' => remove_commas($potongan[$i]),
                        'bayar' => remove_commas($bayar[$i]),
                        'sisa_hutang' => remove_commas($sisa_hutang[$i]),
                    );
                    $this->transaction_model->init_table('tbl_pembayaran_hutang_purchase','hutang_purchase_id');
                    $this->transaction_model->_primary_key = 'hutang_purchase_id';
                    $this->transaction_model->save($data_simpan);
                    if(remove_commas($sisa_hutang[$i]) == '0')
                    {
                        $update_nota = array(
                            'status_purchase' => LUNAS
                        );
                        $this->transaction_model->init_table('tbl_purchase','purchase_id');
                        $this->transaction_model->_primary_key = 'purchase_id';
                        $this->transaction_model->save($update_nota,$purchase_id[$i]);
                    }
                    $i = $i + 1;
                }
            }
            $this->message->save_success('admin/transaction/add_pay_debt/'.$id);
        }
        else
        {
            $this->message->custom_error_msg('admin/transaction/add_pay_debt/'.$id,'Data Gagal disimpan');
        }
    }

    public function delete_debt($id=null)
    {
        $delete = $this->order_model->delete_debt($id);
        if($delete)
        {
            $this->message->delete_success('admin/transaction/piutang');
        }
        else{
            $this->message->custom_error_msg('admin/transaction/piutang', "Data gagal dihapus");
        }
    }

    public function delete_pay($id=null)
    {
        $delete = $this->purchase_model->delete_pay($id);
        if($delete)
        {
            $this->message->delete_success('admin/transaction/hutang');
        }
        else{
            $this->message->custom_error_msg('admin/transaction/hutang', "Data gagal dihapus");
        }
    }
}


?>