<?php

class Report extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('inventory_model', 'inventory');
        $this->load->model('user/user_model', 'user');
        $this->load->model('team/team_model', 'team');
        $this->load->model('report_model', 'report');
        $this->load->model('stock_model', 'stock');
        $this->load->library('parser');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('session');
    }

    function index()
    {
        $this->reports();
    }

    function reports()
    {
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
            $view = $this->load->view('inventory/reports', '', true);
            $this->template($view);
        } else {
            redirect('forbidden');
        }
    }

    function form()
    {
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
            $view = $this->load->view('inventory/report_form', '', true);
            $this->template($view);
        } else {
            redirect('forbidden');
        }
    }

    function report_form_submit()
    {
        $this->form_validation->set_rules('serial', 'Item serial number', 'required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'required');

        if ($this->form_validation->run() == TRUE) {

            $serial = $this->input->post('serial');
            $remarks = $this->input->post('remarks');

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
                $upload_data = $this->upload->data();
                $attachment = $upload_data['file_name'];

                $inv_item = $this->stock->get_item_by_serial($serial);

                $report_form_data = array(
                    'rlog_item_id' => $inv_item['inv_item_id'],
                    'rlog_remarks' => $remarks,
                    'rlog_attachment' => $attachment,
                    'rlog_status' => 0, // 0 = pending, 1 = reviewed, 2 = disposed, 3 = replaced
                    'rlog_added_by' => $_SESSION['user_id'],
                    'rlog_added_at' => date('Y-m-d H:i:s'),
                    'rlog_updated_at' => null,
                );

                if ($this->report->insert_report('report_logs', $report_form_data)) {
                    $response = array('status' => 'success', 'message' => 'Report submitted. Thank you!');
                } else {
                    $response = array('status' => 'error', 'message' => 'Failed to submit a report. Please try again.');
                }
                echo json_encode($response);
            }
        } else {
            $errors = $this->form_validation->error_array();
            $response = array('status' => 'validation_error', 'message' => $errors);
            echo json_encode($response);
        }
    }
}
