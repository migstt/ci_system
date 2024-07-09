<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stock_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }


    function insert_stock($stock_form_data)
    {
        $table = 'inventory_tracking';

        if ($this->insert($table, $stock_form_data, false)) {
            return true;
        }
        return false;
    }

    function insert_items()
    {
    }

    function get_last_inserted_batch_number()
    {
        $query = 'SELECT inv_trk_batch_num FROM inventory_tracking ORDER BY inv_trk_id DESC LIMIT 1';
        return $this->getRowBySQL($query, 'row');
    }
}
