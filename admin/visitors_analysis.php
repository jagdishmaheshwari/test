<?php 
include('header.php');
include ('../conn.php');
?>
<?php
// Assuming $conn is the database connection object

// Default date range (1 month)
$startDate = date('Y-m-01'); // First day of the current month
$endDate = date('Y-m-t');    // Last day of the current month

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve selected date range
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
}

// SQL query to fetch visitor interactions grouped by day
$sqlDaily = "SELECT DATE(visit_timestamp) AS visit_date, COUNT(*) AS visit_count
             FROM logs_visitors
             WHERE visit_timestamp BETWEEN '$startDate' AND '$endDate'
             GROUP BY visit_date
             ORDER BY visit_date";

// Execute SQL query for daily data
$resultDaily = $conn->query($sqlDaily);

// Prepare daily data for Google Charts (JSON format)
$chartDataDaily = [];
while ($row = $resultDaily->fetch_assoc()) {
    $chartDataDaily[] = [$row['visit_date'], intval($row['visit_count'])];
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Visitor Interactions Dashboard</title>
    <!-- Load Google Charts library -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            // Draw daily visitor interactions chart
            var dataDaily = new google.visualization.DataTable();
            dataDaily.addColumn('string', 'Date');
            dataDaily.addColumn('number', 'Visitors');
            dataDaily.addRows(<?php echo json_encode($chartDataDaily); ?>);

            var optionsDaily = {
                title: 'Daily Visitor Interactions',
                hAxis: { title: 'Date' },
                vAxis: { title: 'Visitors' },
                legend: { position: 'none' }
            };

            var chartDaily = new google.visualization.LineChart(document.getElementById('chartDaily'));
            chartDaily.draw(dataDaily, optionsDaily);
        }
    </script>
</head>

<body>
    <h1>Visitor Interactions Dashboard</h1>

    <!-- Date range selection form -->
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" value="<?php echo $startDate; ?>" required>

        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" value="<?php echo $endDate; ?>" required>

        <button type="submit">Update</button>
    </form>

    <!-- Daily Visitor Interactions Chart -->
    <div id="chartDaily" style="width: 800px; height: 400px;"></div>
</body>

</html>






<?php  
include('footer.php');

?>