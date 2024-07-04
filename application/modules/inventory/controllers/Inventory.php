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
        $data['active_categories']  = $this->inventory->get_active_categories();
        $data['active_locations']   = $this->inventory->get_active_locations();
        $this->load->view('inventory/items', $data);
    }

    function reports()
    {
        $this->load->view('inventory/reports');
    }

    function users()
    {

        $current_user = $this->user->get_user_row_by_id($_SESSION['user_id']);
        $current_user_type = $this->user->get_user_type_row($current_user['user_type_id']);

        if ($current_user_type['user_type_name'] != 'Admin') {
            $this->forbidden();
            return;
        }

        $data['active_locations']   = $this->inventory->get_active_locations();
        $data['active_teams']       = $this->team->get_all_teams();
        $data['user_types']         = $this->user->get_active_user_types();

        $this->load->view('inventory/users', $data);

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
        $this->form_validation->set_rules('contact_person', 'Supplier contact_person', 'required');
        $this->form_validation->set_rules('contact_number', 'Supplier contact_number', 'required');
        $this->form_validation->set_rules('bank_name', 'Supplier bank_name', 'required');
        $this->form_validation->set_rules('account_name', 'Supplier account_name', 'required');
        $this->form_validation->set_rules('account_number', 'Supplier account_number', 'required');

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
                $response = array('status' => 'success', 'message' => 'Supplier updated.');
                echo json_encode($response);
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to update supplier. Please try again.');
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
    public function insert_user()
    {
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('team_id', 'Team ID', 'required');
        $this->form_validation->set_rules('user_type_id', 'User Type ID', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('location_id', 'Location ID', 'required');

        $first_name    = $this->input->post('first_name');
        $last_name     = $this->input->post('last_name');
        $email         = $this->input->post('email');
        $password      = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        $team_id       = $this->input->post('team_id');
        $user_type_id  = $this->input->post('user_type_id');
        $status        = $this->input->post('status');
        $location_id   = $this->input->post('location_id');

        if ($this->inventory->verify_user_email($this->db->escape($email))) {
            $response = array('status' => 'error_email_exist', 'message' => 'Email already registered. Please use a different email.');
            echo json_encode($response);
            return;
        }

        if ($this->form_validation->run() == TRUE) {

            $user_form_data = array(
                'user_first_name'   => $first_name,
                'user_last_name'    => $last_name,
                'user_email'        => $email,
                'user_password'     => $password,
                'user_created_at'   => date('Y-m-d H:i:s'),
                'team_id'           => $team_id,
                'user_type_id'      => $user_type_id,
                'user_status'       => $status,
                'user_location_id'  => $location_id,
            );

            if ($this->user->insert_user($user_form_data)) {
                $response = array('status' => 'success', 'message' => 'User added successfully.');
                echo json_encode($response);
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to add user. Please try again.');
                echo json_encode($response);
            }
        }
    }

    function update_user()
    {
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('team_id', 'Team ID', 'required');
        $this->form_validation->set_rules('user_type_id', 'User Type ID', 'required');
        $this->form_validation->set_rules('location_id', 'Location ID', 'required');

        $user_id       = $this->input->post('user_id');
        $first_name    = $this->input->post('first_name');
        $last_name     = $this->input->post('last_name');
        $team_id       = $this->input->post('team_id');
        $user_type_id  = $this->input->post('user_type_id');
        $location_id   = $this->input->post('location_id');

        if ($this->form_validation->run() == TRUE) {

            $updated_user_form_data = array(
                'user_first_name'   => $first_name,
                'user_last_name'    => $last_name,
                'team_id'           => $team_id,
                'user_type_id'      => $user_type_id,
                'user_location_id'  => $location_id,
                'user_updated_at'   => date('Y-m-d H:i:s'),
            );

            if ($this->user->update_user($user_id, $updated_user_form_data)) {
                $response = array('status' => 'success', 'message' => 'User updated successfully.');
                echo json_encode($response);
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to update user. Please try again.');
                echo json_encode($response);
            }
        }
    }

    function delete_user()
    {
        $user_id = $this->input->post('user_id');

        $updated_user_formdata = array(
            'user_status'       => 1,
            'user_deleted_at'   => date('Y-m-d H:i:s'),
            'user_updated_at'   => date('Y-m-d H:i:s')
        );

        if ($this->user->update_user($user_id, $updated_user_formdata)) {
            $response = array('status' => 'success', 'message' => 'User set to Inactive.');
            echo json_encode($response);
        } else {
            $response = array('status' => 'error', 'message' => 'Failed to set user to Inactive. Please try again.');
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
                'first_name'    => $user['user_first_name'],
                'last_name'     => $user['user_last_name'],
                'full_name'     => $user['user_first_name'] . ' ' . $user['user_last_name'],
                'email'         => $user['user_email'],
                'location'      => $user_location['location_name'],
                'location_id'   => $user['user_location_id'],
                'type'          => $user_type['user_type_name'],
                'type_id'       => $user['user_type_id'],
                'team'          => $user_team['team_name'],
                'team_id'       => $user['team_id'],
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


    // ITEM MANAGEMENT
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

            if ($this->inventory->insert_item('items', $item_form_data)) {
                $response = array('status' => 'success', 'message' => 'Location added successfully.');
                echo json_encode($response);
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to add location. Please try again.');
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

            if ($this->inventory->update_item($item_id, $updated_item_formdata)) {
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

        if ($this->inventory->update_item($item_id, $updated_item_formdata)) {
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

        $items = $this->inventory->get_all_items();

        if ($items === false || empty($items)) {
            $items = array();
        }

        $data = array();
        foreach ($items as $item) {

            $item_added_by = $this->user->get_user_row_by_id($item->item_added_by);
            $item_category = $this->inventory->get_category_row_by_id($item->item_category_id);
            $item_location = $this->inventory->get_location_row_by_id($item->item_location_id);

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
    // ITEM MANAGEMENT


    public function forbidden()
    {
        $this->load->view('inventory/forbidden');
    }
}



