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

// Delete hospital if delete request is made
if (isset($_GET['delete'])) {
    $hospital_id = intval($_GET['delete']);
    $sql = "DELETE FROM Hospital WHERE hospital_id = $hospital_id";
    $conn->query($sql);
    header("Location: view_hospitals.php"); // Redirect to the same page after deletion
}

// Fetch hospitals from the database
$sql = "SELECT * FROM Hospital";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Hospital Details</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        a {
            color: #4CAF50;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .action-link {
            color: red;
        }
        .action-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hospital Details</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Total Beds</th>
                <th>Available Beds</th>
                <th>Total Staff</th>
                <th>Available Staff</th>
                <th>Total Patients</th>
                <th>Action</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['hospital_id'] . "</td>
                            <td>" . $row['name'] . "</td>
                            <td>" . $row['total_beds'] . "</td>
                            <td>" . $row['available_beds'] . "</td>
                            <td>" . $row['total_staff'] . "</td>
                            <td>" . $row['available_staff'] . "</td>
                            <td>" . $row['total_patients'] . "</td>
                            <td><a href='view_hospitals.php?delete=" . $row['hospital_id'] . "' class='action-link' onclick='return confirm(\"Are you sure you want to delete this hospital?\");'>Delete</a></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='8' style='text-align:center;'>No hospitals found</td></tr>";
            }
            $conn->close();
            ?>
        </table>
        <div style="text-align: center;">
            <a href="manage_hospitals.php">Add New Hospital</a>
        </div>
    </div>
</body>
</html>
