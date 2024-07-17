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
                    "className": "text-center align-middle",
                    "render": function(data, type, row) {
                        let dropdownItems = '';
                        let buttonClass = 'btn-secondary';
                        let dropdownHtml = '';

                        if (data === 'Pending') {
                            dropdownItems = `
                        <li><a class="dropdown-item" href="#" onclick="updateStatus('${row.report_id}', 'Reviewed')">Reviewed</a></li>
                        <li><a class="dropdown-item" href="#" onclick="updateStatus('${row.report_id}', 'Disposed')">Disposed</a></li>
                        <li><a class="dropdown-item" href="#" onclick="updateStatus('${row.report_id}', 'Replaced')">Replaced</a></li>
                    `;
                            buttonClass = 'btn-warning';
                        } else if (data === 'Reviewed') {
                            dropdownItems = `
                        <li><a class="dropdown-item" href="#" onclick="updateStatus('${row.report_id}', 'Disposed')">Disposed</a></li>
                        <li><a class="dropdown-item" href="#" onclick="updateStatus('${row.report_id}', 'Replaced')">Replaced</a></li>
                    `;
                            buttonClass = 'btn-info';
                        } else if (data === 'Disposed') {
                            dropdownItems = `
                        <li><a class="dropdown-item" href="#" onclick="updateStatus('${row.report_id}', 'Replaced')">Replaced</a></li>
                    `;
                            buttonClass = 'btn-danger';
                        } else if (data === 'Replaced') {
                            buttonClass = 'btn-success';
                        }

                        if (data !== 'Replaced') {
                            dropdownHtml = `
                        <div class="dropdown">
                            <button class="btn btn-fixed-width ${buttonClass} dropdown-toggle text-white" type="button" id="statusDropdown${row.report_id}" data-bs-toggle="dropdown" aria-expanded="false">
                                ${data}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="statusDropdown${row.report_id}">
                                ${dropdownItems}
                            </ul>
                        </div>
                    `;
                        } else {
                            dropdownHtml = `
                        <button class="btn btn-fixed-width ${buttonClass} text-white" type="button" disabled>
                            ${data}
                        </button>
                    `;
                        }
                        return dropdownHtml;
                    }
                },
                {
                    "data": null,
                    "sortable": false,
                    "className": "text-center align-middle",
                    "render": function(data, type, row) {
                        return `
                        <button class="btn btn-primary btn-sm view-report-details" 
                                data-id="${row.report_id}" 
                                data-item-name="${row.item_name}" 
                                data-serial="${row.serial}" 
                                data-reporter="${row.reporter}" 
                                data-date-reported="${row.date_reported}" 
                                data-remarks="${row.remarks}" 
                                data-attachment="${row.attachment}" 
                                data-status="${row.status}" 
                                data-toggle="modal" 
                                data-target="#viewReportDetailsModal">View
                        </button>
                    `;
                    }
                }
            ],
        });


        $(document).on('click', '.view-report-details', function() {
            const button = $(this);

            $('#modalItemName').text(button.data('item-name'));
            $('#modalSerial').text(button.data('serial'));
            $('#modalReporter').text(button.data('reporter'));
            $('#modalDateReported').text(button.data('date-reported'));
            $('#modalRemarks').text(button.data('remarks'));
            $('#modalStatus').text(button.data('status'));

            const attachment = button.data('attachment');
            const attachmentContainer = $('#modalAttachmentContainer');
            const downloadButton = $('#downloadAttachment');
            attachmentContainer.empty();

            if (attachment) {
                const uploadsBaseUrl = '<?php echo base_url(); ?>uploads_reports/';
                const fullAttachmentUrl = uploadsBaseUrl + attachment.split('/uploads_reports/')[1];

                downloadButton.attr('href', fullAttachmentUrl).show();

                const extension = fullAttachmentUrl.split('.').pop().toLowerCase();
                if (extension === 'pdf') {
                    attachmentContainer.append(`<iframe src="${fullAttachmentUrl}" width="100%" height="500px"></iframe>`);
                } else if (['jpg', 'jpeg', 'png', 'gif'].includes(extension)) {
                    attachmentContainer.append(`<img src="${fullAttachmentUrl}" class="img-fluid" alt="Attachment Image">`);
                } else {
                    attachmentContainer.append(`<p>No attachment available.`);
                    downloadButton.hide();
                }
            } else {
                attachmentContainer.append('<p>No attachment available.</p>');
                downloadButton.hide();
            }

            $('#viewReportDetailsModal').modal('show');
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
        <h5 class="mt-2"><?php echo $admin_loc['location_name'] ?> Item Report Logs</h5>
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

    <!-- Report Detail Modal -->
    <div class="modal fade" id="viewReportDetailsModal" tabindex="-1" aria-labelledby="viewReportDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewReportDetailsModalLabel">Report Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Item Name:</strong> <span id="modalItemName"></span></p>
                            <p><strong>Serial:</strong> <span id="modalSerial"></span></p>
                            <p><strong>Reporter:</strong> <span id="modalReporter"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Date Reported:</strong> <span id="modalDateReported"></span></p>
                            <p><strong>Remarks:</strong> <span id="modalRemarks"></span></p>
                            <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <p><strong>Attachment:</strong></p>
                            <div id="modalAttachmentContainer" class="text-center"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="downloadAttachment" class="btn btn-primary" href="#" download>Download Attachment</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


</div>

<style>
    .dropdown-toggle {
        color: white !important;
    }

</style>