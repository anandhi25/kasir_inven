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
class Product extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->model('purchase_model');
        $this->load->model('global_model');
        $this->load->library('pagination');
        $this->load->helper('ckeditor');
        $this->data['ckeditor'] = array(
            'id' => 'ck_editor',
            'path' => 'asset/js/ckeditor',
            'config' => array(
                'toolbar' => 'Full',
                'width' => '100%',
                'height' => '250px',
            ),
        );
    }


    /*** Create Category ***/
    public function category($id = null)
    {
        $this->product_model->_table_name = 'tbl_category';
        $this->product_model->_order_by = 'category_id';
        $data['all_category'] = $this->product_model->get();
        // edit operation of category
        if (!empty($id)) { // if category id exist
            $where = array('category_id' => $id);
            $data['category_info'] = $this->product_model->check_by($where, 'tbl_category');

            if (empty($data['category_info'])) { // empty alert
                // massage
                $this->message->norecord_found('admin/product/category');
            }
        }

        //view page
        $data['title'] = 'Create Category';
        $data['subview'] = $this->load->view('admin/product/category', $data, true); // sub view
        $this->load->view('admin/_layout_main', $data); // main page
    }

    public function add_image($id)
    {
        $data['title'] = 'Tambah Image';
        $data['id_product'] = $id;
        $data['images'] = db_get_all_data('tbl_product_image',array('product_id' => $id,'featured' => '0'));
        $data['subview'] = $this->load->view('admin/product/add_image', $data, true); // sub view
        $this->load->view('admin/_layout_main', $data); // main page
    }

    /*** Save Category ***/
    public function save_category($id = null)
    {
        $this->product_model->_table_name = 'tbl_category';
        $this->product_model->_primary_key = 'category_id';

        $data['category_name'] = $this->input->post('category_name', true);

        // update category
        $where = array('category_name' => $data['category_name']);
        // duplicate check
        if (!empty($id)) {
            $category_id = array('category_id !=' => $id);
        } else {
            $category_id = null;
        }



        $check_category = $this->product_model->check_update('tbl_category', $where, $category_id);
        if (!empty($check_category)) { // if exist

            $type = 'error';
            $message = 'Product Category Information Already Exist';
        } else { // save and update query
            if (!empty($_FILES['cat_icon']['name'])) {
                $old_path = $this->input->post('old_path');
                if ($old_path) { // if old path is no empty
                    unlink($old_path);
                } // upload file
                $val = $this->product_model->uploadImage('cat_icon');
               // $val == true || redirect('admin/product/category');

                $data['cat_icon'] = $val['path'];
            }
            else
            {
                $old_path = $this->input->post('old_path');
                $data['cat_icon'] = $old_path;
            }
            $this->product_model->save($data, $id); //save and update
            // massage for employee
            $type = 'success';
            $message = 'Product Category Information Successfully Saved';
        }

        //redirect users to view page
        set_message($type, $message);
        redirect('admin/product/category');
    }

    private function insert_product_image($file_name,$old_path,$id_product)
    {
        $this->product_model->_table_name = 'tbl_product_image';
        $this->product_model->_order_by = 'product_image_id';
        $data['product_id'] = $id_product;
        $data['featured'] = '0';
        if (!empty($_FILES[$file_name]['name'])) {
            $old_path = $this->input->post($old_path);
            if ($old_path) { // if old path is no empty
                unlink($old_path);
            } // upload file
            $val = $this->product_model->uploadImage($file_name);
            // $val == true || redirect('admin/product/category');

            $data['filename'] = $val['path'];
            $data['image_path'] = $val['fullPath'];
            $res = $this->product_model->save($data);
            return $res;
        }
        else
        {
           // $old_path = $this->input->post($old_path);
            //$data['filename'] = $old_path;
            return false;

        }


    }

    public function save_images()
    {
        $id_product = $this->input->post('id_product');
        $this->product_model->_table_name = 'tbl_product_image';
        $this->product_model->_order_by = 'product_image_id';
        $check = db_get_all_data('tbl_product_image',array('product_id' => $id_product,'featured' => '0'));
        if(count($check) > 0)
        {
            $this->db->where(array('product_id' => $id_product,'featured' => '0'));
            $this->db->delete('tbl_product_image');
        }
        $res_1 = $this->insert_product_image('logo','old_path',$id_product);
        $res_2 = $this->insert_product_image('logo1','old_path_1',$id_product);
        $res_3 = $this->insert_product_image('logo2','old_path_2',$id_product);
        $res_4 = $this->insert_product_image('logo3','old_path_3',$id_product);
        set_message("success", "Data berhasil disimpan");
        redirect('admin/product/add_image/'.$id_product);
    }

    /*** Category Delete ***/
    public function delete_category($id)
    {
        $this->product_model->_table_name = 'tbl_subcategory';
        $this->product_model->_order_by = 'subcategory_id';
        $where = array('category_id' => $id);
        $check_category = $this->product_model->get_by($where, false);

        if (!empty($check_category)) { // if exist
            $type = 'error';
            $message = 'Category Information Already Used';
        } else { // if empty
            $this->product_model->_table_name = 'tbl_category';
            $this->product_model->_primary_key = 'category_id';
            $this->product_model->delete($id);

            $type = 'success';
            $message = 'Product Category Information Successfully Delete ';
        }

        //redirect users to view page
        set_message($type, $message);
        redirect('admin/product/category');
    }

    //create variasi
    public function variasi($id=null)
    {
        $this->product_model->_table_name = 'tbl_attribute_set';
        $this->product_model->_order_by = 'attribute_set_id';
        $data['all_variasi'] = $this->product_model->get();

        if (!empty($id)) { // if exist
            $where = array('attribute_set_id' => $id);
            $data['variasi_info'] = $this->product_model->check_by($where, 'tbl_attribute_set');

            if (empty($data['variasi_info'])) { // if empty
                $this->message->norecord_found('admin/product/variasi');
            }
        }

        $data['title'] = 'Variation Product';
        $data['subview'] = $this->load->view('admin/product/variasi', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function save_variasi($id = null)
    {
        $this->product_model->_table_name = 'tbl_attribute_set';
        $this->product_model->_primary_key = 'attribute_set_id';

        $data['attribute_name'] = $this->input->post('attribute_name', true);

        // update category
        $where = array('attribute_name' => $data['attribute_name']);
        // duplicate check
        if (!empty($id)) {
            $variasi_id = array('attribute_set_id !=' => $id);
        } else {
            $variasi_id = null;
        }

        $check_variasi = $this->product_model->check_update('tbl_attribute_set', $where, $variasi_id);
        if (!empty($check_variasi)) { // if exist
            $type = 'error';
            $message = 'Attribute Name Already Exist';
        } else { // save and update query
            $this->product_model->save($data, $id); //save and update
            // massage for employee
            $type = 'success';
            $message = 'Attribute Information Successfully Saved';
        }

        //redirect users to view page
        set_message($type, $message);
        redirect('admin/product/variasi');
    }

    public function delete_variasi($id)
    {
        $this->product_model->_table_name = 'tbl_attribute';
        $this->product_model->_order_by = 'attribute_id';
        $where = array('attribute_set_id' => $id);
        $check_variasi = $this->product_model->get_by($where, false);

        if (!empty($check_variasi)) { // if exist
            $type = 'error';
            $message = 'Attribute Information Already Used';
        } else { // if empty
            $this->product_model->_table_name = 'tbl_attribute_set';
            $this->product_model->_primary_key = 'attribute_set_id';
            $this->product_model->delete($id);

            $type = 'success';
            $message = 'Attribute Information Successfully Delete ';
        }

        //redirect users to view page
        set_message($type, $message);
        redirect('admin/product/variasi');
    }

    //create brand
    public function brand($id=null)
    {
        $this->product_model->_table_name = 'tbl_brand';
        $this->product_model->_order_by = 'brand_id';
        $data['all_brand'] = $this->product_model->get();

        if (!empty($id)) { // if exist
            $where = array('brand_id' => $id);
            $data['brand_info'] = $this->product_model->check_by($where, 'tbl_brand');

            if (empty($data['brand_info'])) { // if empty
                $this->message->norecord_found('admin/product/brand');
            }
        }

        $data['title'] = 'Brand Product';
        $data['subview'] = $this->load->view('admin/product/brand', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function save_brand($id = null)
    {
        $this->product_model->_table_name = 'tbl_brand';
        $this->product_model->_primary_key = 'brand_id';

        $data['name'] = $this->input->post('name', true);
        $data['description'] = $this->input->post('description', true);

        // update category
        $where = array('name' => $data['name']);
        // duplicate check
        if (!empty($id)) {
            $brand_id = array('brand_id !=' => $id);
        } else {
            $brand_id = null;
        }



        $check_brand = $this->product_model->check_update('tbl_brand', $where, $brand_id);
        if (!empty($check_brand)) { // if exist

            $type = 'error';
            $message = 'Brand Information Already Exist';
        } else { // save and update query
            if (!empty($_FILES['logo']['name'])) {
                $old_path = $this->input->post('old_path');
                if ($old_path) { // if old path is no empty
                    unlink($old_path);
                } // upload file
                $val = $this->product_model->uploadImage('logo');
                // $val == true || redirect('admin/product/category');

                $data['logo'] = $val['path'];
            }
            else
            {
                $old_path = $this->input->post('old_path');
                $data['logo'] = $old_path;
            }
            $this->product_model->save($data, $id); //save and update
            // massage for employee
            $type = 'success';
            $message = 'Brand Information Successfully Saved';
        }

        //redirect users to view page
        set_message($type, $message);
        redirect('admin/product/brand');
    }

    public function delete_brand($id)
    {
        $this->product_model->_table_name = 'tbl_brand';
        $this->product_model->_order_by = 'brand_id';
        $where = array('brand_id' => $id);
        $check_brand = $this->product_model->get_by($where, false);

        if (!empty($check_brand)) { // if exist
            $type = 'error';
            $message = 'Brand Information Already Used';
        } else { // if empty
            $this->product_model->_table_name = 'tbl_brand';
            $this->product_model->_primary_key = 'brand_id';
            $this->product_model->delete($id);

            $type = 'success';
            $message = 'Brand Information Successfully Delete ';
        }

        //redirect users to view page
        set_message($type, $message);
        redirect('admin/product/brand');
    }

    /*** Create Sub Category ***/
    public function subcategory($id = null)
    {
        $this->product_model->_table_name = 'tbl_category';
        $this->product_model->_order_by = 'category_id';
        $data['all_category'] = $this->product_model->get();

        if (!empty($id)) { // if exist
            $where = array('subcategory_id' => $id);
            $data['sub_category_info'] = $this->product_model->check_by($where, 'tbl_subcategory');

            if (empty($data['sub_category_info'])) { // if empty
                $this->message->norecord_found('admin/product/category');
            }
        }
        // get all_sub_category to view
        $data['all_sub_category'] = $this->product_model->get_all_sub_category();
        // view page

        $data['title'] = 'Product Sub Category';
        $data['subview'] = $this->load->view('admin/product/subcategory', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Create and Update Customer group ***/
    public function save_subcategory($id = null)
    {
        $this->product_model->_table_name = 'tbl_subcategory';
        $this->product_model->_primary_key = 'subcategory_id';
        // input form data
        $data['subcategory_name'] = $this->input->post('subcategory_name', true);
        $data['category_id'] = $this->input->post('category_id', true);

        // update sub category
        $where = array('subcategory_name' => $data['subcategory_name'], 'category_id' => $data['category_id']);
        // duplicate value check
        if (!empty($id)) { // if id exist
            $subcategory_id = array('subcategory_id !=' => $id);
        } else { // if id is not exist
            $subcategory_id = null;
        }
        // input data already exist or not
        $check_category = $this->product_model->check_update('tbl_subcategory', $where, $subcategory_id);

        if (!empty($check_category)) { // if exist
            $type = 'error';
            $message = 'Subcategory Information Already Exist';
        } else {
            if (!empty($_FILES['sub_icon']['name'])) {
                $old_path = $this->input->post('old_path');
                if ($old_path) { // if old path is no empty
                    unlink($old_path);
                } // upload file
                $val = $this->product_model->uploadImage('sub_icon');
                // $val == true || redirect('admin/product/category');

                $data['sub_icon'] = $val['path'];
            }
            else
            {
                $old_path = $this->input->post('old_path');
                $data['sub_icon'] = $old_path;
            }
            $this->product_model->save($data, $id);

            $type = 'success';
            $message = 'Subcategory Information Saved Successfully!';
        }
        //redirect users to view page
        set_message($type, $message);
        redirect('admin/product/subcategory');
    }

    /*** Delete Sub Category ***/
    public function delete_subcategory($id)
    {
        $this->product_model->_table_name = 'tbl_product';
        $this->product_model->_order_by = 'subcategory_id';
        $where = array('subcategory_id' => $id);
        $check_sub_category = $this->product_model->get_by($where, false);

        if (!empty($check_sub_category)) { // if exist
            $type = 'error';
            $message = 'Sub Category Information Already Used';
        } else { // if empty
            $this->product_model->_table_name = 'tbl_subcategory';
            $this->product_model->_primary_key = 'subcategory_id';
            $this->product_model->delete($id);

            $type = 'success';
            $message = 'Subcategory Information Delete Successfully!';
        }
        //redirect users to view page
        set_message($type, $message);
        redirect('admin/product/subcategory');
    }

    /*** Add New or Edit Product ***/
    public function add_product($id=null)
    {
        //tab selection
        $title = 'Tambah Produk Baru';
        $tab = $this->uri->segment(5);
        if(!empty($tab)){
            if($tab == 'price')
            {
                $data['tab'] = $tab;
            }else{
                $data['tab'] = $tab;
            }
        }

        //************* Retrieve Product ****************//

        if($id) {
            $this->tbl_product('product_id');
            $data['product_info'] = $this->global_model->get_by(array('product_id' => $id), true);

            if (!empty($data['product_info'])) {
                $title = 'Edit Produk';
                //product image
                $this->tbl_product_image('product_image_id');
                $data['product_image'] = $this->global_model->get_by(array('product_id' => $id), true);

                //product price
                $this->tbl_product_price('product_price_id');
                $data['product_price'] = $this->global_model->get_by(array('product_id' => $id), true);

                //product special offer
                $this->tbl_special_offer('special_offer_id');
                $data['special_offer'] = $this->global_model->get_by(array('product_id' => $id), true);

                //product tier price
                $this->tbl_tier_price('tier_price_id');
                $data['tier_price'] = $this->global_model->get_by(array('product_id' => $id), false);

                //product inventory
                $this->tbl_inventory('inventory_id');
                $data['inventory'] = $this->global_model->get_by(array('product_id' => $id), true);

                //product attribute
                $this->tbl_attribute('attribute_id');
                $data['attribute'] = $this->global_model->get_by(array('product_id' => $id), false);

                //product tag
                $this->tbl_product_tag('product_tag_id');
                $data['product_tags'] = $this->global_model->get_by(array('product_id' => $id), false);

                //subcategory
                $this->tbl_subcategory('subcategory_id');
                $data['subcategory'] = $this->global_model->get();
                $data['product_category'] = $this->global_model->get_by(array('subcategory_id' => $data['product_info']->subcategory_id), true);
                $data['product_sub'] = db_get_all_data('tbl_product_subcategory',array('product_id' => $id));


            } else {
                // redirect with msg product not found
                $this->message->norecord_found('admin/product/manage_product');
            }
        }

        $data['code'] = rand(10000000, 99999);

        $this->tbl_category('category_id');
        $data['category'] = $this->global_model->get();

        $this->tbl_brand('brand_id');
        $data['brand'] = $this->global_model->get();

        $this->tbl_attribute_set('attribute_set_id');
        $data['variasi'] = $this->global_model->get();

        $this->tbl_tax('tax_id');
        $data['tax'] = $this->global_model->get();

        $this->tbl_tag('tag_id');
        $data['tags'] = $this->global_model->get();

        $this->tbl_attribute_set('attribute_set_id');
        $data['attribute_set'] = $this->global_model->get();

        // view page
        $data['title'] = $title;

        $data['editor'] = $this->data; //get ck editor
        $data['subview'] = $this->load->view('admin/product/add_product', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }


    /*** Add New or Update Attribute Group ***/
    public function save_product($id = null)
    {
        if ($id) { // if id
            $product_image_id = $this->input->post('product_image_id', true);
            $product_price_id = $this->input->post('product_price_id', true);
            $special_offer_id = $this->input->post('special_offer_id', true);
            $tier_price_id    = $this->input->post('tier_price_id', true);
            $attribute_id    = $this->input->post('attribute_id', true);
            $inventory_id    = $this->input->post('inventory_id', true);

        } else {
            $product_image_id = null;
            $product_price_id = null;
            $special_offer_id = null;
            $tier_price_id    = null;
            $attribute_id = null;
            $inventory_id = null;
        }


        //*************** Product Information **************

        $product_info = $this->product_model->array_from_post(array(
            'product_name',
            'product_note',
            'subcategory_id',
            'tax_id',
            'serial',
            'category_id',
            'brand_id'
             ));

        $serial = '0';
        if(!empty($this->input->post('serial')))
        {
            if($this->input->post('serial') == 'yes')
            {
                $serial = '1';
            }
        }

        $product_info['serial'] = $serial;
        $sub_cat = '0';
        $post_sub = $this->input->post('subcategory_id');
        if(count($post_sub) > 0)
        {
            $sub_cat = $post_sub[0];
        }
        $product_info['subcategory_id'] = $sub_cat;
        $this->tbl_product('product_id');
        $product_id = $this->global_model->save($product_info, $id);

        if(empty($id)) {
            $product_code['product_code'] = $this->input->post('product_code').$product_id;
            $this->global_model->save($product_code, $product_id);
            $this->set_barcode($product_code['product_code'],$product_id);
        }

        //****************** Product  Image Upload ***********************//

        $this->tbl_product_image('product_image_id');

        // save image Process
        if (!empty($_FILES['product_image']['name'])) {
            $old_path = $this->input->post('old_path');
            if ($old_path) { // if old path is no empty
                unlink($old_path);
            } // upload file
            $val = $this->product_model->uploadImage('product_image');
            $val == true || redirect('admin/product/add_product');

            $image_data['filename'] = $val['path'];
            $image_data['image_path'] = $val['fullPath'];
            $image_data['product_id'] = $product_id;
            $image_data['featured'] = '1';
            if (!empty($product_image_id)) {
                $this->global_model->save($image_data, $product_image_id); // save and update function
            } else {
                $this->global_model->save($image_data);
            }
        }

        //******************Product Price Information ************************//


        $general_price['buying_price'] = remove_commas($this->input->post('buying_price'));
        $general_price['selling_price'] = remove_commas($this->input->post('selling_price'));
        $general_price['product_id'] = $product_id;

        $this->tbl_product_price('product_price_id');
        // save and update
        $this->global_model->save($general_price, $product_price_id);


        //****************** Product Price Information End ************************//

        //************************ Product Special Offer ************************//

        $special_offer = $this->product_model->array_from_post(array(
            'start_date',
            'end_date',
            'offer_price', ));
        $special_offer['product_id'] = $product_id;


        if( (!empty($special_offer['start_date']) && !empty($special_offer['end_date']) && !empty($special_offer['offer_price']) ))
        {
            // save and update function
            $this->tbl_special_offer('special_offer_id');

            if(!empty($special_offer_id))
            {
                $this->global_model->save($special_offer, $special_offer_id);
            }else
            {
                $this->global_model->save($special_offer);
            }


        }


        //************************ Product Special Offer End ************************//

        //************************ Product  Tier Price Start ***********************//

        $tier_quantity = $this->input->post('tier_quantity', true);
        $tier_price = $this->input->post('tier_price', true);
        $tier['product_id'] = $product_id;

        $this->tbl_tier_price('tier_price_id');

        for($i = 0; $i < sizeof($tier_quantity);$i++)
        {
            if($tier_quantity[$i] !=null && $tier_price[$i] != null )
            {
                $tier['quantity_above'] = $tier_quantity[$i];
                $tier['tier_price'] = $tier_price[$i];
                $tier_id = $tier_price_id[$i];

                $this->global_model->save($tier, $tier_id );
            }
        }

        //************************ Product  Tier Price End ***********************//

        //************************ Product  Attribute Start **********************//

        $attribute_name = $this->input->post('attribute_name', true);
        $attribute_value = $this->input->post('attribute_value', true);
        $attribute['product_id'] = $product_id;



        for($i = 0; $i < sizeof($attribute_name);$i++)
        {
            if($attribute_name[$i] !=null && $attribute_value[$i] != null )
            {
                $attribute['attribute_set_id'] = $attribute_name[$i];
                $this->tbl_attribute_set('attribute_set_id');
                $set_attribute = $this->global_model->get_by(array('attribute_set_id'=>$attribute['attribute_set_id'] ), true);

                $attribute['attribute_name'] = $set_attribute->attribute_name;
                $attribute['attribute_value'] = $attribute_value[$i];
                $product_attribute_id = $attribute_id[$i];
                //save
                $this->tbl_attribute('attribute_id');
                $this->global_model->save($attribute, $product_attribute_id);

                // save set_attribute value
             /*   $this->tbl_attribute_set('attribute_set_id');
                $set_attribute = $this->global_model->get_by(array('attribute_name'=>$attribute['attribute_name'] ), true);

                if(empty($set_attribute))
                {
                    $this->global_model->save($attribute_set_name);
                }*/


            }



        }

        if(count($post_sub) > 0)
        {
            $this->db->where('product_id', $product_id);
            $this->db->delete('tbl_product_subcategory');
            foreach ($post_sub as $sub)
            {
                $product_sub = array(
                    'product_id' => $product_id,
                    'subcategory_id' => $sub
                );
                $this->product_model->_table_name = 'tbl_product_subcategory';
                $this->product_model->_primary_key = 'sub_id';
                $this->product_model->save($product_sub);
            }
        }

        //************************ Product  Attribute End ********************//

        //************************ Product Tag Start *************************//

        $tages = $this->input->post('tages',true);

        //delete product tag
        $product_id = $product_id;
        $this->db->where('product_id', $product_id);
        $this->db->delete('tbl_product_tag');

        for($i=0; $i < sizeof($tages); $i++)
        {

            $this->product_model->_table_name = 'tbl_tag';
            $this->product_model->_primary_key = 'tag_id';

            $product_tag = array();
            $product_tag['tag'] = $tages[$i];
            $where = array('tag' => $tages[$i]);
            $result = $this->product_model->check_by($where, 'tbl_tag');
            $result == true || $this->product_model->save($product_tag);

            $this->tbl_product_tag('product_tag_id');

            $product_tag['product_id'] = $product_id;
            $this->global_model->save($product_tag);
        }
        //************************ Product  Tag End *************************//

        //************ Product  Inventory Information Start *****************//

        $this->tbl_inventory('inventory_id');

        $inventory['notify_quantity'] = $this->input->post('notify_quantity', true);
        $inventory['product_quantity'] = $this->input->post('product_quantity', true);
        $inventory['product_id'] = $product_id;

        $this->global_model->save($inventory, $inventory_id);

        $type = 'success';
        $message = 'Product Information Saved Successfully!';
        set_message($type, $message);
        redirect('admin/product/manage_product');
    }

    /*** Barcode Generate ***/
    private function set_barcode($code, $id)
    {

        //load library
        $this->load->library('Zend');
        //load in folder Zend
        $this->zend->load('Zend/Barcode');

        //generate barcode
        $file = Zend_Barcode::draw('code128', 'image', array('text' => $code), array());

        imagejpeg($file, "img/barcode/{$code}.jpg");

        $data['barcode'] = "img/barcode/{$code}.jpg";
        $data['barcode_path'] = getcwd().'/'.$data['barcode'];

        $this->tbl_product('product_id');
        $this->global_model->save($data, $id);
    }

    /*** Manage Product ***/
    public function manage_product()
    {

        $data['product'] = $this->product_model->get_all_product_info();

        $data['title'] = 'Manage Product';
        $data['subview'] = $this->load->view('admin/product/manage_product', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function init_stock($outlet_id = '')
    {

        $data['product'] = $this->product_model->get_all_product_info();
        $data['outlet_id'] = $outlet_id;
        $data['title'] = 'Tambah Stok Awal Produk';
        $data['subview'] = $this->load->view('admin/product/init_stock', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function view_product($id)
    {
        $data['product'] = $this->product_model->get_product_information_by_id($id);
        //product tier price
        $this->tbl_tier_price('tier_price_id');
        $data['tier_price'] = $this->global_model->get_by(array('product_id' => $id), false);

        //product attribute
        $this->tbl_attribute('attribute_id');
        $data['attribute'] = $this->global_model->get_by(array('product_id' => $id), false);

        //product tag
        $this->tbl_product_tag('product_tag_id');
        $data['product_tags'] = $this->global_model->get_by(array('product_id' => $id), false);

        $data['title'] = 'View Product';
        $data['product_id'] = $id;
        $data['modal_subview'] = $this->load->view('admin/product/_modal_view_product', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);
    }

    /*** Damage product management ***/
    public function damage_product()
    {
        $this->tbl_damage_product('damage_product_id');
        $data['damage_product'] = $this->global_model->get();



        $data['title'] = 'Damage Product';
        $data['subview'] = $this->load->view('admin/product/damage_product', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Add Damage product ***/
    public function add_damage_product(){

        $this->tbl_product('product_id');
        $data['product'] = $this->global_model->get();

        $data['title'] = 'Add Damage Product';
        $data['subview'] = $this->load->view('admin/product/add_damage_product', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Save Damage product ***/
    public function save_damage_product(){
        $data= $this->product_model->array_from_post(array('product_id','qty','note','decrease'));

        if(empty($data['product_id'])){
            $this->message->custom_error_msg('admin/product/add_damage_product','Please select Product');
        }

        $data['date'] = date("j F, Y");

        $this->tbl_product('product_id');
        $product_code = $this->global_model->get_by(array('product_id'=>$data['product_id']),true);

        $category = $this->product_model->get_damage_product($data['product_id']);

        $data['product_code'] = $product_code->product_code;
        $data['product_name'] = $product_code->product_name;
        $data['category'] = $category->category_name . ' > '. $category->subcategory_name ;

        //product inventory
        $this->tbl_inventory('inventory_id');
        $inventory = $this->global_model->get_by(array('product_id'=>$data['product_id']),true);

        if($data['qty'] > $inventory->product_quantity )
        {
            $msg = 'Sorry! Your Damage Product Quantity is Greater than Product Quantity!';
            $this->message->custom_error_msg('admin/product/damage_product', $msg );

        }else
        {

            //save damage product
            $this->tbl_damage_product('damage_product_id');
            $this->global_model->save($data);

            if($data['decrease']==1)
            {
                // update tbl_inventory
                $sdata['product_quantity'] = $inventory->product_quantity - $data['qty'];
                $this->tbl_inventory('inventory_id');
                $this->global_model->save($sdata, $inventory->inventory_id);
                // redirect success msg
                $this->message->save_success('admin/product/damage_product');

            }else
            {
                $this->message->save_success('admin/product/damage_product');
            }
        }
    }

    /*** product action handel ***/
    public function product_action()
    {
        // 1 = active
        // 2 = deactivated
        // 3 = delete

        $action = $this->input->post('action' , true);
        $product_id = $this->input->post('product_id' , true);

        if(!empty($product_id)) {


            if ($action == 1) {
                //active product
                $this->active_product($product_id);

            } elseif ($action == 2) {
                //deactivated product
                $this->deactive_product($product_id);
            } else {
                //delete product
                $this->delete_product($product_id);
            }
        }else{
            $this->message->custom_error_msg('admin/product/manage_product', 'You did not select any Product');
        }
    }

    /*** product activate ***/
    public function active_product($product_id)
    {
        foreach($product_id as $v_product_id){
            $id = $v_product_id;
            $data['status'] = 1;
            $this->tbl_product('product_item');

            //update
            $this->global_model->save($data,$id );
        }
        $this->message->custom_success_msg('admin/product/manage_product', 'Your Product Active Successfully!');
    }

    /*** product deactivate ***/
    public function deactive_product($product_id)
    {
        foreach($product_id as $v_product_id){
            $id = $v_product_id;
            $data['status'] = 0;
            $this->tbl_product('product_item');

            //update
            $this->global_model->save($data,$id );
        }
        $this->message->custom_success_msg('admin/product/manage_product', 'Your Product Deactivated Successfully!');
    }

    /*** Delete product***/
    public function delete_product($id){
        if(is_array($id))
        {
            foreach($id as $v_id)
            {
                $this->_delete($v_id);
            }
            $this->message->delete_success('admin/product/manage_product');

        }else
        {
            if (!empty($id)) {

                $this->tbl_product('product_id');
                $product = $this->global_model->get_by(array('product_id'=>$id),true);
                if(!empty($product)){
                    $this->_delete($id);
                    $this->message->delete_success('admin/product/manage_product');
                }
                redirect('admin/product/manage_product');

            } else {
                redirect('admin/product/manage_product');
            }
        }
    }

    /*** Delete Function ***/
    public function _delete($id){

        //delete from tbl_product
        $this->tbl_product('product_id');
        $this->global_model->delete($id);

        //price
        $this->tbl_product_price('product_price_id');
        $product_price = $this->global_model->get_by(array('product_id'=>$id),true);
        $this->global_model->delete($product_price->product_price_id);

        //Inventory
        $this->tbl_inventory('inventory_id');
        $inventory = $this->global_model->get_by(array('product_id'=>$id),true);
        $this->global_model->delete($inventory->inventory_id);

        //delete image
        $this->tbl_product_image('product_image_id');
        $image_id = $this->global_model->get_by(array('product_id'=>$id),true);
        if(!empty($image_id)) {
            $this->global_model->delete($image_id->product_image_id);
        }
        //Special offer
        $this->tbl_special_offer('special_offer_id');
        $special_offer = $this->global_model->get_by(array('product_id'=>$id),true);
        if(!empty($special_offer)) {
            $this->global_model->delete($special_offer->special_offer_id);
        }
        //tier Price
        $this->tbl_tier_price('tier_price_id');
        $tire_price = $this->global_model->get_by(array('product_id'=>$id),false);

        if(!empty($tire_price)) {
            foreach ($tire_price as $v_tire_price) {
                $this->global_model->delete($v_tire_price->tier_price_id);
            }
        }

        //tag
        $this->tbl_product_tag('product_tag_id');
        $tag = $this->global_model->get_by(array('product_id'=>$id),false);
        if(!empty($tag)) {
            foreach ($tag as $v_tag) {
                $this->global_model->delete($v_tag->product_tag_id);
            }
        }

        //attribute
        $this->tbl_attribute('attribute_id');
        $attribute = $this->global_model->get_by(array('product_id'=>$id),false);
        if(!empty($attribute)) {
            foreach ($attribute as $v_attribute) {
                $this->global_model->delete($v_attribute->attribute_id);
            }
        }

    }

    /*** Add Damage product ***/
    public function print_barcode(){

        $this->tbl_product('product_id');
        $data['product'] = $this->global_model->get();

        $data['title'] = 'Add Damage Product';
        $data['subview'] = $this->load->view('admin/product/print_barcode', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function add_to_print(){

        $product_id = $this->input->post('product_id', true);


        for($i=0; $i< sizeof($product_id); $i++){
            $this->tbl_product('product_id');
            $product = $this->global_model->get_by(array('product_id'=>$product_id[$i] ),true);


            $flag= true;
            if(!empty($this->session->userdata("barcode"))) {
                $barcode = $this->session->userdata("barcode");
                for ($j = 0; $j < count($barcode); $j++) {
                    if ($product->product_id == $barcode[$j]['product_id']) {
                        $flag = false;
                    }

                }
            }
            if($flag){
                $arr = array(
                    'barcode' => array(
                        "product_id"    =>$product->product_id,
                        "product_name"  =>$product->product_name,
                        "barcode"       =>$product->barcode,
                    )
                );
                $this->session->set_userdata($arr);
               /* $_SESSION["barcode"][] =  array(
                    "product_id"    =>$product->product_id,
                    "product_name"  =>$product->product_name,
                    "barcode"       =>$product->barcode,
                );*/
            }

        }

        redirect('admin/product/print_barcode');
    }

    /*** Barcode Print Session Destroy ***/
    public function clear_print_tray(){
        unset($_SESSION['barcode']);
        redirect('admin/product/print_barcode');
    }


    public function barcode_pdf(){
        // load DOMPDF to create PDF
        $this->load->helper('dompdf');

        $view_file = $this->load->view('admin/product/barcode_pdf','', true);
        $file_name = pdf_create($view_file, 'Barcode');
        echo $file_name;
    }

    /*** Delete tier price ***/
    public function delete_tire_price($id)
    {

        $this->tbl_tier_price('tier_price_id');

        //product id
        $product = $this->global_model->get_by(array('tier_price_id' => $id),true);
        $this->global_model->delete($id);
        redirect('admin/product/add_product/'.$product->product_id. '/' . $flag='price');

    }

    /*** Delete Attribute ***/
    public function delete_attribute($id)
    {

        $this->tbl_attribute('attribute_id');

        //product id
        $attribute = $this->global_model->get_by(array('attribute_id' => $id),true);
        $this->global_model->delete($id);
        redirect('admin/product/add_product/'.$attribute->product_id. '/' . $flag='attribute');

    }

    /*** Delete Damage Product ***/
    public function delete_damage_product($id)
    {
        $this->tbl_damage_product('damage_product_id');
        $this->global_model->delete($id);
        $this->message->delete_success('admin/product/damage_product');

    }

    /*** Notification Product ***/
    public function notification_product()
    {

        $data['product'] = $this->product_model->get_all_product_info();

        $data['title'] = 'Manage Product';
        $data['subview'] = $this->load->view('admin/product/notification_product', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Get subcategory by category ***/
    public function get_subcategory_by_category($id=null){
        $HTML = '';
        $this->tbl_subcategory('subcategory_id');
        $subcategory = $this->global_model->get_by(array('category_id' => $id), false);
        if ($subcategory) {
            foreach ($subcategory as $v_subcategory) {
                $HTML.="<option value='" . $v_subcategory->subcategory_id . "'>" . $v_subcategory->subcategory_name . "</option>";
            }
        }
        echo $HTML;
    }

    public function cart_product_table($iden='')
    {
        $getData = array();
        $where = '';
        $limit = '';
        $orderby = '';
        $arrCol = array(
            0 => 'product_code'
        );
        if(isset($_GET["search"]["value"]))
        {
            if ($where == '') {
                $where = "WHERE product_code LIKE '%".$_GET["search"]["value"]."%' OR product_name LIKE '%".$_GET["search"]["value"]."%'";
            } else {
                $where .= " AND product_code LIKE '%".$_GET["search"]["value"]."%' OR product_name LIKE '%".$_GET["search"]["value"]."%'";
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
            $orderby = " ORDER BY product_name ASC";
        }

        if(isset($_GET["length"])) {
            if ($_GET["length"] != -1) {
                $limit = " LIMIT ".$_GET['start'] . ',' . $_GET['length'];
            }
        }
        $list = $this->global_model->get_by_sql("SELECT * FROM tbl_product ".$where.' '.$orderby.' '.$limit);
        $listAll = $this->global_model->get_by_sql("SELECT * FROM tbl_product ".$where);
        $total = count($listAll);
        foreach ($list as $post) {
            $subdata = array();
            $subdata[] = '<input name="product_barcode[]" value="'.$post->product_code.'" class="child_present" type="checkbox" />';
            $subdata[] = $post->product_code;
            $subdata[] = $post->product_name;
            $subdata[] = '<input type="hidden" name="product_id" value="'.$post->product_code.'">
                        <a href="'.base_url().'admin/order/add_cart_item/'.$post->product_code.'/'.$iden.'" data-original-title="Add to Cart" class="btn btn-primary btn-xs" title="" data-toggle="tooltip" data-placement="top">
                            <i class="fa fa-shopping-cart"></i></a>';
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

    public function add_stock($product_id,$outlet_id)
    {
        $judul = 'Tambah Stok Awal';
        $url_action = base_url('admin/product/save_init_stock');
        $find_product = db_get_row_data('tbl_product',array('product_id' => $product_id));
        $data['product'] = $find_product;
        $data['outlet'] =  $outlet_id;
        if(!empty($id))
        {
            $judul = 'Edit Stok Awal';
            //$url_action = base_url('admin/settings/edit_account');
            $where = array('category_id' => $id);
            $data['category'] = $this->transaction_model->check_by($where, 'tbl_trans_category');
        }
        $data['title'] = $judul;
        $data['url_action'] = $url_action;
        $data['modal_subview'] = $this->load->view('admin/product/add_init_stock_modal', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);
    }

    public function save_init_stock()
    {
        $id = null;
        if(!empty($this->session->userdata('id_purchase'))) {
            $id = $this->session->userdata('id_purchase');

        }
        $product_id = $this->input->post('product_id');
        $find_product = db_get_row_data('tbl_product',array('product_id' => $product_id));
        $outlet_id = $this->input->post('outlet_id');
        $order_no = rand(100, 99999);
        $data = array(
            'order_no' => $order_no,
            'supplier_id' => '0',
            'supplier_name' => '',
            'grand_total' => '0',
            'note' => 'Stok awal',
            'payment_method' => '',
            'payment_ref' => 'stok awal',
            'purchase_by' => $this->session->userdata('name'),
            'outlet_id' => $outlet_id,
            'tax' => '0',
            'discount' => '0',
            'discount_type' => '',
            'due_date' => '',
            'down_payment' => '0',
            'subtotal' => '0',
            'discount_amount' => '0',
        );
        //save to purchase table
        $this->tbl_purchase('purchase_id');
        $purchase_id = $this->global_model->save($data,$id);
        $buy_price = '0';
        $find_price = db_get_row_data('tbl_product_price',array('product_id' => $product_id));
        if($find_price)
        {
            $buy_price = $find_price->buying_price;
        }
        $data = array();
        $this->tbl_purchase_product('purchase_product_id');
        $data['purchase_id'] = $purchase_id;
        $data['product_code'] = $find_product->product_code;
        $data['product_name'] = $find_product->product_name;
        $data['qty'] = $this->input->post('quantity');
        $data['unit_price'] = $buy_price;
        $data['sub_total'] = ($buy_price * $this->input->post('quantity'));
        $data['sisa_qty'] = $this->input->post('quantity');
        $pur_detail_id = $this->global_model->save($data);
        echo json_encode(array('success' => true,'outlet' => $outlet_id));

    }

    public function add_modal_brand()
    {
        $data['title'] = "Tambah Brand / Merek";
        $data['url_action'] = base_url('admin/product/save_modal_brand');
        $data['modal_subview'] = $this->load->view('admin/product/add_brand_modal', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);
    }

    public function add_modal_category()
    {
        $data['title'] = "Tambah Kategori";
        $data['url_action'] = base_url('admin/product/save_modal_category');
        $data['modal_subview'] = $this->load->view('admin/product/add_category_modal', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);
    }

    public function save_modal_category()
    {
        $this->product_model->_table_name = 'tbl_category';
        $this->product_model->_primary_key = 'category_id';

        $data['category_name'] = $this->input->post('category_name', true);
        $res = $this->product_model->save($data);
        if($res)
        {
            $q_category = db_get_all_data('tbl_category');
            $str = '';
            if(count($q_category) > 0)
            {
                foreach ($q_category as $cat)
                {
                    $sel = '';
                    if($cat->category_id == $res)
                    {
                        $sel = 'selected';
                    }
                    $str .= '<option value="'.$cat->category_id.'" '.$sel.'>'.$cat->category_name.'</option>';
                }
            }
            echo json_encode(array('success' => true,'message' => 'data berhasil disimpan','qcategory' => $str));
        }
        else
        {
            echo json_encode(array('success' => false,'message' => 'data gagal disimpan'));
        }
    }

    public function save_modal_brand()
    {
        $this->product_model->_table_name = 'tbl_brand';
        $this->product_model->_primary_key = 'brand_id';

        $data['name'] = $this->input->post('name', true);
        $data['description'] = $this->input->post('description', true);

        $res = $this->product_model->save($data);
        if($res)
        {
            $q_brand = db_get_all_data('tbl_brand');
            $str = '';
            if(count($q_brand) > 0)
            {
                foreach ($q_brand as $brand)
                {
                    $sel = '';
                    if($brand->brand_id == $res)
                    {
                        $sel = 'selected';
                    }
                    $str .= '<option value="'.$brand->brand_id.'" '.$sel.'>'.$brand->name.'</option>';
                }
            }
            echo json_encode(array('success' => true,'message' => 'data berhasil disimpan','qbrand' => $str));
        }
        else
        {
            echo json_encode(array('success' => false,'message' => 'data gagal disimpan'));
        }
    }

}