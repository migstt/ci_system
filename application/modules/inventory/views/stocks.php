<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom scripts -->
<script>
    $(document).ready(function() {
        // initialize flatpickr for task task due date and time,
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

        // client side other's tasks datatable
        $('#others_tasks').DataTable({
            responsive: true,
            searching: true,
            processing: true,
            ajax: {
                url: '<?php echo site_url(); ?>/task/get_others_tasks',
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
                    "data": "title",
                    "className": "text-start align-middle"
                },
                {
                    "data": "description",
                    "className": "text-start align-middle"
                },
                {
                    "data": "assigned_to",
                    "className": "text-start align-middle",
                },
                {
                    "data": "due_date",
                    "className": "text-start align-middle",
                },
                {
                    "data": "status",
                    "className": "text-start align-middle",
                    "render": function(data) {
                        data = data.replace(/_/g, ' ');
                        data = data.charAt(0).toUpperCase() + data.slice(1);
                        return data;
                    }
                },
                // for the tasks actions (edit, delete) row
                {
                    "data": null,
                    "sortable": false,
                    "className": "align-middle",
                    "render": function(data, type, row) {
                        let options = window.editUserOptions;
                        let optionsHTML = '';
                        for (let key in options) {
                            optionsHTML += `<option value="${key}" ${options[key] == data.assigned_to ? 'selected' : ''}>${options[key]}</option>`;
                        }
                        return `
                            <div class="d-flex justify-content-end">
                                <div class="btn-group btn-group-sm" role="group" aria-label="">
                            
                                    <!-- Update/Edit Task Modal -->
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editTaskModal${data.task_id}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <div class="modal fade" id="editTaskModal${data.task_id}" tabindex="-1" aria-labelledby="editTaskModal" aria-hidden="true">
                                        <?php echo validation_errors(); ?>
                                        <?php echo form_open('task/update_others_task', array('id' => 'editTaskForm${data.task_id}')); ?>
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="modalLabel">Edit Task</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col mb-3">
                                                        <p class="text-start"><strong>Task title</strong></p>
                                                    </div>
                                                    <div class="col">
                                                        <input name="title" value="${data.title}" type="text" class="form-control" placeholder="Task title" aria-label="Task title" required />
                                                    </div>
                                                    <div class="col mt-3 mb-3">
                                                        <p class="text-start"><strong>Task description</strong></p>
                                                    </div>
                                                    <div class="col mt-3 mb-3">
                                                        <textarea name="description" class="form-control" placeholder="Task description" aria-label="Task description" required rows="4">${data.description}</textarea>
                                                    </div>
                                                    <div class="col mt-3 mb-3">
                                                        <p class="text-start"><strong>Task is assigned to: </strong></p>
                                                    </div>
                                                    <div class="col">
                                                        <select name="user_selected" class="form-select" aria-label="User selected">
                                                            ${optionsHTML}
                                                        </select>
                                                    </div> 
                                                    <div class="col mt-3 text-start">
                                                        <p><strong>Task due date</strong></p>
                                                    </div>
                                                    <div class="col">
                                                        <input name="due_date" id="due_date" type="text" class="form-control" placeholder="Due date" aria-label="Due date" required value="${data.due_date}" />
                                                    </div>
                                                    <div class="col">
                                                        <input type="hidden" name="task_id" value="${data.task_id}" type="text" class="form-control" placeholder="task_id" aria-label="task_id" required />
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </form>
                                    </div>


                                    <!-- Delete Confirmation Modal -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal${data.task_id}">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                    <div class="modal fade" id="confirmDeleteModal${data.task_id}" tabindex="-1" aria-labelledby="confirmDeleteModal" aria-hidden="true">
                                    <?php echo form_open('task/delete_task', array('id' => 'deleteTaskForm${data.task_id}')); ?>
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmation</h1>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="task_id" value="${data.task_id}" />
                                                    <p class="text-start">Are you sure you want to delete this task?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-danger">Yes</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Nope</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                }
            ],
        });

        // client side my tasks datatable
        $('#my_tasks').DataTable({
            responsive: true,
            searching: true,
            processing: true,
            ajax: {
                url: '<?php echo site_url(); ?>/task/get_my_tasks',
                dataSrc: 'data',
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
                    "data": "title",
                    "className": "text-start align-middle"
                },
                {
                    "data": "description",
                    "className": "text-start align-middle"
                },
                {
                    "data": "assigned_by",
                    "className": "text-start align-middle",
                },
                {
                    "data": "due_date",
                    "className": "text-start align-middle",
                },
                {
                    "data": "status",
                    "sortable": false,
                    "className": "text-start align-middle",
                    "render": function(data, type, row) {
                        let dropdownItems = '';

                        if (data === 'in_progress') {
                            dropdownItems = `
                                <li><a class="dropdown-item" href="#" onclick="updateStatus('${row.task_id}', 'done')">Done</a></li>
                                <li><a class="dropdown-item" href="#" onclick="updateStatus('${row.task_id}', 'pending')">Pending</a></li>
                            `;
                        } else if (data === 'done') {
                            dropdownItems = `
                                <li><a class="dropdown-item" href="#" onclick="updateStatus('${row.task_id}', 'in_progress')">In Progress</a></li>
                                <li><a class="dropdown-item" href="#" onclick="updateStatus('${row.task_id}', 'pending')">Pending</a></li>
                            `;
                        } else if (data === 'pending') {
                            dropdownItems = `
                                <li><a class="dropdown-item" href="#" onclick="updateStatus('${row.task_id}', 'in_progress')">In Progress</a></li>
                                <li><a class="dropdown-item" href="#" onclick="updateStatus('${row.task_id}', 'done')">Done</a></li>
                            `;
                        }

                        let buttonClass = 'btn-secondary';
                        if (data === 'in_progress') {
                            buttonClass = 'btn-primary';
                        } else if (data === 'done') {
                            buttonClass = 'btn-success';
                        } else if (data === 'pending') {
                            buttonClass = 'btn-danger';
                        }

                        return `
                            <div class="dropdown">
                                <button class="btn btn-fixed-width ${buttonClass} dropdown-toggle" type="button" id="statusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    ${data.replace(/_/g, ' ').charAt(0).toUpperCase() + data.replace(/_/g, ' ').slice(1)}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="statusDropdown">
                                    ${dropdownItems}
                                </ul>
                            </div>
                        `;
                    }
                },
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

        // for adding task
        $(document).on('submit', 'form[id^="addNewTaskForm"]', function(e) {
            e.preventDefault();

            var form = $(this);

            var userSelected = form.find('select[name="user_selected"]').val();
            var teamSelected = form.find('select[name="team_selected"]').val();
            var dueDate = form.find('input[name="due_date"]').val();

            const assignErrorMessageElement = document.querySelector('.assign-error-message p');
            const dateErrorMessageElement = document.querySelector('.date-error-message p');

            let hasError = false;

            if (userSelected === "Default" && teamSelected === "Default") {
                assignErrorMessageElement.textContent = "Please select a user or team to assign this task to.";
                hasError = true;
            } else {
                assignErrorMessageElement.textContent = "";
            }

            if (dueDate === "") {
                dateErrorMessageElement.textContent = "Please select a due date for this task.";
                hasError = true;
            } else {
                dateErrorMessageElement.textContent = "";
            }

            if (hasError) {
                event.preventDefault();
            } else {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url(); ?>/task/insert_task/",
                    data: form.serialize({
                        user_selected: userSelected,
                        team_selected: teamSelected,
                        due_date: dueDate
                    }),
                    success: function(response) {
                        response = JSON.parse(response);
                        $('#others_tasks').DataTable().ajax.reload(null, false);
                        $('#my_tasks').DataTable().ajax.reload(null, false);
                        form.closest('.modal').modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
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
                        $('#others_tasks').DataTable().ajax.reload(null, false);
                        $('#my_tasks').DataTable().ajax.reload(null, false);
                        form.closest('.modal').modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        console.error('AJAX ERROR: ' + xhr.responseText);
                        console.error('ADD TASK ERROR: ' + error);
                    }
                });
            }
        });

        // for updating  tasks
        $(document).on('submit', 'form[id^="editTaskForm"]', function(e) {
            e.preventDefault();
            var form = $(this);
            var id = form.find('input[name="task_id"]').val();

            var has_changes = false;

            form.find('input, textarea').each(function() {
                if ($(this).val() !== $(this).attr('value')) {
                    has_changes = true;
                    return false;
                }
            });

            if (!has_changes) {
                Swal.fire({
                    position: "top-end",
                    icon: "warning",
                    title: 'No changes made.',
                    showConfirmButton: false,
                    timer: 1200
                });
                return;
            }

            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>/task/update_others_task/" + id,
                data: form.serialize(),
                success: function(response) {
                    response = JSON.parse(response);
                    $('#others_tasks').DataTable().ajax.reload(null, false);
                    $('#my_tasks').DataTable().ajax.reload(null, false);
                    form.closest('.modal').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1200
                    });
                },
                error: function(xhr, status, error) {
                    var response = JSON.parse(xhr.responseText);
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1200
                    });
                    console.error('AJAX ERROR: ' + xhr.responseText);
                    console.error('EDIT TASK ERROR: ' + error);
                }
            });
        });

        // for deleting  tasks
        $(document).on('submit', 'form[id^="deleteTaskForm"]', function(e) {
            e.preventDefault();
            var form = $(this);
            var id = form.find('input[name="task_id"]').val();
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>/task/delete_task/" + id,
                data: form.serialize(),
                success: function(response) {
                    response = JSON.parse(response);
                    $('#others_tasks').DataTable().ajax.reload(null, false);
                    $('#my_tasks').DataTable().ajax.reload(null, false);
                    form.closest('.modal').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function(xhr, status, error, response) {
                    response = JSON.parse(response);
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    console.error('AJAX ERROR: ' + xhr.responseText);
                    console.error('DELETE TASK ERROR: ' + error);
                }
            });
        });

    });

    // for updating task status
    function updateStatus(taskId, newStatus) {
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url(); ?>/task/update_task_status/" + taskId,
            data: {
                task_id: taskId,
                status: newStatus
            },
            success: function(response) {
                response = JSON.parse(response);
                $('#my_tasks').DataTable().ajax.reload(null, false);
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });
                console.error('AJAX ERROR: ' + xhr.responseText);
                console.error('UPDATE STATUS ERROR: ' + error);
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

    <!-- Add New Stocks Modal -->
    <div class="modal fade" id="addNewStocksModal" tabindex="-1" aria-labelledby="addNewStocksModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewStocksModalLabel">Add stocks</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <?php echo form_open('inventory/stock/insert_stocks', array('id' => 'addNewStocksForm')); ?>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="batchCode" class="form-label">Batch Code</label>
                            <input type="text" class="form-control" name="batch_code" id="batchCode" placeholder="0000371">
                        </div>
                        <div class="col-md-6">
                            <label for="totalCost" class="form-label">Total Cost</label>
                            <input type="text" class="form-control" name="total_cost" id="totalCost" placeholder="₱ 0" disabled>
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
                                        <input type="text" class="form-control mt-2" placeholder="Please choose an item first." disabled>
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][quantity]" class="form-control" placeholder="Quantity: 0" min="0" required>
                                        <input type="number" name="items[0][amount]" class="form-control mt-2" placeholder="Amount: 0" min="0" required>
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
<script>
    $(document).ready(function() {

        // for adding supplier
        $(document).on('submit', 'form[id^="addNewStocksForm"]', function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>/inventory/stock/insert_stocks/",
                data: form.serialize(),
                success: function(response) {
                    response = JSON.parse(response);
                    // $('#supplier_table').DataTable().ajax.reload(null, false);
                    form.closest('.modal').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
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

        // initialize flatpickr for task task due date and time,
        flatpickr("#date_received", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today",
        });

        var itemIndex = 0;

        $('#addItemButton').click(function() {
            addItemRow();
        });

        $(document).on('click', '.remove-item', function() {
            $(this).closest('tr').remove();
            reindexItemRows();
        });

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
                                    <input type="text" class="form-control mt-2" placeholder="Please choose an item first." disabled>
                                </td>
                                <td>
                                    <input type="number" name="items[` + itemIndex + `][quantity]" class="form-control" placeholder="Quantity: 0" min="0" required>
                                    <input type="number" name="items[` + itemIndex + `][amount]" class="form-control mt-2" placeholder="Amount: 0" min="0" required>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger remove-item">Remove</button>
                                </td>
                            </tr>
                        `;
            $('#itemsTable tbody').append(newRow);
            initializeSelect2();
            reindexItemRows();
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

        checkRemoveButtons();
        initializeSelect2();
    });
</script>