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

class MY_Install
{
    public function __construct()
    {
        $CI = &get_instance();
        $CI->load->database();
        if ($CI->db->database == '') {
            $arraydata = array(
                'install_flag'  => 'install',
            );

            $this->session->set_userdata($arraydata);

            header('location:install/');
        } else {

            //query from installer tbl
            $installer = $CI->db->query('SELECT installer_flag FROM installer');

            $item = $installer->result_array();

            $flag = $item[0]['installer_flag'];
            // if installer_flag = 0
            if ($flag == 0) {
                // make it 1
                $CI->db->query('UPDATE installer SET installer_flag=1 WHERE id=1');
                redirect('install/create_user','refresh');
            }
            //run this code
            //else nothing
        }
    }
}
