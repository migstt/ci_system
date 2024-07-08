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
            $remarks        = $this->input->post('remarks');
            $date_received  = $this->input->post('date_received');
            $location_id    = $this->input->post('location_id');
            $attachment     = $this->input->post('attachment');
            $added_by       = $_SESSION['user_id'];

            $tracking_data = array(
                'inv_trk_batch_num'         => $batch_code,
                'inv_trk_location_id'       => $location_id,
                'inv_trk_total_cost'        => $total_cost,
                'inv_trk_notes'             => $remarks,
                'inv_trk_supplier_id'       => $supplier_id,
                'inv_trk_date_delivered'    => $date_received,
                'inv_trk_status'            => 0,
                'inv_trk_added_by'          => $added_by,
                'inv_trk_added_at'          => date('Y-m-d H:i:s'),
                'inv_trk_attachment'        => $attachment,
                'inv_trk_updated_at'        => NULL
            );

            $tracking_id = $this->stock->insert_stocks($tracking_data);

            $items = $this->input->post('items');
            foreach ($items as $item) {
                $item_data = array(
                    'tracking_id'   => $tracking_id,
                    'item_id'       => $item['item_id'],
                    'unit_cost'     => $item['amount'],
                    'quantity'      => $item['quantity'],
                    'brand'         => NULL,
                    'serial'        => NULL,
                    'attachment'    => NULL,
                    'assigned_to'   => $location_id,
                    'status'        => 1,
                    'added_by'      => $added_by,
                    'date_added'    => date('Y-m-d H:i:s'),
                    'date_updated'  => NULL
                );

                $this->inventory->insert_items($item_data);
            }

            $response = array('status' => 'success', 'message' => 'Stocks added successfully.');
            echo json_encode($response);
        } else {
            $response = array('status' => 'error', 'message' => 'Failed to add stocks. Please try again.');
            echo json_encode($response);
        }
    }

    private function generate_batch_code()
    {
        return 'B00000001';
    }

    private function generate_serial_code()
    {
        return 'S00000001';
    }
}
