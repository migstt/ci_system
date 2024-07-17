<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Items_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_all_items($admin_location_id)
    {
        $this->db->select('*');
        $this->db->from('inventory');
        $this->db->where('inv_status', 0);
        $this->db->where('inv_assigned_to', $admin_location_id);
        $this->db->order_by('inv_added_at', 'DESC');
        return $this->db->get()->result();
    }
}
