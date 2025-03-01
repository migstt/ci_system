<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<!-- Custom scripts -->
<script>
    $(document).ready(function() {
        // client side suppliers datatable
        $('#all_items_table').DataTable({
            responsive: true,
            searching: true,
            processing: true,
            ajax: {
                url: '<?php echo site_url(); ?>/inventory/items/get_all_items',
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
                    "data": "brand",
                    "className": "text-start align-middle"
                },
                {
                    "data": "unit_cost",
                    "className": "text-start align-middle"
                },
                {
                    "data": "tracking_no",
                    "className": "text-start align-middle"
                },
                {
                    "data": "serial_no",
                    "className": "text-start align-middle"
                },
                {
                    "data": "location",
                    "className": "text-start align-middle"
                },
                // for the viewing item action details
                {
                    "data": null,
                    "sortable": false,
                    "className": "text-center align-middle",
                    "render": function(data, type, row) {
                        return `
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#viewStockDetailsModal">View</button>
                        `;
                    }
                }
            ],
        });
    });

</script>

<!-- Page Contents -->
<i class='bx bx-menu' style='margin-top: .7%;'></i>
<div class="container-sm">
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="mt-2"><?php echo $location['location_name']; ?> Inventory</h5>
    </div>

    <!-- Supplier Table -->
    <div class="all-items-table-container">
        <table class="table table-sm table-striped" class="display" id="all_items_table">
            <thead>
                <tr>
                    <th class="text-center"></th>
                    <th class="text-start"><strong>Name</strong></th>
                    <th class="text-start"><strong>Brand</strong></th>
                    <th class="text-start"><strong>Unit cost</strong></th>
                    <th class="text-start"><strong>Tracking no.</strong></th>
                    <th class="text-start"><strong>Serial no.</strong></th>
                    <th class="text-start"><strong>Assigned to</strong></th>
                    <th class="text-center"><strong>Details</strong></th>
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