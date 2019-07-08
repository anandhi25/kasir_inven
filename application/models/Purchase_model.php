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

class Purchase_Model extends MY_Model
{
    public $_table_name;
    public $_order_by;
    public $_primary_key;

    public function get_all_product_info()
    {
        $this->db->select('tbl_product.*', false);
        $this->db->select('tbl_inventory.product_quantity, tbl_inventory.notify_quantity ', false);
        $this->db->from('tbl_product');
        $this->db->join('tbl_inventory', 'tbl_inventory.product_id  =  tbl_product.product_id ', 'left');

        $this->db->order_by('tbl_product.product_id', ' DESC');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }
    // Add an item to the cart
    function validate_add_cart_item(){

        $id = $this->input->post('product_id'); // Assign posted product_id to $id

        $this->db->select('tbl_product.*', false);
        $this->db->select('tbl_product_price.buying_price ', false);
        $this->db->from('tbl_product');
        $this->db->where('tbl_product.product_id', $id);
        $this->db->join('tbl_product_price', 'tbl_product_price.product_id  =  tbl_product.product_id ', 'left');
        $query_result = $this->db->get();
        $result = $query_result->row();

        if($result) {
            if ($result->buying_price <= 1) {
                $price = 1;
            } else {
                $price = $result->buying_price;
            }

            $data = array(
                'id' => $result->product_code,
                'qty' => 1,
                'price' => $price,
                'name' => $result->product_name
            );
            $this->cart->insert($data);
            return true;
        }else
        {
            return false;
        }
    }

    public function select_purchase_by_id($id = null)
    {
        $this->db->select('tbl_purchase.*, tbl_supplier.* ', false);
        $this->db->from('tbl_purchase');
        $this->db->where('tbl_purchase.purchase_id', $id);
        $this->db->join('tbl_supplier', 'tbl_supplier.supplier_id  =  tbl_purchase.supplier_id ', 'left');
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }

    public function fifo($qty,$product_code)
    {
        $sql = "SELECT t.* FROM tbl_purchase p, tbl_purchase_product t WHERE t.product_code = '$product_code' AND p.purchase_id = t.purchase_id AND t.sisa_qty <> '0' ORDER BY p.datetime ASC ";
        $res = $this->get_by_sql($sql);
        $arr_ret = '';
        if(count($res) > 0)
        {
            foreach ($res as $r)
            {
                if($r->sisa_qty >= $qty)
                {
                    $sisa = $r->sisa_qty - $qty;
                    $this->_table_name = 'tbl_purchase_product';
                    $this->_primary_key = 'purchase_product_id';
                    $data = array(
                        'sisa_qty' => $sisa
                    );
                    $this->save($data,$res->purchase_product_id);
                    $arr_ret = array(
                        'unit_price' => $r->unit_price,
                        'purchase_product_id' => $r->purchase_product_id
                    );
                    break;
                }
                else
                {
                    $qty = $qty - $r->sisa_qty;
                    $this->_table_name = 'tbl_purchase_product';
                    $this->_primary_key = 'purchase_product_id';
                    $data = array(
                        'sisa_qty' => '0'
                    );
                    $this->save($data,$res->purchase_product_id);
                }
            }
        }
        return $arr_ret;
    }


}