<?php

class Supplier extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('inventory_model', 'inventory');
        $this->load->model('supplier_model', 'supplier');
        $this->load->model('user/user_model', 'user');
        $this->load->model('team/team_model', 'team');
        $this->load->library('parser');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('session');
        $this->load->library('parser');
    }

    function index()
    {
        $this->suppliers();
    }

    function suppliers()
    {
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
            $view = $this->load->view('inventory/suppliers', '', true);
            $this->template($view);
        } else {
            redirect('forbidden');
        }
    }

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

            if ($this->supplier->insert_supplier('suppliers', $supplier_form_data)) {
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

            if ($this->supplier->update_supplier($supplier_id, $updated_supplier_form_data)) {
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

        if ($this->supplier->update_supplier($supplier_id, $updated_supplier_formdata)) {
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
            redirect('login');
        }

        $suppliers = $this->supplier->get_all_suppliers();

        if ($suppliers === false || empty($suppliers)) {
            $suppliers = array();
        }

        $data = array();
        foreach ($suppliers as $supplier) {

            $supplier_added_by = $this->user->get_user_row_by_id($supplier['supplier_added_by']);

            $data[] = array(
                'supplier_id'       => $supplier['supplier_id'],
                'name'              => $supplier['supplier_name'],
                'contact_details'   => $supplier,
                'bank_details'      => $supplier,
                'contact_person'    => $supplier['supplier_contact_person'],
                'contact_no'        => $supplier['supplier_contact_no'],
                'bank_name'         => $supplier['supplier_bank_name'],
                'account_name'      => $supplier['supplier_account_name'],
                'account_no'        => $supplier['supplier_account_no'],
                'status'            => $supplier['supplier_status'] == 0 ? 'Active' : 'Inactive',
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
}
