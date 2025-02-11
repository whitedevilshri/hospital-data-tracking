<?php
session_start();
include('config.php');

if (!isset($_SESSION['hospital_admin_id'])) {
    header("Location: hospital_admin_login.php");
    exit();
}

$hospital_id = $_SESSION['hospital_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $total_beds = $_POST['total_beds'];
    $available_beds = $_POST['available_beds'];
    
    $update_query = "UPDATE Hospital SET name = ?, total_beds = ?, available_beds = ? WHERE hospital_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('siii', $name, $total_beds, $available_beds, $hospital_id);
    $stmt->execute();
    
    header("Location: hospital_admin_dashboard.php");
    exit();
}

$query = "SELECT * FROM Hospital WHERE hospital_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $hospital_id);
$stmt->execute();
$hospital = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Hospital Details</title>
</head>
<body>
    <h2>Update Hospital Details</h2>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo $hospital['name']; ?>" required>
        
        <label>Total Beds:</label>
        <input type="number" name="total_beds" value="<?php echo $hospital['total_beds']; ?>" required>
        
        <label>Available Beds:</label>
        <input type="number" name="available_beds" value="<?php echo $hospital['available_beds']; ?>" required>
        
        <button type="submit">Update</button>
    </form>
</body>
</html>
