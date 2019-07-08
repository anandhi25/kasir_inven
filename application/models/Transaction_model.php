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

class Transaction_model extends MY_Model
{
    public $_table_name;
    public $_order_by;
    public $_primary_key;

    public function get_transaction_info($id = null)
    {
        $this->db->select('*');
        $this->db->from('tbl_transaction');
        if (!empty($id)) {
            //specific customer information needed
            $this->db->where('trans_id', $id);
            $query_result = $this->db->get();
            $result = $query_result->row();
        } else {
            //all customer information needed
            $query_result = $this->db->get();
            $result = $query_result->result();
        }

        return $result;
    }
}
