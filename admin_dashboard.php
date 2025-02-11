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
    <title>Admin Dashboard</title>
    <style>
        /* Inline styling for improved dashboard layout */
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
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        ul li {
            margin: 10px 0;
        }
        ul li a {
            text-decoration: none;
            font-size: 16px;
            color: #007bff;
            padding: 10px 20px;
            border: 1px solid #007bff;
            border-radius: 5px;
            display: inline-block;
            width: 100%;
            box-sizing: border-box;
            transition: background-color 0.3s, color 0.3s;
        }
        ul li a:hover {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="manage_hospitals.php">Manage Hospitals</a></li>
            <li><a href="add_hospital_admin.php">Add Hospital Admin</a></li>
            <li><a href="view_user_details.php">View User Details</a></li>
            <li><a href="view_hospital_details.php">View Hospital Details</a></li>
            <li><a href="logout.php">Logout</a></li> <!-- Logout button -->
        </ul>
    </div>
</body>
</html>
