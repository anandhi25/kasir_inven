<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Page extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('page_model');
        $this->load->model('settings_model');
        $this->load->model('global_Model');

    }

    public function all_page()
    {
        $data['title'] = 'Daftar Halaman';
        $data['subview'] = $this->load->view('admin/page/page_list', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function add_page($id='')
    {
        $judul = 'Tambah Halaman';
        $url_action = base_url('admin/page/save_page');
        if(!empty($id))
        {
            $judul = 'Edit Halaman';
            //$url_action = base_url('admin/settings/edit_account');
            $where = array('page_id' => $id);
            $data['page'] = $this->page_model->check_by($where, 'tbl_page');
        }
        $data['title'] = $judul;
        $data['url_action'] = $url_action;
        $data['subview'] = $this->load->view('admin/page/add_page', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function save_page()
    {
        $title = $this->input->post('title');
        $check = db_get_all_data('tbl_page',array('title' => $title));
        $slug = seo_title($title);
        if(count($check) > 0)
        {
            $slug = seo_title($title).count($check);
        }
        $data_simpan = array(
            'title' => $title,
            'slug' => $slug,
            'description' => $this->input->post('description'),
            'content' => $this->input->post('content'),
            'page_template' => 'default',
        );
        $id = null;
        if(!empty($this->input->post('page_id')))
        {
            $id = $this->input->post('page_id');
        }
        $this->page_model->init_table('tbl_page','page_id');
        $this->page_model->_primary_key = 'page_id';
        $res = $this->page_model->save($data_simpan,$id);
        if($res)
        {
            $this->message->save_success('admin/page/add_page');
        }
        else
        {
            $this->message->custom_error_msg('admin/page/add_page','Data Gagal disimpan');
        }
    }

    public function delete_page($id=null)
    {
        $this->page_model->init_table('tbl_page','page_id');
        $this->page_model->_primary_key = 'page_id';
        $this->page_model->delete($id);
        $this->message->delete_success('admin/page/all_page');
    }

    public function page_table()
    {
        $getData = array();
        $where = '';
        $limit = '';
        $orderby = '';
        $arrCol = array(
            0 => 'title'
        );
        if(isset($_GET["search"]["value"]))
        {
            if ($where == '') {
                $where = "WHERE title LIKE '%".$_GET["search"]["value"]."%'";
            } else {
                $where .= " AND title LIKE '%".$_GET["search"]["value"]."%'";
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
            $orderby = " ORDER BY title ASC";
        }

        if(isset($_GET["length"])) {
            if ($_GET["length"] != -1) {
                $limit = " LIMIT ".$_GET['start'] . ',' . $_GET['length'];
            }
        }
        $list = $this->global_model->get_by_sql("SELECT * FROM tbl_page ".$where.' '.$orderby.' '.$limit);
        $listAll = $this->global_model->get_by_sql("SELECT * FROM tbl_page ".$where);
        $total = count($listAll);
        foreach ($list as $post) {
            $subdata = array();
            $subdata[] = $post->title;
            $subdata[] = $post->description;
            $subdata[] = btn_edit(base_url('admin/page/add_page/'.$post->page_id)).' '.btn_delete(base_url('admin/page/delete_page/'.$post->page_id));
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