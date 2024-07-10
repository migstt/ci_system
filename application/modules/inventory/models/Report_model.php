<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function insert_report($table, $report_form_data)
    {
        if ($this->db->insert($table, $report_form_data)) {
            return true;
        }
        return false;
    }
}
