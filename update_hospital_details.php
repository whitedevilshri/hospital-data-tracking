<?php 
session_start();

// Check if the user is logged in
if (!isset($_SESSION['hospital_admin_username'])) {
    header("Location: hospital_login.php"); // Redirect to login if not logged in
    exit();
}

// Include database configuration
include('config.php');

// Get the hospital ID of the logged-in admin
$hospital_id = $_SESSION['hospital_id'];

// Fetch hospital details for display
$query = "SELECT name, available_beds, available_staff, available_doctors FROM hospital WHERE hospital_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $hospital_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $hospital = $result->fetch_assoc();
} else {
    die("Hospital not found.");
}

// Update hospital details if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $updated_beds = $_POST['available_beds'];
    $updated_staff = $_POST['available_staff'];

    $update_query = "UPDATE hospital SET available_beds = ?, available_staff = ? WHERE hospital_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param('iii', $updated_beds, $updated_staff, $hospital_id);
    
    if ($update_stmt->execute()) {
        echo "<p style='color: green;'>Hospital details updated successfully.</p>";
    } else {
        echo "<p style='color: red;'>Error updating details: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Hospital Details</title>
    <style>
        /* Inline styling for enhanced form design */
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
        label {
            display: block;
            font-size: 16px;
            color: #555;
            margin: 15px 0 5px;
            text-align: left;
        }
        input[type="number"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Hospital Details for <?php echo htmlspecialchars($hospital['name']); ?></h2>
        <form method="post" action="">
            <label for="available_beds">Available Beds:</label>
            <input type="number" id="available_beds" name="available_beds" value="<?php echo htmlspecialchars($hospital['available_beds']); ?>" required>
            
            <label for="available_staff">Available Staff:</label>
            <input type="number" id="available_staff" name="available_staff" value="<?php echo htmlspecialchars($hospital['available_staff']); ?>" required>
            
            <label for="available_doctors">Available Doctors:</label>
            <input type="number" id="available_doctors" name="available_doctors" value="<?php echo htmlspecialchars($hospital['available_doctors']); ?>" readonly>
            
            <input type="submit" value="Update Hospital">
        </form>
    </div>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
