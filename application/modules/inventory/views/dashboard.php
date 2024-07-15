<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom scripts -->
<script>
    $(document).ready(function() {

    });

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
                    title: 'Items in each category',
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
        <h5 class="mt-2">Inventory Dashboard</h5>
    </div>
    <div style="display: flex; gap: 0; border: 1px solid #dddddd; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); overflow: hidden;">
        <div id="piechart_item_count_by_category" style="width: 50%; height: 350px;"></div>
        <div id="piechart_suppliers" style="width: 50%; height: 350px;"></div>
    </div>
    
    <div class="dashboard-cards">
        <div class="card">
            <h6>Report Log Stats</h6>
            <table>
                <tr>
                    <td>Total Reported Items:</td>
                    <td>XX</td>
                </tr>
                <tr>
                    <td>Pending:</td>
                    <td>XX</td>
                </tr>
                <tr>
                    <td>Review:</td>
                    <td>XX</td>
                </tr>
                <tr>
                    <td>Disposed:</td>
                    <td>XX</td>
                </tr>
                <tr>
                    <td>Replaced:</td>
                    <td>XX</td>
                </tr>
            </table>
        </div>
        <div class="card">
            <h6>Items Delivered Today</h6>
            <p>Total: XX</p>
        </div>
        <div class="card">
            <h6>Stock Tracking</h6>
            <table>
                <tr>
                    <td>Total Batches Delivered:</td>
                    <td>XX</td>
                </tr>
                <tr>
                    <td>Issued Stocks:</td>
                    <td>XX</td>
                </tr>
                <tr>
                    <td>Approved by Manager:</td>
                    <td>XX</td>
                </tr>
                <tr>
                    <td>In Transit:</td>
                    <td>XX</td>
                </tr>
            </table>
        </div>
        <div class="card">
            <h6>Users</h6>
            <table>
                <tr>
                    <td>Total Users:</td>
                    <td>XX</td>
                </tr>
                <tr>
                    <td>Admins:</td>
                    <td>XX</td>
                </tr>
                <tr>
                    <td>Employees:</td>
                    <td>XX</td>
                </tr>
                <tr>
                    <td>Warehouse Managers:</td>
                    <td>XX</td>
                </tr>
                <tr>
                    <td>Couriers:</td>
                    <td>XX</td>
                </tr>
            </table>
        </div>
    </div>
</div>


<style>
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