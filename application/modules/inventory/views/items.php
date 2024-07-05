<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom scripts -->
<script>
    $(document).ready(function() {
        // client side items datatable
        $('#items_table').DataTable({
            responsive: true,
            searching: true,
            processing: true,
            ajax: {
                url: '<?php echo site_url(); ?>/inventory/item/get_items',
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
                    "data": "category",
                    "className": "text-start align-middle"
                },
                {
                    "data": "location",
                    "className": "text-start align-middle"
                },
                {
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
                // for the item actions (edit, delete) row
                {
                    "data": null,
                    "sortable": false,
                    "className": "align-middle",
                    "render": function(data, type, row) {
                        return `
                            <div class="d-flex justify-content-end">
                                <div class="btn-group btn-group-sm" role="group" aria-label="">
                            
                                    <!-- Update/Edit Item Modal -->
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editItemModal${data.item_id}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <div class="modal fade" id="editItemModal${data.item_id}" tabindex="-1" aria-labelledby="editItemModal" aria-hidden="true">
                                        <?php echo validation_errors(); ?>
                                        <?php echo form_open('inventory/item/update_item', array('id' => 'editItemForm${data.item_id}')); ?>
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="modalLabel">Edit Item</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col mb-3">
                                                        <p class="text-start"><strong>Item name</strong></p>
                                                    </div>
                                                    <div class="col mb-3">
                                                        <input name="name" value="${data.name}" type="text" class="form-control" placeholder="Item name" aria-label="Item name" required />
                                                    </div>
                                                    <div class="col mb-3">
                                                        <p class="text-start"><strong>Item category</strong></p>
                                                    </div>
                                                    <div class="mb-2">
                                                            <select name="category" class="form-control" required>
                                                                <option value="${data.category_id}">${data.category}</option>
                                                                <?php foreach ($active_categories as $category) : ?>
                                                                    <option value="<?php echo $category->category_id; ?>" ${data.category_id == "<?php echo $category->category_id; ?>" ? 'selected' : ''}>
                                                                        <?php echo $category->category_name; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                    </div>

                                                    <div class="col mb-3">
                                                        <p class="text-start"><strong>Item location</strong></p>
                                                    </div>
                                                    <div class="mb-2">
                                                            <select name="location" class="form-control" required>
                                                                <option value="${data.location_id}">${data.location}</option>
                                                                <?php foreach ($active_locations as $location) : ?>
                                                                    <option value="<?php echo $location->location_id; ?>" ${data.location_id == "<?php echo $location->location_id; ?>" ? 'selected' : ''}>
                                                                        <?php echo $location->location_name; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                    </div>


                                                    <div class="col">
                                                        <input type="hidden" name="item_id" value="${data.item_id}" type="text" class="form-control" placeholder="item_id" aria-label="item_id" required />
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
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal${data.item_id}">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                    <div class="modal fade" id="confirmDeleteModal${data.item_id}" tabindex="-1" aria-labelledby="confirmDeleteModal" aria-hidden="true">
                                    <?php echo form_open('inventory/item/delete_item', array('id' => 'deleteItemForm${data.item_id}')); ?>
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmation</h1>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="item_id" value="${data.item_id}" />
                                                    <p class="text-start">Are you sure you want to set this item to inactive?</p>
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

        // for adding item
        $(document).on('submit', 'form[id^="addNewItemForm"]', function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>/inventory/item/insert_item/",
                data: form.serialize(),
                success: function(response) {
                    response = JSON.parse(response);
                    $('#items_table').DataTable().ajax.reload(null, false);
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
                    console.error('ADD ITEM ERROR: ' + error);
                }
            });

        });

        // for updating  item
        $(document).on('submit', 'form[id^="editItemForm"]', function(e) {
            e.preventDefault();
            var form = $(this);
            var id = form.find('input[name="item_id"]').val();
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>/inventory/item/update_item/" + id,
                data: form.serialize(),
                success: function(response) {
                    response = JSON.parse(response);
                    $('#items_table').DataTable().ajax.reload(null, false);
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
                    console.error('EDIT ITEM ERROR: ' + error);
                }
            });
        });

        // for deleting  item
        $(document).on('submit', 'form[id^="deleteItemForm"]', function(e) {
            e.preventDefault();
            var form = $(this);
            var id = form.find('input[name="item_id"]').val();
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>/inventory/item/delete_item/" + id,
                data: form.serialize(),
                success: function(response) {
                    response = JSON.parse(response);
                    $('#items_table').DataTable().ajax.reload(null, false);
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
                    console.error('DELETE ITEM ERROR: ' + error);
                }
            });
        });

    });

    // for updating item status
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
        <h5 class="mt-2">Items</h5>
    </div>

    <!-- Add New Item Button -->
    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addNewItemModal">
        Add Item
    </button>


    <!-- Items Table -->
    <div class="item-table-container">
        <table class="table table-sm table-striped" class="display" id="items_table">
            <thead>
                <tr>
                    <th class="text-center"></th>
                    <th class="text-start">Name</th>
                    <th class="text-start">Category</th>
                    <th class="text-start">Location</th>
                    <th class="text-start">Status</th>
                    <th class="text-start">Added by</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
        </table>
    </div>


    <!-- Add New Item Modal -->
    <div class="modal fade" id="addNewItemModal" tabindex="-1" aria-labelledby="addNewItemModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalLabek">Add Item</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo validation_errors(); ?>
                    <?php echo form_open('inventory/item/insert_item', array('id' => 'addNewItemForm')); ?>

                    <div class="col">
                        <p><strong>Name</strong></p>
                    </div>
                    <div class="col">
                        <input name="name" value="<?php echo set_value('name'); ?>" type="text" class="form-control" placeholder="Item name" aria-label="Item name" required />
                    </div>

                    <div class="col mt-3">
                        <p><strong>Item category</strong></p>
                    </div>
                    <div class="mb-3">
                        <select name="category" class="form-control" required>
                            <option value="">Select category</option>
                            <?php foreach ($active_categories as $category) : ?>
                                <option value="<?php echo $category->category_id; ?>"><?php echo $category->category_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col mt-3">
                        <p><strong>Item location</strong></p>
                    </div>
                    <div class="col mt-3 mb-3">
                        <select name="location" class="form-control" required>
                            <option value="">Select location</option>
                            <?php foreach ($active_locations as $location) : ?>
                                <option value="<?php echo $location->location_id; ?>"><?php echo $location->location_name; ?></option>
                            <?php endforeach; ?>
                        </select>
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