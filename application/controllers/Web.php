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
        $this->load->helper('text');

    }

    public function index()
    {
        $data['title'] = get_profile()->company_name;
        $data['content'] = 'home';
        $data['product'] = $this->product_model->get_all_product('yes');
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

    public function c($category_id,$seo_category='',$sort_by='a-to-z')
    {
        $this->load->library('pagination');
        $where = array('category_id' => $category_id);
        $all_data = $this->product_model->get_all_count($where);
        $config['base_url'] = base_url()."c/$category_id/$seo_category/$sort_by/";
        $config['total_rows'] = $all_data;
        $config['per_page'] = 1;
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

    public function add_to_cart_web()
    {
        $product_code = '44433356';
        $this->cart_system($product_code,'order');
        echo $this->cart->total_items();
    }

    public function cart_system($product_code,$iden)
    {
        $result = $this->order_model->validate_add_cart_item($product_code);
        $qty = 1;
        if($result){

            //product price check
            $price = $this->check_product_rate($result->product_id, $qty=1);
            //product tax check
            $tax = $this->product_tax_calculate($result->tax_id, $qty=1, $price);

            $where = array('product_id' => $result->product_id);
            $res_attr = $this->order_model->check_by($where, 'tbl_attribute');
            $has_attr = 'yes';
            if(empty($res_attr))
            {
                $has_attr = 'no';
            }

            $arr = array();
            $arr_attr = array();
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
}

?>