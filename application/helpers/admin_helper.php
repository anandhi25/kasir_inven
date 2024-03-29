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

function btn_edit($uri) {
    return anchor($uri, '<i class="glyphicon glyphicon-edit"></i>', array('class' => "btn bg-navy btn-xs", 'title'=>'Edit', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
}
function btn_edit_disable($uri) {
    return anchor($uri, '<span class="glyphicon glyphicon-pencil"></span>', array('class' => "btn btn-primary btn-xs disabled", 'title'=>'Edit', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
}

function btn_edit_modal($uri) {
    return anchor($uri, '<span class="glyphicon glyphicon-pencil"></span>', array('class' => "btn btn-primary btn-xs", 'title'=>'Edit', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-toggle'=>'modal', 'data-target'=>'#myModal'));
}

function btn_view_modal($uri) {
    return anchor($uri, '<span class="glyphicon glyphicon-search"></span>', array('class' => "btn bg-olive btn-xs",'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'View', 'data-toggle'=>'modal', 'data-target'=>'#myModal'));
}

function btn_add_modal($uri,$modal_name='myModal',$title='',$class = "btn bg-olive btn-xs") {
    return anchor($uri, '<span class="glyphicon glyphicon-plus"></span>'.$title, array('class' => $class,'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Tambah', 'data-toggle'=>'modal', 'data-target'=>'#'.$modal_name));
}

function btn_serial_modal($uri,$modal_name='myModal') {
    return anchor($uri, '<span class="glyphicon glyphicon-sort-by-order"></span>', array('class' => "btn bg-olive btn-xs",'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Input Serial', 'data-toggle'=>'modal', 'data-target'=>'#'.$modal_name));
}

function btn_variasi_modal($uri,$modal_name='myModal') {
    return anchor($uri, '<span class="glyphicon glyphicon-plus"></span> Variasi', array('class' => "btn bg-primary btn-xs",'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Input Serial', 'data-toggle'=>'modal', 'data-target'=>'#'.$modal_name));
}

function btn_submit_modal($uri,$modal_name='myModal',$title='Submit',$class='') {
    return anchor($uri, $title, array('class' => "btn bg-navy btn-block".$class,'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$title, 'data-toggle'=>'modal', 'data-target'=>'#'.$modal_name));
}

function btn_delete($uri) {
    return anchor($uri, '<i class="fa fa-trash-o"></i>', array(
        'class' => "btn btn-danger btn-xs", 'title'=>'Delete', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'onclick' => "return confirm('Are you sure want to delete this record ?');"
    ));    
}
function btn_delete_disable($uri) {
    return anchor($uri, '<i class="fa fa-trash-o"></i>', array(
        'class' => "btn btn-danger btn-xs disabled", 'title'=>'Delete', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'onclick' => "return confirm('You are about to delete a record. This cannot be undone. Are you sure?');"
    ));    
}
function btn_active($uri) {
    return anchor($uri, '<i class="fa fa-check"></i>', array(
        'class' => "btn btn-success btn-xs", 'title'=>'Active', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'onclick' => "return confirm('You are about to active new sesion . This cannot be undone. Are you sure?');"
    ));    
}

function btn_modal_active($uri) {
    return anchor($uri, '<span class="fa fa-check"></span>', array('class' => "btn bg-olive btn-xs",'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'View', 'data-toggle'=>'modal', 'data-target'=>'#myModal'));
}

function btn_print() {
    return anchor('','<span class="glyphicon glyphicon-print"></i></span>', array('class' => "btn btn-primary btn-xs", 'title'=>'Print','data-toggle'=>'tooltip', 'data-placement'=>'top', 'onclick'=>'printDiv("printableArea")'));
}

function btn_atndc_print() {
    return anchor('','<span class="glyphicon glyphicon-print"></i></span>', array('class' => "btn btn-customs btn-xs", 'title'=>'Print','data-toggle'=>'tooltip', 'data-placement'=>'top', 'onclick'=>'printDiv("printableArea")'));
}

function btn_pdf($uri) {
    return anchor($uri, '<span <i class="fa fa-file-pdf-o"></i></span>', array('class' => "btn btn-primary btn-xs",'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Pdf'));
}
function btn_excel($uri) {
    return anchor($uri, '<span <i class="fa fa-file-excel-o"></i></span>', array('class' => "btn btn-primary btn-xs",'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Excel'));
}

function btn_view($uri) {
    return anchor($uri, '<span class="glyphicon glyphicon-search"></span>', array('class' => "btn bg-olive btn-xs",'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'View'));
}

function btn_view_custom($uri,$btnClass="btn bg-olive btn-xs",$title='') {
    return anchor($uri, '<span class="glyphicon glyphicon-search"></span>'.$title, array('class' => $btnClass,'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'View', 'data-toggle'=>'modal', 'data-target'=>'#myModal'));
}

function btn_save($uri) {
    return anchor($uri, '<span <i class="fa fa-plus-circle"></i></span>', array('class' => "btn btn-success btn-xs", 'title'=>'Save', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
}

function btn_add($uri,$title='') {
    return anchor($uri, '<span <i class="fa fa-plus-square"></i></span>'.$title, array('class' => "btn btn-success btn-xs", 'title'=>$title, 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
}

function btn_publish($uri) {
return anchor($uri, '<i class="fa fa-check"></i>', array(
        'class' => "btn btn-success btn-xs", 'title'=>'Click to Unpublish', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'onclick' => "return confirm('You are about to unpublish an exam. Are you sure?');"
    ));    
}

function btn_unpublish($uri) {
    return anchor($uri, '<i class="fa fa-times"></i>', array(
        'class' => "btn btn-danger btn-xs", 'title'=>'Click to PUblish', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'onclick' => "return confirm('You are about to publish an exam. Are you sure?');"
    ));
}

function btn_delete_attr($uri,$i_class = "fa fa-trash-o",$a_class='btn btn-danger btn-xs') {
    return anchor($uri, '<i class="'.$i_class.'"></i>', array(
        'class' => $a_class, 'title'=>'Delete', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'onclick' => "return confirm('Are you sure want to delete this record ?');"
    ));
}

function btn_view_order($uri) {
    return anchor($uri, '<span class="fa fa-eye"></span>', array('class' => "btn bg-olive btn-xs",'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'View'));
}

if(!function_exists('remove_commas')) {
    function remove_commas($str)
    {
        $ret = str_replace(',','',$str);
        return $ret;
    }
}

if(!function_exists('db_get_all_data')) {
    function db_get_all_data($table_name = null, $where = false) {
        $ci =& get_instance();
        if ($where) {
            $ci->db->where($where);
        }
        $query = $ci->db->get($table_name);

        return $query->result();
    }
}

if(!function_exists('db_get_all_data_by_query'))
{
    function db_get_all_data_by_query($sql)
    {
        $ci =& get_instance();
        $query = $ci->db->query($sql);

        return $query->result();
    }
}

if(!function_exists('db_get_row_data')) {
    function db_get_row_data($table_name = null, $where = false) {
        $ci =& get_instance();
        if ($where) {
            $ci->db->where($where);
        }
        $query = $ci->db->get($table_name);

        return $query->row();
    }
}

if(!function_exists('get_stock')) {
    function get_stock($product_code,$outlet_id)
    {
        $sql = "SELECT t.sisa_qty AS sisa FROM tbl_purchase p,tbl_purchase_product t WHERE p.purchase_id =  t.purchase_id AND t.product_code = '$product_code' AND p.outlet_id = '$outlet_id';";
        $res = db_get_all_data_by_query($sql);
        $total_qty = 0;
        if(count($res) > 0) {
            foreach ($res as $r) {
                $total_qty = $total_qty + $r->sisa;
            }
        }
        return $total_qty;
    }
}

if(!function_exists('seo_title')) {
    function seo_title($str)
    {
        $text = trim($str);
        if (empty($text)) return '';
        $text = preg_replace("/[^a-zA-Z0-9\-\s]+/", "", $text);
        $text = strtolower(trim($text));
        $text = str_replace(' ', '-', $text);
        $text = $text_ori = preg_replace('/\-{2,}/', '-', $text);
        return $text;
    }
}

if(!function_exists('_ent')) {
    function _ent($string = null) {
        return htmlentities($string);
    }
}

if (!function_exists('create_childern')) {

    function create_childern($childern, $parent, $tree) {
        foreach($childern as $child):
            ?>
            <option <?= $child->id == $parent? 'selected="selected"' : ''; ?> value="<?= $child->id; ?>"><?= str_repeat('----', $tree) ?>   <?= ucwords($child->label); ?></option>
            <?php if (isset($child->children) and count($child->children)):
            $tree++;
            ?>
            <?php create_childern($child->children, $parent, $tree); ?>
        <?php endif ?>
        <?php endforeach;
    }
}

if(!function_exists('get_menu')) {
    function get_menu($menu_type = null) {
        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('menu_model');

        if(is_numeric($menu_type)) {
            $menu_type_id = $menu_type;
        }
        else {
            $menu_type_id = $ci->menu_model->get_id_menu_type_by_flag($menu_type);
        }


        $menus = $ci->db
            ->where(['menu_type_id' =>  $menu_type_id])
            ->order_by('sort', 'ASC')
            ->get('tbl_menu_front')
            ->result();

        $menu_parents = $ci->db
            ->where( ['menu_type_id' => $menu_type_id, 'parent' => 0])
            ->order_by('sort', 'ASC')
            ->get('tbl_menu_front')
            ->result();


        $new = array();
        foreach ($menus as $a){
            $new[$a->parent][] = $a;
        }

        $news = array();
        $menus_tree = array();
        foreach ($menus as $a){
            $news[$a->parent][] = $a;
        }

        foreach ($menu_parents as $new) {
            $menus_tree = array_merge($menus_tree, create_tree($news, array($new)));
        }
        return $menus_tree;
    }
}

if(!function_exists('create_tree')) {
    function create_tree(&$list, $parent) {

        $tree = array();
        foreach ($parent as $k=>$l){
            if(isset($list[$l->id])){

                $l->children = create_tree($list, $list[$l->id]);
            }
            $tree[] = $l;
        }
        return $tree;
    }
}

if(!function_exists('display_menu_module')) {
    function display_menu_module($parent, $level, $menu_type, $ignore_active = false) {
        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('menu_model');
        $menu_type_id = $ci->menu_model->get_id_menu_type_by_flag($menu_type);
        $result = $ci->db->query("SELECT a.id, a.label, a.type, a.active, a.link, Deriv1.Count FROM `tbl_menu_front` a  LEFT OUTER JOIN (SELECT parent, COUNT(*) AS Count FROM `tbl_menu_front` GROUP BY parent) Deriv1 ON a.id = Deriv1.parent WHERE a.menu_type_id = ".$menu_type_id." AND a.parent=" . $parent." ".($ignore_active ? '' : 'and active = 1')." order by `sort` ASC")->result();

        $ret = '';
        if ($result) {
            $ret .= '<ol class="dd-list">';
            foreach ($result as $row) {
                if ($row->Count > 0) {
                    $ret .= '<li class="dd-item dd3-item '.($row->active ? '' : 'menu-toggle-activate_inactive').' menu-toggle-activate" data-id="'.$row->id.'" data-status="'.$row->active.'">';

                    if ($row->type != 'label') {
                        $ret .= '<div class="dd-handle dd3-handle dd-handles"></div>';
                        $ret .= '<div class="dd3-content">'._ent($row->label);
                    } else{
                        $ret .= '<div class="dd3-content  dd-label dd-handles"><b>'._ent($row->label).'</b>';
                    }


                        $ret .= '<span class="pull-right"><a class="remove-data" href="javascript:void()" data-href="'.site_url('admin/menu_front/delete_menu/'.$row->id).'"><i class="fa fa-trash btn-action"></i></a>
				                </span';


                        $ret .= '<span class="pull-right"><a href="'.site_url('admin/menu_front/edit/'.$row->id).'"><i class="fa fa-pencil btn-action"></i></a>
		                        </span>';


                    $ret .= '</div>';
                    $ret .= display_menu_module($row->id, $level + 1, $menu_type, $ignore_active);
                    $ret .= "</li>";
                } elseif ($row->Count==0) {
                    $ret .= '<li class="dd-item dd3-item '.($row->active ? '' : 'menu-toggle-activate_inactive').' menu-toggle-activate" data-id="'.$row->id.'" data-status="'.$row->active.'">';

                    if ($row->type != 'label') {
                        $ret .= '<div class="dd-handle dd3-handle dd-handles"></div>';
                        $ret .= '<div class="dd3-content">'._ent($row->label);
                    } else{
                        $ret .= '<div class="dd3-content  dd-label dd-handles"><b>'._ent($row->label).'</b>';
                    }


                        $ret .= '<span class="pull-right"><a class="remove-data" href="javascript:void()" data-href="'.site_url('admin/menu_front/delete_menu/'.$row->id).'"><i class="fa fa-trash btn-action"></i></a>
				                </span';



                        $ret .= '<span class="pull-right"><a href="'.site_url('admin/menu_front/edit/'.$row->id).'"><i class="fa fa-pencil btn-action"></i></a>
		                        </span>';


                    $ret .= '</div></li>';
                }
            }
            $ret .= "</ol>";
        }

        return $ret;
    }
}

if(!function_exists('theme_url')) {
    function theme_url($url_additional = null) {
        $ci =& get_instance();
      //  $active_theme = get_option('active_theme', 'cicool');
        $active_theme = get_profile()->themes;

        return base_url() . 'content/themes/' . $active_theme . '/' . $url_additional;
    }
}

if(!function_exists('theme_asset')) {
    function theme_asset() {
        return theme_url('asset/');
    }
}

if(!function_exists('get_profile')) {
    function get_profile() {
        $profile = db_get_row_data('tbl_business_profile',array('business_profile_id' => '1'));
        return $profile;
    }
}

if(!function_exists('get_customer_login_url')) {
    function get_customer_login_url() {
        $ret_url = base_url('account/do_login');
        return $ret_url;
    }
}

if(!function_exists('get_customer_signup_url')) {
    function get_customer_signup_url() {
        $ret_url = base_url('account/user_signup');
        return $ret_url;
    }
}

if(!function_exists('get_tax')) {
    function get_tax() {
        $tax = get_profile()->tax_sale;
        $q_tax = db_get_row_data('tbl_tax',array('tax_id' => $tax));
        if($q_tax)
        {
            return $q_tax;
        }
        else
        {
            return '';
        }
    }
}

if(!function_exists('is_login')) {
    function is_login()
    {
        $ci =& get_instance();
        if(!empty($ci->session->userdata('customer_login')))
        {
            return (bool)$ci->session->userdata('customer_login');
        }
        return false;

    }
}

if(!function_exists('get_product_category')) {
    function get_product_category() {
        $ret_categories = db_get_all_data('tbl_category');
        return $ret_categories;
    }
}

if(!function_exists('get_footer_menu')) {
    function get_footer_menu($menu_type)
    {
        $sql = "SELECT f.* FROM tbl_menu_front f,tbl_menu_type t WHERE f.menu_type_id = t.id AND t.name = '$menu_type' AND parent='0' ORDER BY f.sort ASC";
        $ret_data = db_get_all_data_by_query($sql);
        return $ret_data;
    }
}

if(!function_exists('get_slider')) {
    function get_slider()
    {
        $q_slider = db_get_all_data('tbl_slider',array('slider_status' => '1'));
        return $q_slider;
    }
}

if(!function_exists('get_frontend_store')) {
    function get_frontend_store()
    {
        $q_toko = db_get_all_data('tbl_outlets',array('status' => '2'));
        $id_toko = 0;
        if(count($q_toko) > 0)
        {
            $id_toko = $q_toko[0]->outlet_id;
        }
        return $id_toko;
    }
}

if(!function_exists('get_discount_offer')) {
    function get_discount_offer($product_id)
    {
        $offer_price = db_get_all_data('tbl_special_offer',array('product_id' => $product_id));
        $price = 0;
        if(count($offer_price) > 0)
        {
            $today = strtotime(date('Y-m-d'));
            $start_date = strtotime($offer_price[0]->start_date);
            $end_date = strtotime($offer_price[0]->end_date);
            if (($today >= $start_date) && ($today <= $end_date)) {
                $price = $offer_price->offer_price;
            }
        }
        return $price;
    }
}

if(!function_exists('get_product_price')) {
    function get_product_price($product_id)
    {
        $offer_price = db_get_all_data('tbl_product_price',array('product_id' => $product_id));
        $price = 0;
        if(count($offer_price) > 0)
        {
            $price = $offer_price[0]->selling_price;
        }
        return $price;
    }
}

if(!function_exists('get_product_image')) {
    function get_product_image($product_id)
    {
        $image = db_get_all_data('tbl_product_image',array('product_id' => $product_id));
        return $image;
    }
}

if(!function_exists('check_if_sold'))
{
    function check_if_sold($purchase_id)
    {
        $get_product_pur = db_get_all_data('tbl_purchase_product',array('purchase_id' => $purchase_id));
        $ret = false;
        if(count($get_product_pur) > 0)
        {
            foreach ($get_product_pur as $pur)
            {
                $get_order_det = db_get_all_data('tbl_order_details',array('purchase_product_id' => $pur->purchase_product_id));
                if(count($get_order_det) > 0)
                {
                    $ret = true;
                }
            }
        }
        return $ret;
    }
}

if(!function_exists('get_arr_attribute'))
{
    function get_arr_attribute($arr)
    {
        if(is_array($arr))
        {
            $str = '';
            for($i=0;$i<count($arr);$i++)
            {
                $get_attr = db_get_row_data('tbl_attribute',array('attribute_id' => $arr[$i]));
                if($str == '')
                {
                    $str = $get_attr->attribute_name." : ".$get_attr->attribute_value;
                }
                else
                {
                    $str .= ', '.$get_attr->attribute_name." : ".$get_attr->attribute_value;
                }
            }
            return $str;
        }
        else
        {
            $get_attr = db_get_row_data('tbl_attribute',array('attribute_id' => $arr));
            return $get_attr->attribute_name." : ".$get_attr->attribute_value;
        }
    }
}





