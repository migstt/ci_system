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
        $this->load->module('inventory/stock');
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
        $this->form_validation->set_rules('remarks', 'Remarks', 'required');
        $this->form_validation->set_rules('location_id', 'Location', 'required');
        $this->form_validation->set_rules('batch_code', 'Batch code', 'required');

        if ($this->form_validation->run() == TRUE) {

            $batch_code     = $this->input->post('batch_code');
            $remarks        = $this->input->post('remarks');
            $location_id    = $this->input->post('location_id');
            $courier_id     = $this->input->post('courier_id');
            // If the "requires_approval" checkbox is unchecked, the $checkbox_value would be 0.
            $checkbox_value = $this->input->post('requires_approval') ? 1 : 0;
            $added_by       = $_SESSION['user_id'];
            $items          = $this->input->post('items');


            $upload_path = './uploads/' . $location_id . '/' . $batch_code . '/';

            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0755, true);
            }

            $config['upload_path']   = $upload_path;
            $config['allowed_types'] = 'pdf|jpg|jpeg|png';
            $config['max_size']      = 2048;
            $config['file_name']     = $batch_code . '-' . date('YmdHis');

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('attachment')) {
                $error      = array('error' => $this->upload->display_errors());
                $response   = array('status' => 'error_attachment', 'message' => $error['error']);
                echo json_encode($response);
                exit();
            } else {

                $data           = $this->upload->data();
                $attachment     = $upload_path . $data['file_name'];

                if ($checkbox_value == 0) {

                    $inv_status = 2;

                    $transfer_location  = $this->location->get_location_row_by_id($location_id);
                    $current_location   = $this->location->get_location_row_by_id($_SESSION['user_loc_id']);

                    $task_formdata = array(
                        'task_assigned_by'          => $_SESSION['user_id'],
                        'task_title'                => 'Stock Transfer Task',
                        'task_description'          => 'Stock Transfer Task from ' . $current_location['location_name'] . ' to ' . $transfer_location['location_name'],
                        'task_assigned_to_user'     => $courier_id,
                        'task_status'               => 'pending',
                        'task_created_at'           => date('Y-m-d H:i:s'),
                        'task_updated_at'           => null,
                        'task_completed_at'         => null,
                        'task_due_date'             => null,
                        'task_is_deleted'           => 0,
                    );

                    // $task_id = $this->task->insert_stock_task($task_formdata, $courier_id);

                    foreach ($items as $item) {
                        $last_inserted_item_serial = $this->stock->get_last_inserted_serial_number_of_a_specific_item($item['item_id'], $current_location['location_id']);
                        $last_serial = substr($last_inserted_item_serial['serial'], 3);
                        $last_serial_int = (int) $last_serial - 1;
                        cute_print($last_serial_int);

                    
                    }

                    // Message: Call to undefined method Inventory_model::update_inventory_by_batch()

                    $this->inventory->update_inventory_by_batch($batch_code, $inv_status);

                } else {
                    $inv_trk_status = 0;
                    $task_id = null;
                }

                $tracking_data  = array(
                    'inv_trk_batch_num'         => $batch_code,
                    'inv_trk_location_id'       => $location_id,
                    'inv_trk_notes'             => $remarks,
                    'inv_trk_courier'           => $courier_id,
                    'inv_trk_task_id'           => $task_id,
                    'inv_trk_attachment'        => $attachment,
                    'inv_trk_status'            => $inv_trk_status, // 0 - Delivered, 1 - Issued, 2 - Approved by Warehouse Manager, 3 - On the Way
                    'inv_trk_added_by'          => $added_by,
                    'inv_trk_added_at'          => date('Y-m-d H:i:s'),
                    'inv_trk_updated_at'        => NULL
                );

                if ($this->stock->insert_stock($tracking_data)) {
                    $items = $this->input->post('items');
                    foreach ($items as $item) {

                        $quantity               = $item['quantity'];
                        $item_serial_initial    = substr($item['serial_code'], 0, 3);
                        $item_serial_num        = (int) substr($item['serial_code'], 3);

                        for ($i = 0; $i < $quantity; $i++) {

                            $new_serial_number = str_pad($item_serial_num, 8, '0', STR_PAD_LEFT);
                            $new_serial = $item_serial_initial . $new_serial_number;

                            $item_data = array(
                                'inv_tracking_id'   => $batch_code,
                                'inv_item_id'       => $item['item_id'],
                                'inv_unit_cost'     => $item['unit_cost'],
                                'inv_brand'         => $item['brand'],
                                'inv_serial'        => $new_serial,
                                'inv_assigned_to'   => $location_id,
                                'inv_status'        => $inv_trk_status,  // 0 - Delivered, 1 - Issued, 2 - Approved by Warehouse Manager, 3 - On the Way
                                'inv_added_by'      => $added_by,
                                'inv_added_at'      => date('Y-m-d H:i:s'),
                                'inv_updated_at'    => NULL
                            );
                            if ($this->inventory->insert_items($item_data)) {
                                $response = array('status' => 'success', 'message' => 'Stocks added successfully.');
                                $item_serial_num++;
                            } else {
                                $response = array('status' => 'error_item_insert', 'message' => 'Database error. Please try again.');
                                echo json_encode($response);
                                return;
                            }
                        }
                    }
                    echo json_encode($response);
                } else {
                    $response = array('status' => 'error_stock_insert', 'message' => 'Database error. Please try again.');
                    echo json_encode($response);
                }
            }
        } else {
            $response = array('status' => 'validation_error', 'message' => validation_errors());
            echo json_encode($response);
        }
    }

    function get_item_remaining_current_location()
    {
        $item_id        = $this->input->post('item_id');
        $location_id    = $_SESSION['user_loc_id'];
        $count          = $this->inventory->get_item_remaining_current_location($item_id, $location_id);

        if ($count) {
            echo json_encode(['status' => 'success', 'stocks_remaining' => $count['total_remaining']]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Unable to fetch data']);
        }
    }
}
