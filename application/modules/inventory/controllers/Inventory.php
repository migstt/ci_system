<?php

class Inventory extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('inventory_model', 'inventory');
        $this->load->model('report_model', 'report');
        $this->load->model('stock_model', 'stock');
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

        $data['report_log_counts']  = $this->report->get_report_log_counts();
        $data['stock_counts']       = $this->stock->get_stock_counts();
        $data['user_counts']        = $this->user->get_user_counts();

        if (isset($_SESSION['user_id']) && isset($_SESSION['user_email']) && isset($_SESSION['user_type_id'])) {
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

    function forbidden()
    {
        $this->load->view('inventory/forbidden');
    }

    function count_items_supplied_by_each_supplier()
    {
        $data = $this->inventory->count_items_supplied_by_each_supplier();
        echo json_encode($data);
    }

    function get_monthly_stock_counts_per_category()
    {
        $data   = [];
        $result = $this->stock->get_monthly_stock_counts_per_category();

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
