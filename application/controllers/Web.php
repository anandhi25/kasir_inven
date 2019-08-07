<?php
/**
 * Created by PhpStorm.
 * User: anandhi
 * Date: 7/17/19
 * Time: 10:36 PM
 */

class Web extends FrontController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->model('order_model');
        $this->load->model('global_model');
        $this->load->model('purchase_model');
        $this->load->helper('text');

    }

    public function index()
    {
        $data['title'] = get_profile()->company_name;
        $data['content'] = 'home';
        $data['product'] = $this->product_model->get_all_product('yes');
        $data['latest'] = $this->product_model->get_home_product('latest',8);
       // print_r($this->load->view('admin/customer/modal', $data, false));
        $this->render($data);
    }

    public function p($product_id,$seo_title='')
    {
        $this->product_model->update_viewed($product_id);
        $product = $this->product_model->get_product_information_by_id($product_id);
        $data['title'] = $product->product_name;
        $data['product_gallery_img'] = db_get_all_data('tbl_product_image',array('product_id' => $product_id));
        $data['content'] = 'product';
        $data['product'] = $product;
        $this->render($data);
    }

    public function checkout()
    {
        if(!is_login())
        {
            $this->session->set_userdata('from_url', base_url('checkout'));
            redirect(base_url('account/signin'));
        }
        else
        {
            if(!empty($this->session->userdata('from_url')))
            {
                $this->session->unset_userdata('from_url');
            }
            if(count($this->cart->contents()) == 0)
            {
                redirect(base_url('cart'));
            }
            $data_customer = db_get_row_data('tbl_customer',array('customer_id' => $this->session->userdata('customer_id')));
            $data['customer'] = $data_customer;
            $data['title'] = 'Checkout';
            $data['content'] = 'checkout';
            $this->render($data);
        }
    }

    public function update_cart_item()
    {
        $row_id = $this->input->post('row_id');
        $qty = $this->input->post('qnty');
        $get_data = $this->cart->get_item($row_id);
        $subtotal = $qty * $get_data['price'];
        $data = array(
            'rowid' => $row_id,
            'qty' => $qty,
            'subtotal' => $subtotal,
        );
        $this->cart->update($data);
        echo $this->cart->total_items();
    }

    public function delivery()
    {
        if(!is_login())
        {
            $this->session->set_userdata('from_url', base_url('delivery'));
            redirect(base_url('account/signin'));
        }
        else
        {
            if(!empty($this->session->userdata('from_url')))
            {
                $this->session->unset_userdata('from_url');
            }
            if(count($this->cart->contents()) == 0)
            {
                redirect(base_url('cart'));
            }
            $data_customer = db_get_row_data('tbl_customer',array('customer_id' => $this->session->userdata('customer_id')));
            $customer_meta = db_get_all_data('tbl_customer_meta',array('customer_id' => $this->session->userdata('customer_id')));
            $data['customer'] = $data_customer;
            $data['customer_meta'] = $customer_meta;
            $data['state'] = db_get_all_data('tbl_state');
            $data['title'] = 'Alamat Pengiriman';
            $data['content'] = 'delivery';
            $this->render($data);
        }
    }

    public function payment()
    {
        if(!is_login())
        {
            $this->session->set_userdata('from_url', base_url('payment'));
            redirect(base_url('account/signin'));
        }
        else
        {
            if(!empty($this->session->userdata('from_url')))
            {
                $this->session->unset_userdata('from_url');
            }
            if(count($this->cart->contents()) == 0)
            {
                redirect(base_url('cart'));
            }
            $data_payment = db_get_all_data('tbl_payment_method',array('status_payment' => '1'));
            $data['payment_list'] = $data_payment;
            $data['title'] = 'Metode Pembayaran';
            $data['content'] = 'payment';
            $this->render($data);
        }
    }

    public function confirmation()
    {
        if(!is_login())
        {
            $this->session->set_userdata('from_url', base_url('confirmation'));
            redirect(base_url('account/signin'));
        }
        else
        {
            if(!empty($this->session->userdata('from_url')))
            {
                $this->session->unset_userdata('from_url');
            }
            if(count($this->cart->contents()) == 0)
            {
                redirect(base_url('cart'));
            }
            $data_customer = db_get_row_data('tbl_customer',array('customer_id' => $this->session->userdata('customer_id')));
            $customer_meta = db_get_all_data('tbl_customer_meta',array('customer_id' => $this->session->userdata('customer_id')));
            $data['customer'] = $data_customer;
            $data['customer_meta'] = $customer_meta;
            $data['state'] = db_get_all_data('tbl_state');
            $data['title'] = 'Konfirmasi Pembelian';
            $data['content'] = 'confirmation';
            $this->render($data);
        }
    }

    public function cart()
    {
        if(!is_login())
        {
            $this->session->set_userdata('from_url', base_url('cart'));
            redirect(base_url('account/signin'));
        }
        else
        {
            $data['title'] = 'Keranjang belanja';
            $data['content'] = 'cart';
            $this->render($data);
        }
    }

    public function c($category_id,$seo_category='',$sort_by='a-to-z')
    {
        $this->load->library('pagination');
        $where = array('tbl_product.category_id' => $category_id);
        $all_data = $this->product_model->get_all_count($where);
        $config['base_url'] = base_url()."c/$category_id/$seo_category/$sort_by/";
        $config['total_rows'] = $all_data;
        $config['per_page'] = 30;
        $config['full_tag_open'] = "<ul class='pagination justify-content-center mt-4'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = "<li class='page-item'>";
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = "</span><span class='sr-only'>(current)</span></li>";
        $config['next_tag_open'] = "<li class='page-item'>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li class='page-item'>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li class='page-item'>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li class='page-item'>";
        $config['last_tagl_close'] = "</li>";
        $config['attributes'] = array('class' => 'page-link');
        $config['prev_link'] = 'Previous';
        $config['next_link'] = 'Next';
        $from = $this->uri->segment(5);
        $this->pagination->initialize($config);
        $data['cat_url'] = base_url('c/'.$category_id.'/'.$seo_category.'/');

        $find_category = db_get_row_data('tbl_category',array('category_id' => $category_id));
        $data['title'] = $find_category->category_name;
        $product = $this->product_model->get_with_limit($where,$config['per_page'],$from,$sort_by);
        $data['category'] = $find_category;
        $data['product'] = $product;
        $data['content'] = 'category';
        $data['links'] = $this->pagination->create_links();
        $this->render($data);
    }

    public function sub($subcategory,$seo_category='',$sort_by='a-to-z')
    {
        $this->load->library('pagination');
        $where = array('tbl_product.subcategory_id' => $subcategory);
        $all_data = $this->product_model->get_all_count($where);
        $config['base_url'] = base_url()."sub/$subcategory/$seo_category/$sort_by/";
        $config['total_rows'] = $all_data;
        $config['per_page'] = 30;
        $config['full_tag_open'] = "<ul class='pagination justify-content-center mt-4'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = "<li class='page-item'>";
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = "</span><span class='sr-only'>(current)</span></li>";
        $config['next_tag_open'] = "<li class='page-item'>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li class='page-item'>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li class='page-item'>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li class='page-item'>";
        $config['last_tagl_close'] = "</li>";
        $config['attributes'] = array('class' => 'page-link');
        $config['prev_link'] = 'Previous';
        $config['next_link'] = 'Next';
        $from = $this->uri->segment(5);
        $this->pagination->initialize($config);
        $data['cat_url'] = base_url('sub/'.$subcategory.'/'.$seo_category.'/');

        $find_category = db_get_row_data('tbl_subcategory',array('subcategory_id' => $subcategory));
        $data['title'] = $find_category->subcategory_name;
        $product = $this->product_model->get_with_limit($where,$config['per_page'],$from,$sort_by);
        $data['sub_category'] = $find_category;
        $data['category'] = db_get_all_data('tbl_category');
        $data['product'] = $product;
        $data['content'] = 'category';
        $data['links'] = $this->pagination->create_links();
        $this->render($data);
    }

    public function brand($brand_id,$seo_category='',$sort_by='a-to-z')
    {
        $this->load->library('pagination');
        $where = array('tbl_product.brand_id' => $brand_id);
        $all_data = $this->product_model->get_all_count($where);
        $config['base_url'] = base_url()."brand/$brand_id/$seo_category/$sort_by/";
        $config['total_rows'] = $all_data;
        $config['per_page'] = 30;
        $config['full_tag_open'] = "<ul class='pagination justify-content-center mt-4'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = "<li class='page-item'>";
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = "</span><span class='sr-only'>(current)</span></li>";
        $config['next_tag_open'] = "<li class='page-item'>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li class='page-item'>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li class='page-item'>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li class='page-item'>";
        $config['last_tagl_close'] = "</li>";
        $config['attributes'] = array('class' => 'page-link');
        $config['prev_link'] = 'Previous';
        $config['next_link'] = 'Next';
        $from = $this->uri->segment(5);
        $this->pagination->initialize($config);
        $data['cat_url'] = base_url('brand/'.$brand_id.'/'.$seo_category.'/');

        $find_brand = db_get_row_data('tbl_brand',array('brand_id' => $brand_id));
        $data['title'] = $find_brand->name;
        $product = $this->product_model->get_with_limit($where,$config['per_page'],$from,$sort_by);
        $data['sub_category'] = $find_brand;
        $data['category'] = db_get_all_data('tbl_category');
        $data['product'] = $product;
        $data['content'] = 'category';
        $data['links'] = $this->pagination->create_links();
        $this->render($data);
    }

    public function add_to_cart_web()
    {
        $product_code = $this->input->post('product_code');
        $qty = 1;
        if(!empty($this->input->post('qty')))
        {
            $qty=$this->input->post('qty');
        }
        $attribute = '';
        if(!empty($this->input->post('attribute')))
        {
            $attribute = $this->input->post('attribute');
        }
        $this->cart_system($product_code,'order',$qty,$attribute);
        echo $this->cart->total_items();
    }

    public function cart_system($product_code,$iden,$qty_br,$attr)
    {
        $result = $this->order_model->validate_add_cart_item($product_code);
        $qty = $qty_br;
        if($result){

            //product price check
            $price = $this->check_product_rate($result->product_id, $qty);
            //product tax check
            $tax = $this->product_tax_calculate($result->tax_id, $qty, $price);

            $where = array('product_id' => $result->product_id);
            $res_attr = $this->order_model->check_by($where, 'tbl_attribute');
            $has_attr = 'yes';
            if(empty($res_attr))
            {
                $has_attr = 'no';
            }

            $arr = array();
            $arr_attr = array();
            if($attr != '')
            {
                for($i=0;$i<count($attr);$i++)
                {
                    if(!empty($attr[$i]))
                    {
                        $arr_attr[] = $attr[$i];
                    }

                }
            }
            $subtotal = $price * $qty;
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
                    'discount' => '0',
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
                    'subtotal' => $subtotal,
                    'image' => $result->filename,
                    'discount' => '0',
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

    public function check_product_rate($product_id=null, $qty=null)
    {
        //tier Price check
        $tire_price = $this->order_model->get_tire_price($product_id, $qty);

        if($tire_price)
        {
            return $price = $tire_price->tier_price ;
        }

        //special offer check
        $this->global_model->_table_name = 'tbl_special_offer';
        $this->global_model->_order_by = 'special_offer_id';
        $this->global_model->_primary_key = 'special_offer_id';
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
        $this->global_model->_table_name = 'tbl_product_price';
        $this->global_model->_order_by = 'product_price_id';
        $this->global_model->_primary_key = 'product_price_id';
        $general_price = $this->global_model->get_by(array("product_id"=>$product_id), true);
        return $product_price = $general_price->selling_price;

    }

    /*** Product tax calculation ***/
    public function product_tax_calculate($tax_id, $qty ,$price)
    {
        $this->global_model->_table_name = 'tbl_tax';
        $this->global_model->_order_by = 'tax_id';
        $this->global_model->_primary_key = 'tax_id';
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

    public function remove_cart_web(){
        $rowid = $this->input->post('row_id');
        $result = $this->cart->remove($rowid);
        if ($result) {
            echo $this->cart->total_items();
        }
    }

    public function save_order()
    {
        $order_no = rand(10000000, 99999);
        $note = $this->input->post('note');
        $ongkir = $this->input->post('ongkir');
        $data_customer = db_get_row_data('tbl_customer',array('customer_id' => $this->session->userdata('customer_id')));
        $coupon_amnt = 0;
        if(!empty($this->session->userdata('coupon_amnt')))
        {
            $coupon_amnt = $this->session->userdata('coupon_amnt');
        }
        $sub_total = $this->cart->total() - $coupon_amnt;
        if (get_tax() != '') {
            $hit_pajak = (get_tax()->tax_rate / 100) * $sub_total;
            $sub_total = $sub_total + $hit_pajak;
            $sub_total = $sub_total + $ongkir;
        }
        $data_order = array(
            'order_no' => $order_no,
            'customer_id' => $this->session->userdata('customer_id'),
            'customer_name' => $data_customer->customer_name,
            'customer_email' => $data_customer->email,
            'customer_phone' => $data_customer->phone,
            'customer_address' => $data_customer->address,
            'shipping_address' => '',
            'subtotal' => $this->cart->total(),
            'discount' => '0',
            'discount_amount' => '0',
            'tax' => $hit_pajak,
            'grand_total' => $sub_total,
            'payment_method' => $this->session->userdata('cart_payment'),
            'payment_ref' => '',
            'order_status' => '0',
            'note' => $note,
            'sales_person' => '0',
            'outlet_id' => get_frontend_store(),
            'due_date' => '',
            'discount_type' => 'persen',
            'persen_pajak' => get_tax()->tax_rate,
            'jumlah_uang' => $sub_total,
            'ongkir' => $ongkir
        );
        $this->order_model->init_table('tbl_order','order_id');
        $order_id = $this->order_model->save($data_order);
        $accept_phone = '';
        if(!empty($this->session->userdata('customer_phone')))
        {
            $accept_phone = $this->session->userdata('customer_phone');
        }
        else
        {
            $accept_phone =  $data_customer->phone;
        }
        $data_address = array(
            'order_id' => $order_id,
            'accept_name' => $this->session->userdata('customer_accept'),
            'phone' => $accept_phone,
            'state_id' => $this->session->userdata('customer_state'),
            'city_id' => $this->session->userdata('customer_city'),
            'district_id' => $this->session->userdata('customer_district'),
            'zip_code' => $this->session->userdata('customer_zip'),
            'address' => $this->session->userdata('customer_address')
        );
        $this->global_model->init_table('tbl_order_address','order_address_id');
        $address_id = $this->global_model->save($data_address);
        $cart = $this->cart->contents();
        foreach($cart as $item)
        {
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
            $this->global_model->init_table('tbl_order_details','order_details_id');
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

        }
        $this->cart->destroy();
        $customer_session = array('coupon_amnt', 'customer_accept', 'customer_state', 'customer_city', 'customer_district', 'customer_zip', 'customer_address');
        $this->session->unset_userdata($customer_session);
        redirect(base_url('success'));
    }

    public function search()
    {
        $get_category = $this->input->get('product_category');
        $get_product = $this->input->get('search_product');
        $this->load->library('pagination');
        if($get_category == '0')
        {
            $where = "tbl_product.product_name LIKE '%$get_product%'";
        }
        else
        {
            $where = "tbl_product.product_name LIKE '%$get_product%' AND tbl_product.category_id='$get_category'";
        }

        $all_data = $this->product_model->get_all_count($where);
        $config['base_url'] = base_url()."web/search?product_category=$get_category&search_product=$get_product";
        $config['total_rows'] = $all_data;
        $config['per_page'] = 30;
        $config['full_tag_open'] = "<ul class='pagination justify-content-center mt-4'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = "<li class='page-item'>";
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = "</span><span class='sr-only'>(current)</span></li>";
        $config['next_tag_open'] = "<li class='page-item'>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li class='page-item'>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li class='page-item'>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li class='page-item'>";
        $config['last_tagl_close'] = "</li>";
        $config['attributes'] = array('class' => 'page-link');
        $config['prev_link'] = 'Previous';
        $config['next_link'] = 'Next';
        $from = $this->uri->segment(5);
        $this->pagination->initialize($config);
        $data['cat_url'] = base_url()."web/search?product_category=$get_category&search_product=$get_product";
        if($get_category != '0')
        {
            $find_category = db_get_row_data('tbl_category',array('category_id' => $get_category));
            $data['category'] = $find_category;
        }

        $data['title'] = $get_product;
        $filter = '';
        if(!empty($this->input->get('filter')))
        {
            $filter = $this->input->get('filter');
        }
        $product = $this->product_model->get_with_limit($where,$config['per_page'],$from,'search',$filter);
        $data['all_category'] = db_get_all_data('tbl_category');
        $data['product'] = $product;
        $data['content'] = 'search';
        $data['links'] = $this->pagination->create_links();
        $this->render($data);
    }

    public function order_success()
    {
        $data['title'] = 'Order telah berhasil';
        $data['content'] = 'success';
        $this->render($data);
    }
}

?>