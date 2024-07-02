<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Task_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }


    public function insert_task($task_formdata, $selected_user)
    {
        $inserted_task_id = $this->insert('tasks', $task_formdata, true);

        if (isset($inserted_task_id)) {
            $user_tasks_data = array(
                'task_id'                   => $inserted_task_id,
                'task_assigned_to_user'     => $selected_user,
                'task_assigned_by'          => $_SESSION['user_id'],
            );
            if ($this->insert_to_user_tasks($user_tasks_data)) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function insert_task_by_team($task_formdata, $selected_team)
    {
        $inserted_task_id = $this->insert('tasks', $task_formdata, true);

        if (isset($inserted_task_id)) {
            $user_tasks_data = array(
                'task_id'                   => $inserted_task_id,
                'task_assigned_to_team'     => $selected_team,
                'task_assigned_by'          => $_SESSION['user_id'],
            );
            if ($this->insert_to_user_tasks($user_tasks_data)) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function get_user_specific_tasks($user_id, $current_user_team_id, $limit = 0, $offset = 0)
    {
        $this->db->select('*');
        $this->db->from('user_tasks');
        $this->db->join('tasks', 'user_tasks.task_id = tasks.task_id');
        $this->db->where('tasks.task_is_deleted', 0);
        $this->db->group_start();
        $this->db->where('user_tasks.task_assigned_to_user', $user_id);
        $this->db->or_where('user_tasks.task_assigned_to_team', $current_user_team_id);
        $this->db->group_end();
        $this->db->order_by('tasks.task_title', 'ASC');
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result();
    }



    public function get_tasks_assigned_to_others($task_assigned_by, $limit = 0, $offset = 0)
    {
        $this->db->select('*');
        $this->db->from('user_tasks');
        $this->db->where('user_tasks.task_assigned_by', $task_assigned_by);
        $this->db->join('tasks', 'user_tasks.task_assigned_by = tasks.task_assigned_by');
        $this->db->where('tasks.task_is_deleted', 0);
        $this->db->order_by('tasks.task_title', 'ASC');
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result();
    }

    public function count_user_specific_tasks($user_id)
    {
        $this->db->from('user_tasks');
        $this->db->where('user_tasks.task_assigned_to_user', $user_id);
        $this->db->join('tasks', 'user_tasks.task_assigned_to_user = tasks.task_assigned_to_user');
        $this->db->where('tasks.task_is_deleted', 0);
        return $this->db->count_all_results();
    }

    public function update_task($task_id, $updated_task_formdata)
    {
        $this->db->where('task_id', $task_id);
        $result_one = $this->db->update('tasks', $updated_task_formdata);

        if ($result_one) {
            return true;
        } else {
            return false;
        }
    }

    public function insert_to_user_tasks($user_task_data)
    {
        if ($this->insert('user_tasks', $user_task_data)) {
            return true;
        }
        return false;
    }

    public function get_tasks_row($field, $table, $task_assigned_to_user)
    {
        $this->getRow($field, $table, 'task_assigned_to_user=' . $task_assigned_to_user);
    }
}
