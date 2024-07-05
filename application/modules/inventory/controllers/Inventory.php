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
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
            $view = $this->load->view('inventory/dashboard', '', true);
            $this->template($view);
        } else {
            redirect('forbidden');
        }
    }

    function stocks()
    {
        redirect('inventory/stock/stocks');
    }

    function location()
    {
        redirect('inventory/location/locations');
    }

    function category()
    {
        redirect('inventory/category/category');
    }

    function suppliers()
    {
        redirect('inventory/supplier/suppliers');
    }

    function items()
    {
        redirect('inventory/item/items');
    }

    function users()
    {
        redirect('inventory/user/users');
    }

    function reports()
    {
        redirect('inventory/report/reports');
    }

    public function forbidden()
    {
        $this->load->view('inventory/forbidden');
    }
}
