<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<!-- Custom scripts -->
<script>
    $(document).ready(function() {
        // client side suppliers datatable
        $('#supplier_table').DataTable({
            responsive: true,
            searching: true,
            processing: true,
            ajax: {
                url: '<?php echo site_url(); ?>/inventory/supplier/get_suppliers',
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
                    "data": "contact_details",
                    "className": "text-start align-middle",
                    "render": function(data, type, row) {
                        if (Array.isArray(data)) {
                            return data.map(function(detail) {
                                return `
                                    <div class="contact-details">
                                        <strong>Person:</strong> ${detail.supplier_contact_person}<br>
                                        <strong>Number:</strong> ${detail.supplier_contact_no}
                                    </div>
                                `;
                            }).join('<br><br>');
                        } else if (typeof data === 'object') {
                            return `
                                <div class="contact-details">
                                    <strong>Person:</strong> ${data.supplier_contact_person}<br>
                                    <strong>Number:</strong> ${data.supplier_contact_no}
                                </div>
                            `;
                        } else {
                            return data;
                        }
                    }
                },
                {
                    "sortable": false,
                    "data": "bank_details",
                    "className": "text-start align-middle",
                    "render": function(data, type, row) {
                        if (Array.isArray(data)) {
                            return data.map(function(detail) {
                                return `
                                    <div class="bank-details">
                                        <strong>Bank name: </strong> ${detail.supplier_bank_name}<br>
                                        <strong>Account name: </strong> ${detail.supplier_account_name}<br>
                                        <strong>Account no: </strong> ${detail.supplier_account_no}
                                    </div>
                                `;
                            }).join('<br><br><br>');
                        } else if (typeof data === 'object') {
                            return `
                                <div class="bank-details">
                                    <strong>Bank name:</strong> ${data.supplier_bank_name}<br>
                                    <strong>Account name: </strong> ${data.supplier_account_name}<br>
                                    <strong>Account no: </strong> ${data.supplier_account_no}
                                </div>
                            `;
                        } else {
                            return data;
                        }
                    }
                },
                {
                    "sortable": false,
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
                {
                    "data": "added_by",
                    "className": "text-start align-middle",
                },
                // for the supplier actions (edit, delete) row
                {
                    "data": null,
                    "sortable": false,
                    "className": "align-middle",
                    "render": function(data, type, row) {
                        return `
                            <div class="d-flex justify-content-end">
                                <div class="btn-group btn-group-sm" role="group" aria-label="">
                            
                                    <!-- Update/Edit Supplier Modal -->
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editSupplierModal${data.supplier_id}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <div class="modal fade" id="editSupplierModal${data.supplier_id}" tabindex="-1" aria-labelledby="editSupplierModal" aria-hidden="true">
                                        <?php echo validation_errors(); ?>
                                        <?php echo form_open('inventory/supplier/update_supplier', array('id' => 'editSupplierForm${data.supplier_id}')); ?>
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="modalLabel">Edit Supplier</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Supplier Name -->
                                                    <div class="mb-5">
                                                        <p class="text-start"><strong>Supplier Name</strong></p>
                                                        <input name="name" value="${data.name}" type="text" class="form-control" placeholder="Supplier Name" aria-label="Supplier Name" required />
                                                    </div>

                                                    <!-- Supplier Contact Details -->
                                                    <div class="mb-5">
                                                        <p class="text-start"><strong>Supplier Contact Details</strong></p>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <input name="contact_person" value="${data.contact_person}" type="text" class="form-control" placeholder="Contact Person" aria-label="Contact Person" required />
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input name="contact_number" value="${data.contact_no}" type="text" class="form-control" placeholder="Contact Number" aria-label="Contact Number" required />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Supplier Bank Details -->
                                                    <div class="mb-3">
                                                        <p class="text-start"><strong>Supplier Bank Details</strong></p>
                                                        <div class="mb-3">
                                                            <input name="bank_name" value="${data.bank_name}" type="text" class="form-control" placeholder="Bank Name" aria-label="Bank Name" required />
                                                        </div>
                                                        <div class="mb-3">
                                                            <input name="account_name" value="${data.account_name}" type="text" class="form-control" placeholder="Account Name" aria-label="Account Name" required />
                                                        </div>
                                                        <div class="mb-3">
                                                            <input name="account_number" value="${data.account_no}" type="text" class="form-control" placeholder="Account Number" aria-label="Account Number" required />
                                                        </div>
                                                    </div>

                                                    <!-- Hidden Supplier ID -->
                                                    <input type="hidden" name="supplier_id" value="${data.supplier_id}" />

                                                    <!-- Modal Footer -->
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
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal${data.supplier_id}">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                    <div class="modal fade" id="confirmDeleteModal${data.supplier_id}" tabindex="-1" aria-labelledby="confirmDeleteModal" aria-hidden="true">
                                    <?php echo form_open('inventory/supplier/delete_supplier', array('id' => 'deleteSupplierForm${data.supplier_id}')); ?>
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmation</h1>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="supplier_id" value="${data.supplier_id}" />
                                                    <p class="text-start">Are you sure you want to set this supplier to inactive?</p>
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

        // for adding supplier
        $(document).on('submit', 'form[id^="addNewSupplierForm"]', function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>/inventory/supplier/insert_supplier/",
                data: form.serialize(),
                success: function(response) {
                    response = JSON.parse(response);
                    $('#supplier_table').DataTable().ajax.reload(null, false);
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
                    console.error('ADD SUPPLIER ERROR: ' + error);
                }
            });

        });

        // for updating  supplier
        $(document).on('submit', 'form[id^="editSupplierForm"]', function(e) {
            e.preventDefault();
            var form = $(this);
            var id = form.find('input[name="supplier_id"]').val();
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
                url: "<?php echo site_url(); ?>/inventory/supplier/update_supplier/" + id,
                data: form.serialize(),
                success: function(response) {
                    response = JSON.parse(response);
                    $('#supplier_table').DataTable().ajax.reload(null, false);
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
                    console.error('EDIT SUPPLIER ERROR: ' + error);
                }
            });
        });

        // for deleting supplier
        $(document).on('submit', 'form[id^="deleteSupplierForm"]', function(e) {
            e.preventDefault();
            var form = $(this);
            var id = form.find('input[name="supplier_id"]').val();
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>/inventory/supplier/delete_supplier/" + id,
                data: form.serialize(),
                success: function(response) {
                    response = JSON.parse(response);
                    $('#supplier_table').DataTable().ajax.reload(null, false);
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
                    console.error('DELETE SUPPLIER ERROR: ' + error);
                }
            });
        });
    });

    // for updating supplier status
    function updateStatus(id, newStatus) {
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url(); ?>/inventory/supplier/update_status/" + taskId,
            data: {
                table: 'suppliers',
                id: taskId,
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

<!-- Page Contents -->
<i class='bx bx-menu' style='margin-top: .7%;'></i>
<div class="container-sm">
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="mt-2">Suppliers</h5>
    </div>

    <!-- Add New Supplier Button -->
    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addNewSupplierModal">
        Add Supplier
    </button>

    <!-- Supplier Table -->
    <div class="supplier-table-container">
        <table class="table table-sm table-striped" class="display" id="supplier_table">
            <thead>
                <tr>
                    <th class="text-center"></th>
                    <th class="text-start"><strong>Name</strong></th>
                    <th class="text-start"><strong>Contact Details</strong></th>
                    <th class="text-start"><strong>Bank Details</strong></th>
                    <th class="text-start"><strong>Status</strong></th>
                    <th class="text-start"><strong>Added by</strong></th>
                    <th class="text-end"><strong>Actions</strong></th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Add New Supplier Modal -->
    <div class="modal fade" id="addNewSupplierModal" tabindex="-1" aria-labelledby="addNewSupplierModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalLabek">Add Supplier</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <?php echo validation_errors(); ?>
                    <?php echo form_open('inventory/supplier/insert_supplier', array('id' => 'addNewSupplierForm')); ?>

                    <!-- Supplier Name -->
                    <div class="mb-5">
                        <p><strong>Supplier Name</strong></p>
                        <input name="name" value="<?php echo set_value('name'); ?>" type="text" class="form-control" placeholder="Supplier Name" aria-label="Supplier Name" required />
                    </div>

                    <!-- Supplier Contact Details -->
                    <div class="mb-4">
                        <p><strong>Supplier Contact Details</strong></p>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input name="contact_person" value="<?php echo set_value('contact_person'); ?>" type="text" class="form-control" placeholder="Contact Person" aria-label="Contact Person" required />
                            </div>
                            <div class="col-md-6 mb-3">
                                <input name="contact_number" value="<?php echo set_value('contact_number'); ?>" type="text" class="form-control" placeholder="Contact Number" aria-label="Contact Number" required />
                            </div>
                        </div>
                    </div>

                    <!-- Supplier Bank Details -->
                    <div class="mb-3">
                        <p><strong>Supplier Bank Details</strong></p>
                        <div class="mb-3">
                            <input name="bank_name" value="<?php echo set_value('bank_name'); ?>" type="text" class="form-control" placeholder="Bank Name" aria-label="Bank Name" required />
                        </div>
                        <div class="mb-3">
                            <input name="account_name" value="<?php echo set_value('account_name'); ?>" type="text" class="form-control" placeholder="Account Name" aria-label="Account Name" required />
                        </div>
                        <div class="mb-3">
                            <input name="account_number" value="<?php echo set_value('account_number'); ?>" type="text" class="form-control" placeholder="Account Number" aria-label="Account Number" required />
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>

                    <?php echo form_close(); ?>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>