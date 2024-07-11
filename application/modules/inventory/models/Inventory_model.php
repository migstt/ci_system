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




    function get_last_inserted_serial_number($item_id)
    {
        $query = 'SELECT * FROM inventory WHERE inv_item_id=' . $item_id . ' ORDER BY inv_id DESC LIMIT 1';
        return $this->getRowBySQL($query, 'row');
    }
}
