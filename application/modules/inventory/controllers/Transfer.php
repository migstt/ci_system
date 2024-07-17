<?php

class Transfer extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('inventory_model', 'inventory');
        $this->load->model('user/user_model', 'user');
        $this->load->model('team/team_model', 'team');
        $this->load->model('report_model', 'report');
        $this->load->model('location_model', 'location');
        $this->load->model('item_model', 'item');
        $this->load->model('stock_model', 'stock');
        $this->load->library('parser');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('session');
    }

    function index()
    {
        $this->transfers();
    }

    function transfers()
    {
        if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_email'])) {
            redirect('login');
        }

        if ($_SESSION['user_type_id'] != 1) {
            redirect('forbidden');
        }

        $admin_loc_id = $_SESSION['user_loc_id'];

        $data['active_locations']   = $this->location->get_active_locations_except_current($admin_loc_id);
        $data['active_items']       = $this->item->get_active_items();
        $data['active_couriers']    = $this->user->get_users_by_type(3);
        $data['admin_loc']          = $this->location->get_location_row_by_id($_SESSION['user_loc_id']);

        $view = $this->load->view('inventory/transfers', $data, true);
        $this->template($view);
    }

    function transfer_form_submit()
    {
        $this->form_validation->set_rules('serial', 'Item serial number', 'required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'required');

        if ($this->form_validation->run() == TRUE) {

            $serial     = $this->input->post('serial');
            $remarks    = $this->input->post('remarks');
            $loc_id     = $this->input->post('location_id');

            $inv_item = $this->stock->get_item_by_serial_by_sql($serial);

            if ($inv_item) {
                $upload_path = './uploads_reports/' . $serial . '/';

                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0755, true);
                }

                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'pdf|jpg|jpeg|png';
                $config['max_size'] = 2048;
                $config['file_name'] = $serial . '-' . date('YmdHis');

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('attachment')) {
                    $error = $this->upload->display_errors();
                    $response = array('status' => 'error_attachment', 'message' => strip_tags($error));
                    echo json_encode($response);
                    exit();
                } else {

                    $upload_data    = $this->upload->data();
                    $attachment     = $upload_path . $upload_data['file_name'];

                    $report_form_data = array(
                        'rlog_item_id'      => $inv_item['inv_item_id'],
                        'rlog_remarks'      => $remarks,
                        'rlog_serial'       => $serial,
                        'rlog_attachment'   => $attachment,
                        'rlog_status'       => 'Pending', // Pending, Reviewed, Disposed, Replaced - 
                        'rlog_added_by'     => $_SESSION['user_id'],
                        'rlog_added_at'     => date('Y-m-d H:i:s'),
                        'rlog_updated_at'   => null,
                        'rlog_location_id'  => $loc_id,
                    );

                    if ($this->report->insert_report('report_logs', $report_form_data)) {
                        $response = array('status' => 'success', 'message' => 'Report submitted. Thank you!');
                    } else {
                        $response = array('status' => 'error', 'message' => 'Failed to submit a report. Please try again.');
                    }
                    echo json_encode($response);
                }
            } else {
                $response = array('status' => 'error_serial', 'message' => 'Item not found. Please make sure the serial number is correct.');
                echo json_encode($response);
            }
        } else {
            $errors = $this->form_validation->error_array();
            $response = array('status' => 'validation_error', 'message' => $errors);
            echo json_encode($response);
        }
    }
}
