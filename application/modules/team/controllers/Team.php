<?php

class Team extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('contact_model', 'contact');
        $this->load->model('user/user_model', 'user');
        $this->load->library('parser');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('session');
    }

}
