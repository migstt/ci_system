<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom scripts -->
<script>
    $(document).ready(function() {
        // client side my reported items datatable
        $('#my_reports').DataTable({
            responsive: true,
            searching: true,
            processing: true,
            bPaginate: false,
            bLengthChange: false,
            searching: false,
            info: false,
            ajax: {
                url: '<?php echo site_url(); ?>/inventory/report/get_my_submitted_reports',
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
                    "data": "item_name",
                    "className": "text-start align-middle"
                },
                {
                    "sortable": false,
                    "data": "serial",
                    "className": "text-start align-middle"
                },
                {
                    "sortable": false,
                    "data": "status",
                    "className": "text-start align-middle",
                    "createdCell": function(td, cellData, rowData, row, col) {
                        var className = "";
                        switch (cellData) {
                            case "Pending":
                                className = "bg-warning";
                                break;
                            case "Reviewed":
                                className = "bg-info";
                                break;
                            case "Disposed":
                                className = "bg-danger";
                                break;
                            case "Replaced":
                                className = "bg-success";
                                break;
                            default:
                                className = "";
                                break;
                        }
                        $(td).addClass('p-0 text-center');
                        $(td).html("<span class='" + className + "'>" + cellData + "</span>");
                    },
                    "render": function(data, type, row, meta) {
                        return data; // Return the raw data
                    }
                },
                {
                    "data": "date_reported",
                    "className": "text-start align-middle",
                }
            ],
        });

        $(document).on('submit', 'form[id^="addItemReportForm"]', function(e) {
            e.preventDefault();

            var form = $(this)[0];
            var formData = new FormData(form);

            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>/inventory/report/report_form_submit/",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status === 'error_serial') {
                        $('#my_reports').DataTable().ajax.reload(null, false);
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    } else {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#my_reports').DataTable().ajax.reload();
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
                <div class="col">
                    <input type="hidden" name="location_id" value="<?php echo $_SESSION['user_loc_id']; ?>">
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
                            <th scope="col"><strong>Name</strong></th>
                            <th scope="col"><strong>Serial</strong></th>
                            <th scope="col" class="text-center"><strong>Status</strong></th>
                            <th scope="col"><strong>Date reported</strong></th>
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

    .bg-warning {
        background-color: #ffc107 !important;
        color: #fff;
        padding: 5px;
        border-radius: 5px;
        display: inline-block;
        width: 100px;
        /* Set a fixed width */
        text-align: center;
        /* Center the text */
    }

    .bg-info {
        background-color: #17a2b8 !important;
        color: #fff;
        padding: 5px;
        border-radius: 5px;
        display: inline-block;
        width: 100px;
        text-align: center;
    }

    .bg-danger {
        background-color: #dc3545 !important;
        color: #fff;
        padding: 5px;
        border-radius: 5px;
        display: inline-block;
        width: 100px;
        text-align: center;
    }

    .bg-success {
        background-color: #28a745 !important;
        color: #fff;
        padding: 5px;
        border-radius: 5px;
        display: inline-block;
        width: 100px;
        text-align: center;
    }
</style>