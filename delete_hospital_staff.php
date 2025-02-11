<?php
session_start();
include('config.php');

// Check if user is logged in as admin
if (!isset($_SESSION['username']) || $_SESSION['role_id'] != 1) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['staff_id'])) {
    $staff_id = $_GET['staff_id'];

    // Prepare and execute delete query
    $query = "DELETE FROM hospital_staff WHERE staff_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $staff_id);

    if ($stmt->execute()) {
        // Redirect after successful deletion
        header("Location: view_hospital_staff.php?message=Staff deleted successfully");
        exit();
    } else {
        echo "Error deleting hospital staff: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
