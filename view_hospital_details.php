<?php 
session_start();

// Database credentials
$servername = "localhost";  
$username = "root";         
$password = "";             
$dbname = "dbms_hms";       

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete hospital admin if delete_admin_id request is made
if (isset($_GET['delete_admin_id'])) {
    $delete_admin_id = $_GET['delete_admin_id'];
    $delete_admin_sql = "UPDATE hospital SET admin_id = NULL WHERE admin_id = ?";
    $stmt = $conn->prepare($delete_admin_sql);
    $stmt->bind_param("i", $delete_admin_id);
    $stmt->execute();
    $stmt->close();
    header("Location: view_hospital_details.php"); // Redirect to the same page after deletion
    exit();
}

// Delete hospital if delete_hospital_id request is made
if (isset($_GET['delete_hospital_id'])) {
    $delete_hospital_id = $_GET['delete_hospital_id'];
    $delete_hospital_sql = "DELETE FROM hospital WHERE hospital_id = ?";
    $stmt = $conn->prepare($delete_hospital_sql);
    $stmt->bind_param("i", $delete_hospital_id);
    $stmt->execute();
    $stmt->close();
    header("Location: view_hospital_details.php"); // Redirect to the same page after deletion
    exit();
}

// Fetch hospital details
$sql = "SELECT h.hospital_id, h.name, u.user_id, COALESCE(u.username, 'N/A') AS admin_name
        FROM hospital h
        LEFT JOIN user u ON h.admin_id = u.user_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Hospital Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        a {
            color: #ff0000; /* Red color for delete link */
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Hospital Details</h2>
    <table>
        <tr>
            <th>Hospital ID</th>
            <th>Name</th>
            <th>Admin Name</th>
            <th>Action (Delete Admin)</th>
            <th>Action (Delete Hospital)</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["hospital_id"]; ?></td>
                    <td><?php echo $row["name"]; ?></td>
                    <td><?php echo $row["admin_name"]; ?></td>
                    <td>
                        <?php if ($row["user_id"] !== null): ?>
                            <a href="?delete_admin_id=<?php echo $row["user_id"]; ?>" onclick="return confirm('Are you sure you want to remove this hospital admin?');">Delete Admin</a>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="?delete_hospital_id=<?php echo $row["hospital_id"]; ?>" onclick="return confirm('Are you sure you want to delete this hospital?');">Delete Hospital</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">No hospitals found.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
