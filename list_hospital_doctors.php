<?php
session_start();

// Check if the user is logged in as hospital admin
if (!isset($_SESSION['hospital_admin_username'])) {
    header("Location: hospital_login.php"); // Redirect to login if not logged in
    exit();
}

// Include database configuration
include('config.php'); // This will include your database connection details

// Get the hospital ID of the logged-in admin
$hospital_id = $_SESSION['hospital_id'];

// Fetch doctors for the hospital
$query = "SELECT * FROM hospitaldoctor WHERE hospital_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $hospital_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Hospital Doctors</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link your CSS file for styling -->
</head>
<body>
    <div class="container">
        <h2>List of Doctors for Hospital ID: <?php echo htmlspecialchars($hospital_id); ?></h2>
        <table border="1">
            <tr>
                <th>Doctor Name</th>
                <th>Specification</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($doctor = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($doctor['doctor_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($doctor['specification']) . "</td>";
                    echo "<td>" . htmlspecialchars($doctor['doctor_email']) . "</td>";
                    echo "<td><a href='delete_hospital_doctor.php?id=" . $doctor['hospital_doctor_id'] . "' onclick='return confirm(\"Are you sure you want to delete this doctor?\");'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No doctors found for this hospital.</td></tr>";
            }
            ?>
        </table>
        <br>
        <a href="hospital_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
