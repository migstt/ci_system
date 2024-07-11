<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<!-- Custom scripts -->
<script>
    $(document).ready(function() {
        // client side locations datatable
        $('#report_logs_table').DataTable({
            responsive: true,
            searching: true,
            processing: true,
            ajax: {
                url: '<?php echo site_url(); ?>/inventory/report/get_all_reports',
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
                    "className": "text-start align-middle",
                    "width": "15%",
                },
                {
                    "data": "serial",
                    "className": "text-start align-middle"
                },
                {
                    "data": "reporter",
                    "className": "text-start align-middle"
                },
                {
                    "data": "date_reported",
                    "className": "text-start align-middle"
                },
                {
                    "data": "remarks",
                    "className": "text-start align-middle",
                    "width": "20%",
                },
                {
                    "data": "status",
                    "className": "text-start align-middle",
                    "render": function(data, type, row) {
                        let dropdownItems = '';

                        if (data === 'Pending') {
                            dropdownItems = `
                                                <li><a class="dropdown-item" href="#" onclick="updateStatus('${row.report_id}', 'Reviewed')">Reviewed</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="updateStatus('${row.report_id}', 'Disposed')">Disposed</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="updateStatus('${row.report_id}', 'Replaced')">Replaced</a></li>
                                            `;
                        } else if (data === 'Reviewed') {
                            dropdownItems = `
                                                <li><a class="dropdown-item" href="#" onclick="updateStatus('${row.report_id}', 'Pending')">Pending</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="updateStatus('${row.report_id}', 'Disposed')">Disposed</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="updateStatus('${row.report_id}', 'Replaced')">Replaced</a></li>
                                            `;
                        } else if (data === 'Disposed') {
                            dropdownItems = `
                                                <li><a class="dropdown-item" href="#" onclick="updateStatus('${row.report_id}', 'Pending')">Pending</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="updateStatus('${row.report_id}', 'Reviewed')">Reviewed</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="updateStatus('${row.report_id}', 'Replaced')">Replaced</a></li>
                                            `;
                        } else if (data === 'Replaced') {
                            dropdownItems = `
                                                <li><a class="dropdown-item" href="#" onclick="updateStatus('${row.report_id}', 'Pending')">Pending</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="updateStatus('${row.report_id}', 'Reviewed')">Reviewed</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="updateStatus('${row.report_id}', 'Disposed')">Disposed</a></li>
                                            `;
                        }

                        let buttonClass = 'btn-secondary';
                        if (data === 'Pending') {
                            buttonClass = 'btn-warning';
                        } else if (data === 'Reviewed') {
                            buttonClass = 'btn-info';
                        } else if (data === 'Disposed') {
                            buttonClass = 'btn-danger';
                        } else if (data === 'Replaced') {
                            buttonClass = 'btn-success';
                        }

                        return `
                                    <div class="dropdown">
                                        <button class="btn btn-fixed-width ${buttonClass} dropdown-toggle" type="button" id="statusDropdown${row.report_id}" data-bs-toggle="dropdown" aria-expanded="false">
                                            ${data}
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="statusDropdown${row.report_id}">
                                            ${dropdownItems}
                                        </ul>
                                    </div>
                                `;
                    }
                },

                // for the report log details with attachment
                {
                    "data": null,
                    "sortable": false,
                    "className": "align-middle",
                    render: function(data, type, row) {
                        return `
                                    <button class="btn btn-primary btn-sm view-stock-details" 
                                            data-id="${row.batch_id}" 
                                            data-batch-code="${row.batch_code}" 
                                            data-supplier="${row.supplier}" 
                                            data-warehouse="${row.warehouse}" 
                                            data-total-cost="${row.total_cost}" 
                                            data-location="${row.location}" 
                                            data-date-received="${row.date_received}" 
                                            data-added-by="${row.added_by}" 
                                            data-remarks="${row.remarks}" 
                                            data-attachment="${row.attachment}" 
                                            data-status="${row.status}" 
                                            data-toggle="modal" 
                                            data-target="#viewStockDetailsModal">View
                                    </button>
                                `;
                    }
                }
            ],
        });
    });

    // for updating report log status
    function updateStatus(reportId, newStatus) {
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url(); ?>/inventory/report/update_report_status/" + reportId,
            data: {
                report_id: reportId,
                status: newStatus
            },
            success: function(response) {
                response = JSON.parse(response);
                $('#report_logs_table').DataTable().ajax.reload(null, false);
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
        <h5 class="mt-2">Report Log</h5>
    </div>

    <!-- Report Logs Table -->
    <div class="location-table-container">
        <table class="table table-sm table-striped" class="display" id="report_logs_table">
            <thead>
                <tr>
                    <th class="text-center"></th>
                    <th class="text-start"><strong>Item</strong></th>
                    <th class="text-start"><strong>Serial</strong></th>
                    <th class="text-start"><strong>Reporter</strong></th>
                    <th class="text-start"><strong>Date</strong></th>
                    <th class="text-start"><strong>Remarks</strong></th>
                    <th class="text-center"><strong>Status</strong></th>
                    <th class="text-center"><strong>Details</strong></th>
                </tr>
            </thead>
        </table>
    </div>

</div>

<style>
    .dropdown-toggle {
        color: white !important;
    }
</style>