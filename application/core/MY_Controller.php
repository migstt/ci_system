<?php

class MY_Controller extends MX_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('MY_Model', 'model');
    }

    function main_template($data = NULL)
    {
        $this->load->view('template/template_main', $data);
    }
}
