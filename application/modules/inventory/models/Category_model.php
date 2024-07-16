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

    public function count_items_each_category()
    {
        $query = "
            SELECT 
                c.category_name, 
                COUNT(i.inv_item_id) AS total_items
            FROM 
                inventory i
            JOIN 
                items it ON i.inv_item_id = it.item_id
            JOIN 
                categories c ON it.item_category_id = c.category_id
            WHERE 
                i.inv_status = 0
            GROUP BY 
                c.category_name
            ORDER BY 
                c.category_name;
        ";

        return $this->getRowBySQL($query, 'result');
    }
}
