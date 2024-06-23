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
        if($this->insert('users', $registration_formdata)){
            return true;
        }
        return false;
    }

    public function get_user_row($email)
    {
        return $this->getRow('*', 'users', 'user_email='. $email);
    }

    function get_users_except_current($current_user_id)
    {
        $users_except_current = $this->getRows('*', 'users', 'user_id!='. $current_user_id, '');

        if (!is_array($users_except_current)) {
            $users_except_current = array();
            return $users_except_current;
        }
        return $users_except_current;
    }
}
