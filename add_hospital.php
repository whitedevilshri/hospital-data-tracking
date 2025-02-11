<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password
$dbname = "dbms_hms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $total_beds = $_POST['total_beds'];
    $available_beds = $_POST['available_beds'];
    $total_staff = $_POST['total_staff'];
    $available_staff = $_POST['available_staff'];
    $total_patients = $_POST['total_patients'];

    // Insert hospital into database
    $sql = "INSERT INTO Hospital (name, total_beds, available_beds, total_staff, available_staff, total_patients)
            VALUES ('$name', $total_beds, $available_beds, $total_staff, $available_staff, $total_patients)";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_hospitals.php"); // Redirect to view hospitals page after adding
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
