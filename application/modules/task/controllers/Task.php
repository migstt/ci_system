<?php

class Task extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('task_model', 'task');
        $this->load->model('user/user_model', 'user');
        $this->load->library('parser');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('session');
    }

    function index()
    {
        $this->tasks();
    }

    public function tasks()
    {
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

            $data['user_id']        = $_SESSION['user_id'];
            $data['user_email']     = $_SESSION['user_email'];
            $data['current_user']   = $this->user->get_user_row($this->db->escape($_SESSION['user_email']));
            $data['user_options']   = array('Default' => 'Select user to assign');
            $users_except_current   = $this->get_other_users_except_current($_SESSION['user_id']);
            $total_task_rows     = $this->task->count_user_specific_tasks($_SESSION['user_id']);

            // pagination config
            $config["base_url"]         = base_url() . "index.php/task/tasks";
            $config["total_rows"]       = $total_task_rows;
            $config["per_page"]         = 5;
            $config["uri_segment"]      = 3;
            $config['full_tag_open']    = '<ul class="pagination">';
            $config['full_tag_close']   = '</ul>';
            $config['attributes']       = ['class' => 'page-link'];
            $config['first_link']       = false;
            $config['last_link']        = false;
            $config['first_tag_open']   = '<li class="page-item">';
            $config['first_tag_close']  = '</li>';
            $config['prev_link']        = '&laquo';
            $config['prev_tag_open']    = '<li class="page-item">';
            $config['prev_tag_close']   = '</li>';
            $config['next_link']        = '&raquo';
            $config['next_tag_open']    = '<li class="page-item">';
            $config['next_tag_close']   = '</li>';
            $config['last_tag_open']    = '<li class="page-item">';
            $config['last_tag_close']   = '</li>';
            $config['cur_tag_open']     = '<li class="page-item active"><a href="#" class="page-link">';
            $config['cur_tag_close']    = '<span class="sr-only"></span></a></li>';
            $config['num_tag_open']     = '<li class="page-item">';
            $config['num_tag_close']    = '</li>';

            $this->pagination->initialize($config);

            $page = $this->uri->segment(3);
            $data["links"]      = $this->pagination->create_links();

            // paginated
            // $data['contacts']   = $this->task->get_user_specific_contacts($_SESSION['user_id'], $config["per_page"], $page);
            // not paginated
            $data['tasks']   = $this->task->get_user_specific_tasks($_SESSION['user_id'], 0, 0);

            foreach ($users_except_current as $user) {
                $data['user_options'][$user['user_id']] = $user['user_first_name'] . ' ' . $user['user_last_name'];
            }
            if (!is_array($data['tasks'])) {
                $data['tasks'] = array();
            }

            $this->load->view('task/tasks', $data);
        } else {
            redirect('login');
        }
    }

    public function get_task()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if (!isset($_SESSION['user_id'])) {
            echo json_encode(array('error' => 'User ID not set in session.'));
            return;
        }

        $tasks = $this->task->get_user_specific_tasks($_SESSION['user_id'], 0, 0);

        if ($tasks === false) {
            echo json_encode(array('error' => 'Error retrieving tasks.'));
        } else {
            $data = array();
            foreach ($tasks as $task) {
                $data[] = array(
                    'task_id'       => $task->task_id,
                    'title'         => $task->task_title,
                    'description'   => $task->description,
                    'assigned_to'   => $task->task_assigned_to,
                    'assigned_by'   => $task->task_assigned_by,
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
    }

    function insert_task()
    {
        $this->form_validation->set_rules('title', 'Task title', 'required');
        $this->form_validation->set_rules('description', 'Task description', 'required');
        $this->form_validation->set_rules('assigned_to', 'Assigned to', 'required');


        if ($this->form_validation->run() == TRUE) {

            $firstname      = $this->input->post('title');
            $lastname       = $this->input->post('description');
            $assigned_to    = $this->input->post('assigned_to');

            $task_formdata = array(
                'task_assigned_by' => $_SESSION['user_id'],
                'task_title'       => $firstname,
                'task_description' => $lastname,
                'task_assigned_to' => $assigned_to,
                'task_status'      => 'pending',
                'task_created_at'  => date('Y-m-d H:i:s'),
                'task_updated_at'  => null,
                'task_completed_at'=> null,
                'task_is_deleted'  => 0,
            );  

            if ($this->task->insert_task($task_formdata, $_SESSION['user_id'])) {
                $this->session->set_flashdata('success', 'Contact added successfully!');
            } else {
                $this->session->set_flashdata('error', 'Contact not added!');
            }
        }
    }

    function update_task()
    {
        $tasks_id = $this->input->post('tasks_id');
        $user_id    = $_SESSION['user_id'];

        $this->form_validation->set_rules('firstname', 'First name', 'required');
        $this->form_validation->set_rules('lastname', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('phone', 'Phone number', 'required');
        $this->form_validation->set_rules('companyname', 'Company name', 'required');

        if ($this->form_validation->run() == TRUE) {

            $firstname      = $this->input->post('firstname');
            $lastname       = $this->input->post('lastname');
            $email          = $this->input->post('email');
            $phone          = $this->input->post('phone');
            $companyname    = $this->input->post('companyname');

            $updated_tasks_formdata = array(
                'tasks_first_name'    => $firstname,
                'tasks_last_name'     => $lastname,
                'tasks_email'         => $email,
                'tasks_phone'         => $phone,
                'tasks_company_name'  => $companyname,
                'tasks_updated_at'    => date('Y-m-d H:i:s')
            );

            if ($this->task->update_contact($user_id, $tasks_id, $updated_tasks_formdata)) {
                $this->session->set_flashdata('success', 'Contact updated successfully!');
            } else {
                $this->session->set_flashdata('error', 'Failed to update contact!');
            }
        }
    }

    function delete_task()
    {
        $tasks_id = $this->input->post('tasks_id');
        $user_id    = $_SESSION['user_id'];

        $updated_tasks_formdata = array(
            'tasks_is_deleted' => 1,
            'tasks_deleted_at' => date('Y-m-d H:i:s')
        );

        if ($this->task->update_contact($user_id, $tasks_id, $updated_tasks_formdata)) {
            redirect('task/tasks";');
        } else {
            redirect('contact/error_page');
        }
    }

    public function assign_contact()
    {
        $selected_user      = $this->input->post('user_selected');

        $shared_tasks_formdata = array(
            'user_id'               => $selected_user,
            'tasks_first_name'    => $this->input->post('firstname'),
            'tasks_last_name'     => $this->input->post('lastname'),
            'tasks_email'         => $this->input->post('email'),
            'tasks_phone'         => $this->input->post('phone'),
            'tasks_company_name'  => $this->input->post('companyname'),
            'tasks_is_deleted'    => 0,
            'tasks_created_at'    => date('Y-m-d H:i:s'),
            'tasks_shared_at'     => date('Y-m-d H:i:s')
        );

        if ($this->task->insert_contact($shared_tasks_formdata, $selected_user)) {
            $this->session->set_flashdata('success', 'sContact shared successfully!');
            redirect('task/tasks";');
        } else {
            $this->session->set_flashdata('error', 'Failed to share contact!');
        }
    }

    function get_other_users_except_current($current_user_id)
    {
        $other_users = $this->user->get_users_except_current($current_user_id);
        return $other_users;
    }
}
