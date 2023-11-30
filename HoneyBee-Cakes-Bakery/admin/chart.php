<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="theme-color" content="#3e454c">

        <title>HoneyBee Cakes Bakery Bar Graph</title>

        <!-- Font awesome -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <!-- Sandstone Bootstrap CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <!-- Bootstrap Datatables -->
        <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
        <!-- Bootstrap social button library -->
        <link rel="stylesheet" href="css/bootstrap-social.css">
        <!-- Bootstrap select -->
        <link rel="stylesheet" href="css/bootstrap-select.css">
        <!-- Bootstrap file input -->
        <link rel="stylesheet" href="css/fileinput.min.css">
        <!-- Awesome Bootstrap checkbox -->
        <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
        <!-- Admin Stye -->
        <link rel="stylesheet" href="css/style.css">

        <!-- Bootstrap and Chart.js -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.css">

        <style>
            .content {
                margin-top: 80px;
            }
        </style>
    </head>

    <body>
        <?php include('includes/header.php'); ?>

        <div class="ts-main-content">
            <?php include('includes/leftbar.php'); ?>
            <div class="content-wrapper">
                <div class="container-fluid">
                    <div style="width:60%; height:20%; text-align:center">
                        <button onClick="window.print()">Print Bar Chart</button>
                        <h2 class="page-header">Order Analysis</h2>
                        <canvas id="chartjs_bar"></canvas>
                    </div>
                    <div style="width:60%; height:20%; text-align:center">
                        <button onClick="window.print()">Print Bar Chart</button>
                        <h2 class="page-header">Order Analysis</h2>
                        <canvas id="chartjs_line"></canvas>
                    </div>
                    <div style="width:60%; height:20%; text-align:center">
                        <button onClick="window.print()">Print Bar Chart</button>
                        <h2 class="page-header">Order Analysis</h2>
                        <canvas id="chartjs_pie"></canvas>
                    </div>
                </div>
            </div>
        </div>



        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap-select.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap.min.js"></script>
        <script src="js/Chart.min.js"></script>
        <script src="js/fileinput.js"></script>
        <script src="js/chartData.js"></script>
        <script src="js/main.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
        <script type="text/javascript">
            // PHP code to fetch order data from the database
            <?php
            // Database connection parameters
            $host = "localhost";
            $username = "root";
            $password = "";
            $database = "patos";

            // Create a database connection
            $conn = new mysqli($host, $username, $password, $database);

            // Check the database connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // SQL query to retrieve order data
            $sql = "SELECT
            p.productName AS product_name,
            SUM(o.quantity) AS total_quantity
        FROM orders o
        INNER JOIN products p ON o.productId = p.id
        GROUP BY p.productName";

            // Execute the SQL query
            $result = $conn->query($sql);

            // Initialize arrays to store product names and total quantities
            $productNames = [];
            $totalQuantities = [];

            // Fetch data from the result set
            while ($row = $result->fetch_assoc()) {
                $productNames[] = $row['product_name'];
                $totalQuantities[] = $row['total_quantity'];
            }

            // Close the database connection
            $conn->close();
            ?>
            

            // JavaScript code to render the bar chart
            var ctx = document.getElementById("chartjs_bar").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($productNames); ?>,
                    datasets: [{
                        backgroundColor: "#5969ff",
                        data: <?php echo json_encode($totalQuantities); ?>,
                    }]
                },
                options: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            fontColor: '#71748d',
                            fontFamily: 'Circular Std Book',
                            fontSize: 14,
                        }
                    }
                }
            });

            // JavaScript code to render the line chart
    var ctxLine = document.getElementById("chartjs_line").getContext('2d');
    var myLineChart = new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($productNames); ?>,
            datasets: [{
                label: 'Product Sales Trend',
                data: <?php echo json_encode($totalQuantities); ?>,
                fill: false,
                borderColor: "#4CAF50",
                backgroundColor: "#fff",
                pointBorderColor: "#4CAF50",
                pointBackgroundColor: "#fff",
                pointRadius: 5,
                pointHoverRadius: 10,
            }]
        },
        options: {
            // Add any desired options for the line chart here
        }
    });

    // JavaScript code to render the pie chart
    var ctxPie = document.getElementById("chartjs_pie").getContext('2d');
    var myPieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($productNames); ?>,
            datasets: [{
                data: <?php echo json_encode($totalQuantities); ?>,
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    // Add more colors if needed
                ],
            }]
        },
        options: {
            // Add any desired options for the pie chart here
        }
    });
            
        </script>
    </body>

    </html>
    <!-- Add Canvas elements for Line Chart and Pie Chart -->


<?php } ?>