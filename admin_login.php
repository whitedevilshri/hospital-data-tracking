<?php
session_start();

// Initialize login variables
$email = "admin@vit.edu";
$password = "admin2004";

// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_email = $_POST['email'];
    $input_password = $_POST['password'];

    // Validate admin credentials
    if ($input_email === $email && $input_password === $password) {
        $_SESSION['role'] = 'admin'; // Set session role
        header("Location: admin_dashboard.php"); // Redirect to admin dashboard
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Admin Login</h2>
        <?php if (isset($error)): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
