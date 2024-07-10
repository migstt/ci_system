<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom scripts -->
<script>
    $(document).ready(function() {
        // client side my reported items datatable
        $('#location_table').DataTable({
            responsive: true,
            searching: true,
            processing: true,
            ajax: {
                url: '<?php echo site_url(); ?>/inventory/location/get_locations',
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
                    "data": "address",
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
                // for the location actions (edit, delete) row
                {
                    "data": null,
                    "sortable": false,
                    "className": "align-middle",
                    "render": function(data, type, row) {
                        return `
                            <div class="d-flex justify-content-end">
                                <div class="btn-group btn-group-sm" role="group" aria-label="">
                            
                                    <!-- Update/Edit Location Modal -->
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editLocationModal${data.location_id}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <div class="modal fade" id="editLocationModal${data.location_id}" tabindex="-1" aria-labelledby="editLocationModal" aria-hidden="true">
                                        <?php echo validation_errors(); ?>
                                        <?php echo form_open('inventory/update_location', array('id' => 'editLocationForm${data.location_id}')); ?>
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="modalLabel">Edit Location</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col mb-3">
                                                        <p class="text-start"><strong>Location name</strong></p>
                                                    </div>
                                                    <div class="col mb-3">
                                                        <input name="name" value="${data.name}" type="text" class="form-control" placeholder="Location name" aria-label="Location name" required />
                                                    </div>
                                                    <div class="col mb-3">
                                                        <p class="text-start"><strong>Location address</strong></p>
                                                    </div>
                                                    <div class="col mb-3">
                                                        <input name="address" value="${data.address}" type="text" class="form-control" placeholder="Location address" aria-label="Location address" required />
                                                    </div>
                                                    <div class="col">
                                                        <input type="hidden" name="location_id" value="${data.location_id}" type="text" class="form-control" placeholder="location_id" aria-label="location_id" required />
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
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal${data.location_id}">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                    <div class="modal fade" id="confirmDeleteModal${data.location_id}" tabindex="-1" aria-labelledby="confirmDeleteModal" aria-hidden="true">
                                    <?php echo form_open('inventory/delete_location', array('id' => 'deleteLocationForm${data.location_id}')); ?>
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmation</h1>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="location_id" value="${data.location_id}" />
                                                    <p class="text-start">Are you sure you want to set this location to inactive?</p>
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

        // for submitting item report
        $(document).on('submit', 'form[id^="addItemReportForm"]', function(e) {
            e.preventDefault();

            var form = $(this)[0]; // Get the form element
            var formData = new FormData(form); // Create a FormData object

            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>/inventory/report/report_form_submit/",
                data: formData,
                contentType: false,
                processData: false,
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
                    console.error('SUBMIT REPORT LOG ERROR: ' + error);
                }
            });
        });



    });
</script>

<i class='bx bx-menu' style='margin-top: .7%;'></i>
<div class="container-sm mt-2">
    <div class="row">
        <div class="col-md-6">
            <div class="form-container p-4 rounded shadow-sm bg-light">
                <div class="d-flex justify-content-between align-items-center form-header mb-4">
                    <h5>Report Item Form</h5>
                </div>
                <?php echo form_open_multipart('inventory/report/report_form_submit', array('id' => 'addItemReportForm')); ?>
                <div class="form-group">
                    <label for="itemSerialCode" class="font-weight-bold">Item Serial Code</label>
                    <input name="serial" type="text" class="form-control mt-2" id="itemSerialCode" placeholder="Enter item serial code" required>
                </div>
                <div class="form-group mt-4">
                    <label for="remarks" class="font-weight-bold">Remarks</label>
                    <textarea name="remarks" class="form-control mt-2" id="remarks" rows="3" placeholder="Enter remarks" required></textarea>
                </div>
                <div class="form-group mt-4">
                    <label for="attachment" class="font-weight-bold">Attachment</label>
                    <input type="file" name="attachment" class="form-control mt-2" id="attachment" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-4">Submit</button>
                <?php echo form_close(); ?>

            </div>

        </div>
        <div class="col-md-6">
            <div class="table-container p-4 rounded shadow-sm bg-light">
                <h5 class="mb-4 text-primary">My reported items</h5>
                <table class="table table-striped" id="my_reports">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Item name</th>
                            <th scope="col">Item serial code</th>
                            <th scope="col">Remarks</th>
                            <!-- <th scope="col">Attachment</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .form-container,
    .table-container {
        background-color: #f8f9fa;
        padding: 2%;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-header h5,
    .table-container h5 {
        color: #007bff;
    }

    .form-group label {
        font-weight: bold;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
</style>