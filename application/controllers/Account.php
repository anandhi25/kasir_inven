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

}


?>