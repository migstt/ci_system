<?php

class Report extends MY_Controller
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
        $this->reports();
    }

    function reports()
    {
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
            $view = $this->load->view('inventory/reports', '', true);
            $this->template($view);
        } else {
            redirect('forbidden');
        }
    }
}
