<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom scripts -->
<script>
    $(document).ready(function() {
        // client side my reported items datatable
        $('#stock_transfers').DataTable({
            responsive: true,
            searching: true,
            processing: true,
            bPaginate: false,
            bLengthChange: false,
            searching: false,
            info: false,
            ajax: {
                url: '<?php echo site_url(); ?>/inventory/report/get_my_submitted_reports',
                // dataSrc: 'data',
                type: 'POST',
            },
            columns: [{
                    "sortable": false,
                    "data": null,
                    "className": "text-center align-middle",
                    "render": function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data": "item_name",
                    "className": "text-start align-middle"
                },
                {
                    "sortable": false,
                    "data": "serial",
                    "className": "text-start align-middle"
                },
                {
                    "sortable": false,
                    "data": "status",
                    "className": "text-start align-middle",
                    "createdCell": function(td, cellData, rowData, row, col) {
                        var className = "";
                        switch (cellData) {
                            case "Pending":
                                className = "bg-warning";
                                break;
                            case "Reviewed":
                                className = "bg-info";
                                break;
                            case "Disposed":
                                className = "bg-danger";
                                break;
                            case "Replaced":
                                className = "bg-success";
                                break;
                            default:
                                className = "";
                                break;
                        }
                        $(td).addClass('p-0 text-center');
                        $(td).html("<span class='" + className + "'>" + cellData + "</span>");
                    },
                    "render": function(data, type, row, meta) {
                        return data; // Return the raw data
                    }
                },
                {
                    "data": "date_reported",
                    "className": "text-start align-middle",
                }
            ],
        });

        $(document).on('submit', 'form[id^="addTransferForm"]', function(e) {
            e.preventDefault();

            var form = $(this)[0];
            var formData = new FormData(form);

            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>/inventory/transfer/transfer_form_submit/",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status === 'error_serial') {
                        $('#stock_transfers').DataTable().ajax.reload(null, false);
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    } else {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#stock_transfers').DataTable().ajax.reload();
                    }
                },
                error: function(xhr, status, error) {
                    var response = JSON.parse(xhr.responseText);
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                    console.error('AJAX ERROR: ' + xhr.responseText);
                    console.error('SUBMIT REPORT LOG ERROR: ' + error);
                }
            });
        });

        $(document).on('change', '.item_select', function() {
            var itemId = $(this).val();
            var stocksRemaining = $(this).siblings('.stocks-remaining');
            var quantityInput = $(this).closest('tr').find('.quantity');

            if (itemId) {
                $.ajax({
                    url: "<?php echo site_url(); ?>/inventory/transfer/get_item_remaining_current_location/",
                    type: 'POST',
                    data: {
                        item_id: itemId
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.status === 'success') {
                            if (data.stocks_remaining !== undefined) {
                                stocksRemaining.text('Stocks remaining: ' + data.stocks_remaining).show();
                                quantityInput.attr('max', data.stocks_remaining);
                            }
                        } else {
                            stocksRemaining.text('Stocks remaining: Error fetching data').show();
                            quantityInput.attr('max', '');
                        }
                    },
                    error: function() {
                        stocksRemaining.text('Stocks remaining: Error fetching data').show();
                        quantityInput.attr('max', '');
                    }
                });
            } else {
                stocksRemaining.hide();
                quantityInput.attr('max', '');
            }
        });

        $(document).on('input', '.quantity', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });


        $('.courier_select').select2({
            width: '100%',
            theme: "classic",
            placeholder: "Select courier",
        });

        $('.location_select').select2({
            width: '100%',
            theme: "classic",
            placeholder: "Select location",
        });

        $('.item_select').select2({
            width: '100%',
            theme: "classic",
            placeholder: "Select item",
        });

        $('#addItemButton').click(function() {
            addItemRow();
        });

        $(document).on('click', '.remove-item', function() {
            $(this).closest('tr').remove();
            reindexItemRows();
        });

        $('.location_select').change(function() {
            var location_id = $(this).val();
            if (location_id) {
                generateBatchCode(location_id);
            }
        });

    });

    var itemIndex = 1;

    function addItemRow() {
        var newRow = `
                        <tr>
                            <td>
                                <select name="items[` + itemIndex + `][item_id]" class="form-control item_select" required>
                                    <option value="">Select item</option>
                                    <?php foreach ($active_items as $item) : ?>
                                        <option value="<?php echo $item['item_id']; ?>"><?php echo $item['item_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <p class="stocks-remaining">Stocks remaining: {value here}</p>
                            </td>
                            <td class="align-middle">
                                <input type="number" name="items[` + itemIndex + `][quantity]" class="form-control quantity" placeholder="" min="1" required>
                            </td>
                            <td class="action align-middle text-center">
                                <button type="button" class="btn btn-danger remove-item btn-sm">Remove</button>
                            </td>
                        </tr>
                    `;
        $('#itemsTable tbody').append(newRow);
        initializeSelect2();
        reindexItemRows();
        itemIndex++;
    }

    function reindexItemRows() {
        itemIndex = 0;
        $('#itemsTable tbody tr').each(function() {
            $(this).find('select[name^="items["]').attr('name', 'items[' + itemIndex + '][item_id]');
            itemIndex++;
        });
    }

    function checkRemoveButtons() {
        if ($('#itemsTable tbody tr').length == 1) {
            $('.remove-item').prop('disabled', true);
        } else {
            $('.remove-item').prop('disabled', false);
        }
    }

    function initializeSelect2() {
        $('.item_select').select2({
            width: '100%',
            theme: 'classic',
            placeholder: 'Select item',
        });
    }

    function generateBatchCode(location_id) {
        $.ajax({
            url: '<?php echo site_url(); ?>/inventory/stock/get_batch_code/',
            type: 'POST',
            dataType: 'json',
            data: {
                location_id: location_id
            },
            success: function(response) {
                if (response.batch_code) {
                    $('#batchCode').val(response.batch_code);
                } else {
                    console.error('Failed to generate batch code.');
                }
            },
            error: function() {
                console.error('An error occurred while generating the batch code.');
            }
        });
    }
