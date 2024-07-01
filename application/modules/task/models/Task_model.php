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
                'task_id' => $inserted_task_id,
                'task_assigned_to' => $selected_user,
                'task_assigned_by' => $_SESSION['user_id'],
            );
            if ($this->insert_to_user_tasks($user_tasks_data)) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function get_user_specific_tasks($user_id, $limit = 0, $offset = 0)
    {
        $this->db->select('*');
        $this->db->from('user_tasks');
        $this->db->where('user_tasks.task_assigned_to', $user_id);
        $this->db->join('tasks', 'user_tasks.task_assigned_to = tasks.task_assigned_to');
        $this->db->where('tasks.task_is_deleted', 0);
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
        $this->db->where('user_tasks.task_assigned_to', $user_id);
        $this->db->join('tasks', 'user_tasks.task_assigned_to = tasks.task_assigned_to');
        $this->db->where('tasks.task_is_deleted', 0);
        return $this->db->count_all_results();
    }

    public function update_task($task_id, $updated_task_formdata)
    {
        $this->db->where('task_id', $task_id);
        $result = $this->db->update('tasks', $updated_task_formdata);

        if ($result) {
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

    public function get_tasks_row($field, $table, $task_assigned_to)
    {
        $this->getRow($field, $table, 'task_assigned_to=' . $task_assigned_to);
    }
}
