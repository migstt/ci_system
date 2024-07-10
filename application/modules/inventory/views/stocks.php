<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom scripts -->
<script>
    $(document).ready(function() {

        checkRemoveButtons();
        initializeSelect2();
        generateBatchCode();

        // ajax for adding stocks
        $(document).on('submit', 'form[id^="addNewStocksForm"]', function(e) {
            e.preventDefault();

            var attachmentField = $('#attachment');
            if (attachmentField.get(0).files.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select a file to upload!',
                });
                return;
            }

            var form = $(this);

            // loading indicator
            Swal.fire({
                title: 'Loading...',
                text: 'Please wait while stocks are being added.',
                allowOutsideClick: false,
                showConfirmButton: false,
                onOpen: () => {
                    swal.showLoading();
                }
            });

            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>/inventory/stock/insert_stocks/",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    $('#stocks_table').DataTable().ajax.reload(null, false);
                    generateBatchCode();
                    response = JSON.parse(response);
                    form.closest('.modal').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();

                    Swal.close();
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                },
                error: function(xhr, status, error, response) {
                    response = JSON.parse(response);
                    form.closest('.modal').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();

                    Swal.close();
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                    console.error('AJAX ERROR: ' + xhr.responseText);
                    console.error('ADD STOCKS ERROR: ' + error);
                }
            });
        });
        $('.location_select').select2({
            dropdownParent: '#addNewStocksModal .modal-content',
            width: '100%',
            theme: "classic",
            placeholder: "Select location",
        });

        $('.item_select').select2({
            dropdownParent: '#addNewStocksModal .modal-content',
            width: '100%',
            theme: "classic",
            placeholder: "Select item",
        });

        $('.supplier_select').select2({
            dropdownParent: '#addNewStocksModal .modal-content',
            width: '100%',
            theme: "classic",
            placeholder: "Select supplier",
        });

        $('.warehouse_select').select2({
            dropdownParent: '#addNewStocksModal .modal-content',
            width: '100%',
            theme: "classic",
            placeholder: "Select warehouse",
        });

        flatpickr("#date_received", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today",
        });

        $('#addItemButton').click(function() {
            addItemRow();
        });

        $(document).on('click', '.remove-item', function() {
            $(this).closest('tr').remove();
            reindexItemRows();
        });

        // enable/disable fields based on item selection
        $(document).on('change', '.item_select', function() {
            var selectedValue = $(this).val();
            var $unitCost = $(this).siblings('.unit_cost');
            var $brand = $(this).siblings('.brand');
            var $serialCode = $(this).siblings('.serial_code');
            var $quantity = $(this).closest('tr').find('.quantity');

            if (selectedValue) {
                $unitCost.prop('disabled', false).attr('placeholder', 'Unit cost');
                $brand.prop('disabled', false).attr('placeholder', 'Brand');
                $serialCode.prop('disabled', false).attr('placeholder', 'Serial code');
                $quantity.prop('disabled', false).attr('placeholder', 'Quantity: ');
                $serialCode.prop('readonly', true);

                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url(); ?>/inventory/stock/get_last_inserted_serial_number_of_a_specific_item',
                    data: {
                        item_id: selectedValue
                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        if (response.status === 'success') {
                            $serialCode.val(response.serial);
                        } else {
                            console.error('Error: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX ERROR: ' + xhr.responseText);
                        console.error('GET ITEM DETAILS ERROR: ' + error);
                    }
                });
            } else {
                $unitCost.prop('disabled', true).attr('placeholder', 'Please choose an item first.');
                $brand.prop('disabled', true).attr('placeholder', 'Please choose an item first.');
                $serialCode.prop('disabled', true).attr('placeholder', 'Please choose an item first.');
            }
        });

        // calculate amount when unit cost or quantity changes
        $(document).on('input', '.unit_cost, .quantity', function() {
            var $row = $(this).closest('tr');
            var unitCost = parseFloat($row.find('.unit_cost').val()) || 0;
            var quantity = parseFloat($row.find('.quantity').val()) || 0;
            var amount = unitCost * quantity;
            $row.find('.amount').val(amount.toFixed(2));
            $row.find('.amount_display').val(amount.toFixed(2));
            calculateTotalCost();
        });

        flatpickr("#due_date", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today",
        });

        // for flatpickr bug on month dropdown
        $("#addNewStocksModal").modal({
            show: true,
            focus: false
        });

        // client side stocks datatable
        $('#stocks_table').DataTable({
            responsive: true,
            searching: true,
            processing: true,
            ajax: {
                url: '<?php echo site_url(); ?>/inventory/stock/get_stocks',
                // dataSrc: 'data',
                dataSrc: function(json) {
                    window.editUserOptions = json.edit_user_options;
                    window.editTeamOptions = json.edit_team_options;
                    return json.data;
                },
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
                    "data": "batch_code",
                    "className": "text-start align-middle"
                },
                {
                    "data": "supplier",
                    "className": "text-start align-middle"
                },
                {
                    "data": "warehouse",
                    "className": "text-start align-middle"
                },
                {
                    "data": "total_cost",
                    "className": "text-start align-middle",
                },
                {
                    "data": "location",
                    "className": "text-start align-middle",
                },
                {
                    "data": "date_received",
                    "className": "text-start align-middle",
                },
                {
                    "data": "added_by",
                    "className": "text-start align-middle",
                },
                // action button for viewing other stock details like remarks, attachments, etc..
                {
                    "data": null,
                    "sortable": false,
                    "className": "align-middle",
                    render: function(data, type, row) {
                        return `
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#viewStockDetailsModal">View Details</button>
                        `;
                    }
                }
            ],
        });

        // for Flatpickr bug on month dropdown
        $("[id^='editTaskModal']").modal({
            show: true,
            focus: false
        });

        // initialize Flatpickr in the dynamically generated modals
        $(document).on('shown.bs.modal', function(event) {
            var modal = $(event.target);
            var input = modal.find('input[id^="due_date"]');
            if (input.length) {
                flatpickr(input, {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    minDate: "today"
                });
            }
        });

        // server side contacts datatable, currently hidden
        $('#ssp_contacts_table').DataTable({
            searching: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?php echo site_url(); ?>/contact/get_contacts_ssp',
                type: 'GET',
            },
            columns: [{
                    "data": null,
                    "render": function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'full_name'
                },
                {
                    data: 'company'
                },
                {
                    data: 'phone'
                },
                {
                    data: 'email'
                },
                // for the contact actions (edit, share, delete) row
                {
                    data: 'actions',
                    sortable: false,
                },
            ],
        });

        $('#assign_to_team').change(function() {
            if (this.checked) {
                $('#team_selected').prop('disabled', false);
                $('#user_selected').prop('disabled', true);
                $('#user_selected').val('Default');
            } else {
                $('#team_selected').prop('disabled', true);
                $('#user_selected').prop('disabled', false);
                $('#team_selected').val('Default');
            }
        });

        // event listener for changes in quantity field
        $(document).on('input', '.quantity', function() {
            var $row = $(this).closest('tr');
            var quantity = parseInt($(this).val(), 10);
            var serialCode = $row.find('.serial_code').val().trim();

            if (serialCode && quantity > 0) {
                var serialInitial = serialCode.substring(0, 3);
                var serialNum = parseInt(serialCode.substring(3), 10);

                if (quantity === 1 || quantity === 0) {
                    $row.find('.serial_code').val(serialCode);
                } else {
                    var endSerialNum = serialNum + quantity - 1;
                    var endSerialCode = serialInitial + endSerialNum.toString().padStart(8, '0');
                    var serialRange = serialInitial + serialNum.toString().padStart(8, '0') + ' - to - ' + endSerialCode;
                    $row.find('.serial_code').val(serialRange);
                }
            }
        });

        $('.supplier_select').on('change', function() {
            var supplierId = $(this).val();
            var warehouseSelect = $('.warehouse_select');
            var selectSupplierWarn = $('.select_supplier_warn');

            if (supplierId) {
                // Remove the warning message
                selectSupplierWarn.hide();

                $.ajax({
                    url: "<?php echo site_url(); ?>/inventory/stock/get_supplier_specific_warehouses/",
                    type: 'POST',
                    data: {
                        supplier_id: supplierId
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.status === 'success') {
                            warehouseSelect.empty().append('<option value="">Select warehouse</option>');
                            $.each(data.warehouses, function(index, warehouse) {
                                warehouseSelect.append('<option value="' + warehouse.wh_id + '">' + warehouse.wh_name + '</option>');
                            });
                            warehouseSelect.prop('disabled', false);
                        } else {
                            alert(data.message);
                        }
                    },
                    error: function() {
                        alert('An error occurred while fetching warehouses.');
                    }
                });
            } else {
                // Show the warning message again if no supplier is selected
                selectSupplierWarn.show();
                warehouseSelect.prop('disabled', true).empty().append('<option value="">Please select supplier first</option>');
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
                                <input type="text" name="items[` + itemIndex + `][unit_cost]" class="form-control mt-2 unit_cost" placeholder="Please choose an item first." disabled>
                                <input type="text" name="items[` + itemIndex + `][brand]" class="form-control mt-2 brand" placeholder="Please choose an item first." disabled>
                                <label class="mt-2">Serial Number:</label>
                                <input type="text" id="serial_code[` + itemIndex + `]" name="items[` + itemIndex + `][serial_code]" class="form-control mt-2 serial_code" placeholder="Please choose an item first." disabled>
                            </td>
                            <td>
                                <label class="mt-2 mb-2">Quantity:</label>
                                <input type="number" name="items[` + itemIndex + `][quantity]" class="form-control quantity" placeholder="Quantity: 0" min="1" required>
                                <input type="number" name="items[` + itemIndex + `][amount]" class="form-control mt-2 amount" placeholder="Amount: 0" value="0" min="0" required hidden>
                                <label class="mt-2">Amount:</label>
                                <input type="number" name="items[` + itemIndex + `][amount]" class="form-control mt-2 amount_display" placeholder="Amount: 0" min="0" disabled>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger remove-item">Remove</button>
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
            $(this).find('input[name^="items["][name$="[quantity]"]').attr('name', 'items[' + itemIndex + '][quantity]');
            $(this).find('input[name^="items["][name$="[amount]"]').attr('name', 'items[' + itemIndex + '][amount]');
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
            dropdownParent: '#addNewStocksModal .modal-content',
            width: '100%',
            theme: 'classic',
            placeholder: 'Select item',
        });
    }

    function calculateTotalCost() {
        var totalCost = 0;
        $('.amount').each(function() {
            totalCost += parseFloat($(this).val()) || 0;
        });
        $('#total_cost_display').val('₱ ' + totalCost.toFixed(2));
        $('#total_cost').val(totalCost.toFixed(2));
    }

    function generateBatchCode() {
        $.ajax({
            url: '<?php echo site_url(); ?>/inventory/stock/get_batch_code/',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // console.log('Batch code response:', response);
                if (response.batch_code) {
                    $('#batchCode').val(response.batch_code);
                    $('#batchCodeDisplay').val(response.batch_code);
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
<div class="container-sm">
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="mt-2">Stocks</h5>
    </div>

    <!-- Add New Stocks Button -->
    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addNewStocksModal">
        Add stocks
    </button>

    <!-- Stocks Table -->
    <div class="supplier-table-container">
        <table class="table table-sm table-striped" class="display" id="stocks_table">
            <thead>
                <tr>
                    <th class="text-center"></th>
                    <th class="text-start"><strong>Batch code</strong></th>
                    <th class="text-start"><strong>Supplier</strong></th>
                    <th class="text-start"><strong>Warehouse</strong></th>
                    <th class="text-start"><strong>Total cost</strong></th>
                    <th class="text-start"><strong>Location</strong></th>
                    <th class="text-start"><strong>Date received</strong></th>
                    <th class="text-start"><strong>Added by</strong></th>
                    <th class="text-center"><strong>Details</strong></th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Add New Stocks Modal -->
    <div class="modal fade" id="addNewStocksModal" tabindex="-1" aria-labelledby="addNewStocksModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewStocksModalLabel">Add stocks</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <?php echo form_open_multipart('inventory/stock/insert_stocks', array('id' => 'addNewStocksForm')); ?>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="batchCodeDisplay" class="form-label">Batch Code</label>
                            <input type="text" class="form-control" name="batch_code" id="batchCode" value="" hidden>
                            <input type="text" class="form-control" name="batch_code_display" id="batchCodeDisplay" value="" disabled>
                        </div>

                        <div class="col-md-6">
                            <label for="totalCost" class="form-label">Total Cost</label>
                            <input type="text" class="form-control" id="total_cost_display" placeholder="₱ 0" disabled>
                            <input type="hidden" name="total_cost" id="total_cost" value="0">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="supplier" class="form-label">Supplier</label>
                            <select name="supplier_id" class="form-control supplier_select" required>
                                <option value="">Select supplier</option>
                                <?php foreach ($active_suppliers as $supplier) : ?>
                                    <option value="<?php echo $supplier['supplier_id']; ?>"><?php echo $supplier['supplier_name']; ?></option>
                                <?php endforeach; ?>
                            </select>

                            <label for="warehouse" class="form-label mt-3" style="margin-bottom: -2px;">Warehouse</label>
                            <p style="color: red; display: inline;" class="select_supplier_warn">Please select a supplier first.</p>
                            <select name="warehouse_id" class="form-control warehouse_select" required disabled>
                                <option value="">Please select supplier first</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea name="remarks" class="form-control" id="remarks" placeholder="Enter remarks here..."></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="dateReceived" class="form-label">Date Received</label>
                            <input name="date_received" id="date_received" type="date" class="form-control" placeholder="Date received" aria-label="Date received" required />
                        </div>
                        <div class="col-md-6">
                            <label for="location" class="form-label">Location</label>
                            <select name="location_id" class="form-control location_select" required>
                                <option value="">Select Location</option>
                                <?php foreach ($active_locations as $location) : ?>
                                    <option value="<?php echo $location->location_id; ?>"><?php echo $location->location_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="attachment" class="form-label">Attachment</label>
                            <input type="file" name="attachment" class="form-control" id="attachment">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="itemsTable">
                            <thead>
                                <tr>
                                    <th>Item details</th>
                                    <th>Quantity & Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="items[0][item_id]" class="form-control item_select" required>
                                            <option value="">Select item</option>
                                            <?php foreach ($active_items as $item) : ?>
                                                <option value="<?php echo $item['item_id']; ?>"><?php echo $item['item_name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input type="text" class="form-control mt-2 unit_cost" name="items[0][unit_cost]" placeholder="Please select an item first." disabled>
                                        <input type="text" class="form-control mt-2 brand" name="items[0][brand]" placeholder="Please select an item first." disabled>
                                        <label class="mt-2">Serial Number:</label>
                                        <input type="text" class="form-control mt-2 serial_code" name="items[0][serial_code]" placeholder="Please select an item first." disabled>
                                    </td>
                                    <td>
                                        <label class="mt-2 mb-2">Quantity:</label>
                                        <input type="number" name="items[0][quantity]" class="form-control quantity" placeholder="Quantity: 0" min="1" required disabled>
                                        <input type="number" name="items[0][amount]" class="form-control mt-2 amount" placeholder="Amount: 0" min="0" value="0" required hidden>
                                        <label class="mt-2">Amount:</label>
                                        <input type="number" name="items[0][amount]" class="form-control mt-2 amount_display" placeholder="Amount: 0" min="0" disabled>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger remove-item">Remove</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-primary mt-3" id="addItemButton">Add Item</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>