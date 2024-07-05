<?php

class MY_Controller extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('MY_Model', 'model');
        $this->load->model('user/user_model', 'user');
    }

    function main_template($data = NULL)
    {
        $this->load->view('template/template_main', $data);
    }

    function template($view)
    {
        $current_user_row   = $this->user->get_user_row_by_id($_SESSION['user_id']);
        $current_user_type  = $this->user->get_current_user_type($current_user_row['user_type_id']);
        
        $data = array(
            'current_user_type'         => $current_user_type,
            'current_user_first_name'   => $current_user_row['user_first_name'],
            'current_user_last_name'    => $current_user_row['user_last_name'],
            'current_user_full_name'    => $current_user_row['user_first_name'] . ' ' . $current_user_row['user_last_name'],
            'content'                   => $view
        );

        $this->parser->parse('template', $data);
    }
}
