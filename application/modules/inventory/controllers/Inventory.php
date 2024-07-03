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

            if ($this->inventory->insert_location('locations', $location_form_data)) {
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
            $locations = array();
        }

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

            if ($this->inventory->insert_category('categories', $category_form_data)) {
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
            $categories = array();
        }

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
    // CATEGORY MANAGEMENT


    // SUPPLIER MANAGEMENT
    function insert_supplier()
    {

        $this->form_validation->set_rules('name', 'Supplier name', 'required');
        $this->form_validation->set_rules('contact_person', 'Supplier name', 'required');
        $this->form_validation->set_rules('contact_number', 'Supplier name', 'required');
        $this->form_validation->set_rules('bank_name', 'Supplier name', 'required');
        $this->form_validation->set_rules('account_name', 'Supplier name', 'required');
        $this->form_validation->set_rules('account_number', 'Supplier name', 'required');

        if ($this->form_validation->run() == TRUE) {

            $name               = $this->input->post('name');
            $contact_person     = $this->input->post('contact_person');
            $contact_number     = $this->input->post('contact_number');
            $bank_name          = $this->input->post('bank_name');
            $account_name       = $this->input->post('account_name');
            $account_number     = $this->input->post('account_number');

            $supplier_form_data = array(
                'supplier_name'             => $name,
                'supplier_contact_person'   => $contact_person,
                'supplier_contact_no'       => $contact_number,
                'supplier_bank_name'        => $bank_name,
                'supplier_account_name'     => $account_name,
                'supplier_account_no'       => $account_number,
                'supplier_status'           => 0,
                'supplier_added_by'         => $_SESSION['user_id'],
                'supplier_added_at'         => date('Y-m-d H:i:s'),
                'supplier_updated_at'       => null,
                'supplier_deleted_at'       => null,
            );

            if ($this->inventory->insert_supplier('suppliers', $supplier_form_data)) {
                $response = array('status' => 'success', 'message' => 'Supplier added successfully.');
                echo json_encode($response);
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to add supplier. Please try again.');
                echo json_encode($response);
            }
        }
    }

    function update_supplier()
    {
        $this->form_validation->set_rules('name', 'Supplier name', 'required');
        $this->form_validation->set_rules('contact_person', 'Supplier name', 'required');
        $this->form_validation->set_rules('contact_number', 'Supplier name', 'required');
        $this->form_validation->set_rules('bank_name', 'Supplier name', 'required');
        $this->form_validation->set_rules('account_name', 'Supplier name', 'required');
        $this->form_validation->set_rules('account_number', 'Supplier name', 'required');

        if ($this->form_validation->run() == TRUE) {

            $supplier_id        = $this->input->post('supplier_id');
            $name               = $this->input->post('name');
            $contact_person     = $this->input->post('contact_person');
            $contact_number     = $this->input->post('contact_number');
            $bank_name          = $this->input->post('bank_name');
            $account_name       = $this->input->post('account_name');
            $account_number     = $this->input->post('account_number');

            $updated_supplier_form_data = array(
                'supplier_name'             => $name,
                'supplier_contact_person'   => $contact_person,
                'supplier_contact_no'       => $contact_number,
                'supplier_bank_name'        => $bank_name,
                'supplier_account_name'     => $account_name,
                'supplier_account_no'       => $account_number,
                'supplier_updated_at'       => date('Y-m-d H:i:s'),
            );

            if ($this->inventory->update_supplier($supplier_id, $updated_supplier_form_data)) {
                $response = array('status' => 'success', 'message' => 'Location updated.');
                echo json_encode($response);
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to update location. Please try again.');
                echo json_encode($response);
            }
        }
    }

    function delete_supplier()
    {
        $supplier_id = $this->input->post('supplier_id');

        $updated_supplier_formdata = array(
            'supplier_status'       => 1,
            'supplier_updated_at'   => date('Y-m-d H:i:s'),
            'supplier_deleted_at'   => date('Y-m-d H:i:s')
        );

        if ($this->inventory->update_supplier($supplier_id, $updated_supplier_formdata)) {
            $response = array('status' => 'success', 'message' => 'Location set to Inactive.');
            echo json_encode($response);
        } else {
            $response = array('status' => 'error', 'message' => 'Failed to set location to Inactive. Please try again.');
            echo json_encode($response);
        }
    }

    function get_suppliers()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_email'])) {
            echo json_encode(array('error' => 'Login required.'));
            return;
        }

        $suppliers = $this->inventory->get_all_suppliers();

        if ($suppliers === false || empty($suppliers)) {
            $suppliers = array();
        }

        $data = array();
        foreach ($suppliers as $supplier) {

            $supplier_added_by = $this->user->get_user_row_by_id($supplier->supplier_added_by);
            $supplier_details = $this->inventory->get_supplier_row_by_id($supplier->supplier_id);

            $data[] = array(
                'supplier_id'       => $supplier->supplier_id,
                'name'              => $supplier->supplier_name,
                'contact_details'   => $supplier,
                'bank_details'      => $supplier,
                'contact_person'    => $supplier->supplier_contact_person,
                'contact_no'        => $supplier->supplier_contact_no,
                'bank_name'         => $supplier->supplier_bank_name,
                'account_name'      => $supplier->supplier_account_name,
                'account_no'        => $supplier->supplier_account_no,
                'status'            => $supplier->supplier_status == 0 ? 'Active' : 'Inactive',
                'added_by'          => $supplier_added_by['user_first_name'] . ' ' . $supplier_added_by['user_last_name'],
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
    // SUPPLIER MANAGEMENT



    // USER MANAGEMENT
    function insert_user()
    {

        $this->form_validation->set_rules('name', 'Supplier name', 'required');
        $this->form_validation->set_rules('contact_person', 'Supplier name', 'required');
        $this->form_validation->set_rules('contact_number', 'Supplier name', 'required');
        $this->form_validation->set_rules('bank_name', 'Supplier name', 'required');
        $this->form_validation->set_rules('account_name', 'Supplier name', 'required');
        $this->form_validation->set_rules('account_number', 'Supplier name', 'required');

        if ($this->form_validation->run() == TRUE) {

            $name               = $this->input->post('name');
            $contact_person     = $this->input->post('contact_person');
            $contact_number     = $this->input->post('contact_number');
            $bank_name          = $this->input->post('bank_name');
            $account_name       = $this->input->post('account_name');
            $account_number     = $this->input->post('account_number');

            $supplier_form_data = array(
                'supplier_name'             => $name,
                'supplier_contact_person'   => $contact_person,
                'supplier_contact_no'       => $contact_number,
                'supplier_bank_name'        => $bank_name,
                'supplier_account_name'     => $account_name,
                'supplier_account_no'       => $account_number,
                'supplier_status'           => 0,
                'supplier_added_by'         => $_SESSION['user_id'],
                'supplier_added_at'         => date('Y-m-d H:i:s'),
                'supplier_updated_at'       => null,
                'supplier_deleted_at'       => null,
            );

            if ($this->inventory->insert_supplier('suppliers', $supplier_form_data)) {
                $response = array('status' => 'success', 'message' => 'Supplier added successfully.');
                echo json_encode($response);
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to add supplier. Please try again.');
                echo json_encode($response);
            }
        }
    }

    function update_user()
    {
        $this->form_validation->set_rules('name', 'Supplier name', 'required');
        $this->form_validation->set_rules('contact_person', 'Supplier name', 'required');
        $this->form_validation->set_rules('contact_number', 'Supplier name', 'required');
        $this->form_validation->set_rules('bank_name', 'Supplier name', 'required');
        $this->form_validation->set_rules('account_name', 'Supplier name', 'required');
        $this->form_validation->set_rules('account_number', 'Supplier name', 'required');

        if ($this->form_validation->run() == TRUE) {

            $supplier_id        = $this->input->post('supplier_id');
            $name               = $this->input->post('name');
            $contact_person     = $this->input->post('contact_person');
            $contact_number     = $this->input->post('contact_number');
            $bank_name          = $this->input->post('bank_name');
            $account_name       = $this->input->post('account_name');
            $account_number     = $this->input->post('account_number');

            $updated_supplier_form_data = array(
                'supplier_name'             => $name,
                'supplier_contact_person'   => $contact_person,
                'supplier_contact_no'       => $contact_number,
                'supplier_bank_name'        => $bank_name,
                'supplier_account_name'     => $account_name,
                'supplier_account_no'       => $account_number,
                'supplier_updated_at'       => date('Y-m-d H:i:s'),
            );

            if ($this->inventory->update_supplier($supplier_id, $updated_supplier_form_data)) {
                $response = array('status' => 'success', 'message' => 'Location updated.');
                echo json_encode($response);
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to update location. Please try again.');
                echo json_encode($response);
            }
        }
    }

    function delete_user()
    {
        $supplier_id = $this->input->post('supplier_id');

        $updated_supplier_formdata = array(
            'supplier_status'       => 1,
            'supplier_updated_at'   => date('Y-m-d H:i:s'),
            'supplier_deleted_at'   => date('Y-m-d H:i:s')
        );

        if ($this->inventory->update_supplier($supplier_id, $updated_supplier_formdata)) {
            $response = array('status' => 'success', 'message' => 'Location set to Inactive.');
            echo json_encode($response);
        } else {
            $response = array('status' => 'error', 'message' => 'Failed to set location to Inactive. Please try again.');
            echo json_encode($response);
        }
    }

    function get_users()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_email'])) {
            echo json_encode(array('error' => 'Login required.'));
            return;
        }

        $users = $this->user->get_users();

        if (empty($users)) {
            $users = array();
        }

        $data = array();

        foreach ($users as $user) {

            $user_location  = $this->inventory->get_location_row_by_id($user['user_location_id']);
            $user_type      = $this->user->get_user_type_row($user['user_type_id']);
            $user_team      = $this->user->get_user_team_row($user['team_id']);

            $data[] = array(
                'user_id'       => $user['user_id'],
                'full_name'     => $user['user_first_name'] . ' ' . $user['user_last_name'],
                'email'         => $user['user_email'],
                'location'      => $user_location['location_name'],
                'type'          => $user_type['user_type_name'],
                'team'          => $user_team['team_name'],
                'status'        => $user['user_status'] == 0 ? 'Active' : 'Inactive',
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
    // USER MANAGEMENT
}
