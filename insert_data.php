<?php
$servername = "localhost";
$username = "nnhqxdpc_roomradashuser";
$password = "SplashParkedMenaceSalved12"; 
$dbname = "nnhqxdpc_roomradash";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_revenue = $_POST["room_revenue"];
    $add_ons = $_POST["add_ons"];
    $adr = $_POST["adr"];
    $rev_par = $_POST["rev_par"];
    
    $sql = "INSERT INTO roomradash (date, room_revenue, add_ons, adr, rev_par)
            VALUES (CURDATE(), '$room_revenue', '$add_ons', '$adr', '$rev_par')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
    
    header("Location: index.php");
    exit();
}
?>
<?php
file_put_contents('form_data.log', print_r($_POST, true), FILE_APPEND);
?>