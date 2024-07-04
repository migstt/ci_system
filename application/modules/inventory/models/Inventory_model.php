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
        $result = $this->db->update('categories', $updated_category_formdata);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    function get_active_categories()
    {
        $this->db->select('*');
        $this->db->from('categories');
        $this->db->where('category_status', 0);
        $this->db->order_by('category_name', 'ASC');
        return $this->db->get()->result();
    }

    function get_all_categories()
    {
        $this->db->select('*');
        $this->db->from('categories');
        // $this->db->where('category_status', 0);
        $this->db->order_by('category_name', 'ASC');
        return $this->db->get()->result();
    }

    function get_category_row_by_id($category_id)
    {
        $where = 'category_id=' . $category_id;
        return $this->getRow('*', 'categories', $where);
    }
    // CATEGORY MANAGEMENT

    // SUPPLIER MANAGEMENT
    function insert_supplier($table, $supplier_form_data)
    {
        if ($this->db->insert($table, $supplier_form_data)) {
            return true;
        }
        return false;
    }

    function update_supplier($supplier_id, $updated_supplier_formdata)
    {
        $this->db->where('supplier_id', $supplier_id);
        $result = $this->db->update('suppliers', $updated_supplier_formdata);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    function get_all_suppliers()
    {
        $this->db->select('*');
        $this->db->from('suppliers');
        // $this->db->where('location_status', 0);
        $this->db->order_by('supplier_name', 'ASC');
        return $this->db->get()->result();
    }

    function get_supplier_row_by_id($supplier_id)
    {
        $where = 'supplier_id=' . $supplier_id;
        return $this->getRow('*', 'suppliers', $where);
    }
    // SUPPLIER MANAGEMENT

    // ITEM MANAGEMENT
    function insert_item($table, $item_form_data)
    {
        if ($this->db->insert($table, $item_form_data)) {
            return true;
        }
        return false;
    }

    function update_item($item_id, $updated_item_formdata)
    {
        $this->db->where('item_id', $item_id);
        $result = $this->db->update('items', $updated_item_formdata);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    function get_all_items()
    {
        $this->db->select('*');
        $this->db->from('items');
        $this->db->order_by('item_name', 'ASC');
        return $this->db->get()->result();
    }

    function get_active_items()
    {
        $this->db->select('*');
        $this->db->from('items');
        $this->db->where('item_status', 0);
        $this->db->order_by('item_name', 'ASC');
        return $this->db->get()->result();
    }
    // ITEM MANAGEMENT

    // USER MANAGEMENT
    function verify_user_email($user_email)
    {
        $where = 'user_email=' . $user_email;
        $user = $this->getRow('*', 'users', $where);
        if ($user) {
            return true;
        }
        return false;
    }
    // USER MANAGEMENT
}
