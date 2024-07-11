<?php

class Stock extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('user/user_model', 'user');
        $this->load->model('team/team_model', 'team');
        $this->load->model('inventory_model', 'inventory');
        $this->load->model('inventory/stock_model', 'stock');
        $this->load->model('inventory/supplier_model', 'supplier');
        $this->load->model('inventory/location_model', 'location');
        $this->load->model('inventory/item_model', 'item');
        $this->load->model('inventory/warehouse_model', 'warehouse');
        $this->load->library('parser');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('session');
    }

    function index()
    {
        $this->stocks();
    }

    function stocks()
    {
        $data['active_suppliers']   = $this->supplier->get_active_suppliers();
        $data['active_locations']   = $this->location->get_active_locations();
        $data['active_items']       = $this->item->get_active_items();
        $data['batch_code']         = $this->generate_batch_code();

        if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
            $view = $this->load->view('inventory/stocks', $data, true);
            $this->template($view);
        } else {
            redirect('forbidden');
        }
    }

    public function insert_stocks()
    {
        $this->form_validation->set_rules('supplier_id', 'Supplier', 'required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'required');
        $this->form_validation->set_rules('date_received', 'Date Received', 'required');
        $this->form_validation->set_rules('location_id', 'Location', 'required');

        if ($this->form_validation->run() == TRUE) {

            $batch_code     = $this->input->post('batch_code');
            $total_cost     = $this->input->post('total_cost');
            $supplier_id    = $this->input->post('supplier_id');
            $warehouse_id   = $this->input->post('warehouse_id');
            $remarks        = $this->input->post('remarks');
            $date_received  = $this->input->post('date_received');
            $location_id    = $this->input->post('location_id');
            $added_by       = $_SESSION['user_id'];

            $upload_path = './uploads/' . $batch_code . '/';

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

                $tracking_data  = array(
                    'inv_trk_batch_num'         => $batch_code,
                    'inv_trk_location_id'       => $location_id,
                    'inv_trk_total_cost'        => $total_cost,
                    'inv_trk_notes'             => $remarks,
                    'inv_trk_supplier_id'       => $supplier_id,
                    'inv_trk_warehouse_id'      => $warehouse_id,
                    'inv_trk_date_delivered'    => $date_received,
                    'inv_trk_attachment'        => $attachment,
                    'inv_trk_status'            => 0,
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
                                'inv_warehouse_id'  => $warehouse_id,
                                'inv_assigned_to'   => $location_id,
                                'inv_status'        => 0,
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



    public function get_stocks()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_email'])) {
            redirect('login');
        }

        $stocks = $this->stock->get_stocks();

        if ($stocks === false || empty($stocks)) {
            $stocks = array();
        }

        $data = array();
        foreach ($stocks as $stock) {

            $stock_added_by     = $this->user->get_user_row_by_id($stock['inv_trk_added_by']);
            $stock_location     = $this->location->get_location_row_by_id($stock['inv_trk_location_id']);
            $stock_supplier     = $this->supplier->get_supplier_row_by_id($stock['inv_trk_supplier_id']);
            $stock_warehouse    = $this->warehouse->get_warehouse_row_by_id($stock['inv_trk_warehouse_id']);
            $items_by_batch     = $this->inventory->get_items_ordered_by_batch($stock['inv_trk_batch_num']);

            $data[] = array(
                'batch_id'          => $stock['inv_trk_id'],
                'batch_code'        => $stock['inv_trk_batch_num'],
                'supplier'          => $stock_supplier['supplier_name'],
                'warehouse'         => $stock_warehouse['wh_name'],
                'total_cost'        => $stock['inv_trk_total_cost'],
                'items_info'        => $items_by_batch,
                'location'          => $stock_location['location_name'],
                'date_received'     => $stock['inv_trk_date_delivered'],
                'added_by'          => $stock_added_by['user_first_name'] . ' ' . $stock_added_by['user_last_name'],
                'remarks'           => $stock['inv_trk_notes'],
                'attachment'        => $stock['inv_trk_attachment'],
                'status'            => $stock['inv_trk_status'] == 0 ? 'Delivered' : 'Issued',
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

    private function generate_batch_code()
    {
        $last_inserted_batch_number = $this->stock->get_last_inserted_batch_number();

        if (!$last_inserted_batch_number) {
            return 'B00000001';
        } else {
            $last_inserted_batch_number = $last_inserted_batch_number['inv_trk_batch_num'];
            $last_inserted_batch_number = substr($last_inserted_batch_number, 1);
            $new_batch_number = $last_inserted_batch_number + 1;
            return 'B' . str_pad($new_batch_number, 8, '0', STR_PAD_LEFT);
        }
    }

    public function get_batch_code()
    {
        echo json_encode(['batch_code' => $this->generate_batch_code()]);
    }

    public function get_last_inserted_serial_number_of_a_specific_item()
    {
        $item_id    = $this->input->post('item_id');
        $last_item  = $this->inventory->get_last_inserted_serial_number($item_id);
        $item       = $this->item->get_item($item_id);

        if (!$item) {
            echo json_encode(['status' => 'error', 'message' => 'Item not found.']);
            return;
        }

        $item_name_cap = strtoupper(substr($item['item_name'], 0, 3));

        if (!$last_item) {
            $new_serial = $item_name_cap . '00000001';
        } else {
            $last_inserted_serial = $last_item['inv_serial'];
            if (strpos($last_inserted_serial, $item_name_cap) === 0) {
                $last_serial_number = substr($last_inserted_serial, 3);
                $new_serial_number  = str_pad((int)$last_serial_number + 1, 8, '0', STR_PAD_LEFT);
                $new_serial         = $item_name_cap . $new_serial_number;
            } else {
                $new_serial = $item_name_cap . '00000001';
            }
        }

        echo json_encode(['status' => 'success', 'serial' => $new_serial]);
    }

    public function get_supplier_specific_warehouses()
    {
        $supplier_id = $this->input->post('supplier_id');
        $warehouses = $this->warehouse->get_supplier_specific_warehouses($supplier_id);

        if (!$warehouses) {
            echo json_encode(['status' => 'error', 'message' => 'No warehouse found for this supplier.']);
            return;
        }

        echo json_encode(['status' => 'success', 'warehouses' => $warehouses]);
    }
}
