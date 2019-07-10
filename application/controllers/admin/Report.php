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

class Report extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('report_model');
        $this->load->model('global_model');
        $this->load->model('outlet_model');
    }


    /*** Sales Report ***/
    public function sales_report()
    {
        $data['title'] = 'View Sales Report';

        $start_date = $this->input->post('start_date', true);
        $end_date = $this->input->post('end_date', true);

        // report date
        $data['start_date'] = date('Y-m-d', strtotime($start_date));
        $data['end_date'] = date('Y-m-d', strtotime($end_date));
        // invoice information
        $invoice = $this->report_model->get_invoice_by_date($data['start_date'], $data['end_date']);

        if (!empty($invoice)) {
            $this->tbl_order_details('order_details_id');
            foreach ($invoice as $v_invoice) {
                $data['invoice_details'][$v_invoice->invoice_no] = $this->global_model->get_by(array('order_id' => $v_invoice->order_id),
                    false);
                $data['order'][] = $v_invoice;
            }
        }

        $data['subview'] = $this->load->view('admin/report/sales_report', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Generate PDF Sales Report ***/
    public function pdf_sales_report()
    {
        $start_date = $this->input->post('start_date', true);
        $end_date = $this->input->post('end_date', true);


        $data['start_date'] = date('Y-m-d', strtotime($start_date));
        $data['end_date'] = date('Y-m-d', strtotime($end_date));
        // invoice information
        $invoice = $this->report_model->get_invoice_by_date($data['start_date'], $data['end_date']);

        if (!empty($invoice)) {
            $this->tbl_order_details('order_details_id');
            foreach ($invoice as $v_invoice) {
                $data['invoice_details'][$v_invoice->invoice_no] = $this->global_model->get_by(array('order_id' => $v_invoice->order_id),
                    false);
                $data['order'][] = $v_invoice;
            }
        }

        foreach ($data['invoice_details'] as $invoice => $v_order) {
            $buying_price = 0;
            foreach ($v_order as $v_order_details) {

                $buying_price += $v_order_details->buying_price;
            }
            $data['total_buying'][] = $buying_price;
        }

        $html = $this->load->view('admin/report/sales_report_pdf', $data, true);


        $filename = 'INV-' . $start_date . ' to ' . $end_date;
        $this->load->library('pdf');
        $pdf = $this->pdf->load();

        $pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}|' . date(DATE_RFC822));
        $pdf->WriteHTML($html);
        $pdf->Output($filename, 'D');

    }

    /*** purchase Report ***/
    public function purchase_report()
    {
        $data['title'] = 'View Purchase Report';

        $start_date = $this->input->post('start_date', true);
        $end_date = $this->input->post('end_date', true);

        // report date
        $data['start_date'] = date('Y-m-d', strtotime($start_date));
        $data['end_date'] = date('Y-m-d', strtotime($end_date));
        // invoice information
        $invoice = $this->report_model->get_purchase_by_date($data['start_date'], $data['end_date']);


        if (!empty($invoice)) {
            $this->tbl_purchase_product('purchase_product_id');
            foreach ($invoice as $v_invoice) {
                $data['purchase_details'][$v_invoice->order_no] = $this->global_model->get_by(array('purchase_id' => $v_invoice->purchase_id),
                    false);
                $data['purchase'][] = $v_invoice;
            }
        }


        $data['subview'] = $this->load->view('admin/report/purchase_report', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** PDF Purchase Report ***/
    public function pdf_purchase_report()
    {
        $start_date = $this->input->post('start_date', true);
        $end_date = $this->input->post('end_date', true);


        $data['start_date'] = date('Y-m-d', strtotime($start_date));
        $data['end_date'] = date('Y-m-d', strtotime($end_date));

        $invoice = $this->report_model->get_purchase_by_date($data['start_date'], $data['end_date']);


        if (!empty($invoice)) {
            $this->tbl_purchase_product('purchase_product_id');
            foreach ($invoice as $v_invoice) {
                $data['purchase_details'][$v_invoice->purchase_order_number] = $this->global_model->get_by(array('purchase_id' => $v_invoice->purchase_id),
                    false);
                $data['purchase'][] = $v_invoice;
            }
        }



        $html = $this->load->view('admin/report/purchase_report_pdf', $data, true);


        $filename = 'PUR-'.$start_date.' to '.$end_date;
        $this->load->library('pdf');
        $pdf = $this->pdf->load();

        $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822));
        $pdf->WriteHTML($html);
        $pdf->Output($filename, 'D');

    }

    public function stock_report()
    {
        $data['title'] = 'Stock Report';
        $data['outlets'] = $this->outlet_model->get_outlet_info();
        $data['subview'] = $this->load->view('admin/report/stock_report', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function stock_table()
    {
        $getData = array();
        $where = '';
        $limit = '';
        $orderby = '';
        $arrCol = array(
            0 => 'product_name',
            1 => 'product_code'
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
            $subdata[] = $post->product_name;
            $subdata[] = $post->product_code;
            $outlets = $this->outlet_model->get_outlet_info();
            if(count($outlets) > 0)
            {
                foreach ($outlets as $out)
                {
                    $stock = get_stock($post->product_code,$out->outlet_id);
                    $subdata[] = $stock;
                }
            }
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

    public function profit_loss_report()
    {
        $data['title'] = 'Laporan Laba Rugi';
        if($this->input->post('start_date', true))
        {
            $start_date = $this->input->post('start_date', true);
            $end_date = $this->input->post('end_date', true);

            // report date
            $data['start_date'] = date('Y-m-d', strtotime($start_date));
            $data['end_date'] = date('Y-m-d', strtotime($end_date));
            $data['jual_bersih'] = $this->get_penjualan_bersih($data['start_date'],$data['end_date']);
            $data['hpp'] = $this->get_harga_pokok_penjualan($data['start_date'],$data['end_date']);
            $data['profit_loss'] = 'OK';
            $data['category_income'] = db_get_all_data('tbl_trans_category',array('trans_type' => 'pendapatan'));
            $data['category_expense'] = db_get_all_data('tbl_trans_category',array('trans_type' => 'pengeluaran'));
            $data['pendapatan'] = $this->get_total_category($data['start_date'],$data['end_date'],$data['category_income']);
            $data['beban'] = $this->get_total_category($data['start_date'],$data['end_date'],$data['category_expense']);
        }


        $data['subview'] = $this->load->view('admin/report/profit_loss_report', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    private function get_penjualan_bersih($start,$end,$outlet_id='0')
    {
        $sql = "SELECT SUM(subtotal) as jual_bersih FROM tbl_order WHERE order_date BETWEEN '$start' AND '$end'";
        $res = db_get_all_data_by_query($sql);
        $total = 0;
        if(count($res) > 0)
        {
            $total = $res[0]->jual_bersih;
        }
        return $total;
    }

    private function get_total_category($start,$end,$cat,$outlet_id='0')
    {
        $ret_blk = array();
        if(count($cat) > 0)
        {
            foreach ($cat as $r)
            {
                $sql = "SELECT SUM(nominal) as total_category FROM tbl_transaction WHERE category_id = '".$r->category_id."' AND trans_date BETWEEN '$start' AND '$end'";
                $res = db_get_all_data_by_query($sql);
                $total = 0;
                if(count($res) > 0)
                {
                    $total = $res[0]->total_category;
                }
                $sub_data['trans_name'] = $r->trans_name;
                $sub_data['total'] = $total;
                $ret_blk[] = $sub_data;
            }
        }
        return $ret_blk;
    }

    private function get_harga_pokok_penjualan($start,$end,$outlet_id='0')
    {
        $sql = "SELECT SUM(d.buying_price * d.product_quantity) as harga_beli FROM tbl_order o,tbl_order_details d WHERE o.order_id = d.order_id AND o.order_date BETWEEN '$start' AND '$end'";
        $res = db_get_all_data_by_query($sql);
        $total = 0;
        if(count($res) > 0)
        {
            $total = $res[0]->harga_beli;
        }
        return $total;
    }


}
