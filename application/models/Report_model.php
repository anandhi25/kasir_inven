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

class Report_Model extends MY_Model
{
    //put your code here
    public $_table_name;
    public $_order_by;
    public $_primary_key;

    public function get_invoice_by_date($start_date, $end_date, $outlet='0')
    {
        $this->db->select('tbl_invoice.*', false);
        $this->db->select('tbl_order.*', false);
        $this->db->from('tbl_invoice');
        $this->db->join('tbl_order', 'tbl_order.order_id  =  tbl_invoice.order_id', 'left');
        if($outlet != '0')
        {
            $this->db->where('outlet_id', $outlet);
        }
        if ($start_date == $end_date) {
            $this->db->like('tbl_invoice.invoice_date', $start_date);
        } else {

            $this->db->where('tbl_invoice.invoice_date >=', $start_date);
            $this->db->where('tbl_invoice.invoice_date <=', $end_date.'23:59:59');
        }
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    public function get_purchase_by_date($start_date, $end_date,$outlet='0')
    {
        $this->db->select('tbl_purchase.*', false);
        $this->db->from('tbl_purchase');
        if($outlet != '0')
        {
            $this->db->where('outlet_id', $outlet);
        }
        if ($start_date == $end_date) {
            $this->db->like('datetime', $start_date);
        } else {

            $this->db->where('datetime >=', $start_date);
            $this->db->where('datetime <=', $end_date.'23:59:59');
        }
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    public function get_order_by_date($start_date, $end_date, $outlet='0',$filter='total')
    {
        $this->db->select('*', false);
        $this->db->from('tbl_order');
        if($outlet != '0')
        {
            $this->db->where('outlet_id', $outlet);
        }
        if($filter == 'kredit')
        {
            $this->db->where('payment_method', 'kredit');
        }
        if($filter == 'cash')
        {
            $this->db->where('payment_method', 'cash');
        }

        if ($start_date == $end_date) {
            $this->db->like('order_date', $start_date);
        } else {

            $this->db->where('order_date >=', $start_date);
            $this->db->where('order_date <=', $end_date.'23:59:59');
        }
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }


}
