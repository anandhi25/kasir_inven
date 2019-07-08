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

class Outlet_model extends MY_Model
{
    public $_table_name;
    public $_order_by;
    public $_primary_key;

    public function get_outlet_info($id = null) // this function is to get all customer info from tbl customer and tbl_customer_group
    {
        $this->db->select('*');
        $this->db->from('tbl_outlets');
        if (!empty($id)) {
            //specific customer information needed
            $this->db->where('outlet_id', $id);
            $query_result = $this->db->get();
            $result = $query_result->row();
        } else {
            //all customer information needed
            $query_result = $this->db->get();
            $result = $query_result->result();
        }

        return $result;
    }

    public function get_outlet_detail()
    {
        // this function is to get all customer info blank
        $post = new stdClass();
        $post->name = '';
        $post->address = '';
        $post->contact_number = '';
        $post->receipt_header = '';
        $post->receipt_footer = '';
        $post->created_user_id = '0';
        $post->created_datetime = '';
        $post->updated_user_id = '0';
        $post->updated_datetime = '';
        $post->status = '0';

        return $post;
    }
}
