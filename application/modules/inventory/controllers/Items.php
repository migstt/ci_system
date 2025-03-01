<?php

class Items extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('inventory_model', 'inventory');
        $this->load->model('item_model', 'item');
        $this->load->model('items_model', 'items');
        $this->load->model('location_model', 'location');
        $this->load->model('category_model', 'category');
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
        $this->all_items();
    }

    function all_items()
    {
        $data['location'] = $this->location->get_location_row_by_id($_SESSION['user_loc_id']);

        if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
            $view = $this->load->view('inventory/all_items', $data, true);
            $this->template($view);
        } else {
            redirect('forbidden');
        }
    }

    function get_all_items()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_email'])) {
            redirect('login');
        }

        if ($_SESSION['user_type_id'] != 1) {
            redirect('forbidden');
        }

        $admin_loc_id = $_SESSION['user_loc_id'];

        $items = $this->items->get_all_items($admin_loc_id);

        if ($items === false || empty($items)) {
            $items = array();
        }

        $data = array();
        foreach ($items as $item) {

            $item_row           = $this->item->get_item($item->inv_item_id);
            $item_location      = $this->location->get_location_row_by_id($item->inv_assigned_to);

            $data[] = array(
                'id'                => $item->inv_id,
                'name'              => $item_row['item_name'],
                'brand'             => $item->inv_brand,
                'location'          => $item_location['location_name'],
                'unit_cost'         => $item->inv_unit_cost,
                'tracking_no'       => $item->inv_tracking_id,
                'serial_no'         => $item->inv_serial,
            );
        }

        $output = array(
            "draw"              => intval($this->input->get("draw")),
            "recordsTotal"      => count($data),
            "recordsFiltered"   => count($data),
            "data"              => $data
        );

        echo json_encode($output);
    }
}
