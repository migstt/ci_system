<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stock_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_stocks()
    {
        $table      = 'inventory_tracking';
        $orderby    = 'inv_trk_id DESC';
        $where      = '';
        return $this->getRows('*', $table, $where, $orderby);
    }

    function insert_stock($stock_form_data)
    {
        $table = 'inventory_tracking';

        if ($this->insert($table, $stock_form_data, false)) {
            return true;
        }
        return false;
    }

    function insert_items($item_form_data)
    {
        $table = 'inventory';

        if ($this->insert($table, $item_form_data, false)) {
            return true;
        }
        return false;
    }

    function get_last_inserted_batch_number()
    {
        $query = 'SELECT inv_trk_batch_num FROM inventory_tracking ORDER BY inv_trk_id DESC LIMIT 1';
        return $this->getRowBySQL($query, 'row');
    }

    function get_item_by_serial($serial)
    {
        $field = '*';
        $table = 'inventory';
        $where = 'inv_serial = ' . $serial;
        $orderby = '';
        return $this->getRow($field, $table, $where, $orderby);
    }

    function get_item_by_serial_by_sql($serial)
    {
        $query = "SELECT * FROM inventory WHERE inv_serial = '$serial'";
        return $this->getRowBySQL($query, 'row');
    }

}
