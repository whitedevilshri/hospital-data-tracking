<?php
session_start();
include('config.php'); // Include your database configuration

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ? AND role = 'hospital_admin'");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Direct comparison of password (without hashing)
        if ($password === $user['password']) {
            // Store user information in session
            $_SESSION['hospital_admin_username'] = $user['username'];
            $_SESSION['hospital_id'] = $user['hospital_id']; // Ensure this exists

            // Redirect to the hospital dashboard
            header("Location: hospital_dashboard.php");
            exit();
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Invalid username or password.";
    }
}
?>
