<?php
/**
 * Created by PhpStorm.
 * User: anandhi
 * Date: 7/17/19
 * Time: 10:36 PM
 */

class Web extends FrontController
{
    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        $data['title'] = get_profile()->company_name;
        $data['content'] = 'home';
       // print_r($this->load->view('admin/customer/modal', $data, false));
        $this->render($data);
    }
}

?>