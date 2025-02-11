<?php 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Database credentials
$servername = "localhost";  // Usually 'localhost' for XAMPP
$username = "root";         // Default username for XAMPP is 'root'
$password = "";             // Default password is empty for XAMPP
$dbname = "dbms_hms";       // Your database name (ensure it matches your actual DB name)

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
