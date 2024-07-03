<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }


    // LOCATION MANAGEMENT
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
        $result = $this->db->update('location', $updated_location_formdata);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    function get_all_locations()
    {
        $this->db->select('*');
        $this->db->from('location');
        // $this->db->where('location_status', 0);
        $this->db->order_by('location_name', 'ASC');
        return $this->db->get()->result();
    }
    // LOCATION MANAGEMENT


    // CATEGORY MANAGEMENT
    function insert_category($table, $category_form_data)
    {
        if ($this->db->insert($table, $category_form_data)) {
            return true;
        }
        return false;
    }

    function update_category($category_id, $updated_category_formdata)
    {
        $this->db->where('category_id', $category_id);
        $result = $this->db->update('category', $updated_category_formdata);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    function get_all_categories()
    {
        $this->db->select('*');
        $this->db->from('category');
        // $this->db->where('category_status', 0);
        $this->db->order_by('category_name', 'ASC');
        return $this->db->get()->result();
    }
    // CATEGORY MANAGEMENT
}
