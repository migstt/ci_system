<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom scripts -->
<script>
    $(document).ready(function() {

        function getMonthLabels() {
            const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            const date = new Date();
            return months.slice(0, date.getMonth() + 1);
        }

        function initializeZeroFilledData() {
            const months = getMonthLabels();
            return months.map(month => ({
                month,
                stock_count: 0
            }));
        }

        const categoryColors = {
            'Office Supplies': '#FF6384',
            'Cleaning Supplies': '#36A2EB',
            'Furniture': '#FFCE56',
            'Computers': '#4BC0C0',
            'Printers': '#9966FF',
            'Stationery': '#FF9F40',
            'Networking Equipment': '#8E44AD',
            'Office Electronics': '#2ECC71',
            'Software': '#E74C3C'
        };

        function getCategoryColor(category) {
            if (!categoryColors[category]) {
                categoryColors[category] = getRandomColor();
            }
            return categoryColors[category];
        }

        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        $.ajax({
            url: '<?php echo site_url(); ?>/inventory/inventory/get_monthly_stock_counts_per_category',
            method: 'POST',
            dataType: 'json',
            success: function(response) {
                var datasets = [];
                var monthLabels = getMonthLabels();

                for (var category in response) {
                    if (response.hasOwnProperty(category)) {
                        var data = response[category];
                        var zeroFilledData = initializeZeroFilledData();

                        data.forEach(item => {
                            const monthIndex = new Date(item.month + '-01').getMonth();
                            zeroFilledData[monthIndex].stock_count = item.stock_count;
                        });

                        const color = getCategoryColor(category);

                        var dataset = {
                            label: category,
                            backgroundColor: color + '33',
                            borderColor: color,
                            pointBackgroundColor: color,
                            pointBorderColor: color,
                            borderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            data: zeroFilledData.map(item => item.stock_count)
                        };

                        datasets.push(dataset);
                    }
                }

                var ctxLine = document.getElementById('line_chart').getContext('2d');
                var line_chart = new Chart(ctxLine, {
                    type: 'line',
                    data: {
                        labels: monthLabels,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        elements: {
                            line: {
                                tension: 0.3,
                                borderCapStyle: 'round'
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            y: {
                                grid: {
                                    borderDash: [3, 3]
                                },
                                ticks: {
                                    font: {
                                        size: 14
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    font: {
                                        size: 14
                                    },
                                    usePointStyle: true
                                }
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                                titleFont: {
                                    size: 16
                                },
                                bodyFont: {
                                    size: 14
                                },
                                footerFont: {
                                    size: 12
                                },
                                cornerRadius: 4,
                                padding: 10
                            },
                            title: {
                                display: true,
                                text: 'Monthly Stocks Count per Category',
                                font: {
                                    size: 20
                                }
                            }
                        }
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    });


    // Google Charts
    google.charts.load("current", {
        packages: ["corechart"]
    });
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
        fetchItemCountCategoryChartData();
        fetchSupplierItemCountChartData();
        setInterval(fetchItemCountCategoryChartData, 60000);
        setInterval(fetchSupplierItemCountChartData, 60000);
    }

    function fetchItemCountCategoryChartData() {
        $.ajax({
            url: "<?php echo site_url(); ?>/inventory/category/count_items_each_category",
            method: "GET",
            dataType: "json",
            success: function(response) {
                var dataArray = [
                    ['Category', 'Total Items']
                ];
                response.forEach(function(item) {
                    dataArray.push([item.category_name, parseInt(item.total_items)]);
                });

                var data = google.visualization.arrayToDataTable(dataArray);

                var options = {
                    title: 'Total items per category',
                    is3D: true,
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart_item_count_by_category'));
                chart.draw(data, options);
            },
            error: function(error) {
                console.log("Error fetching data", error);
            }
        });
    }

    function fetchSupplierItemCountChartData() {
        $.ajax({
            url: "<?php echo site_url(); ?>/inventory/inventory/count_items_supplied_by_each_supplier",
            method: "GET",
            dataType: "json",
            success: function(response) {
                var dataArray = [
                    ['Supplier', 'Total Items Supplied']
                ];
                response.forEach(function(item) {
                    dataArray.push([item.supplier_name, parseInt(item.total_items_supplied)]);
                });

                var data = google.visualization.arrayToDataTable(dataArray);

                var options = {
                    title: 'Items supplied by each supplier',
                    is3D: true,
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart_suppliers'));
                chart.draw(data, options);
            },
            error: function(error) {
                console.log("Error fetching data", error);
            }
        });
    }
</script>


<i class='bx bx-menu' style='margin-top: .7%;'></i>
<div class="container-sm">
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="mt-2"><?php echo $current_user_loc['location_name']; ?> Inventory Dashboard</h5>
    </div>
    <div class="line_chart">
        <!-- Dropdown to select chart options -->
        <!-- <div style="position: relative;">
            <div style="position: absolute; top: 0; right: 0;" class="mt-1">
                <select id="chartOptions" class="form-select form-select-sm" onchange="updateChart()">
                    <option value="option1">Monthly Stocks Count per Category</option>
                    <option value="option2">Monthly Total Cost per Category</option>
                </select>
            </div>
        </div> -->
        <canvas id="line_chart" width="100%" height="385"></canvas>
    </div>

    <div style="display: flex; gap: 0; border: 1px solid #dddddd; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); overflow: hidden; margin-top: 15px">
        <div id="piechart_item_count_by_category" style="width: 50%; height: 300px;"></div>
        <div id="piechart_suppliers" style="width: 50%; height: 300px;"></div>
    </div>
    <div class="dashboard-cards">
        <div class="card">
            <h6>Stock Tracking</h6>
            <table>
                <tr>
                    <td>Total Batches Delivered:</td>
                    <td><?php echo $stock_counts['delivered']; ?></td>
                </tr>
                <tr>
                    <td>Issued Stocks:</td>
                    <td><?php echo $stock_counts['issued']; ?></td>
                </tr>
                <tr>
                    <td>Approved by Warehouse Manager:</td>
                    <td><?php echo $stock_counts['approved_manager']; ?></td>
                </tr>
                <tr>
                    <td>In Transit:</td>
                    <td><?php echo $stock_counts['transit']; ?></td>
                </tr>
            </table>
        </div>
        <div class="card">
            <h6>Report Logs</h6>
            <table>
                <tr>
                    <td>Total Reported Items:</td>
                    <td><?php echo $report_log_counts['total_reported_items']; ?></td>
                </tr>
                <tr>
                    <td>Pending:</td>
                    <td><?php echo $report_log_counts['pending']; ?></td>
                </tr>
                <tr>
                    <td>Reviewed:</td>
                    <td><?php echo $report_log_counts['reviewed']; ?></td>
                </tr>
                <tr>
                    <td>Disposed:</td>
                    <td><?php echo $report_log_counts['disposed']; ?></td>
                </tr>
                <tr>
                    <td>Replaced:</td>
                    <td><?php echo $report_log_counts['replaced']; ?></td>
                </tr>
            </table>
        </div>
        <div class="card">
            <h6>Users</h6>
            <table>
                <tr>
                    <td>Total Users:</td>
                    <td><?php echo $user_counts['total_users']; ?></td>
                </tr>
                <tr>
                    <td>Admins:</td>
                    <td><?php echo $user_counts['admins']; ?></td>
                </tr>
                <tr>
                    <td>Employees:</td>
                    <td><?php echo $user_counts['employees']; ?></td>
                </tr>
                <tr>
                    <td>Warehouse Managers:</td>
                    <td><?php echo $user_counts['managers']; ?></td>
                </tr>
                <tr>
                    <td>Couriers:</td>
                    <td><?php echo $user_counts['couriers']; ?></td>
                </tr>
            </table>
        </div>
        <div class="card">
            <h6>Entities</h6>
            <table>
                <tr>
                    <td>Suppliers:</td>
                    <td><?php echo $supplier_count['total_suppliers'] ?></td>
                </tr>
                <tr>
                    <td>Warehouses:</td>
                    <td><?php echo $warehouse_count['total_warehouses'] ?></td>
                </tr>
                <tr>
                    <td>Locations:</td>
                    <td><?php echo $location_count['total_locations'] ?></td>
                </tr>
                <tr>
                    <td><?php echo $current_user_loc['location_name']; ?> Users:</td>
                    <td><?php echo $currloc_user_count['total_users'] ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<style>
    .form-select-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
        margin-right: 1.5rem;
    }

    .d-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dashboard-cards {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 15px;
    }

    .card {
        background-color: #ffffff;
        border: 1px solid #dddddd;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 15px;
        flex: 1;
        min-width: 220px;
        max-width: 300px;
    }

    .card h6 {
        margin-bottom: 10px;
        font-size: 16px;
        font-weight: bold;
        color: #333333;
    }

    .card table {
        width: 100%;
        border-collapse: collapse;
    }

    .card table td {
        padding: 5px 0;
        color: #666666;
    }

    .card table td:first-child {
        font-weight: bold;
    }

    .card p {
        font-size: 14px;
        color: #666666;
    }

    .chart-container {
        display: flex;
        gap: 0;
        border: 1px solid #dddddd;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 20px;
    }

    #piechart_item_count_by_category,
    #piechart_suppliers {
        width: 50%;
        height: 350px;
        margin: 0;
        padding: 0;
    }
</style>