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
        $arr_ret = '';
        if(!empty($product_code)) {
            $sql = "SELECT t.* FROM tbl_purchase p, tbl_purchase_product t WHERE t.product_code = '$product_code' AND p.purchase_id = t.purchase_id AND t.sisa_qty <> '0' ORDER BY p.datetime ASC ";
            $res = $this->get_by_sql($sql);
            $arr_ret = '';
            if (count($res) > 0) {
                foreach ($res as $r) {
                    if ($r->sisa_qty >= $qty) {
                        $sisa = $r->sisa_qty - $qty;
                        $this->_table_name = 'tbl_purchase_product';
                        $this->_primary_key = 'purchase_product_id';
                        $data = array(
                            'sisa_qty' => $sisa
                        );
                        $this->save($data, $r->purchase_product_id);
                        $arr_ret = array(
                            'unit_price' => $r->unit_price,
                            'purchase_product_id' => $r->purchase_product_id
                        );
                        break;
                    } else {
                        $qty = $qty - $r->sisa_qty;
                        $this->_table_name = 'tbl_purchase_product';
                        $this->_primary_key = 'purchase_product_id';
                        $data = array(
                            'sisa_qty' => '0'
                        );
                        $this->save($data, $r->purchase_product_id);
                    }
                }
            }
        }
        return $arr_ret;
    }

    public function delete_purchase($id)
    {
        $get_detail = db_get_all_data('tbl_purchase_product',array('purchase_id' => $id));
        if(count($get_detail) > 0)
        {
            foreach ($get_detail as $detail)
            {
                $this->db->where(array('purchase_product_id' => $detail->purchase_product_id));
                $this->db->delete('tbl_purchase_serial');

                $this->db->where(array('purchase_product_id' => $detail->purchase_product_id));
                $this->db->delete('tbl_purchase_attribute');
            }

            $this->db->where(array('purchase_id' => $id));
            $this->db->delete('tbl_purchase_product');

            $this->db->where(array('purchase_id' => $id));
            $this->db->delete('tbl_purchase');
            return true;
        }
        else
        {
            return false;
        }
    }

    public function get_total_hutang_by_supplier($supplier_id)
    {
        $get_purchase = $this->get_query_by('tbl_purchase',array('supplier_id' => $supplier_id,'payment_method' => 'kredit'));
        $total_hutang = 0;
        if(count($get_purchase) > 0)
        {
            foreach ($get_purchase as $pur)
            {
                $grand_total = $pur->grand_total;
                $get_bayar = $this->get_query_by('tbl_pembayaran_hutang_purchase',array('purchase_id' => $pur->purchase_id));
                $total_bayar = 0;
                if(count($get_bayar) > 0)
                {
                    foreach ($get_bayar as $bayar)
                    {
                        $total_bayar = $total_bayar + ($bayar->potongan + $bayar->bayar);
                    }
                }
                $total_hutang = $total_hutang + ($grand_total-$total_bayar);
            }
        }
        return $total_hutang;
    }

    public function get_nota_by_supplier($supplier_id,$status_nota)
    {
        $get_purchase = $this->get_query_by('tbl_purchase',array('supplier_id' => $supplier_id,'payment_method' => 'kredit','status_purchase' => $status_nota));
        $nota = '';
        if(count($get_purchase) > 0)
        {
            foreach ($get_purchase as $pur)
            {
                $grand_total = $pur->grand_total;
                $get_bayar = $this->get_query_by('tbl_pembayaran_hutang_purchase',array('purchase_id' => $pur->purchase_id));
                $total_bayar = 0;
                if(count($get_bayar) > 0)
                {
                    foreach ($get_bayar as $bayar)
                    {
                        $total_bayar = $total_bayar + ($bayar->potongan + $bayar->bayar);
                    }
                }
                $saldo_hutang = $grand_total - $total_bayar;
                $nota .= '<tr>
                            <td style="vertical-align: middle;"><input type="hidden" name="order_no[]" value="'.$pur->order_no.'"><input type="hidden" name="purchase_id[]" value="'.$pur->purchase_id.'">'.$pur->order_no.'</td>
                            <td><input type="text" name="saldo_hutang[]" readonly class="form-control input-saldo" value="'.number_format($saldo_hutang).'"></td>
                            <td style="vertical-align: middle;"><input type="hidden" name="pajak[]" value="'.number_format($pur->tax).'">'.number_format($pur->tax).'</td>
                            <td><input type="text" name="potongan[]" class="form-control input-potongan" value="0"></td>
                            <td><input type="text" name="bayar[]" class="form-control input-bayar" value="0"></td>
                            <td><input type="text" name="sisa_hutang[]" class="form-control input-sisa" value="0"></td>
                            <td><button type="button" name="hapus" id="hapus" class="btn btn-danger remove_row"><i class="fa fa-trash"></i></button></td>
                          </tr> ';
            }
        }
        return $nota;
    }

    public function delete_pay($id,$master='')
    {
        $check_pembayaran_hutang = db_get_all_data('tbl_pembayaran_hutang_purchase',array('pembayaran_hutang_id' => $id));
        if(count($check_pembayaran_hutang) > 0)
        {
            foreach ($check_pembayaran_hutang as $bayar)
            {
                $data_status = array(
                    'status_purchase' => BELUM_LUNAS
                );
                $this->db->where('purchase_id', $bayar->purchase_id);
                $this->db->update('tbl_purchase', $data_status);

                $this->db->where('hutang_purchase_id', $bayar->hutang_purchase_id);
                $this->db->delete('tbl_pembayaran_hutang_purchase');
            }
            if($master == '')
            {
                $this->db->where('hutang_id', $id);
                $this->db->delete('tbl_pembayaran_hutang');
            }

            return true;
        }
        return false;
    }


}