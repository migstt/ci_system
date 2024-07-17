<?php

class Inventory extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('inventory_model', 'inventory');
        $this->load->model('supplier_model', 'supplier');
        $this->load->model('warehouse_model', 'warehouse');
        $this->load->model('location_model', 'location');
        $this->load->model('report_model', 'report');
        $this->load->model('stock_model', 'stock');
        $this->load->model('location_model', 'location');
        $this->load->model('user/user_model', 'user');
        $this->load->model('team/team_model', 'team');
        $this->load->library('parser');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('session');
    }

    function index()
    {
        $this->dashboard();
    }

    function dashboard()
    {

        if (isset($_SESSION['user_id']) && isset($_SESSION['user_email']) && isset($_SESSION['user_type_id']) && isset($_SESSION['user_loc_id'])) {

            $admin_loc_id = $_SESSION['user_loc_id'];

            $data['report_log_counts']  = $this->report->get_report_log_counts($admin_loc_id);
            $data['stock_counts']       = $this->stock->get_stock_counts();
            $data['user_counts']        = $this->user->get_user_counts();
            $data['current_user_loc']   = $this->location->get_location_row_by_id($admin_loc_id);
            $data['supplier_count']     = $this->supplier->get_supplier_count();
            $data['warehouse_count']    = $this->warehouse->get_warehouse_count();
            $data['location_count']     = $this->location->get_location_count();
            $data['currloc_user_count'] = $this->user->get_currentloc_user_count($admin_loc_id);

            $view = $this->load->view('inventory/dashboard', $data, true);
            $this->template($view);
        } else {
            redirect('forbidden');
        }
    }

    function all_items()
    {
        redirect('inventory/items/all_items');
    }

    function stocks()
    {
        redirect('inventory/stock/stocks');
    }

    function location()
    {
        redirect('inventory/location/locations');
    }

    function category()
    {
        redirect('inventory/category/category');
    }

    function suppliers()
    {
        redirect('inventory/supplier/suppliers');
    }

    function items()
    {
        redirect('inventory/item/items');
    }

    function users()
    {
        redirect('inventory/user/users');
    }

    function reports()
    {
        redirect('inventory/report/reports');
    }

    function transfer()
    {
        redirect('inventory/transfer/transfers');
    }

    function forbidden()
    {
        $this->load->view('inventory/forbidden');
    }

    function count_items_supplied_by_each_supplier()
    {

        $admin_loc_id   = $_SESSION['user_loc_id'];
        $data           = $this->inventory->count_items_supplied_by_each_supplier($admin_loc_id);

        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode([]);
        }
    }

    function get_monthly_stock_counts_per_category()
    {

        $admin_loc_id = $_SESSION['user_loc_id'];

        $data   = [];
        $result = $this->stock->get_monthly_stock_counts_per_category($admin_loc_id);

        if (!$result) {
            echo json_encode($data);
            return;
        }

        foreach ($result as $row) {
            $category_name = $row['category_name'];
            $month = $row['month'];
            $stock_count = $row['stock_count'];

            $data[$category_name][] = [
                'month' => $month,
                'stock_count' => $stock_count
            ];
        }

        echo json_encode($data);
    }
}
