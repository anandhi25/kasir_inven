<?php

class Account extends FrontController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->model('order_model');
        $this->load->model('global_model');
        $this->load->model('customer_model');
        $this->load->helper('text');
        $this->load->library('message');

    }

    public function signin()
    {
        $data['title'] = 'Login';
        $data['content'] = 'login';
        $this->render($data);
    }

    public function signup()
    {
        $data['title'] = 'Login';
        $data['content'] = 'signup';
        $this->render($data);
    }

    public function do_login()
    {
        $email_cust = $this->input->post('email');
        $password = $this->input->post('password');
        $check_login = db_get_all_data('tbl_customer',array('email' => $email_cust,'customer_password' => md5($password)));
        if(count($check_login) > 0)
        {
            $data = array(
                'customer_name' => $check_login[0]->customer_name,
                'customer_id' => $check_login[0]->customer_id,
                'customer_login' => true
            );
            $this->session->set_userdata($data);
            if(!empty($this->session->userdata('from_url')))
            {
                redirect($this->session->userdata('from_url'));
            }
            else
            {
                redirect(base_url('account/my'));
            }
        }
        else
        {
            $this->message->custom_error_msg(base_url('account/signin'),'email atau password salah');
        }

    }

    public function cek_available()
    {
        $email_cust = $this->input->post('email');
        $cek = db_get_all_data('tbl_customer',array('email' => $email_cust));
        if(count($cek) > 0)
        {
            echo 'ada';
        }
        else
        {
            echo 'kosong';
        }
    }

    public function user_signup()
    {
        $customer_name = $this->input->post('customer_name');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $password = md5($this->input->post('password'));
        $customer_code = rand(10000000, 99999);
        $data = array(
            'customer_code' => $customer_code,
            'customer_name' => $customer_name,
            'email' => $email,
            'phone' => $phone,
            'address' => '',
            'discount' => '0',
            'customer_password' => $password
        );
        $this->customer_model->init_table('tbl_customer','customer_id');
        $res = $this->customer_model->save($data);
        if($res)
        {
            if(!empty($this->session->userdata('from_url')))
            {
                redirect($this->session->userdata('from_url'));
            }
            else
            {
                redirect(base_url('account/my'));
            }
        }
        else
        {
            $this->message->custom_error_msg(base_url('account/signup'),'data gagal disimpan, coba periksa data anda');
        }

    }

    public function show_city()
    {
        $state_id = $this->input->post('state_id');
        $get_cities = db_get_all_data('tbl_city',array('state_id' => $state_id));
        if(count($get_cities) > 0)
        {
            $str = '';
            foreach ($get_cities as $ci)
            {
                $str .= '<option value="'.$ci->city_id.'">'.$ci->city_name.'</option>';
            }
            echo $str;
        }
        else
        {
            echo '';
        }
    }

    public function show_district()
    {
        $city_id = $this->input->post('city_id');
        $get_district = db_get_all_data('tbl_district',array('city_id' => $city_id));
        if(count($get_district) > 0)
        {
            $str = '';
            foreach ($get_district as $ci)
            {
                $str .= '<option value="'.$ci->district_id.'">'.$ci->district_name.'</option>';
            }
            echo $str;
        }
        else
        {
            echo '';
        }
    }

    public function save_temp_address()
    {
        $phone = $this->input->post('phone');
        $nama_penerima = $this->input->post('nama_penerima');
        $state = $this->input->post('state');
        $city = $this->input->post('city');
        $district = $this->input->post('district');
        $zip_code = $this->input->post('zip_code');
        $address = $this->input->post('address');

        $data_temp = array(
            'customer_phone' => $phone,
            'customer_state' => $state,
            'customer_accept' => $nama_penerima,
            'customer_city' => $city,
            'customer_district' => $district,
            'customer_zip' => $zip_code,
            'customer_address' => $address,
        );
        $this->session->set_userdata($data_temp);
        $arr = array(
            'success' => true
        );
        echo json_encode($arr);
    }

    public function save_temp_payment()
    {
        $payment_id = $this->input->post('metode_bayar');
        $this->session->set_userdata('cart_payment',$payment_id);
        $arr = array(
            'success' => true
        );
        echo json_encode($arr);
    }

    public function my($page='profile')
    {
        $data['title'] = 'My Account';
        $data['content'] = 'my_account';
        $data['page'] = $page;
        $data['state'] = db_get_all_data('tbl_state');
        $data_customer = db_get_row_data('tbl_customer',array('customer_id' => $this->session->userdata('customer_id')));
        $meta_customer = db_get_row_data('tbl_customer_meta',array('customer_id' => $this->session->userdata('customer_id')));
        $data['customer'] = $data_customer;
        $data['customer_meta'] = $meta_customer;
        $this->render($data);
    }

    public function detail_order($order_no='')
    {
        $data_order = db_get_row_data('tbl_order',array('order_no' => $order_no));
        $order_product = db_get_all_data('tbl_order_details',array('order_id' => $data_order->order_id));
        $data['title'] = 'Detail Order #'.$order_no;
        $data['content'] = 'my_account';
        $data['page'] = 'detail_order';
        $data['order'] = $data_order;
        $data['detail_order'] = $order_product;
        $data_customer = db_get_row_data('tbl_customer',array('customer_id' => $this->session->userdata('customer_id')));
        $data['customer'] = $data_customer;
        $this->render($data);
    }

    public function order_tables()
    {
        $customer_id = $this->input->get('customer_id');
        $getData = array();
        $where = "WHERE customer_id = '$customer_id' ";
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
            $str = btn_view_order('account/detail_order/' . $v_order->order_no);
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

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url());
    }

    public function update_profile()
    {
        $customer_name = $this->input->post('customer_name');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
        $passwd = $this->input->post('passwd');
        $confirm = $this->input->post('confirmpasswd');

        if(empty($passwd))
        {
            $data_cust = array(
                'customer_name' => $customer_name,
                'email' => $email,
                'phone' => $phone
            );
            $this->customer_model->init_table('tbl_customer','customer_id');
            $save_model = $this->customer_model->save($data_cust,$this->session->userdata('customer_id'));
            if($save_model)
            {
                $this->message->save_success(base_url('account/my'));
            }
            else
            {
                $this->message->custom_error_msg(base_url('account/my'),"Data gagal disimpan");
            }
        }
        else
        {
            if($passwd == $confirm)
            {
                $data_cust = array(
                    'customer_name' => $customer_name,
                    'email' => $email,
                    'phone' => $phone,
                    'customer_password' => md5($passwd)
                );
                $this->customer_model->init_table('tbl_customer','customer_id');
                $save_model = $this->customer_model->save($data_cust,$this->session->userdata('customer_id'));
                if($save_model)
                {
                    $this->message->save_success(base_url('account/my'));
                }
                else
                {
                    $this->message->custom_error_msg(base_url('account/my'),"Data gagal disimpan");
                }
            }
            else
            {
                $this->message->custom_error_msg(base_url('account/my'),"password dan konfirmasi password tidak sama");
            }
        }
    }

    public function update_address()
    {
        $state = $this->input->post('state');
        $city = $this->input->post('city');
        $district = $this->input->post('district');
        $zip_code = $this->input->post('zip_code');
        $address = $this->input->post('address');

        $check = db_get_all_data('tbl_customer_meta',array('customer_id' => $this->session->userdata('customer_id')));
        if(count($check) > 0)
        {
            $data_update = array(
                'city_id' => $city,
                'district_id' => $district,
                'state_id' => $state,
                'address' => $address,
                'zip_code' => $zip_code,
            );
            $this->db->set($data_update);
            $this->db->where('customer_id', $this->session->userdata('customer_id'));
            $save_model = $this->db->update('tbl_customer_meta');
            if($save_model)
            {
                $this->message->save_success(base_url('account/my/address'));
            }
            else
            {
                $this->message->custom_error_msg(base_url('account/my/address'),"Data gagal disimpan");
            }
        }
        else
        {
            $data_update = array(
                'customer_id' => $this->session->userdata('customer_id'),
                'city_id' => $city,
                'district_id' => $district,
                'state_id' => $state,
                'address' => $address,
                'customer_name' => '',
                'zip_code' => $zip_code,
                'tipe' => 'billing',
                'phone' => '',
            );
            $this->customer_model->init_table('tbl_customer_meta','id');
            $save_model = $this->customer_model->save($data_update);
            if($save_model)
            {
                $this->message->save_success(base_url('account/my/address'));
            }
            else
            {
                $this->message->custom_error_msg(base_url('account/my/address'),"Data gagal disimpan");
            }
        }


    }


}


?>