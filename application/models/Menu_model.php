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

class Menu_model extends MY_Model
{
    public $_table_name;
    public $_order_by;
    public $_primary_key;

    public function get_id_menu_type_by_flag($flag = '')
    {
        $flag = str_replace('-', ' ', $flag);

        $query = $this->db->get_where('tbl_menu_type', ['name' => $flag]);

        if ($query->row()) {
            return $query->row()->id;
        }

        return 0;
    }

    public function update_child_menu_by_parent($parent)
    {
        $this->db->where('parent', $parent);
        $result = $this->db->update($this->_table_name, ['parent' => '0']);

        return $result;
    }

    public function get_color_icon()
    {

        $color_icon = ['text-red', 'text-yellow', 'text-aqua', 'text-blue', 'text-black', 'text-light-blue', 'text-green', 'text-gray', 'text-navy', 'text-teal', 'text-olive', 'text-lime', 'text-orange', 'text-fuchsia', 'text-purple', 'text-maroon',];

        return $color_icon;
    }


}
