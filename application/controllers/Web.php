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
        $find_category = db_get_row_data('tbl_category',array('category_id' => $category_id));
        $data['title'] = $find_category->category_name;
        $product = db_get_all_data('tbl_product',array('category_id' => $category_id));
        $data['category'] = $find_category;
        $data['product'] = $product;
        $data['content'] = 'category';
        $this->render($data);
    }
}

?>