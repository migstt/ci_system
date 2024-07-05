<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }

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
}
