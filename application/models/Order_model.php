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

class Order_Model extends MY_Model
{
    public $_table_name;
    public $_order_by;
    public $_primary_key;


    public function get_all_product_info()
    {
        $this->db->select('tbl_product.*', false);
        $this->db->select('tbl_inventory.product_quantity, tbl_inventory.notify_quantity ', false);
        $this->db->from('tbl_product');
        $this->db->where('tbl_product.status', 1);
        $this->db->join('tbl_inventory', 'tbl_inventory.product_id  =  tbl_product.product_id ', 'left');
        $this->db->order_by('tbl_product.product_id', ' DESC');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    function validate_add_cart_item($product_code){

        $this->db->select('tbl_product.*', false);
        $this->db->select('tbl_product_price.buying_price, tbl_product_price.selling_price ', false);
        $this->db->select('tbl_product_image.filename ', false);

        $this->db->from('tbl_product');
        $this->db->where('tbl_product.product_code', $product_code);
        $this->db->join('tbl_product_price', 'tbl_product_price.product_id  =  tbl_product.product_id ', 'left');
        $this->db->join('tbl_product_image', 'tbl_product_image.product_id  =  tbl_product.product_id ', 'left');

        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;

    }

    public function get_tire_price($product_id, $qty)
    {
        $this->db->select('tbl_tier_price.*', false);
        $this->db->from('tbl_tier_price');
        $this->db->where('product_id', $product_id);
        $this->db->where('quantity_above <=', $qty);
        $this->db->order_by('quantity_above', 'DESC');
        $this->db->limit(1);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }

    public function get_customer_details($customer_code)
    {
        $where = "customer_code = $customer_code OR phone = $customer_code ";

        $this->db->select('tbl_customer.*', false);
        $this->db->from('tbl_customer');
        $this->db->where($where);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }

    public function get_all_order()
    {
        $this->db->select('tbl_invoice.*, tbl_order.*', false);
        $this->db->from('tbl_order');
        $this->db->join('tbl_invoice', 'tbl_invoice.order_id  =  tbl_order.order_id ', 'left');
        $this->db->order_by('tbl_order.order_id', ' DESC');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function get_all_invoice()
    {
        $this->db->select('tbl_invoice.*, tbl_order.*', false);
        $this->db->from('tbl_invoice');
        $this->db->join('tbl_order', 'tbl_order.order_id  =  tbl_invoice.order_id ', 'left');
        $this->db->order_by('invoice_id', 'DESC');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function delete_order($id)
    {
        $get_detail = db_get_all_data('tbl_order_details',array('order_id' => $id));
        if(count($get_detail) > 0)
        {
            foreach ($get_detail as $detail)
            {
                $this->db->where(array('order_detail_id' => $detail->order_details_id));
                $this->db->delete('tbl_order_serial');

                $this->db->where(array('order_detail_id' => $detail->order_details_id));
                $this->db->delete('tbl_order_attribute');
            }

            $this->db->where(array('order_id' => $id));
            $this->db->delete('tbl_order_details');

            $this->db->where(array('order_id' => $id));
            $this->db->delete('tbl_invoice');

            $this->db->where(array('order_id' => $id));
            $this->db->delete('tbl_order');
            return true;
        }
        else
        {
            return false;
        }
    }

    public function get_total_piutang_by_customer($customer_id)
    {
        $get_order = $this->get_query_by('tbl_order',array('customer_id' => $customer_id,'payment_method' => 'kredit'));
        $total_piutang = 0;
        if(count($get_order) > 0)
        {
            foreach ($get_order as $order)
            {
                $grand_total = $order->grand_total;
                $get_bayar = $this->get_query_by('tbl_penerimaan_piutang_order',array('order_id' => $order->order_id));
                $total_bayar = 0;
                if(count($get_bayar) > 0)
                {
                    foreach ($get_bayar as $bayar)
                    {
                        $total_bayar = $total_bayar + ($bayar->potongan + $bayar->bayar);
                    }
                }
                $total_piutang = $total_piutang + ($grand_total-$total_bayar);
            }
        }
        return $total_piutang;
    }

    public function get_nota_by_customer($customer_id,$status_nota)
    {
        $get_order = $this->get_query_by('tbl_order',array('customer_id' => $customer_id,'payment_method' => 'kredit','order_status' => $status_nota));
        $nota = '';
        if(count($get_order) > 0)
        {
            foreach ($get_order as $order)
            {
                $grand_total = $order->grand_total;
                $get_bayar = $this->get_query_by('tbl_penerimaan_piutang_order',array('order_id' => $order->order_id));
                $total_bayar = 0;
                if(count($get_bayar) > 0)
                {
                    foreach ($get_bayar as $bayar)
                    {
                        $total_bayar = $total_bayar + ($bayar->potongan + $bayar->bayar);
                    }
                }
                $saldo_piutang = $grand_total-$total_bayar;
                $nota .= '<tr>
                            <td style="vertical-align: middle;"><input type="hidden" name="order_no[]" value="'.$order->order_no.'"><input type="hidden" name="order_id[]" value="'.$order->order_id.'">'.$order->order_no.'</td>
                            <td><input type="text" name="saldo_piutang[]" readonly class="form-control input-saldo" value="'.number_format($saldo_piutang).'"></td>
                            <td style="vertical-align: middle;"><input type="hidden" name="pajak[]" value="'.number_format($order->tax).'">'.number_format($order->tax).'</td>
                            <td><input type="text" name="potongan[]" class="form-control input-potongan" value="0"></td>
                            <td><input type="text" name="bayar[]" class="form-control input-bayar" value="0"></td>
                            <td><input type="text" name="sisa_piutang[]" class="form-control input-sisa" value="0"></td>
                            <td><button type="button" name="hapus" id="hapus" class="btn btn-danger remove_row"><i class="fa fa-trash"></i></button></td>
                          </tr> ';
            }
        }
        return $nota;
    }

    public function delete_debt($id,$master='')
    {
        $check_penerimaan_piutang = db_get_all_data('tbl_penerimaan_piutang_order',array('penerimaan_piutang_id' => $id));
        if(count($check_penerimaan_piutang) > 0)
        {
            foreach ($check_penerimaan_piutang as $terima)
            {
                $data_status = array(
                    'order_status' => BELUM_LUNAS
                );
                $this->db->where('order_id', $terima->order_id);
                $this->db->update('tbl_order', $data_status);

                $this->db->where('piutang_order_id', $terima->piutang_order_id);
                $this->db->delete('tbl_penerimaan_piutang_order');
            }
            if($master == '')
            {
                $this->db->where('piutang_id', $id);
                $this->db->delete('tbl_penerimaan_piutang');
            }

            return true;
        }
        return false;
    }

}
