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

// Add doctor to hospitaldoctor table if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor_name = $_POST['doctor_name'];
    $specification = $_POST['specification'];
    $doctor_email = $_POST['doctor_email'];
    $doctor_type_id = $_POST['doctor_type_id']; // Get selected doctor type

    // Insert into hospitaldoctor table
    $insert_query = "INSERT INTO hospitaldoctor (hospital_id, doctor_name, specification, doctor_email, doctor_type_id) VALUES (?, ?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param('isssi', $hospital_id, $doctor_name, $specification, $doctor_email, $doctor_type_id);

    if ($insert_stmt->execute()) {
        // Update available doctors in the hospital table
        $update_hospital_query = "UPDATE hospital SET available_doctors = available_doctors + 1 WHERE hospital_id = ?";
        $update_stmt = $conn->prepare($update_hospital_query);
        $update_stmt->bind_param('i', $hospital_id);
        $update_stmt->execute();

        echo "<p style='color: green;'>Doctor added successfully.</p>";
    } else {
        echo "<p style='color: red;'>Error adding doctor: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Hospital Doctor</title>
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
        input[type="text"], input[type="email"], select {
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
        <h2>Add a Doctor</h2>
        <form method="post" action="">
            <label for="doctor_name">Doctor Name:</label>
            <input type="text" id="doctor_name" name="doctor_name" required>

            <label for="specification">Specification:</label>
            <input type="text" id="specification" name="specification" required>

            <label for="doctor_email">Doctor Email:</label>
            <input type="email" id="doctor_email" name="doctor_email" required>

            <label for="doctor_type_id">Doctor Type:</label>
            <select id="doctor_type_id" name="doctor_type_id" required>
                <option value="">Select Doctor Type</option>
                <?php
                // Fetch doctor types for dropdown
                $doctor_types_query = "SELECT * FROM doctortype";
                $doctor_types_result = $conn->query($doctor_types_query);
                while ($row = $doctor_types_result->fetch_assoc()) {
                    echo "<option value='" . $row['doctor_type_id'] . "'>" . $row['doctor_type_name'] . "</option>";
                }
                ?>
            </select>

            <input type="submit" value="Add Doctor">
        </form>
    </div>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
