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
        $current_user_row           = $this->user->get_user_row_by_id($_SESSION['user_id']);
        $current_user_type          = $this->user->get_current_user_type($current_user_row['user_type_id']);
        $current_user_first_name    = $current_user_row['user_first_name'];
        $current_user_last_name     = $current_user_row['user_last_name'];
        $current_user_full_name     = $current_user_first_name . ' ' . $current_user_last_name;

        $data = array(
            'current_user_type'         => $current_user_type,
            'current_user_first_name'   => $current_user_first_name,
            'current_user_last_name'    => $current_user_last_name,
            'current_user_full_name'    => $current_user_full_name
        );
        $data['content'] = $this->load->view('inventory/reports', '', true);
        $this->parser->parse('template', $data);
    }
}
