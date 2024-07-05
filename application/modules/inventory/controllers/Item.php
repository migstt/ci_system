<?php

class Item extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('inventory_model', 'inventory');
        $this->load->model('item_model', 'item');
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
        $this->items();
    }

    function items()
    {
        $data['active_categories']  = $this->category->get_active_categories();
        $data['active_locations']   = $this->location->get_active_locations();
        
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
            $view = $this->load->view('inventory/items', $data, true);
            $this->template($view);
        } else {
            redirect('forbidden');
        }
    }

    function insert_item()
    {
        $this->form_validation->set_rules('name', 'Item name', 'required');
        $this->form_validation->set_rules('category', 'Item category', 'required');
        $this->form_validation->set_rules('location', 'Item location', 'required');

        if ($this->form_validation->run() == TRUE) {

            $name       = $this->input->post('name');
            $category   = $this->input->post('category');
            $location   = $this->input->post('location');

            $item_form_data = array(
                'item_name'         => $name,
                'item_category_id'  => $category,
                'item_location_id'  => $location,
                'item_status'       => 0,
                'item_added_by'     => $_SESSION['user_id'],
                'item_added_at'     => date('Y-m-d H:i:s'),
                'item_updated_at'   => null,
                'item_deleted_at'   => null
            );

            if ($this->item->insert_item('items', $item_form_data)) {
                $response = array('status' => 'success', 'message' => 'Item added successfully.');
                echo json_encode($response);
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to add item. Please try again.');
                echo json_encode($response);
            }
        }
    }

    function update_item()
    {

        $this->form_validation->set_rules('name', 'Item name', 'required');
        $this->form_validation->set_rules('category', 'Item category', 'required');
        $this->form_validation->set_rules('location', 'Item location', 'required');

        if ($this->form_validation->run() == TRUE) {

            $item_id    = $this->input->post('item_id');
            $name       = $this->input->post('name');
            $category   = $this->input->post('category');
            $location   = $this->input->post('location');

            $updated_item_formdata = array(
                'item_name'         => $name,
                'item_category_id'  => $category,
                'item_location_id'  => $location,
                'item_updated_at'   => date('Y-m-d H:i:s'),
            );

            if ($this->item->update_item($item_id, $updated_item_formdata)) {
                $response = array('status' => 'success', 'message' => 'Item updated.');
                echo json_encode($response);
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to update item. Please try again.');
                echo json_encode($response);
            }
        }
    }

    function delete_item()
    {
        $item_id = $this->input->post('item_id');

        $updated_item_formdata = array(
            'item_status'       => 1,
            'item_deleted_at'   => date('Y-m-d H:i:s')
        );

        if ($this->item->update_item($item_id, $updated_item_formdata)) {
            $response = array('status' => 'success', 'message' => 'Item set to Inactive.');
            echo json_encode($response);
        } else {
            $response = array('status' => 'error', 'message' => 'Failed to set item to Inactive. Please try again.');
            echo json_encode($response);
        }
    }

    function get_items()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_email'])) {
            echo json_encode(array('error' => 'Login required.'));
            return;
        }

        $items = $this->item->get_all_items();

        if ($items === false || empty($items)) {
            $items = array();
        }

        $data = array();
        foreach ($items as $item) {

            $item_added_by = $this->user->get_user_row_by_id($item->item_added_by);
            $item_category = $this->category->get_category_row_by_id($item->item_category_id);
            $item_location = $this->location->get_location_row_by_id($item->item_location_id);

            $data[] = array(
                'item_id'       => $item->item_id,
                'name'          => $item->item_name,
                'category'      => $item_category['category_name'],
                'location'      => $item_location['location_name'],
                'location_id'   => $item->item_location_id,
                'category_id'   => $item->item_category_id,
                'status'        => $item->item_status == 0 ? 'Active' : 'Inactive',
                'added_by'      => $item_added_by['user_first_name'] . ' ' . $item_added_by['user_last_name'],
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
