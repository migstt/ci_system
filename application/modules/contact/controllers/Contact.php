<?php

class Contact extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('contact_model', 'contact');
        $this->load->model('user/user_model', 'user');
        $this->load->library('parser');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('session');
    }

    function index()
    {
        $this->contacts();
    }

    public function contacts()
    {
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

            $data['user_id']        = $_SESSION['user_id'];
            $data['user_email']     = $_SESSION['user_email'];
            $data['current_user']   = $this->user->get_user_row($this->db->escape($_SESSION['user_email']));
            $data['user_options']   = array('Default' => 'Select user');
            $users_except_current   = $this->get_other_users_except_current($_SESSION['user_id']);
            $total_contact_rows     = $this->contact->count_user_specific_contacts($_SESSION['user_id']);

            // pagination config
            $config["base_url"]         = base_url() . "index.php/contact/contacts";
            $config["total_rows"]       = $total_contact_rows;
            $config["per_page"]         = 5;
            $config["uri_segment"]      = 3;
            $config['full_tag_open']    = '<ul class="pagination">';
            $config['full_tag_close']   = '</ul>';
            $config['attributes']       = ['class' => 'page-link'];
            $config['first_link']       = false;
            $config['last_link']        = false;
            $config['first_tag_open']   = '<li class="page-item">';
            $config['first_tag_close']  = '</li>';
            $config['prev_link']        = '&laquo';
            $config['prev_tag_open']    = '<li class="page-item">';
            $config['prev_tag_close']   = '</li>';
            $config['next_link']        = '&raquo';
            $config['next_tag_open']    = '<li class="page-item">';
            $config['next_tag_close']   = '</li>';
            $config['last_tag_open']    = '<li class="page-item">';
            $config['last_tag_close']   = '</li>';
            $config['cur_tag_open']     = '<li class="page-item active"><a href="#" class="page-link">';
            $config['cur_tag_close']    = '<span class="sr-only"></span></a></li>';
            $config['num_tag_open']     = '<li class="page-item">';
            $config['num_tag_close']    = '</li>';

            $this->pagination->initialize($config);

            $page = $this->uri->segment(3);
            $data["links"]      = $this->pagination->create_links();

            // paginated
            // $data['contacts']   = $this->contact->get_user_specific_contacts($_SESSION['user_id'], $config["per_page"], $page);
            // not paginated
            $data['contacts']   = $this->contact->get_user_specific_contacts($_SESSION['user_id'], 0, 0);

            foreach ($users_except_current as $user) {
                $data['user_options'][$user['user_id']] = $user['user_first_name'] . ' ' . $user['user_last_name'];
            }
            if (!is_array($data['contacts'])) {
                $data['contacts'] = array();
            }

            $this->load->view('contact/contacts', $data);
        } else {
            redirect('user/login');
        }
    }

    public function get_contacts()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if (!isset($_SESSION['user_id'])) {
            echo json_encode(array('error' => 'User ID not set in session.'));
            return;
        }

        $contacts = $this->contact->get_user_specific_contacts($_SESSION['user_id'], 0, 0);

        // paginated contacts
        // $page = $this->uri->segment(3);
        // $contacts = $this->contact->get_user_specific_contacts($_SESSION['user_id'], 10, $page);

        if ($contacts === false) {
            echo json_encode(array('error' => 'Error retrieving contacts.'));
        } else {
            $data = array();
            foreach ($contacts as $contact) {
                $data[] = array(
                    'contact_id'    => $contact->contact_id,
                    'firstname'     => $contact->contact_first_name,
                    'lastname'      => $contact->contact_last_name,
                    'full_name'     => $contact->contact_first_name . ' ' . $contact->contact_last_name,
                    'company'       => $contact->contact_company_name,
                    'phone'         => $contact->contact_phone,
                    'email'         => $contact->contact_email,
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

    public function get_contacts_ssp()
    {
        $table          = 'contacts';
        $primary_key    = 'contact_id';
        $where          = "user_id = " . $_SESSION['user_id'] . " AND contact_is_deleted = 0";

        $sql_creds = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db'   => $this->db->database,
            'host' => $this->db->hostname
        );

        $columns = array(
            array('db' => 'contact_first_name', 'dt' => 'full_name'),
            array('db' => 'contact_company_name', 'dt' => 'company'),
            array('db' => 'contact_phone',  'dt' => 'phone'),
            array('db' => 'contact_email',   'dt' => 'email'),
            array(
                'db' => 'contact_id',
                'dt' => 'actions',
                'formatter' => function ($data, $row) {
                    return '
                        <div class="d-flex justify-content-end">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic mixed styles example">

                                <!-- Update/Edit Contact Modal -->
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editContactModal' . $data . '">Edit</button>

                                <!-- Share Contact Modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#shareContactModal' . $data . '">Share</button>

                                <!-- Delete Contact Confirmation Modal -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal' . $data . '">Delete</button>

                            </div>
                        </div>
                    ';
                }
            )
        );

        require('ssp.class.php');

        echo json_encode(
            SSP::complex($_GET, $sql_creds, $table, $primary_key, $columns, null, $where)
        );
    }

    function insert_contact()
    {
        $this->form_validation->set_rules('firstname', 'First name', 'required');
        $this->form_validation->set_rules('lastname', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('phone', 'Phone number', 'required');
        $this->form_validation->set_rules('companyname', 'Company name', 'required');

        if ($this->form_validation->run() == TRUE) {

            $firstname      = $this->input->post('firstname');
            $lastname       = $this->input->post('lastname');
            $email          = $this->input->post('email');
            $phone          = $this->input->post('phone');
            $companyname    = $this->input->post('companyname');

            $contact_formdata = array(
                'user_id'               => $_SESSION['user_id'],
                'contact_first_name'    => $firstname,
                'contact_last_name'     => $lastname,
                'contact_email'         => $email,
                'contact_phone'         => $phone,
                'contact_company_name'  => $companyname,
                'contact_is_deleted'    => 0,
                'contact_created_at'    => date('Y-m-d H:i:s'),
            );

            if ($this->contact->insert_contact($contact_formdata, $_SESSION['user_id'])) {
                $response = array('status' => 'success', 'message' => 'Contact added successfully!');
                echo json_encode($response);
            } else {
                $this->session->set_flashdata('error', 'Contact not added!');
                $response = array('status' => 'success', 'message' => 'Failed to add contact.');
                echo json_encode($response);
            }
        }
    }

    function update_contact()
    {
        $contact_id = $this->input->post('contact_id');
        $user_id    = $_SESSION['user_id'];

        $this->form_validation->set_rules('firstname', 'First name', 'required');
        $this->form_validation->set_rules('lastname', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('phone', 'Phone number', 'required');
        $this->form_validation->set_rules('companyname', 'Company name', 'required');

        if ($this->form_validation->run() == TRUE) {

            $firstname      = $this->input->post('firstname');
            $lastname       = $this->input->post('lastname');
            $email          = $this->input->post('email');
            $phone          = $this->input->post('phone');
            $companyname    = $this->input->post('companyname');

            $updated_contact_formdata = array(
                'contact_first_name'    => $firstname,
                'contact_last_name'     => $lastname,
                'contact_email'         => $email,
                'contact_phone'         => $phone,
                'contact_company_name'  => $companyname,
                'contact_updated_at'    => date('Y-m-d H:i:s')
            );

            if ($this->contact->update_contact($user_id, $contact_id, $updated_contact_formdata)) {
                $response = array('status' => 'success', 'message' => 'Contact updated.');
                echo json_encode($response);
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to update contact.');
                echo json_encode($response);
            }
        }
    }

    function delete_contact()
    {
        $contact_id = $this->input->post('contact_id');
        $user_id    = $_SESSION['user_id'];

        $updated_contact_formdata = array(
            'contact_is_deleted' => 1,
            'contact_deleted_at' => date('Y-m-d H:i:s')
        );

        if ($this->contact->update_contact($user_id, $contact_id, $updated_contact_formdata)) {
            $response = array('status' => 'success', 'message' => 'Contact deleted.');
            echo json_encode($response);
        } else {
            $response = array('status' => 'error', 'message' => 'Failed to delete contact.');
            echo json_encode($response);
        }
    }

    public function share_contact()
    {
        $selected_user      = $this->input->post('user_selected');
        $contact_email      = $this->db->escape($this->input->post('email'));
        $selected_user_row  = $this->user->get_user_row_by_id($selected_user);

        $shared_contact_formdata = array(
            'user_id'               => $selected_user,
            'contact_first_name'    => $this->input->post('firstname'),
            'contact_last_name'     => $this->input->post('lastname'),
            'contact_email'         => $this->input->post('email'),
            'contact_phone'         => $this->input->post('phone'),
            'contact_company_name'  => $this->input->post('companyname'),
            'contact_is_deleted'    => 0,
            'contact_created_at'    => date('Y-m-d H:i:s'),
            'contact_shared_at'     => date('Y-m-d H:i:s')
        );

        if ($this->check_contact_exist($selected_user, $contact_email)) {
            $response = array('status' => 'error', 'message' => $selected_user_row['user_first_name'] . ' ' . $selected_user_row['user_last_name'] . ' already has this contact.');
            echo json_encode($response);
            return;
        }

        if ($this->contact->insert_contact($shared_contact_formdata, $selected_user)) {
            $response = array('status' => 'success', 'message' => 'Contact successfully shared with ' . $selected_user_row['user_first_name'] . ' ' . $selected_user_row['user_last_name'] . '.');
            echo json_encode($response);
        } else {
            $response = array('status' => 'error', 'message' => 'MySQL Database Error! Failed to share contact.');
            echo json_encode($response);
            return;
        }
    }

    public function force_share_contact()
    {
        $selected_user = $this->input->post('user_selected');
        $selected_user_row  = $this->user->get_user_row_by_id($selected_user);

        $shared_contact_formdata = array(
            'user_id'               => $selected_user,
            'contact_first_name'    => $this->input->post('firstname'),
            'contact_last_name'     => $this->input->post('lastname'),
            'contact_email'         => $this->input->post('email'),
            'contact_phone'         => $this->input->post('phone'),
            'contact_company_name'  => $this->input->post('companyname'),
            'contact_is_deleted'    => 0,
            'contact_created_at'    => date('Y-m-d H:i:s'),
            'contact_shared_at'     => date('Y-m-d H:i:s')
        );

        if ($this->contact->insert_contact($shared_contact_formdata, $selected_user)) {
            $response = array('status' => 'success', 'message' => 'Contact successfully shared with ' . $selected_user_row['user_first_name'] . ' ' . $selected_user_row['user_last_name'] . '.');
            echo json_encode($response);
        } else {
            $response = array('status' => 'error', 'message' => 'MySQL Database Error! Failed to share contact.');
            echo json_encode($response);
            return;
        }
    }

    public function check_contact_exist($selected_user, $contact_email)
    {
        $contact_exists = $this->contact->check_contact_exist($selected_user, $contact_email);
        return $contact_exists;
    }

    function get_other_users_except_current($current_user_id)
    {
        $other_users = $this->user->get_users_except_current($current_user_id);
        return $other_users;
    }
}
