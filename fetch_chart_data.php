<?php
header('Content-Type: application/json');

$servername = "localhost"; 
$username = "nnhqxdpc_roomradashuser"; 
$password = "SplashParkedMenaceSalved12";  
$dbname = "nnhqxdpc_roomradash"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the last day of the current month
$current_month = date('Y-m');
$last_day_of_current_month = date('t', strtotime($current_month . '-01'));

// X-axis labels for 1, 5, 10, 15, 20, 25, and the last day of the month
$days_in_month = [1, 5, 10, 15, 20, 25, $last_day_of_current_month];

// Function to fetch data for a specific month
function fetch_data_by_month($conn, $month) {
    global $days_in_month;
    $data = [];
    foreach ($days_in_month as $day) {
        $date = "$month-$day";
        // Fetch total revenue and total entries for each specified day
        $sql = "SELECT SUM(room_revenue + add_ons + adr + rev_par) AS total_revenue, COUNT(*) AS total_entries 
                FROM roomradash 
                WHERE DATE(date) = '$date'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $data['revenue'][] = $row['total_revenue'] ?: 0;
        $data['entries'][] = $row['total_entries'] ?: 0;
    }
    return $data;
}

// Fetch data for the current month and previous month
$current_month_data = fetch_data_by_month($conn, $current_month);
$previous_month = date('Y-m', strtotime('-1 month'));
$previous_month_data = fetch_data_by_month($conn, $previous_month);

$conn->close();

// Prepare the JSON response
echo json_encode([
    'current_month_revenue' => $current_month_data['revenue'],
    'previous_month_revenue' => $previous_month_data['revenue'],
    'current_month_entries' => $current_month_data['entries'],  // Current month's total entries
    'previous_month_entries' => $previous_month_data['entries'],  // Previous month's total entries
    'last_day' => $last_day_of_current_month
]);
?>
