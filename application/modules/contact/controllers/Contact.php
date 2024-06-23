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

    function contacts()
    {
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
            
            $data['user_id']       = $_SESSION['user_id'];
            $data['user_email']    = $_SESSION['user_email'];
            $data['contacts']      = $this->contact->get_user_specific_contacts($_SESSION['user_id']);
            $data['current_user']  = $this->user->get_user_row($this->db->escape($_SESSION['user_email']));

            $data['user_options'] = array(
                'Default' => 'Select user'
            );

            $users_except_current = $this->get_other_users_except_current($_SESSION['user_id']);

            foreach ($users_except_current as $user) {
                $data['user_share_options'][$user['user_id']] = $user['user_first_name'] . ' ' . $user['user_last_name'];
            }
            if (!is_array($data['contacts'])) {
                $data['contacts'] = array();
            }

            $this->load->view('contact/contacts', $data);

        } else {
            redirect('user/login');
        }
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
                'contact_first_name'    => $firstname,
                'contact_last_name'     => $lastname,
                'contact_email'         => $email,
                'contact_phone'         => $phone,
                'contact_company_name'  => $companyname,
                'contact_is_deleted'    => 0,
                'contact_created_at'    => date('Y-m-d H:i:s'),
            );

            if ($this->contact->insert_contact($contact_formdata)) {
                $this->session->set_flashdata('success', 'Contact added successfully!');
                redirect('contact/contacts');
            } else {
                $this->session->set_flashdata('error', 'Contact not added!');
                redirect('contact/contacts');
            }
        }
    }

    function update_contact()
    {
        $contact_id = $this->input->post('contact_id');
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

            if ($this->contact->update_contact($contact_id, $updated_contact_formdata)) {
                $this->session->set_flashdata('success', 'Contact added successfully!');
                redirect('contact/contacts');
            } else {
                $this->session->set_flashdata('error', 'Contact not added!');
                redirect('contact/contacts');
            }
        }
    }

    function delete_contact()
    {
        $contact_id = $this->input->post('contact_id');
        $updated_contact_formdata = array(
            'contact_is_deleted' => 1,
            'contact_deleted_at' => date('Y-m-d H:i:s')
        );
        if ($this->contact->update_contact($contact_id, $updated_contact_formdata)) {
            redirect('contact/contacts');
        } else {
            redirect('contact/error_page');
        }
    }

    public function share_contact()
    {
        $contact_id     = $this->input->post('contact_id');
        $selected_user  = $this->input->post('user_selected');
        $user_contacts_data = array(
            'user_id'       => $selected_user,
            'contact_id'    => $contact_id,
        );

        if ($this->contact->share_contact($user_contacts_data)) {
            redirect('contact/contacts');
        }
    }

    function get_other_users_except_current($current_user_id)
    {
        $other_users = $this->user->get_users_except_current($current_user_id);
        return $other_users;
    }
}
