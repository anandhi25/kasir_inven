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
                $data['purchase_details'][$v_invoice->purchase_order_number] = $this->global_model->get_by(array('purchase_id' => $v_invoice->purchase_id),
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



}
