<?php

class MY_Controller extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('MY_Model', 'model');
        $this->load->model('user/user_model', 'user');
        $this->load->model('inventory/category_model', 'category');
        $this->load->model('inventory/location_model', 'location');
    }

    function main_template($data = NULL)
    {
        $this->load->view('template/template_main', $data);
    }

    function template($view)
    {
        $current_user_row           = $this->user->get_user_row_by_id($_SESSION['user_id']);
        $current_user_type          = $this->user->get_current_user_type($current_user_row['user_type_id']);
        $current_user_first_name    = $current_user_row['user_first_name'];
        $current_user_last_name     = $current_user_row['user_last_name'];
        $current_user_full_name     = $current_user_first_name . ' ' . $current_user_last_name;
        $active_categories          = $this->category->get_active_categories();
        $active_locations           = $this->location->get_active_locations();
        
        $data = array(
            'current_user_type'         => $current_user_type,
            'current_user_first_name'   => $current_user_first_name,
            'current_user_last_name'    => $current_user_last_name,
            'current_user_full_name'    => $current_user_full_name,
            'active_categories'         => $active_categories,
            'active_locations'          => $active_locations
        );

        $data['content'] = $view;

        $this->parser->parse('template', $data);
    }
}
