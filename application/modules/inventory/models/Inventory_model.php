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

    function get_items_ordered_by_batch($batch_number)
    {
        $query = '
            SELECT
                inv_tracking_id AS batch_number,
                inventory.inv_item_id AS item_id,
                items.item_name,
                inventory.inv_brand AS brand,
                inventory.inv_unit_cost AS cost,
                COUNT(*) AS quantity_ordered,
                SUM(inventory.inv_unit_cost) AS total_cost_per_item
            FROM
                inventory
            INNER JOIN
                items ON inventory.inv_item_id = items.item_id
            WHERE
                inv_tracking_id = \'' . $batch_number . '\'
            GROUP BY
                inv_tracking_id,
                inventory.inv_item_id,
                items.item_name,
                inventory.inv_brand
            ORDER BY
                inventory.inv_item_id DESC';

        return $this->getRowBySQL($query, 'result');
    }

    function update_items_by_batch($batch_number)
    {
        $table  = 'inventory';
        $data   = array('inv_status' => 0);
        $where  = array('inv_tracking_id' => $batch_number);
        $this->update($table, $data, $where);
    }


    function get_last_inserted_serial_number($item_id)
    {
        $query = 'SELECT * FROM inventory WHERE inv_item_id=' . $item_id . ' ORDER BY inv_id DESC LIMIT 1';
        return $this->getRowBySQL($query, 'row');
    }

    function count_items_supplied_by_each_supplier()
    {
        $query = "
            SELECT 
                s.supplier_name, 
                COUNT(i.inv_id) AS total_items_supplied
            FROM 
                inventory i
            JOIN 
                inventory_tracking it ON i.inv_tracking_id = it.inv_trk_batch_num
            JOIN 
                suppliers s ON it.inv_trk_supplier_id = s.supplier_id
            GROUP BY 
                s.supplier_name
            ORDER BY 
                s.supplier_name;
        ";

        return $this->getRowBySQL($query, 'result');
    }
}
