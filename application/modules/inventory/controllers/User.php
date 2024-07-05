<?php

class User extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('inventory_model', 'inventory');
        $this->load->model('location_model', 'location');
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
        $this->users();
    }

    function users()
    {
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
            $view = $this->load->view('inventory/users', '', true);
            $this->template($view);
        } else {
            redirect('forbidden');
        }
    }

    public function insert_user()
    {
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('team_id', 'Team ID', 'required');
        $this->form_validation->set_rules('user_type_id', 'User Type ID', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('location_id', 'Location ID', 'required');

        $first_name    = $this->input->post('first_name');
        $last_name     = $this->input->post('last_name');
        $email         = $this->input->post('email');
        $password      = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        $team_id       = $this->input->post('team_id');
        $user_type_id  = $this->input->post('user_type_id');
        $status        = $this->input->post('status');
        $location_id   = $this->input->post('location_id');

        if ($this->user->verify_user_email($this->db->escape($email))) {
            $response = array('status' => 'error_email_exist', 'message' => 'Email already registered. Please use a different email.');
            echo json_encode($response);
            return;
        }

        if ($this->form_validation->run() == TRUE) {

            $user_form_data = array(
                'user_first_name'   => $first_name,
                'user_last_name'    => $last_name,
                'user_email'        => $email,
                'user_password'     => $password,
                'user_created_at'   => date('Y-m-d H:i:s'),
                'team_id'           => $team_id,
                'user_type_id'      => $user_type_id,
                'user_status'       => $status,
                'user_location_id'  => $location_id,
            );

            if ($this->user->insert_user($user_form_data)) {
                $response = array('status' => 'success', 'message' => 'User added successfully.');
                echo json_encode($response);
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to add user. Please try again.');
                echo json_encode($response);
            }
        }
    }

    function update_user()
    {
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('team_id', 'Team ID', 'required');
        $this->form_validation->set_rules('user_type_id', 'User Type ID', 'required');
        $this->form_validation->set_rules('location_id', 'Location ID', 'required');

        $user_id       = $this->input->post('user_id');
        $first_name    = $this->input->post('first_name');
        $last_name     = $this->input->post('last_name');
        $team_id       = $this->input->post('team_id');
        $user_type_id  = $this->input->post('user_type_id');
        $location_id   = $this->input->post('location_id');

        if ($this->form_validation->run() == TRUE) {

            $updated_user_form_data = array(
                'user_first_name'   => $first_name,
                'user_last_name'    => $last_name,
                'team_id'           => $team_id,
                'user_type_id'      => $user_type_id,
                'user_location_id'  => $location_id,
                'user_updated_at'   => date('Y-m-d H:i:s'),
            );

            if ($this->user->update_user($user_id, $updated_user_form_data)) {
                $response = array('status' => 'success', 'message' => 'User updated successfully.');
                echo json_encode($response);
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to update user. Please try again.');
                echo json_encode($response);
            }
        }
    }

    function delete_user()
    {
        $user_id = $this->input->post('user_id');

        $updated_user_formdata = array(
            'user_status'       => 1,
            'user_deleted_at'   => date('Y-m-d H:i:s'),
            'user_updated_at'   => date('Y-m-d H:i:s')
        );

        if ($this->user->update_user($user_id, $updated_user_formdata)) {
            $response = array('status' => 'success', 'message' => 'User set to Inactive.');
            echo json_encode($response);
        } else {
            $response = array('status' => 'error', 'message' => 'Failed to set user to Inactive. Please try again.');
            echo json_encode($response);
        }
    }

    function get_users()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_email'])) {
            echo json_encode(array('error' => 'Login required.'));
            return;
        }

        $users = $this->user->get_users();

        if (empty($users)) {
            $users = array();
        }

        $data = array();

        foreach ($users as $user) {

            $user_location  = $this->location->get_location_row_by_id($user['user_location_id']);
            $user_type      = $this->user->get_user_type_row($user['user_type_id']);
            $user_team      = $this->user->get_user_team_row($user['team_id']);

            $data[] = array(
                'user_id'       => $user['user_id'],
                'first_name'    => $user['user_first_name'],
                'last_name'     => $user['user_last_name'],
                'full_name'     => $user['user_first_name'] . ' ' . $user['user_last_name'],
                'email'         => $user['user_email'],
                'location'      => $user_location['location_name'],
                'location_id'   => $user['user_location_id'],
                'type'          => $user_type['user_type_name'],
                'type_id'       => $user['user_type_id'],
                'team'          => $user_team['team_name'],
                'team_id'       => $user['team_id'],
                'status'        => $user['user_status'] == 0 ? 'Active' : 'Inactive',
            );
        }

        $output = array(
            "draw"              => intval($this->input->get("draw")),
            "recordsTotal"      => count($data),
            "recordsFiltered"   => count($data),
            "data"              => $data
        );

        echo json_encode($output);
    }
    // USER MANAGEMENT




}
