<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }
    
    function insert_supplier($table, $supplier_form_data)
    {
        if ($this->db->insert($table, $supplier_form_data)) {
            return true;
        }
        return false;
    }

    function update_supplier($supplier_id, $updated_supplier_formdata)
    {
        $this->db->where('supplier_id', $supplier_id);
        $result = $this->db->update('suppliers', $updated_supplier_formdata);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    function get_all_suppliers()
    {
        $this->db->select('*');
        $this->db->from('suppliers');
        // $this->db->where('location_status', 0);
        $this->db->order_by('supplier_name', 'ASC');
        return $this->db->get()->result();
    }

    function get_supplier_row_by_id($supplier_id)
    {
        $where = 'supplier_id=' . $supplier_id;
        return $this->getRow('*', 'suppliers', $where);
    }
}
