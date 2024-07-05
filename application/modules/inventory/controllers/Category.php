<?php

class Category extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('inventory_model', 'inventory');
        $this->load->model('category_model', 'category');
        $this->load->model('supplier_model', 'supplier');
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
        $this->categories();
    }

    function categories()
    {
        $this->load->view('inventory/category');
    }

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

            if ($this->category->insert_category('categories', $category_form_data)) {
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

            if ($this->category->update_category($category_id, $updated_category_formdata)) {
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

        if ($this->category->update_category($category_id, $updated_category_formdata)) {
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

        $categories = $this->category->get_all_categories();

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
}
