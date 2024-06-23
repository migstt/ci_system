<?php

class Home extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('home_model', 'home');
    }

    function index()
    {
        $this->load->view('home/home');
    }
}
