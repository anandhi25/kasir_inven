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
                'message' => 'sukses'
            ];
        } else {
            $this->data = [
                'success' => false,
                'message' => 'Data_Gagal'
            ];
        }

        echo json_encode($this->data);
    }

    public function add_save($id=null)
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

        $this->menu_model->init_table('tbl_menu_front','id');
        $this->menu_model->_primary_key = 'id';
        $res = $this->menu_model->save($data_simpan,$id);
        if($res)
        {

        }
        else
        {
            echo 'error';
        }
    }

}