<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Hospitals</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Manage Hospitals</h2>
        <form action="add_hospital.php" method="POST">
            <label for="name">Hospital Name:</label>
            <input type="text" name="name" required>

            <label for="total_beds">Total Beds:</label>
            <input type="number" name="total_beds" required>

            <label for="available_beds">Available Beds:</label>
            <input type="number" name="available_beds" required>

            <label for="total_staff">Total Staff:</label>
            <input type="number" name="total_staff" required>

            <label for="available_staff">Available Staff:</label>
            <input type="number" name="available_staff" required>

            <label for="total_patients">Total Patients:</label>
            <input type="number" name="total_patients" required>

            <button type="submit">Add Hospital</button>
        </form>
        <br>
        <a href="view_hospitals.php">View Hospital Details</a>
    </div>
</body>
</html>
