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

    public function c($category_id,$seo_category='')
    {
        $this->load->library('pagination');
        $where = array('category_id' => $category_id);
        $all_data = $this->product_model->get_all_count($where);
        $config['base_url'] = base_url()."c/$category_id/$seo_category/";
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
        $from = $this->uri->segment(4);
        $this->pagination->initialize($config);

        $find_category = db_get_row_data('tbl_category',array('category_id' => $category_id));
        $data['title'] = $find_category->category_name;
        $product = $this->product_model->get_with_limit($where,$config['per_page'],$from);
        $data['category'] = $find_category;
        $data['product'] = $product;
        $data['content'] = 'category';
        $data['links'] = $this->pagination->create_links();
        $this->render($data);
    }
}

?>