<?php
session_start();
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

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_username = $_POST['username'];
    $login_password = $_POST['password'];

    // Fetch user details
    $sql = "SELECT * FROM User WHERE username='$login_username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($login_password, $row['password'])) {
            $_SESSION['username'] = $row['username']; // Set session variable
            header("Location: user_dashboard.php"); // Redirect to user dashboard
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "User not found.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>User Login</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <input type="submit" value="Login">
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
