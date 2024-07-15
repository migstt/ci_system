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

    function get_stock_by_task_id($task_id)
    {
        $field      = '*';
        $table      = 'inventory_tracking';
        $where      = 'inv_trk_task_id = ' . $task_id;
        $orderby    = '';
        return $this->getRow($field, $table, $where, $orderby);
    }

    function update_stock_by_task_id($task_id, $status, $date_delivered)
    {
        $table = 'inventory_tracking';
        $where = 'inv_trk_task_id = ' . $task_id;

        $stock_form_data = array(
            'inv_trk_status' => $status,
            'inv_trk_date_delivered' => $date_delivered
        );

        if ($this->update($table, $stock_form_data, $where)) {
            return true;
        }
        return false;
    }

    function update_inventory_items_status($batch_number)
    {
        $table  = 'inventory';
        $where  = "inv_tracking_id = '$batch_number'";
        $data   = array('inv_status' => 0);
        
        $this->update($table, $data, $where);
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
