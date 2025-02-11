<?php
session_start();
include('config.php');

// Check if user is logged in as admin
if (!isset($_SESSION['username']) || $_SESSION['role_id'] != 1) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Prepare and execute delete query
    $query = "DELETE FROM User WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        // Redirect after successful deletion
        header("Location: view_hospital_staff.php?message=User deleted successfully");
        exit();
    } else {
        echo "Error deleting user: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
