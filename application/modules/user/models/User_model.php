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
}
