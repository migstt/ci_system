<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">

<head>
    <title>Bisag Unsa System</title>
    <meta charset="UTF-8">
    <!-- for favicon.ico error -->
    <link rel="shortcut icon" href="#">

    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">

    <!-- DataTables -->
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.8/js/dataTables.jqueryui.js"></script>
    <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.jqueryui.css">

    <!-- Jconfirm -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>

    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Flatpickr CSS and JS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- sidebar styles -->
    <style>
        /* Google Fonts Import Link */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 260px;
            background: #11101d;
            z-index: 100;
            transition: all 0.5s ease;
        }

        .sidebar.close {
            width: 78px;
        }

        .sidebar .logo-details {
            height: 60px;
            width: 100%;
            display: flex;
            align-items: center;
        }

        .sidebar .logo-details i {
            font-size: 30px;
            color: #fff;
            height: 50px;
            min-width: 78px;
            text-align: center;
            line-height: 50px;
        }

        .sidebar .logo-details .logo_name {
            font-size: 22px;
            color: #fff;
            font-weight: 600;
            transition: 0.3s ease;
            transition-delay: 0.1s;
        }

        .sidebar.close .logo-details .logo_name {
            transition-delay: 0s;
            opacity: 0;
            pointer-events: none;
        }

        .sidebar .nav-links {
            height: 100%;
            padding: 30px 0 150px 0;
            overflow: auto;
        }

        .sidebar.close .nav-links {
            overflow: visible;
        }

        .sidebar .nav-links::-webkit-scrollbar {
            display: none;
        }

        .sidebar .nav-links li {
            position: relative;
            list-style: none;
            transition: all 0.4s ease;
        }

        .sidebar .nav-links li:hover {
            background: #1d1b31;
        }

        .sidebar .nav-links li .iocn-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar.close .nav-links li .iocn-link {
            display: block
        }

        .sidebar .nav-links li i {
            height: 50px;
            min-width: 78px;
            text-align: center;
            line-height: 50px;
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sidebar .nav-links li.showMenu i.arrow {
            transform: rotate(-180deg);
        }

        .sidebar.close .nav-links i.arrow {
            display: none;
        }

        .sidebar .nav-links li a {
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .sidebar .nav-links li a .link_name {
            font-size: 18px;
            font-weight: 400;
            color: #fff;
            transition: all 0.4s ease;
        }

        .sidebar.close .nav-links li a .link_name {
            opacity: 0;
            pointer-events: none;
        }

        .sidebar .nav-links li .sub-menu {
            padding: 6px 6px 14px 80px;
            margin-top: -10px;
            background: #1d1b31;
            display: none;
        }

        .sidebar .nav-links li.showMenu .sub-menu {
            display: block;
        }

        .sidebar .nav-links li .sub-menu a {
            color: #fff;
            font-size: 15px;
            padding: 5px 0;
            white-space: nowrap;
            opacity: 0.6;
            transition: all 0.3s ease;
        }

        .sidebar .nav-links li .sub-menu a:hover {
            opacity: 1;
        }

        .sidebar.close .nav-links li .sub-menu {
            position: absolute;
            left: 100%;
            top: -10px;
            margin-top: 0;
            padding: 10px 20px;
            border-radius: 0 6px 6px 0;
            opacity: 0;
            display: block;
            pointer-events: none;
            transition: 0s;
        }

        .sidebar.close .nav-links li:hover .sub-menu {
            top: 0;
            opacity: 1;
            pointer-events: auto;
            transition: all 0.4s ease;
        }

        .sidebar .nav-links li .sub-menu .link_name {
            display: none;
        }

        .sidebar.close .nav-links li .sub-menu .link_name {
            font-size: 18px;
            opacity: 1;
            display: block;
        }

        .sidebar .nav-links li .sub-menu.blank {
            opacity: 1;
            pointer-events: auto;
            padding: 3px 20px 6px 16px;
            opacity: 0;
            pointer-events: none;
        }

        .sidebar .nav-links li:hover .sub-menu.blank {
            top: 50%;
            transform: translateY(-50%);
        }

        .one {
            width: 80%;
            margin-left: 10%;
            background-color: black;
            height: 400px;
        }

        .sidebar .profile-details {
            position: fixed;
            bottom: 0;
            width: 260px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #1d1b31;
            padding: 12px 0;
            transition: all 0.5s ease;
        }

        .sidebar.close .profile-details {
            background: none;
        }

        .sidebar.close .profile-details {
            width: 78px;
        }

        .sidebar .profile-details .profile-content {
            display: flex;
            align-items: center;
        }

        .sidebar .profile-details img {
            height: 52px;
            width: 52px;
            object-fit: cover;
            border-radius: 16px;
            margin: 0 14px 0 12px;
            background: #1d1b31;
            transition: all 0.5s ease;
        }

        .sidebar.close .profile-details img {
            padding: 10px;
        }

        .sidebar .profile-details .profile_name,
        .sidebar .profile-details .job {
            color: #fff;
            font-size: 18px;
            font-weight: 500;
            white-space: nowrap;
        }

        .sidebar.close .profile-details i,
        .sidebar.close .profile-details .profile_name,
        .sidebar.close .profile-details .job {
            display: none;
        }

        .sidebar .profile-details .job {
            font-size: 12px;
        }

        .home-section {
            position: relative;
            background: #f2f2f2;
            height: 100vh;
            left: 260px;
            width: calc(100% - 260px);
            transition: all 0.5s ease;
            overflow-y: scroll;
        }

        .sidebar.close~.home-section {
            left: 78px;
            width: calc(100% - 78px);
        }

        .home-section .home-content {
            height: 60px;
            display: flex;
            align-items: center;
        }

        .home-section .bx-menu,
        .home-section .text {
            color: #11101d;
            font-size: 35px;
        }

        .home-section .bx-menu {
            margin: 0 15px;
            cursor: pointer;
        }

        .home-section .home-content .text {
            font-size: 26px;
            font-weight: 600;
        }

        @media (max-width: 420px) {
            .sidebar.close .nav-links li .sub-menu {
                display: none;
            }
        }

        .others-tasks-table-container {
            background-color: white;
            padding: 1%;
            border-radius: 5px;
        }

        .my-tasks-table-container {
            background-color: white;
            padding: 1%;
            border-radius: 5px;
        }

        .btn-fixed-width {
            width: 120px;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
            font-size: 0.875rem;
        }
    </style>
</head>

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
        $("#addNewTaskModal").modal({
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

                                    <?php echo validation_errors(); ?>
                                    <?php echo form_open('task/update_others_task', array('id' => 'editTaskForm${data.task_id}')); ?>
                                    <div class="modal fade" id="editTaskModal${data.task_id}" tabindex="-1" aria-labelledby="editTaskModal" aria-hidden="true">
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
                                    </div>
                                    </form>


                                    <!-- Delete Confirmation Modal -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal${data.task_id}">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                    <?php echo form_open('task/delete_task', array('id' => 'deleteTaskForm${data.task_id}')); ?>
                                    <div class="modal fade" id="confirmDeleteModal${data.task_id}" tabindex="-1" aria-labelledby="confirmDeleteModal" aria-hidden="true">
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
                                    </div>
                                    </form>
                                
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

    });

    // for adding task
    $(document).on('submit', 'form[id^="addNewTaskForm"]', function(e) {
        e.preventDefault();
        var form = $(this);
        var userSelected = form.find('select[name="user_selected"]').val();
        var dueDate = form.find('input[name="due_date"]').val();

        const assignErrorMessageElement = document.querySelector('.assign-error-message p');
        const dateErrorMessageElement = document.querySelector('.date-error-message p');

        let hasError = false;

        if (userSelected === "Default") {
            assignErrorMessageElement.textContent = "Please select a user to assign this task to.";
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
                data: form.serialize(),
                success: function(response) {
                    response = JSON.parse(response);
                    $('#others_tasks').DataTable().ajax.reload(null, false);
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

<body>
    <div class="sidebar close">
        <div class="logo-details">
            <i class='bx bxl-c-plus-plus' style="overflow-y: hidden;"></i>
            <span class="logo_name">Cilog</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="#">
                    <i class='bx bx-grid-alt'></i>
                    <span class="link_name">Dashboard</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Dashboard</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="<?php echo site_url('contacts'); ?>">
                        <i class='bx bx-group'></i>
                        <span class="link_name">Contacts</span>
                    </a>
                    <!-- <i class='bx bxs-chevron-down arrow'></i> -->
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="<?php echo site_url('contacts'); ?>">Contacts</a></li>
                    <!-- <li><a href="#">HTML & CSS</a></li>
                    <li><a href="#">JavaScript</a></li>
                    <li><a href="#">PHP & MySQL</a></li> -->
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="<?php echo site_url('tasks'); ?>">
                        <i class='bx bx-task'></i>
                        <span class="link_name">Tasks</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="<?php echo site_url('tasks'); ?>">Tasks</a></li>
                    <li><a href="#">Pending</a></li>
                    <li><a href="#">In Progess</a></li>
                    <li><a href="#">Completed</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-receipt'></i>
                    <span class="link_name">Inventory</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Inventory</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <i class='bx bx-menu' style='margin-top: .7%;'></i>
        <div class="container-sm">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Tasks assigned by me</h5>
                <?php echo form_open('user/logout'); ?>
                <button type="submit" class="btn btn-secondary mt-3">Logout</button>
                </form>
            </div>

            <!-- Add New Contact Button -->
            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addNewTaskModal">
                Create Task
            </button>

            <!-- Other's Tasks Table -->
            <div class="others-tasks-table-container">
                <table class="table table-sm table-striped" class="display" id="others_tasks">
                    <thead>
                        <tr>
                            <th class="text-center"></th>
                            <th class="text-start">Title</th>
                            <th class="text-start">Description</th>
                            <th class="text-start">Assigned to</th>
                            <th class="text-start">Due date</th>
                            <th class="text-start">Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>


            <h5 class="mb-2 mt-4">
                Tasks assigned to me
            </h5>
            <!-- Task Assigned to me Table -->
            <div class="my-tasks-table-container">
                <table class="table table-sm table-striped" class="display" id="my_tasks">
                    <thead>
                        <tr>
                            <th class="text-center"></th>
                            <th class="text-start">Title</th>
                            <th class="text-start">Description</th>
                            <th class="text-start">Assigned by</th>
                            <th class="text-start">Due date</th>
                            <th class="text-start">Status</th>
                        </tr>
                    </thead>
                </table>
            </div>


            <!-- Add New Task Modal -->
            <div class="modal fade" id="addNewTaskModal" tabindex="-1" aria-labelledby="addNewTaskModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalLabek">Create Task</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php echo validation_errors(); ?>
                            <?php echo form_open('task/insert_task', array('id' => 'addNewTaskForm')); ?>
                            <div class="col">
                                <p><strong>Task title</strong></p>
                            </div>
                            <div class="col">
                                <input name="title" value="<?php echo set_value('title'); ?>" type="text" class="form-control" placeholder="Task title" aria-label="Task title" required />
                            </div>
                            <div class="col mt-3">
                                <p><strong>Task description</strong></p>
                            </div>
                            <div class="col mt-3 mb-3">
                                <textarea name="description" class="form-control" placeholder="Task description" aria-label="Task description" required rows="5"><?php echo set_value('description'); ?></textarea>
                            </div>
                            <div class="col">
                                <p><strong>Assign to</strong></p>
                            </div>
                            <div class="col assign-error-message">
                                <p style="color: red;"></p>
                            </div>
                            <div class="col">
                                <?php if (!empty($user_options)) : ?>
                                    <select name="user_selected" class="form-select" aria-label="User selected">
                                        <?php foreach ($user_options as $option_value => $option_label) : ?>
                                            <option value="<?php echo $option_value; ?>"><?php echo $option_label; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php else : ?>
                                    <p>No users to assign with found.</p>
                                <?php endif; ?>
                            </div>
                            <div class="col mt-3">
                                <p><strong>Due date</strong></p>
                            </div>
                            <div class="col date-error-message">
                                <p style="color: red;"></p>
                            </div>
                            <div class="col">
                                <input name="due_date" id="due_date" type="date" class="form-control" placeholder="Due date" aria-label="Due date" required />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    </section>


    <script>
        // Sidebar
        let arrow = document.querySelectorAll(".arrow");
        for (var i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", (e) => {
                let arrowParent = e.target.parentElement.parentElement;
                arrowParent.classList.toggle("showMenu");
            });
        }
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");
        sidebarBtn.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        });
        // Sidebar
    </script>
</body>

</html>