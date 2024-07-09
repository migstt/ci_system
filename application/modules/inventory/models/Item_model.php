<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Item_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }

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
        $table      = 'items';
        $where      = 'item_status=0';
        $orderby    = 'item_name ASC';
        return $this->getRows('*', $table, $where, $orderby);
    }

    function get_item($item_id)
    {
        $field = '*';
        $table = 'items';
        $where = 'item_id=' . $item_id;
        $order_by = '';
        return $this->getRow($field, $table, $where, $order_by);
    }

}
