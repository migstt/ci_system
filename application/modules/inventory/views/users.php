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

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

        .user-table-container {
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

        /* Custom styles for contact details and bank details */
        .contact-details,
        .bank-details {
            padding: 10px;
            background-color: #f9f9f9;
            /* Light grey background for better readability */
            border-radius: 5px;
            margin-bottom: 5px;
        }

        .contact-details strong,
        .bank-details strong {
            color: #2c3e50;
            /* Darker color for labels */
        }

        table.dataTable td {
            vertical-align: middle;
            /* Vertically align text to the middle */
        }

        /* Optional: Add zebra striping to rows */
        table.dataTable tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        /* Optional: Add hover effect to rows */
        table.dataTable tbody tr:hover {
            background-color: #e0e0e0;
        }

        /* Custom Modal Styling */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            background-color: #e6f7e6;
            /* Light green background color for the modal header */
            padding: 1rem 1.5rem;
            /* Equal padding for top and bottom */
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header .modal-title {
            font-weight: bold;
            font-size: 1.25rem;
            color: #333;
            /* Dark text color for contrast */
        }

        .modal-body {
            padding-top: 2rem;
            /* Added space to move the content away from the header */
        }

        .modal-footer {
            border-top: none;
            justify-content: space-between;
        }

        .form-label {
            font-weight: bold;
            color: #333;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 0.75rem 1rem;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-secondary {
            border-radius: 8px;
        }

        .btn-primary {
            border-radius: 8px;
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        /* Custom Close Button */
        .btn-close {
            background: none;
            border: none;
            font-size: 1.25rem;
        }

        .btn-close:hover {
            color: #dc3545;
            opacity: 0.75;
        }
    </style>
</head>

<!-- Custom scripts -->
<script>
    $(document).ready(function() {
        // client side users datatable
        $('#users_table').DataTable({
            responsive: true,
            searching: true,
            processing: true,
            ajax: {
                url: '<?php echo site_url(); ?>/inventory/get_users',
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
                    "data": "full_name",
                    "className": "text-start align-middle"
                },
                {
                    "data": "email",
                    "className": "text-start align-middle"
                },
                {
                    "data": "location",
                    "className": "text-start align-middle"
                },
                {
                    "data": "type",
                    "className": "text-start align-middle"
                },
                {
                    "data": "team",
                    "className": "text-start align-middle"
                },
                {
                    "data": "status",
                    "className": "text-start align-middle",
                    "createdCell": function(td, cellData, rowData, row, col) {
                        if (cellData === 'Active') {
                            $(td).css({
                                'background-color': '#d4edda',
                                'color': '#155724'
                            });
                        } else if (cellData === 'Inactive') {
                            $(td).css({
                                'background-color': '#f8d7da',
                                'color': '#721c24'
                            });
                        }
                    }
                },
                // for the user actions (edit, delete) row
                {
                    "data": null,
                    "sortable": false,
                    "className": "align-middle",
                    "render": function(data, type, row) {
                        return `
                            <div class="d-flex justify-content-end">
                                <div class="btn-group btn-group-sm" role="group" aria-label="">
                            
                                    <!-- Update/Edit User Modal -->
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editUserModal${data.user_id}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <div class="d-flex justify-content-end">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="">
                                            <div class="modal fade" id="editUserModal${data.user_id}" tabindex="-1" aria-labelledby="editUserModal" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="modalLabel">Edit User</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php echo validation_errors(); ?>
                                                            <?php echo form_open('inventory/update_user', array('id' => 'editUserForm${data.user_id}')); ?>

                                                            <!-- User First Name -->
                                                            <div class="mb-2">
                                                                <label><strong>First Name</strong></label>
                                                                <input name="first_name" value="${data.first_name}" type="text" class="form-control" placeholder="First Name" aria-label="First Name" required />
                                                            </div>

                                                            <!-- User Last Name -->
                                                            <div class="mb-2">
                                                                <label><strong>Last Name</strong></label>
                                                                <input name="last_name" value="${data.last_name}" type="text" class="form-control" placeholder="Last Name" aria-label="Last Name" required />
                                                            </div>

                                                            <!-- User Email -->
                                                            <div class="mb-2">
                                                                <label><strong>Email</strong></label>
                                                                <input name="email" value="${data.email}" type="email" class="form-control" placeholder="Email" aria-label="Email" required disabled />
                                                            </div>

                                                            <!-- Location -->
                                                            <div class="mb-2">
                                                                <label><strong>Location</strong></label>
                                                                <select name="location_id" class="form-control" required>
                                                                    <option value="${data.location_id}">${data.location}</option>
                                                                    <?php foreach ($active_locations as $location) : ?>
                                                                        <option value="<?php echo $location->location_id; ?>" ${data.location_id == "<?php echo $location->location_id; ?>" ? 'selected' : ''}>
                                                                            <?php echo $location->location_name; ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>

                                                            <!-- Team -->
                                                            <div class="mb-2">
                                                                <label><strong>Team</strong></label>
                                                                <select name="team_id" class="form-control" required>
                                                                    <option value="${data.team_id}">${data.team}</option>
                                                                    <?php foreach ($active_teams as $team) : ?>
                                                                        <option value="<?php echo $team['team_id']; ?>" ${data.team_id == "<?php echo $team['team_id']; ?>" ? 'selected' : ''}>
                                                                            <?php echo $team['team_name']; ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>

                                                            <!-- User Type -->
                                                            <div class="mb-2">
                                                                <label><strong>User Type</strong></label>
                                                                <select name="user_type_id" class="form-control" required>
                                                                    <option value="${data.type_id}">${data.type}</option>
                                                                    <?php foreach ($user_types as $type) : ?>
                                                                        <option value="<?php echo $type['user_type_id']; ?>" ${data.user_type_id == "<?php echo $type['user_type_id']; ?>" ? 'selected' : ''}>
                                                                            <?php echo $type['user_type_name']; ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>

                                                            <!-- Hidden User ID -->
                                                            <input type="hidden" name="user_id" value="${data.user_id}" />

                                                            <!-- Modal Footer -->
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                            </div>
                                                            <?php echo form_close(); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Confirmation Modal -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal${data.user_id}">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                    <div class="modal fade" id="confirmDeleteModal${data.user_id}" tabindex="-1" aria-labelledby="confirmDeleteModal" aria-hidden="true">
                                    <?php echo form_open('inventory/delete_user', array('id' => 'deleteUserForm${data.user_id}')); ?>
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmation</h1>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="user_id" value="${data.user_id}" />
                                                    <p class="text-start">Are you sure you want to set this user to inactive?</p>
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

        // for adding user
        $(document).on('submit', 'form[id^="addNewUserForm"]', function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>/inventory/insert_user/",
                data: form.serialize(),
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status === 'error_email_exist') {
                        Swal.fire({
                            position: "top-end",
                            icon: "warning",
                            title: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    } else if (response.status === 'success') {
                        $('#users_table').DataTable().ajax.reload(null, false);
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
                    } else {
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
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
                    console.error('ADD USER ERROR: ' + error);
                }
            });
        });

        // for updating user
        $(document).on('submit', 'form[id^="editUserForm"]', function(e) {
            e.preventDefault();
            var form = $(this);
            var id = form.find('input[name="user_id"]').val();
            var has_changes = false;

            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>/inventory/update_user/" + id,
                data: form.serialize(),
                success: function(response) {
                    response = JSON.parse(response);
                    $('#users_table').DataTable().ajax.reload(null, false);
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
                    console.error('EDIT USER ERROR: ' + error);
                }
            });
        });


        // for deleting user
        $(document).on('submit', 'form[id^="deleteUserForm"]', function(e) {
            e.preventDefault();
            var form = $(this);
            var id = form.find('input[name="user_id"]').val();
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>/inventory/delete_user/" + id,
                data: form.serialize(),
                success: function(response) {
                    response = JSON.parse(response);
                    $('#users_table').DataTable().ajax.reload(null, false);
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
                    console.error('DELETE USER ERROR: ' + error);
                }
            });
        });

        $('.team_select').select2();
        $('.location_select').select2();
        $('.user_type_select').select2();
    });

    // for updating user status
    function updateStatus(userId, newStatus) {
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url(); ?>/task/update_user_status/" + userId,
            data: {
                user_id: userId,
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
                <ul class="sub-menu mt-1">
                    <li><a class="link_name" href="<?php echo site_url('tasks'); ?>">Tasks</a></li>
                    <li><a href="#">Pending</a></li>
                    <li><a href="#">In Progess</a></li>
                    <li><a href="#">Completed</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="<?php echo site_url('inventory'); ?>">
                        <i class='bx bx-task'></i>
                        <span class="link_name">Inventory</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu mt-1">
                    <li><a class="link_name" href="<?php echo site_url('inventory'); ?>">Inventory</a></li>
                    <li><a href="<?php echo site_url('inventory'); ?>">Dashboard</a></li>
                    <li><a href="<?php echo site_url('inventory/stocks'); ?>">Stocks</a></li>
                    <li><a href="<?php echo site_url('inventory/location'); ?>">Location</a></li>
                    <li><a href="<?php echo site_url('inventory/category'); ?>">Category</a></li>
                    <li><a href="<?php echo site_url('inventory/suppliers'); ?>">Suppliers</a></li>
                    <li><a href="<?php echo site_url('inventory/items'); ?>">Items</a></li>
                    <li><a href="<?php echo site_url('inventory/reports'); ?>">Report Log</a></li>
                    <!-- conditional rendering here, if user is admin, show Users option -->
                    <!-- also in controller, restrict access if current user user_type_id != 1 or Admin -->
                    <li><a href="<?php echo site_url('inventory/users'); ?>">Users</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <section class="home-section">
        <i class='bx bx-menu' style='margin-top: .7%;'></i>
        <div class="container-sm">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mt-2">Users</h5>
                <?php echo form_open('user/logout'); ?>
                <button type="submit" class="btn btn-secondary">Logout</button>
                </form>
            </div>

            <!-- Add New User Button -->
            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addNewUserModal">
                Add User
            </button>


            <!-- Users Table -->
            <div class="user-table-container">
                <table class="table table-sm table-striped" class="display" id="users_table">
                    <thead>
                        <tr>
                            <th class="text-center"></th>
                            <th class="text-start"><strong>Name</strong></th>
                            <th class="text-start"><strong>Email</strong></th>
                            <th class="text-start"><strong>Location</strong></th>
                            <th class="text-start"><strong>Type</strong></th>
                            <th class="text-start"><strong>Team</strong></th>
                            <th class="text-start"><strong>Status</strong></th>
                            <th class="text-end"><strong>Actions</strong></th>
                        </tr>
                    </thead>
                </table>
            </div>


            <!-- Add New User Modal -->
            <div class="modal fade" id="addNewUserModal" tabindex="-1" aria-labelledby="addNewUserModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalLabek">Add User</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <?php echo validation_errors(); ?>
                            <?php echo form_open('inventory/insert_user', array('id' => 'addNewUserForm')); ?>

                            <!-- User First Name -->
                            <div class="mb-3">
                                <p><strong>First Name</strong></p>
                                <input name="first_name" value="<?php echo set_value('first_name'); ?>" type="text" class="form-control" placeholder="First Name" aria-label="First Name" required />
                            </div>

                            <!-- User Last Name -->
                            <div class="mb-3">
                                <p><strong>Last Name</strong></p>
                                <input name="last_name" value="<?php echo set_value('last_name'); ?>" type="text" class="form-control" placeholder="Last Name" aria-label="Last Name" required />
                            </div>

                            <!-- User Email -->
                            <div class="mb-3">
                                <p><strong>Email</strong></p>
                                <input name="email" value="<?php echo set_value('email'); ?>" type="email" class="form-control" placeholder="Email" aria-label="Email" required />
                            </div>

                            <!-- User Password -->
                            <div class="mb-3">
                                <p><strong>Password</strong></p>
                                <input name="password" value="<?php echo set_value('password'); ?>" type="password" class="form-control" placeholder="Password" aria-label="Password" required />
                            </div>

                            <div class="mb-3">
                                <p class="location_error" style="color:red;"></p>
                                <p><strong>Location</strong></p>
                                <select name="location_id" class="form-control" required>
                                    <option value="">Select Location</option>
                                    <?php foreach ($active_locations as $location) : ?>
                                        <option value="<?php echo $location->location_id; ?>"><?php echo $location->location_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <p><strong>Team</strong></p>
                                <p class="team_error" style="color:red;"></p>
                                <select name="team_id" class="form-control" required>
                                    <option value="">Select Team</option>
                                    <?php foreach ($active_teams as $team) : ?>
                                        <option value="<?php echo $team['team_id']; ?>"><?php echo $team['team_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <p class="type_error" style="color:red;"></p>
                                <p><strong>User Type</strong></p>
                                <select name="user_type_id" class="form-control" required>
                                    <option value="">Select User Type</option>
                                    <?php foreach ($user_types as $type) : ?>
                                        <option value="<?php echo $type['user_type_id']; ?>"><?php echo $type['user_type_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>


                            <!-- User Status -->
                            <div class="mb-3">
                                <p><strong>Status</strong></p>
                                <select name="status" class="form-control" required>
                                    <option value="0">Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                            </div>

                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>

                            <?php echo form_close(); ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

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