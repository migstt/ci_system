<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function insert_items($item_form_data)
    {
        $table = 'inventory';

        if ($this->insert($table, $item_form_data, false)) {
            return true;
        }
        return false;
    }

    function get_last_inserted_serial_number($item_id)
    {
        $query = 'SELECT * FROM inventory WHERE inv_item_id=' . $item_id . ' ORDER BY inv_id DESC LIMIT 1';
        return $this->getRowBySQL($query, 'row');
    }
}
