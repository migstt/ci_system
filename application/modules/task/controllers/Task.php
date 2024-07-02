<?php

class Task extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('task_model', 'task');
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
        $this->tasks();
    }

    public function tasks()
    {
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

            $data['user_id']        = $_SESSION['user_id'];
            $data['user_email']     = $_SESSION['user_email'];
            $data['current_user']   = $this->user->get_user_row($this->db->escape($_SESSION['user_email']));
            $data['user_options']   = array('Default' => 'Select user to assign this task to');
            $data['team_options']   = array('Default' => 'Select team to assign this task to');
            $users_except_current   = $this->get_other_users_except_current($_SESSION['user_id']);
            $all_teams              = $this->team->get_all_teams();

            foreach ($users_except_current as $user) {
                $data['user_options'][$user['user_id']] = $user['user_first_name'] . ' ' . $user['user_last_name'];
            }

            foreach ($all_teams as $team) {
                $data['team_options'][$team['team_id']] = $team['team_name'];
            }

            $this->load->view('task/tasks', $data);
        } else {
            redirect('login');
        }
    }

    public function get_others_tasks()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if (!isset($_SESSION['user_id'])) {
            echo json_encode(array('error' => 'User ID not set in session.'));
            return;
        }

        $others_tasks = $this->task->get_tasks_assigned_to_others($_SESSION['user_id'], 0, 0);

        if (!$others_tasks) {
            $others_tasks = array();
        }

        $data = array();
        $task_ids = array();

        foreach ($others_tasks as $task) {
            if (!in_array($task->task_id, $task_ids)) {

                if (!$task->task_assigned_to_user) {
                    $assigned_to = $this->team->get_team_row_by_id($task->task_assigned_to_team);
                    if ($assigned_to) {

                        $assigned_name  = 'Team ' . $assigned_to['team_name'];

                        $data[] = array(
                            'task_id'       => $task->task_id,
                            'title'         => $task->task_title,
                            'description'   => $task->task_description,
                            'assigned_to'   => $assigned_name,
                            'due_date'      => $task->task_due_date,
                            'status'        => $task->task_status,
                        );

                        $task_ids[] = $task->task_id;
                    }
                } else {
                    $assigned_to = $this->user->get_user_row_by_id($task->task_assigned_to_user);
                    if ($assigned_to) {

                        $assigned_name  = $assigned_to['user_first_name'] . ' ' . $assigned_to['user_last_name'];

                        $data[] = array(
                            'task_id'       => $task->task_id,
                            'title'         => $task->task_title,
                            'description'   => $task->task_description,
                            'assigned_to'   => $assigned_name,
                            'due_date'      => $task->task_due_date,
                            'status'        => $task->task_status,
                        );

                        $task_ids[] = $task->task_id;
                    }
                }
            }
        }

        $users_except_current = $this->get_other_users_except_current($_SESSION['user_id']);
        $all_teams = $this->team->get_all_teams();

        $edit_user_options = array();
        $edit_team_options = array();

        foreach ($users_except_current as $user) {
            $edit_user_options[$user['user_id']] = $user['user_first_name'] . ' ' . $user['user_last_name'];
        }

        foreach ($all_teams as $team) {
            $edit_team_options[$team['team_id']] = 'Team ' . $team['team_name']; ;
        }

        $output = array(
            "draw" => intval($this->input->get("draw")),
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data,
            "edit_user_options" => $edit_user_options
        );

        echo json_encode($output);
    }

    public function get_my_tasks()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if (!isset($_SESSION['user_id'])) {
            echo json_encode(array('error' => 'User ID not set in session.'));
            return;
        }

        $current_user_team  = $this->user->get_user_row_by_id($_SESSION['user_id']);

        $current_user_tasks = $this->task->get_user_specific_tasks($_SESSION['user_id'], $current_user_team['team_id'], 0, 0);

        if (!$current_user_tasks) {
            $current_user_tasks = array();
        }

        $data = array();
        $task_ids = array();

        foreach ($current_user_tasks as $task) {
            if (!in_array($task->task_id, $task_ids)) {

                $assigned_by = $this->user->get_user_row_by_id($task->task_assigned_by);

                if ($assigned_by) {

                    $assigned_by_name  = $assigned_by['user_first_name'] . ' ' . $assigned_by['user_last_name'];

                    $data[] = array(
                        'task_id'       => $task->task_id,
                        'title'         => $task->task_title,
                        'description'   => $task->task_description,
                        'assigned_by'   => $assigned_by_name,
                        'due_date'      => $task->task_due_date,
                        'status'        => $task->task_status,
                    );

                    $task_ids[] = $task->task_id;
                }
            }
        }

        $output = array(
            "draw"              => intval($this->input->get("draw")),
            "recordsTotal"      => count($data),
            "recordsFiltered"   => count($data),
            "data"              => $data
        );

        echo json_encode($output);
    }

    function insert_task()
    {
        $this->form_validation->set_rules('title', 'Task title', 'required');
        $this->form_validation->set_rules('description', 'Task description', 'required');
        $this->form_validation->set_rules('due_date', 'Due date', 'required');

        if ($this->form_validation->run() == TRUE) {

            $title          = $this->input->post('title');
            $description    = $this->input->post('description');
            $assigned_user  = $this->input->post('user_selected');
            $assigned_team  = $this->input->post('team_selected');
            $due_date       = $this->input->post('due_date');

            if ($assigned_user == '') {

                $assigned_to_row        = $this->team->get_team_row_by_id($assigned_team);
                $create_success_message = 'Task assigned to Team ' . $assigned_to_row['team_name'] . ' members' . '.';
                $create_error_message   = 'Failed to create task for Team ' . $assigned_to_row['team_name'] . ' members' . '.';

                $task_formdata = array(
                    'task_assigned_by'          => $_SESSION['user_id'],
                    'task_title'                => $title,
                    'task_description'          => $description,
                    'task_assigned_to_team'     => $assigned_team,
                    'task_status'               => 'pending',
                    'task_created_at'           => date('Y-m-d H:i:s'),
                    'task_updated_at'           => null,
                    'task_completed_at'         => null,
                    'task_due_date'             => $due_date,
                    'task_is_deleted'           => 0,
                );

                if ($this->task->insert_task_by_team($task_formdata, $assigned_team)) {
                    $response = array('status' => 'success', 'message' => $create_success_message);
                    echo json_encode($response);
                } else {
                    $response = array('status' => 'error', 'message' => 'Failed to create task. Please try again.');
                    echo json_encode($response);
                }

            } else if ($assigned_team == '') {

                $assigned_to_row        = $this->user->get_user_row_by_id($assigned_user);
                $create_success_message = 'Task assigned to ' . $assigned_to_row['user_first_name'] . ' ' .  $assigned_to_row['user_last_name'] . '.';
                $create_error_message   = 'Failed to create task for ' . $assigned_to_row['user_first_name'] . ' ' .  $assigned_to_row['user_last_name'] . '. ' . 'Please try again.';

                $task_formdata = array(
                    'task_assigned_by'          => $_SESSION['user_id'],
                    'task_title'                => $title,
                    'task_description'          => $description,
                    'task_assigned_to_user'     => $assigned_user,
                    'task_status'               => 'pending',
                    'task_created_at'           => date('Y-m-d H:i:s'),
                    'task_updated_at'           => null,
                    'task_completed_at'         => null,
                    'task_due_date'             => $due_date,
                    'task_is_deleted'           => 0,
                );

                if ($this->task->insert_task($task_formdata, $assigned_user)) {
                    $response = array('status' => 'success', 'message' => $create_success_message);
                    echo json_encode($response);
                } else {
                    $response = array('status' => 'error', 'message' => $create_error_message);
                    echo json_encode($response);
                }
            }
        }
    }

    function update_others_task()
    {

        $this->form_validation->set_rules('title', 'Task title', 'required');
        $this->form_validation->set_rules('description', 'Task description', 'required');
        $this->form_validation->set_rules('user_selected', 'Assigned to', 'required');
        $this->form_validation->set_rules('due_date', 'Due date', 'required');


        if ($this->form_validation->run() == TRUE) {

            $title          = $this->input->post('title');
            $description    = $this->input->post('description');
            $assigned_to    = $this->input->post('user_selected');
            $due_date       = $this->input->post('due_date');
            $task_id        = $this->input->post('task_id');

            $updated_task_formdata = array(
                'task_title'            => $title,
                'task_description'      => $description,
                'task_assigned_to_user' => $assigned_to,
                'task_assigned_to_team' => null,
                'task_due_date'         => $due_date,
            );

            if ($this->task->update_task($task_id, $updated_task_formdata)) {
                $response = array('status' => 'success', 'message' => 'Task updated.');
                echo json_encode($response);
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to update task. Please try again.');
                echo json_encode($response);
            }
        }
    }

    function update_task_status()
    {
        $task_id    = $this->input->post('task_id');
        $status     = $this->input->post('status');

        if ($status == 'done') {
            $updated_task_status_formdata = array(
                'task_status'       => $status,
                'task_updated_at'   => date('Y-m-d H:i:s'),
                'task_completed_at' => date('Y-m-d H:i:s')
            );
        } else {
            $updated_task_status_formdata = array(
                'task_status'       => $status,
                'task_updated_at'   => date('Y-m-d H:i:s'),
                'task_completed_at' => null
            );
        }

        if ($this->task->update_task($task_id, $updated_task_status_formdata)) {
            $response = array('status' => 'success', 'message' => 'Task status updated.');
            echo json_encode($response);
        } else {
            $response = array('status' => 'error', 'message' => 'Failed to update task status. Please try again.');
            echo json_encode($response);
        }
    }

    function delete_task()
    {
        $task_id   = $this->input->post('task_id');

        $updated_tasks_formdata = array(
            'task_is_deleted' => 1,
            'task_deleted_at' => date('Y-m-d H:i:s')
        );

        if ($this->task->update_task($task_id, $updated_tasks_formdata)) {
            $response = array('status' => 'success', 'message' => 'Task deleted.');
            echo json_encode($response);
        } else {
            $response = array('status' => 'error', 'message' => 'Failed to delete task. Please try again.');
            echo json_encode($response);
        }
    }

    function get_other_users_except_current($current_user_id)
    {
        $other_users = $this->user->get_users_except_current($current_user_id);
        return $other_users;
    }
}
