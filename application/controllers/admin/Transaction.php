<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Transaction extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaction_model');
        $this->load->model('settings_model');

    }

    public function category()
    {

    }
}


?>