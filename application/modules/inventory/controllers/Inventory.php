<?php

class Inventory extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('inventory_model', 'inventory');
        $this->load->model('user/user_model', 'user');
        $this->load->model('team/team_model', 'team');
        $this->load->library('parser');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('session');
    }

    function index()
    {
        $this->dashboard();
    }

    function dashboard()
    {
        $this->load->view('inventory/dashboard');
    }

    function stocks()
    {
        $this->load->view('inventory/stocks');
    }

    function location()
    {
        $this->load->view('inventory/location');
    }

    function category()
    {
        $this->load->view('inventory/category');
    }

    function suppliers()
    {
        $this->load->view('inventory/suppliers');
    }

    function items()
    {
        $this->load->view('inventory/items');
    }

    function reports()
    {
        $this->load->view('inventory/reports');
    }

    function users()
    {
        $this->load->view('inventory/users');
    }

}
