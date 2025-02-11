<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['hospital_admin_username'])) {
    header("Location: hospital_dashboard.php"); // Redirect to dashboard if already logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Admin Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Hospital Admin Login</h2>
        <form action="hospital_login_process.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
