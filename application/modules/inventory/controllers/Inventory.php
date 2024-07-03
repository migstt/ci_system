<?php

class Inventory extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('inventory_model', 'inventory');
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
        $this->load->view('inventory/dashboard');
    }

    function stocks()
    {
        $this->load->view('inventory/stocks');
    }

    function location()
    {
        $this->load->view('inventory/location');
    }

    function category()
    {
        $this->load->view('inventory/category');
    }

    function suppliers()
    {
        $this->load->view('inventory/suppliers');
    }

    function items()
    {
        $this->load->view('inventory/items');
    }

    function reports()
    {
        $this->load->view('inventory/reports');
    }

    function users()
    {
        $this->load->view('inventory/users');
    }




    // LOCATION MANAGEMENT

    function insert_location()
    {
        $this->form_validation->set_rules('name', 'Location name', 'required');
        $this->form_validation->set_rules('address', 'Location address', 'required');

        if ($this->form_validation->run() == TRUE) {

            $name     = $this->input->post('name');
            $address  = $this->input->post('address');

            $location_form_data = array(
                'location_name'         => $name,
                'location_address'      => $address,
                'location_status'       => 0,
                'location_added_by'     => $_SESSION['user_id'],
                'location_added_at'     => date('Y-m-d H:i:s'),
                'location_updated_at'   => null,
                'location_deleted_at'   => null
            );

            if ($this->inventory->insert_location('location', $location_form_data)) {
                $response = array('status' => 'success', 'message' => 'Location added successfully.');
                echo json_encode($response);
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to add location. Please try again.');
                echo json_encode($response);
            }
        }
    }

    function update_location()
    {

        $this->form_validation->set_rules('name', 'Location name', 'required');
        $this->form_validation->set_rules('address', 'Location address', 'required');

        if ($this->form_validation->run() == TRUE) {

            $location_id = $this->input->post('location_id');
            $name        = $this->input->post('name');
            $address     = $this->input->post('address');

            $updated_location_formdata = array(
                'location_name'         => $name,
                'location_address'      => $address,
                'location_updated_at'   => date('Y-m-d H:i:s')
            );

            if ($this->inventory->update_location($location_id, $updated_location_formdata)) {
                $response = array('status' => 'success', 'message' => 'Location updated.');
                echo json_encode($response);
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to update location. Please try again.');
                echo json_encode($response);
            }
        }
    }

    function delete_location()
    {
        $location_id = $this->input->post('location_id');

        $updated_contact_formdata = array(
            'location_status'       => 1,
            'location_deleted_at'   => date('Y-m-d H:i:s')
        );

        if ($this->inventory->update_location($location_id, $updated_contact_formdata)) {
            $response = array('status' => 'success', 'message' => 'Location set to Inactive.');
            echo json_encode($response);
        } else {
            $response = array('status' => 'error', 'message' => 'Failed to set location to Inactive. Please try again.');
            echo json_encode($response);
        }
    }

    function get_locations()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_email'])) {
            echo json_encode(array('error' => 'Login required.'));
            return;
        }

        $locations = $this->inventory->get_all_locations();

        if ($locations === false || empty($locations)) {
            echo json_encode(array('error' => 'Error retrieving locations.'));
        } else {
            $data = array();
            foreach ($locations as $location) {

                $location_added_by = $this->user->get_user_row_by_id($location->location_added_by);

                $data[] = array(
                    'location_id'   => $location->location_id,
                    'name'          => $location->location_name,
                    'address'       => $location->location_address,
                    'status'        => $location->location_status == 0 ? 'Active' : 'Inactive',
                    'added_by'      => $location_added_by['user_first_name'] . ' ' . $location_added_by['user_last_name'],
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
    // LOCATION MANAGEMENT



    // CATEGORY MANAGEMENT
    function insert_category()
    {

        $this->form_validation->set_rules('name', 'Category name', 'required');

        if ($this->form_validation->run() == TRUE) {

            $name     = $this->input->post('name');

            $category_form_data = array(
                'category_name'         => $name,
                'category_status'       => 0,
                'category_added_by'     => $_SESSION['user_id'],
                'category_created_at'   => date('Y-m-d H:i:s'),
                'category_updated_at'   => null,
                'category_deleted_at'   => null
            );

            if ($this->inventory->insert_category('category', $category_form_data)) {
                $response = array('status' => 'success', 'message' => 'Category added successfully.');
                echo json_encode($response);
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to add category. Please try again.');
                echo json_encode($response);
            }
        }
    }

    function update_category()
    {

        $this->form_validation->set_rules('name', 'Category name', 'required');

        if ($this->form_validation->run() == TRUE) {

            $category_id = $this->input->post('category_id');
            $name        = $this->input->post('name');

            $updated_category_formdata = array(
                'category_name'         => $name,
                'category_updated_at'   => date('Y-m-d H:i:s')
            );

            if ($this->inventory->update_category($category_id, $updated_category_formdata)) {
                $response = array('status' => 'success', 'message' => 'Category updated.');
                echo json_encode($response);
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to update categort. Please try again.');
                echo json_encode($response);
            }
        }
    }

    function delete_category()
    {
        $category_id = $this->input->post('category_id');

        $updated_category_formdata = array(
            'category_status'       => 1,
            'category_deleted_at'   => date('Y-m-d H:i:s')
        );

        if ($this->inventory->update_category($category_id, $updated_category_formdata)) {
            $response = array('status' => 'success', 'message' => 'Category set as inactive.');
            echo json_encode($response);
        } else {
            $response = array('status' => 'error', 'message' => 'Failed to set category as inactive. Please try again.');
            echo json_encode($response);
        }
    }

    function get_categories()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_email'])) {
            echo json_encode(array('error' => 'Login required.'));
            return;
        }

        $categories = $this->inventory->get_all_categories();

        if ($categories === false || empty($categories)) {
            echo json_encode(array('error' => 'Error retrieving categories.'));
        } else {
            $data = array();
            foreach ($categories as $category) {

                $category_added_by = $this->user->get_user_row_by_id($category->category_added_by);

                $data[] = array(
                    'category_id'   => $category->category_id,
                    'name'          => $category->category_name,
                    'status'        => $category->category_status == 0 ? 'Active' : 'Inactive',
                    'added_by'      => $category_added_by['user_first_name'] . ' ' . $category_added_by['user_last_name'],
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
    // CATEGORY MANAGEMENT
}
