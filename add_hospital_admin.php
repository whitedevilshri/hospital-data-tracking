<?php
session_start();

// Ensure the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbms_hms";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch hospitals for the dropdown
$sql = "SELECT * FROM hospital";
$hospitals = $conn->query($sql);

// Add new hospital admin
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_hospital_admin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];  // Plain password (no hashing)
    $email = $_POST['email'];
    $hospital_id = $_POST['hospital_id'];

    // Check if this hospital already has an admin
    $check_sql = "SELECT * FROM hospital WHERE hospital_id = $hospital_id AND admin_id IS NOT NULL";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "This hospital already has an admin.";
    } else {
        // Get role_id for hospital_admin
        $role_sql = "SELECT role_id FROM role WHERE role_name = 'hospital_admin'";
        $role_result = $conn->query($role_sql);
        $role_row = $role_result->fetch_assoc();
        $role_id = $role_row['role_id'];
        
        // Insert into user table
        $insert_sql = "INSERT INTO user (username, password, email, role_id, hospital_id, role) 
                       VALUES ('$username', '$password', '$email', $role_id, $hospital_id, 'hospital_admin')";
        
        if ($conn->query($insert_sql) === TRUE) {
            // Update the hospital's admin_id to the new user's ID
            $last_user_id = $conn->insert_id; // Get the last inserted user ID
            $update_hospital_sql = "UPDATE hospital SET admin_id = $last_user_id WHERE hospital_id = $hospital_id";
            $conn->query($update_hospital_sql);

            // Redirect to the admin dashboard after successful addition
            header("Location: admin_dashboard.php");
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Hospital Admin</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Add Hospital Admin</h2>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" name="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="hospital_id">Select Hospital:</label>
            <select name="hospital_id" required>
                <?php
                if ($hospitals->num_rows > 0) {
                    while ($row = $hospitals->fetch_assoc()) {
                        echo "<option value='" . $row['hospital_id'] . "'>" . $row['name'] . "</option>";
                    }
                }
                ?>
            </select>

            <button type="submit" name="add_hospital_admin">Add Hospital Admin</button>
        </form>
    </div>
</body>
</html>
