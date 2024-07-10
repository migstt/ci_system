<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Warehouse_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_supplier_specific_warehouses($supplier_id)
    {
        $field      = '*';
        $table      = 'warehouses';
        $where      = 'supplier_id = ' . $supplier_id;
        $order_by   = '';
        return $this->getRows($field, $table, $where, $order_by);
    }

    function get_warehouse_row_by_id($warehouse_id)
    {
        $field      = '*';
        $table      = 'warehouses';
        $where      = 'wh_id = ' . $warehouse_id;
        return $this->getRow($field, $table, $where);
    }
}
