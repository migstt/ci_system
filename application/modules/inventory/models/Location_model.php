<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Location_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function insert_location($table, $location_form_data)
    {
        if ($this->db->insert($table, $location_form_data)) {
            return true;
        }
        return false;
    }

    function update_location($location_id, $updated_location_formdata)
    {
        $this->db->where('location_id', $location_id);
        $result = $this->db->update('locations', $updated_location_formdata);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    function get_all_locations()
    {
        $this->db->select('*');
        $this->db->from('locations');
        // $this->db->where('location_status', 0);
        $this->db->order_by('location_name', 'ASC');
        return $this->db->get()->result();
    }

    function get_active_locations()
    {
        $this->db->select('*');
        $this->db->from('locations');
        $this->db->where('location_status', 0);
        $this->db->order_by('location_name', 'ASC');
        return $this->db->get()->result();
    }

    function get_location_row_by_id($location_id)
    {
        $where = 'location_id=' . $location_id;
        return $this->getRow('*', 'locations', $where);
    }
}
