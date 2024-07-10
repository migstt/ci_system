<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System</title>

    <!-- Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

    <!-- Jconfirm -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>

    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<script>
    $(document).ready(function() {

        // client side contacts datatable
        $('#my_contacts_table').DataTable({
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
                    "render": function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data": 'full_name',
                },
                {
                    "data": "company"
                },
                {
                    "sortable": false,
                    "data": "phone"
                },
                {
                    "data": "email"
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
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editContactModal${data.contact_id}">Edit</button>              
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
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#shareContactModal${data.contact_id}">Share</button>
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
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal${data.contact_id}">Delete</button>
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

    // for editing  contact
    $(document).on('submit', 'form[id^="updateContactForm"]', function(e) {
        e.preventDefault();
        var form = $(this);
        var id = form.find('input[name="contact_id"]').val();
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
                                        timer: 2000
                                    });
                                },
                                error: function(xhr, status, error, response) {
                                    response = JSON.parse(response);
                                    Swal.fire({
                                        position: "top-end",
                                        icon: "error",
                                        title: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
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

</head>

<body style="overflow-y: scroll;">
    <div class="container-sm">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mt-1"><?php echo $current_user['user_first_name'] . ' ' . $current_user['user_last_name'] . "'s "; ?> contacts</h4>
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
                        <th></th>
                        <th>Name</th>
                        <th>Company</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
            </table>
        </div>

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

        <!-- Pagination Link -->
        <!-- <p><?php echo $links; ?></p> -->

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


        <!-- Edit Contact Form -->
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>