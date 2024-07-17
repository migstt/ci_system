<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom scripts -->
<script>
    $(document).ready(function() {
        // client side locations datatable
        $('#category_table').DataTable({
            responsive: true,
            searching: true,
            processing: true,
            ajax: {
                url: '<?php echo site_url(); ?>/inventory/category/get_categories',
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
                    "data": "name",
                    "className": "text-start align-middle"
                },
                {
                    "sortable": false,
                    "data": "status",
                    "className": "text-center align-middle",
                    "createdCell": function(td, cellData, rowData, row, col) {
                        if (cellData === 'Active') {
                            $(td).css({
                                'background-color': '#d4edda', // light green
                                'color': '#155724' // dark green text for better contrast
                            });
                        } else if (cellData === 'Inactive') {
                            $(td).css({
                                'background-color': '#f8d7da', // light red
                                'color': '#721c24' // dark red text for better contrast
                            });
                        }
                    }
                },
                {
                    "data": "added_by",
                    "className": "text-start align-middle",
                },
                // for the category actions (edit, delete) row
                {
                    "data": null,
                    "sortable": false,
                    "className": "align-middle",
                    "render": function(data, type, row) {
                        return `
                            <div class="d-flex justify-content-end">
                                <div class="btn-group btn-group-sm" role="group" aria-label="">
                            
                                    <!-- Update/Edit Category Modal -->
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editCategoryModal${data.category_id}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <div class="modal fade" id="editCategoryModal${data.category_id}" tabindex="-1" aria-labelledby="editCategoryModal" aria-hidden="true">
                                        <?php echo validation_errors(); ?>
                                        <?php echo form_open('inventory/update_category', array('id' => 'editCategoryForm${data.category_id}')); ?>
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="modalLabel">Edit Category</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col mb-3">
                                                        <p class="text-start"><strong>Category name</strong></p>
                                                    </div>
                                                    <div class="col mb-3">
                                                        <input name="name" value="${data.name}" type="text" class="form-control" placeholder="Category name" aria-label="Category name" required />
                                                    </div>
                                                    <div class="col">
                                                        <input type="hidden" name="category_id" value="${data.category_id}" type="text" class="form-control" placeholder="category_id" aria-label="category_id" required />
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
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal${data.category_id}">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                    <div class="modal fade" id="confirmDeleteModal${data.category_id}" tabindex="-1" aria-labelledby="confirmDeleteModal" aria-hidden="true">
                                    <?php echo form_open('inventory/delete_category', array('id' => 'deleteCategoryForm${data.category_id}')); ?>
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmation</h1>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="category_id" value="${data.category_id}" />
                                                    <p class="text-start">Are you sure you want to set this category as Inactive?</p>
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

        // for adding location
        $(document).on('submit', 'form[id^="addNewCategoryForm"]', function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>/inventory/category/insert_category/",
                data: form.serialize(),
                success: function(response) {
                    response = JSON.parse(response);
                    $('#category_table').DataTable().ajax.reload(null, false);
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
                    console.error('ADD CATEGORY ERROR: ' + error);
                }
            });

        });

        // for updating  location
        $(document).on('submit', 'form[id^="editCategoryForm"]', function(e) {
            e.preventDefault();
            var form = $(this);
            var id = form.find('input[name="category_id"]').val();
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
                url: "<?php echo site_url(); ?>/inventory/category/update_category/" + id,
                data: form.serialize(),
                success: function(response) {
                    response = JSON.parse(response);
                    $('#category_table').DataTable().ajax.reload(null, false);
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
                    console.error('EDIT CATEGORY ERROR: ' + error);
                }
            });
        });

        // for deleting  location
        $(document).on('submit', 'form[id^="deleteCategoryForm"]', function(e) {
            e.preventDefault();
            var form = $(this);
            var id = form.find('input[name="category_id"]').val();
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>/inventory/category/delete_category/" + id,
                data: form.serialize(),
                success: function(response) {
                    response = JSON.parse(response);
                    $('#category_table').DataTable().ajax.reload(null, false);
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
                    console.error('DELETE CATEGORY ERROR: ' + error);
                }
            });
        });

    });

    // for updating location status
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
        <h5 class="mt-2">Category</h5>
    </div>

    <!-- Add New Category Button -->
    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addNewCategoryModal">
        Add Category
    </button>

    <!-- Category Table -->
    <div class="category-table-container">
        <table class="table table-sm table-striped" class="display" id="category_table">
            <thead>
                <tr>
                    <th class="text-center"></th>
                    <th class="text-start">Name</th>
                    <th class="text-start">Status</th>
                    <th class="text-start">Added by</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Add New Category Modal -->
    <div class="modal fade" id="addNewCategoryModal" tabindex="-1" aria-labelledby="addNewCategoryModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalLabek">Add Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo validation_errors(); ?>
                    <?php echo form_open('inventory/insert_category', array('id' => 'addNewCategoryForm')); ?>
                    <div class="col">
                        <p><strong>Category name</strong></p>
                    </div>
                    <div class="col">
                        <input name="name" value="<?php echo set_value('name'); ?>" type="text" class="form-control" placeholder="Category name" aria-label="Category name" required />
                    </div>
                    <div class="col">
                        <input type="hidden" name="location_id" value="<?php echo $_SESSION['user_loc_id']; ?>">
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