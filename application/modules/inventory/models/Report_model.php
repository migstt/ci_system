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


    function update_report($report_id, $updated_rlog_formdata)
    {
        $this->db->where('rlog_id', $report_id);
        $result_one = $this->db->update('report_logs', $updated_rlog_formdata);

        if ($result_one) {
            return true;
        } else {
            return false;
        }
    }

    function get_my_reports($user_id)
    {
        $this->db->select('*');
        $this->db->from('report_logs');
        $this->db->where('rlog_added_by', $user_id);
        $this->db->order_by('rlog_added_at', 'ASC');
        return $this->db->get()->result();
    }

    function get_all_reports()
    {
        $this->db->select('*');
        $this->db->from('report_logs');
        $this->db->order_by('rlog_added_at', 'ASC');
        return $this->db->get()->result();
    }
}
