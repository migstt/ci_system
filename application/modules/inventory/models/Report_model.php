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

    function get_all_reports($admin_location_id)
    {
        $this->db->select('*');
        $this->db->from('report_logs');
        $this->db->where('rlog_location_id', $admin_location_id);
        $this->db->order_by('rlog_added_at', 'ASC');
        return $this->db->get()->result();
    }

    function get_report_log_counts($admin_location_id)
    {
        $query = "
            SELECT 
                COUNT(*) AS total_reported_items,
                SUM(rlog_status = 'Pending') AS pending,
                SUM(rlog_status = 'Reviewed') AS reviewed,
                SUM(rlog_status = 'Disposed') AS disposed,
                SUM(rlog_status = 'Replaced') AS replaced
            FROM
                report_logs
            WHERE
                rlog_location_id = $admin_location_id
        ";

        return $this->getRowBySQL($query, 'row');
    }
}
