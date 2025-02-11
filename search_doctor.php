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

// Initialize variables for search and results
$doctor_type = '';
$result = null;

// Fetch doctor types for dropdown
$doctor_types_query = "SELECT doctor_type_id, doctor_type_name FROM doctortype";
$doctor_types_result = $conn->query($doctor_types_query);

// Handle search request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['doctor_type'])) {
    $doctor_type_id = $_POST['doctor_type']; // Now using doctor_type_id from dropdown
    
    $sql = "SELECT h.hospital_id, h.name AS hospital_name, d.doctor_type_name 
            FROM hospitaldoctor hd 
            JOIN hospital h ON hd.hospital_id = h.hospital_id 
            JOIN doctortype d ON hd.doctor_type_id = d.doctor_type_id 
            WHERE d.doctor_type_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $doctor_type_id); // Bind doctor_type_id
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $message = "No hospitals found for the selected doctor type.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Doctor</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 800px;
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
        form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Search for Doctors</h2>
        <form method="POST" action="">
            <label for="doctor_type">Select Doctor Type:</label>
            <select id="doctor_type" name="doctor_type" required>
                <option value="">Select Doctor Type</option>
                <?php
                if ($doctor_types_result->num_rows > 0) {
                    while ($row = $doctor_types_result->fetch_assoc()) {
                        echo "<option value='" . $row['doctor_type_id'] . "'>" . $row['doctor_type_name'] . "</option>";
                    }
                }
                ?>
            </select>
            <button type="submit">Search</button>
        </form>
        
        <?php if (isset($message)) echo "<p>$message</p>"; ?>
        
        <table>
            <thead>
                <tr>
                    <th>Hospital ID</th>
                    <th>Hospital Name</th>
                    <th>Doctor Type</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['hospital_id']}</td>
                                <td>{$row['hospital_name']}</td>
                                <td>{$row['doctor_type_name']}</td>
                              </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
