<?php 
session_start();

// Check if the user is logged in
if (!isset($_SESSION['hospital_admin_username'])) {
    header("Location: hospital_login.php"); // Redirect to login if not logged in
    exit();
}

// Include database configuration
include('config.php'); // This will include your database connection details

// Get the hospital ID of the logged-in admin
$hospital_id = $_SESSION['hospital_id'];

// Fetch hospital details for display
$query = "SELECT * FROM hospital WHERE hospital_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $hospital_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $hospital = $result->fetch_assoc();
} else {
    die("Hospital not found."); // Handle case where the hospital doesn't exist
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link your CSS file for styling -->
    <style>
        /* Inline styling for enhanced design */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            width: 90%;
            max-width: 500px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2, h3 {
            color: #333;
            margin-bottom: 15px;
        }
        p {
            font-size: 18px;
            color: #555;
            margin-bottom: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            margin: 15px 0;
        }
        ul li a {
            display: inline-block;
            font-size: 16px;
            color: #007bff;
            text-decoration: none;
            padding: 10px 20px;
            border: 1px solid #007bff;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        ul li a:hover {
            background-color: #007bff;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['hospital_admin_username']); ?>!</h2>
        <h3>Hospital: <?php echo htmlspecialchars($hospital['name']); ?></h3>
        <p>You are logged in as the Hospital Admin. Here are your options:</p>
        <ul>
            <li><a href="update_hospital_details.php">Update Hospital Details</a></li>
            <li><a href="add_hospital_doctor.php">Add Hospital Doctor</a></li>
            <li><a href="list_hospital_doctors.php">View Hospital Doctors</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
