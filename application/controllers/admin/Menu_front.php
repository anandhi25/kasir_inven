<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Menu_front extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('menu_model');
        $this->load->model('settings_model');
        $this->load->model('global_Model');
    }

    public function index($type = null)
    {
        if (!$this->menu_model->get_id_menu_type_by_flag($type)) {
            redirect('admin/menu_front/index/main-menu');
        }

        $data['title'] = 'Daftar Menu';
        $data['subview'] = $this->load->view('admin/menu/menu_list', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function add_menu($menu_type ='')
    {
        $menu_type_id = $this->menu_model->get_id_menu_type_by_flag($menu_type);
        $data = [
            'menu_type_id' 		=> $menu_type_id,
            'color_icon'		=> $this->menu_model->get_color_icon(),
            'url_action' => base_url('admin/menu_front/add_save')
        ];
        $data['title'] = 'Tambah Menu';
        $data['subview'] = $this->load->view('admin/menu/add_menu', $data, true);
        $this->load->view('admin/_layout_main', $data);

    }

    public function edit($id ='')
    {
        $row_menu = db_get_row_data('tbl_menu_front',array('id' => $id));
        $data = [
            'menu_type_id' 		=> $row_menu->menu_type_id,
            'color_icon'		=> $this->menu_model->get_color_icon(),
            'url_action' => base_url('admin/menu_front/add_save')
        ];
        $data['title'] = 'Edit Menu';
        $data['menu'] = $row_menu;
        $data['subview'] = $this->load->view('admin/menu/add_menu', $data, true);
        $this->load->view('admin/_layout_main', $data);

    }

    private function _parse_menu($menus, $parent = '')
    {
        $data = [];
        foreach ($menus as $menu) {
            $this->sort++;
            $this->menus[] = [
                'id' => $menu['id'],
                'sort' => $this->sort,
                'parent' => $parent
            ];
            if (isset($menu['children'])) {
                $this->_parse_menu($menu['children'], $menu['id']);
            }
        }
    }

    public function set_status()
    {

        $status = $this->input->post('status');
        $id = $this->input->post('id');

       $data_simpan = array(
            'active' => $status
        );

        $this->menu_model->init_table('tbl_menu_front','id');
        $this->menu_model->_primary_key = 'id';
        $update_status = $this->menu_model->save($data_simpan,$id);

        if ($update_status) {
            echo json_encode([
                'success' => true,
                'message' => 'Menu status updated to '.($status == 1 ? 'active' : 'inactive'),
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Data gagal disimpan'
            ]);
        }

    }

    public function save_ordering()
    {
        $this->menus = [];
        $this->sort = 0;
        $this->_parse_menu($_POST['menu']);
        $save_ordering = $this->db->update_batch('tbl_menu_front', $this->menus, 'id');
        if ($save_ordering) {
            $this->data = [
                'success' => true,
                'message' => 'Sukses'
            ];
        } else {
            $this->data = [
                'success' => false,
                'message' => 'Gagal'
            ];
        }

        echo json_encode($this->data);
    }

    public function add_save()
    {
        $total = db_get_all_data('tbl_menu_front');
        $data_simpan = array(
            'label' 		=> $this->input->post('label'),
            'link' 			=> $this->input->post('link'),
            'icon' 			=> $this->input->post('icon'),
            'parent' 		=> $this->input->post('parent'),
            'menu_type_id' 	=> $this->input->post('menu_type_id'),
            'type' 			=> $this->input->post('type'),
            'icon_color' 	=> $this->input->post('icon_color'),
            'sort' 			=> 1,
            'active' 	    => 1
        );
        $id = null;
        if(!empty($this->input->post('id_menu')))
        {
            $id = $this->input->post('id_menu');
        }
        $this->menu_model->init_table('tbl_menu_front','id');
        $this->menu_model->_primary_key = 'id';
        $res = $this->menu_model->save($data_simpan,$id);
        if($res)
        {
            $this->message->save_success('admin/menu_front');
        }
        else
        {
            $this->message->custom_error_msg('admin/menu_front','Data gagal disimpan');
        }
    }

    public function add_menu_type()
    {
        $judul = 'Tambah Tipe Menu';
        $url_action = base_url('admin/menu_front/save_menu_type');
        $data['title'] = $judul;
        $data['url_action'] = $url_action;
        $data['modal_subview'] = $this->load->view('admin/menu/add_menu_type_modal', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);
    }

    public function save_menu_type($id=null)
    {
        $data_simpan = array(
            'name' => $this->input->post('name_menu'),
            'definition' => $this->input->post('description'),
        );
        $this->menu_model->init_table('tbl_menu_type','id');
        $this->menu_model->_primary_key = 'id';
        $res = $this->menu_model->save($data_simpan,$id);
        if($res)
        {
            $arr = array(
                'success' => true
            );
            $type = 'success';
            $message = 'Your record has been saved successfully!';
            set_message($type, $message);
        }
        else
        {
            $arr = array(
                'success' => false
            );
        }
        echo json_encode($arr);
    }

    public function delete_type($id)
    {
        $cek_menu = db_get_all_data('tbl_menu_front',array('menu_type_id' => $id));
        if(count($cek_menu) > 0)
        {
            $this->menu_model->init_table('tbl_menu_front','id');
            $this->menu_model->_primary_key = 'id';
            $this->menu_model->delete_all(array('menu_type_id' => $id));
        }
        $this->menu_model->init_table('tbl_menu_type','id');
        $this->menu_model->_primary_key = 'id';
        $this->menu_model->delete($id);
        $this->message->delete_success('admin/menu_front');
    }

}