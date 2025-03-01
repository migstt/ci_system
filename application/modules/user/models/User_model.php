<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function insert_user($registration_formdata)
    {
        if ($this->insert('users', $registration_formdata)) {
            return true;
        }
        return false;
    }

    public function update_user($user_id, $updated_user_formdata)
    {
        $this->db->where('user_id', $user_id);
        $result = $this->db->update('users', $updated_user_formdata);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function get_users()
    {
        return $this->getRows('*', 'users', '', 'user_first_name ASC');
    }

    public function get_user_row($email)
    {
        $where = 'user_email=' . $email;
        return $this->getRow('*', 'users', $where);
    }

    public function get_user_row_by_id($user_id)
    {
        $where = 'user_id=' . $user_id;
        return $this->getRow('*', 'users', $where);
    }

    public function get_user_type_row($user_type_id)
    {
        $where = 'user_type_id=' . $user_type_id;
        return $this->getRow('*', 'user_type', $where);
    }

    public function get_user_team_row($user_team_id)
    {
        $where = 'team_id=' . $user_team_id;
        return $this->getRow('*', 'team', $where);
    }

    public function get_active_user_types()
    {
        return $this->getRows('*', 'user_type', '', 'user_type_name ASC');
    }

    function get_users_except_current($current_user_id)
    {

        $where      = 'user_id!=' . $current_user_id;
        $order_by   = 'user_first_name ASC';

        $users_except_current = $this->getRows('*', 'users', $where, $order_by);

        if (!is_array($users_except_current)) {
            $users_except_current = array();
            return $users_except_current;
        }

        return $users_except_current;
    }

    function get_current_user_type($user_type_id)
    {
        $where       = 'user_type_id=' . $user_type_id;
        $user_type   = $this->getRow('*', 'user_type', $where);
        return $user_type['user_type_name'];
    }

    function verify_user_email($user_email)
    {
        $where = 'user_email=' . $user_email;
        $user = $this->getRow('*', 'users', $where);
        if ($user) {
            return true;
        }
        return false;
    }

    function get_users_by_type($user_type_id)
    {
        $field = '*';
        $table = 'users';
        $where = 'user_type_id=' . $user_type_id;
        $orderby = 'user_first_name ASC';
        return $this->getRows($field, $table, $where, $orderby);
    }

    function get_user_counts()
    {
        // 1 - Admin, 2 - Employee, 3 - Courier, 4 - Manager
        $query = "
            SELECT 
                COUNT(*) AS total_users,
                SUM(user_type_id = 1) AS admins,
                SUM(user_type_id = 2) AS employees,
                SUM(user_type_id = 3) AS couriers,
                SUM(user_type_id = 4) AS managers
            FROM
                users
            WHERE
                user_status = 0;
        ";

        return $this->getRowBySQL($query, 'row');
    }

    function get_currentloc_user_count($admin_current_loc)
    {
        $query = "
            SELECT 
                COUNT(*) AS total_users
            FROM
                users
            WHERE
                user_location_id = $admin_current_loc
        ";

        return $this->getRowBySQL($query, 'row');
    }
}