</script>

<i class='bx bx-menu' style='margin-top: .7%;'></i>
<div class="container-sm mt-2">
    <div class="row">
        <div class="col-md-6">
            <div class="form-container p-4 rounded shadow-sm bg-light">

                <div class="d-flex justify-content-between align-items-center form-header mb-4">
                    <h5>Transfer Stocks Form</h5>
                </div>

                <?php echo form_open_multipart('inventory/transfer/insert_transfer', array('id' => 'addTransferForm')); ?>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="courier" class="form-label">Courier</label>
                            <select name="courier_id" class="form-control courier_select" required>
                                <option value="">Select courier</option>
                                <?php foreach ($active_couriers as $courier) : ?>
                                    <option value="<?php echo $courier['user_id']; ?>"><?php echo $courier['user_first_name'] . ' ' . $courier['user_last_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="location" class="form-label">Transfer to</label>
                            <select name="location_id" class="form-control location_select" required>
                                <option value="">Select Location</option>
                                <?php foreach ($active_locations as $location) : ?>
                                    <option value="<?php echo $location->location_id; ?>"><?php echo $location->location_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="batch_code" id="batchCode" value="" hidden>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="attachment" class="form-label">Attachment</label>
                            <input type="file" name="attachment" class="form-control" id="attachment" required>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" name="requires_approval" value="1" id="requires_approval">
                                <label class="form-check-label" for="requires_approval">
                                    Requires Approval from Receiving Location
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea name="remarks" class="form-control" id="remarks" placeholder="Enter remarks here..." rows="3"></textarea>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="itemsTable">
                            <thead>
                                <tr>
                                    <th class="col-md-6">Select Item</th>
                                    <th class="col-md-2 text-center">Quantity</th>
                                    <th class="col-md-2 action text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="align-middle">
                                    <td>
                                        <select name="items[0][item_id]" class="form-control item_select" required>
                                            <option value="">Select item</option>
                                            <?php foreach ($active_items as $item) : ?>
                                                <option value="<?php echo $item['item_id']; ?>"><?php echo $item['item_name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <p class="stocks-remaining">Stocks remaining: {value here}</p>
                                    </td>
                                    <td class="align-middle">
                                        <input type="number" name="items[0][quantity]" class="form-control quantity" placeholder="" min="1" required>
                                        <p class="stocks-remaining">&zwnj;</p>
                                    </td>
                                    <td class="action align-middle text-center">
                                        <button type="button" class="btn btn-danger remove-item btn-sm" disabled>Remove</button>
                                        <p class="stocks-remaining">&zwnj;</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-primary mt-3 btn-sm" id="addItemButton">Add Item</button>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
                <?php echo form_close(); ?>


            </div>
        </div>

        <div class="col-md-6">
            <div class="table-container p-4 rounded shadow-sm bg-light">
                <h5 class="mb-4 text-primary">Stock Transfers Between Locations</h5>
                <table class="table table-striped" id="stock_transfers">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col"><strong>Name</strong></th>
                            <th scope="col"><strong>Serial</strong></th>
                            <th scope="col" class="text-center"><strong>Status</strong></th>
                            <th scope="col"><strong>Date reported</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .stocks-remaining {
        color: red;
        margin-left: 9px;
        margin-bottom: -2px;
        margin-top: 5px;
        display: none;
    }

    .form-container,
    .table-container {
        background-color: #f8f9fa;
        padding: 2%;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-header h5,
    .table-container h5 {
        color: #007bff;
    }

    .form-group label {
        font-weight: bold;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .bg-warning {
        background-color: #ffc107 !important;
        color: #fff;
        padding: 5px;
        border-radius: 5px;
        display: inline-block;
        width: 100px;
        /* Set a fixed width */
        text-align: center;
        /* Center the text */
    }

    .bg-info {
        background-color: #17a2b8 !important;
        color: #fff;
        padding: 5px;
        border-radius: 5px;
        display: inline-block;
        width: 100px;
        text-align: center;
    }

    .bg-danger {
        background-color: #dc3545 !important;
        color: #fff;
        padding: 5px;
        border-radius: 5px;
        display: inline-block;
        width: 100px;
        text-align: center;
    }

    .bg-success {
        background-color: #28a745 !important;
        color: #fff;
        padding: 5px;
        border-radius: 5px;
        display: inline-block;
        width: 100px;
        text-align: center;
    }
</style>