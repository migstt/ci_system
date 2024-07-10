<?php

class User extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->library('parser');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    function index()
    {
        $this->login();
    }

    function login()
    {
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
            redirect('contacts');
        } else {
            if ($this->form_validation->run() == TRUE) {

                $email          = $this->db->escape($this->input->post('email'));
                $password       = $this->input->post('password');
                $existing_user  = $this->user->get_user_row($email);

                if ($existing_user) {
                    if (password_verify($password, $existing_user['user_password'])) {
                        $user_session_data = array(
                            'user_id'       => $existing_user['user_id'],
                            'user_email'    => $existing_user['user_email'],
                            'user_type_id'  => $existing_user['user_type_id'],
                        );
                        $this->session->set_userdata($user_session_data);
                        if (isset($_SESSION['user_id']) && isset($_SESSION['user_email']) && isset($_SESSION['user_type_id'])) {
                            $response = array('status' => 'success', 'message' => 'Sign in successful. Redirecting.');
                            echo json_encode($response);
                        } else {
                            $response = array('status' => 'error', 'message' => 'Unable to sign you in this time. Please try again later.');
                            echo json_encode($response);
                        }
                    } else {
                        $response = array('status' => 'error', 'message' => 'Incorrect password. Please try again.');
                        echo json_encode($response);
                    }
                } else {
                    $response = array('status' => 'error', 'message' => $email . ' is not a registered email.');
                    echo json_encode($response);
                }
            } else {
                $this->load->view('user/login');
            }
        }
    }

    function register()
    {
        $this->form_validation->set_rules('firstname', 'First name', 'required');
        $this->form_validation->set_rules('lastname', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('confpassword', 'Password Confirmation', 'required');

        if ($this->form_validation->run() == TRUE) {

            $firstname  = $this->input->post('firstname');
            $lastname   = $this->input->post('lastname');
            $email      = $this->input->post('email');
            $password   = $this->input->post('password');

            if ($this->verify_user_email($this->db->escape($email))) {
                $response = array('status' => 'error_email_exist', 'message' => 'Email already registered.');
                echo json_encode($response);
                return;
            }

            $registration_formdata = array(
                'user_first_name'   => $firstname,
                'user_last_name'    => $lastname,
                'user_email'        => $email,
                'user_password'     => password_hash($password, PASSWORD_DEFAULT),
                'user_created_at'   => date('Y-m-d H:i:s'),
            );

            if ($this->user->insert_user($registration_formdata)) {
                $this->session->set_userdata('user_email', $email);

                if (isset($_SESSION['user_email'])) {
                    $new_registered_user = $this->user->get_user_row($this->db->escape($_SESSION['user_email']));
                    $this->session->set_userdata('user_id', $new_registered_user['user_id']);
                    if (isset($_SESSION['user_id'])) {
                        $response = array('status' => 'success', 'message' => 'Registration successful.');
                        echo json_encode($response);
                    } else {
                        $this->load->view('user/register');
                    }
                }
            } else {
                $response = array('status' => 'error', 'message' => 'Unable to register you at this time. Please try again later.');
                echo json_encode($response);
            }
        } else {
            $this->load->view('user/register');
        }
    }

    function verify_user_email($user_email)
    {
        $user = $this->user->get_user_row($user_email);
        if ($user) {
            return true;
        }
        return false;
    }

    function logout()
    {
        $this->unset_destroy_session();
    }

    function unset_destroy_session()
    {
        unset(
            $_SESSION['user_email'],
            $_SESSION['user_id'],
            $_SESSION['user_type_id']
        );
        $this->session->sess_destroy();
        if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_email'])) {
            redirect('login');
        } else {
            $response = array('status' => 'error', 'message' => 'Unable to log you out. Please try again.');
            echo json_encode($response);
        }
    }

    function thankyou()
    {
        $this->load->view('user/thankyou');
    }
}
