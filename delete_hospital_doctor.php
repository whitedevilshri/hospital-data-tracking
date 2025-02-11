<?php
session_start();

// Check if the user is logged in as hospital admin
if (!isset($_SESSION['hospital_admin_username'])) {
    header("Location: hospital_login.php");
    exit();
}

// Include database configuration
include('config.php');

// Get hospital doctor ID from query string
if (isset($_GET['id'])) {
    $doctor_id = $_GET['id'];

    // Prepare and execute deletion query
    $query = "DELETE FROM hospitaldoctor WHERE hospital_doctor_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $doctor_id);
    if ($stmt->execute()) {
        // Redirect back to the list page
        header("Location: list_hospital_doctors.php");
        exit();
    } else {
        echo "Error deleting doctor: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}

$conn->close(); // Close the database connection
?>
