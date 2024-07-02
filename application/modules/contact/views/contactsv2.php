<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">

<head>
    <title>Bisag Unsa System</title>
    <meta charset="UTF-8">
    <!-- for favicon.ico error -->
    <link rel="shortcut icon" href="#">

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

    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Jconfirm -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>

    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        .contacts-table-container {
            background-color: white;
            padding: 1%;
            border-radius: 5px;
        }
    </style>
</head>

<!-- Custom scripts -->
<script>
    $(document).ready(function() {

        // client side contacts datatable
        $('#my_contacts_table').DataTable({
            responsive: true,
            searching: true,
            processing: true,
            ajax: {
                url: '<?php echo site_url(); ?>/contact/get_contacts',
                dataSrc: 'data',
                type: 'POST',
            },
            columns: [{
                    "sortable": false,
                    "data": null,
                    "className": "text-center align-middle", // Add align-middle class for vertical alignment
                    "render": function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data": "full_name",
                    "className": "text-start align-middle"
                },
                {
                    "data": "company",
                    "className": "text-start align-middle"
                },
                {
                    "data": "phone",
                    "className": "text-start align-middle",
                    "sortable": false,
                },
                {
                    "data": "email",
                    "className": "text-start align-middle"
                },
                // for the contact actions (edit, share, delete) row
                {
                    "data": null,
                    "sortable": false,
                    "render": function(data, type, row) {
                        return `
                            <div class="d-flex justify-content-end">
                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic mixed styles example">
                                
                                    <!-- Update/Edit Contact Modal -->
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editContactModal${data.contact_id}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <?php echo validation_errors(); ?>
                                    <?php echo form_open('contact/update_contact', array('id' => 'updateContactForm${data.contact_id}')); ?>
                                    <div class="modal fade" id="editContactModal${data.contact_id}" tabindex="-1" aria-labelledby="editContactModal" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Contact</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row g-3 mb-3">
                                                        <div class="col">
                                                            <input name="firstname" value="${data.firstname}" type="text" class="form-control" placeholder="First name" aria-label="First name" required />
                                                        </div>
                                                        <div class="col">
                                                            <input name="lastname" value="${data.lastname}" type="text" class="form-control" placeholder="Last name" aria-label="Last name" required />
                                                        </div>
                                                    </div>
                                                    <div class="row g-3 mb-3">
                                                        <div class="col">
                                                            <input name="email" value="${data.email}" type="email" class="form-control" placeholder="Email address" aria-label="Email address" required />
                                                        </div>
                                                        <div class="col">
                                                            <input name="phone" value="${data.phone}" type="text" class="form-control" placeholder="Phone number" aria-label="Phone number" required />
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <input name="companyname" value="${data.company}" type="text" class="form-control" placeholder="Company name" aria-label="Company name" required />
                                                    </div>
                                                    <div class="col">
                                                        <input type="hidden" name="contact_id" value="${data.contact_id}" type="text" class="form-control" placeholder="contact_id" aria-label="contact_id" required />
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </form>


                                    <!-- Share Modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#shareContactModal${data.contact_id}">
                                        <i class="bi bi-share-fill"></i>
                                    </button>
                                    <?php echo form_open('contact/share_contact', array('id' => 'shareContactForm${data.contact_id}')); ?>
                                    <div class="modal fade" id="shareContactModal${data.contact_id}" tabindex="-1" aria-labelledby="shareContactModal" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Share contact</h1>
                                                    <div class="col">
                                                        <input type="hidden" name="contact_id" value="${data.contact_id}" type="text" class="form-control" placeholder="contact_id" aria-label="contact_id" required />

                                                        <div class="row g-3 mb-3">
                                                            <div class="col">
                                                                <input type="hidden" name="firstname" value="${data.firstname}" type="text" class="form-control" placeholder="First name" aria-label="First name" required />
                                                            </div>
                                                            <div class="col">
                                                                <input type="hidden" name="lastname" value="${data.lastname}" type="text" class="form-control" placeholder="Last name" aria-label="Last name" required />
                                                            </div>
                                                        </div>
                                                        <div class="row g-3 mb-3">
                                                            <div class="col">
                                                                <input type="hidden" name="email" value="${data.email}" type="email" class="form-control" placeholder="Email address" aria-label="Email address" required />
                                                            </div>
                                                            <div class="col">
                                                                <input type="hidden" name="phone" value="${data.phone}" type="text" class="form-control" placeholder="Phone number" aria-label="Phone number" required />
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <input type="hidden" name="companyname" value="${data.company}" type="text" class="form-control" placeholder="Company name" aria-label="Company name" required />
                                                        </div>

                                                    </div>
                                                    <div>
                                                        <?php echo validation_errors(); ?>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="modal-body">
                                                        <div class="col">
                                                            <?php if (!empty($user_options)) : ?>
                                                                <select name="user_selected" class="form-select" aria-label="User selected">
                                                                    <?php foreach ($user_options as $option_value => $option_label) : ?>
                                                                        <option value="<?php echo $option_value; ?>"><?php echo $option_label; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            <?php else : ?>
                                                                <p>No users to share with found.</p>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Share</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                    
                                    
                                    <!-- Delete Confirmation Modal -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal${data.contact_id}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <?php echo form_open('contact/delete_contact', array('id' => 'deleteContactForm${data.contact_id}')); ?>
                                    <div class="modal fade" id="confirmDeleteModal${data.contact_id}" tabindex="-1" aria-labelledby="confirmDeleteModal" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmation</h1>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="contact_id" value="${data.contact_id}" />
                                                    <p>Are you sure you want to delete this contact?</p>
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

    // ajax for adding contact
    $(document).on('submit', 'form[id^="addNewContactForm"]', function(e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url(); ?>/contact/insert_contact/",
            data: form.serialize(),
            success: function(response) {
                response = JSON.parse(response);
                $('#my_contacts_table').DataTable().ajax.reload(null, false);
                $('#ssp_contacts_table').DataTable().ajax.reload(null, false);
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
            error: function(xhr, status, error, response) {
                response = JSON.parse(response);
                $('#my_contacts_table').DataTable().ajax.reload(null, false);
                $('#ssp_contacts_table').DataTable().ajax.reload(null, false);
                form.closest('.modal').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1200
                });
                console.error('AJAX ERROR: ' + xhr.responseText);
                console.error('ADD CONTACT ERROR: ' + error);
            }
        });
    });

    $(document).on('submit', 'form[id^="updateContactForm"]', function(e) {
        e.preventDefault();
        var form = $(this);
        var id = form.find('input[name="contact_id"]').val();

        var has_changes = false;
        form.find('input').each(function() {
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
            url: "<?php echo site_url(); ?>/contact/update_contact/" + id,
            data: form.serialize(),
            success: function(response) {
                response = JSON.parse(response);
                $('#my_contacts_table').DataTable().ajax.reload(null, false);
                $('#ssp_contacts_table').DataTable().ajax.reload(null, false);
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
            error: function(xhr, status, error, response) {
                response = JSON.parse(response);
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1200
                });
                console.error('AJAX ERROR: ' + xhr.responseText);
                console.error('EDIT CONTACT ERROR: ' + error);
            }
        });
    });

    // for deleting  contact
    $(document).on('submit', 'form[id^="deleteContactForm"]', function(e) {
        e.preventDefault();
        var form = $(this);
        var id = form.find('input[name="contact_id"]').val();
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url(); ?>/contact/delete_contact/" + id,
            data: form.serialize(),
            success: function(response) {
                response = JSON.parse(response);
                $('#my_contacts_table').DataTable().ajax.reload(null, false);
                $('#ssp_contacts_table').DataTable().ajax.reload(null, false);
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
            error: function(xhr, status, error, response) {
                response = JSON.parse(response);
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1200
                });
                console.error('AJAX ERROR: ' + xhr.responseText);
                console.error('DELETE CONTACT ERROR: ' + error);
            }
        });
    });

    // for sharing  contact
    $(document).on('submit', 'form[id^="shareContactForm"]', function(e) {
        e.preventDefault();
        var form = $(this);
        var id = form.find('input[name="contact_id"]').val();
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url(); ?>/contact/share_contact/" + id,
            data: form.serialize(),
            success: function(response) {
                response = JSON.parse(response);
                if (response.status === 'error') {
                    Swal.fire({
                        text: response.message,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Share anyway?"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'POST',
                                url: "<?php echo site_url(); ?>/contact/force_share_contact/" + id,
                                data: form.serialize(),
                                success: function(response) {
                                    response = JSON.parse(response);
                                    Swal.fire({
                                        position: "top-end",
                                        icon: "success",
                                        title: response.message,
                                        showConfirmButton: false,
                                        timer: 1200
                                    });
                                },
                                error: function(xhr, status, error, response) {
                                    response = JSON.parse(response);
                                    Swal.fire({
                                        position: "top-end",
                                        icon: "error",
                                        title: response.message,
                                        showConfirmButton: false,
                                        timer: 1200
                                    });
                                    console.error('AJAX ERROR: ' + xhr.responseText);
                                    console.error('EDIT CONTACT ERROR: ' + error);
                                }
                            });
                        }
                    });
                } else if (response.status === 'success') {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1200
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Failed to share contact.",
                    showConfirmButton: false,
                    timer: 1200
                });
                console.error('AJAX ERROR: ' + xhr.responseText);
                console.error('SHARE CONTACT ERROR: ' + error);
            }
        });
    });
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
                <h5>Contacts</h5>
                <?php echo form_open('user/logout'); ?>
                <button type="submit" class="btn btn-secondary mt-3">Logout</button>
                </form>
            </div>

            <!-- Add New Contact Button -->
            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addNewContactModal">
                Add new contact
            </button>

            <!-- Contacts Table -->
            <div class="contacts-table-container">
                <table class="table table-sm table-striped" class="display" id="my_contacts_table">
                    <thead>
                        <tr>
                            <th class="text-center"></th>
                            <th class="text-start">Name</th>
                            <th class="text-start">Company</th>
                            <th class="text-start">Phone</th>
                            <th class="text-start">Email</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- Pagination Link -->
            <!-- <p><?php echo $links; ?></p> -->

            <!-- SSP Contacts Table -->
            <!-- Currently hidden -->
            <!-- <table class="table table-sm table-striped mt-5" class="display" id="ssp_contacts_table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fullname</th>
                            <th>Company</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                </table> -->



            <!-- Add New Contact Modal -->
            <div class="modal fade" id="addNewContactModal" tabindex="-1" aria-labelledby="addNewContactModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Contact</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php echo validation_errors(); ?>
                            <?php echo form_open('contact/insert_contact', array('id' => 'addNewContactForm')); ?>
                            <div class="row g-3 mb-3">
                                <div class="col">
                                    <input name="firstname" value="<?php echo set_value('firstname'); ?>" type="text" class="form-control" placeholder="First name" aria-label="First name" required />
                                </div>
                                <div class="col">
                                    <input name="lastname" value="<?php echo set_value('lastname'); ?>" type="text" class="form-control" placeholder="Last name" aria-label="Last name" required />
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col">
                                    <input name="email" value="<?php echo set_value('email'); ?>" type="email" class="form-control" placeholder="Email address" aria-label="Email address" required />
                                </div>
                                <div class="col">
                                    <input name="phone" value="<?php echo set_value('phone'); ?>" type="text" class="form-control" placeholder="Phone number" aria-label="Phone number" required />
                                </div>
                            </div>
                            <div class="col">
                                <input name="companyname" value="<?php echo set_value('companyname'); ?>" type="text" class="form-control" placeholder="Company name" aria-label="Company name" required />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
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
                let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
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