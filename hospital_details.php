<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbms_hms";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch hospital details with available doctors
$sql = "SELECT h.*, 
               (SELECT COUNT(*) 
                FROM HospitalDoctor hd 
                WHERE hd.hospital_id = h.hospital_id) AS available_doctors 
        FROM Hospital h";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Details</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hospital Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Hospital ID</th>
                    <th>Name</th>
                    <th>Total Beds</th>
                    <th>Available Beds</th>
                    <th>Total Staff</th>
                    <th>Available Staff</th>
                    <th>Total Patients</th>
                    <th>Available Doctors</th> <!-- New column for available doctors -->
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['hospital_id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['total_beds']}</td>
                                <td>{$row['available_beds']}</td>
                                <td>{$row['total_staff']}</td>
                                <td>{$row['available_staff']}</td>
                                <td>{$row['total_patients']}</td>
                                <td>{$row['available_doctors']}</td> <!-- Display available doctors -->
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No hospitals found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
