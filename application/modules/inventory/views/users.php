<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



<!-- Custom scripts -->
<script>
    $(document).ready(function() {

        $('.location_select').select2({
            dropdownParent: '#addNewUserModal .modal-content',
            width: '100%',
            theme: "classic",
            placeholder: "Select location",
            allowClear: true
        });

        $('.team_select').select2({
            dropdownParent: '#addNewUserModal .modal-content',
            width: '100%',
            theme: "classic",
            placeholder: "Select team",
            allowClear: true
        });

        $('.user_type_select').select2({
            dropdownParent: '#addNewUserModal .modal-content',
            width: '100%',
            theme: "classic",
            placeholder: "Select user type",
            allowClear: true
        });

        // client side users datatable
        $('#users_table').DataTable({
            responsive: true,
            searching: true,
            processing: true,
            ajax: {
                url: '<?php echo site_url(); ?>/inventory/user/get_users',
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
                    "className": "text-center align-middle",
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
                                                            <?php echo form_open('inventory/user/update_user', array('id' => 'editUserForm${data.user_id}')); ?>

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
                                                                    <?php foreach ($active_user_types as $type) : ?>
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
                                    <?php echo form_open('inventory/user/delete_user', array('id' => 'deleteUserForm${data.user_id}')); ?>
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
                url: "<?php echo site_url(); ?>/inventory/user/insert_user/",
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
                url: "<?php echo site_url(); ?>/inventory/user/update_user/" + id,
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
                url: "<?php echo site_url(); ?>/inventory/user/delete_user/" + id,
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

<i class='bx bx-menu' style='margin-top: .7%;'></i>
<div class="container-sm">
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="mt-2">Users</h5>
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
                    <?php echo form_open('inventory/user/insert_user', array('id' => 'addNewUserForm')); ?>

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
                        <select name="location_id" class="form-control location_select" required>
                            <option value="" >Select Location</option>
                            <?php foreach ($active_locations as $location) : ?>
                                <option value="<?php echo $location->location_id; ?>"><?php echo $location->location_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <p><strong>Team</strong></p>
                        <p class="team_error" style="color:red;"></p>
                        <select name="team_id" class="form-control team_select" required>
                            <option value="">Select Team</option>
                            <?php foreach ($active_teams as $team) : ?>
                                <option value="<?php echo $team['team_id']; ?>"><?php echo $team['team_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <p class="type_error" style="color:red;"></p>
                        <p><strong>User Type</strong></p>
                        <select name="user_type_id" class="form-control user_type_select" required>
                            <option value="">Select User Type</option>
                            <?php foreach ($active_user_types as $type) : ?>
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