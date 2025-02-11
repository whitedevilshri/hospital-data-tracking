<?php
// Start session
session_start();
include('config.php'); // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if the user already exists
    $checkUser = "SELECT * FROM User WHERE email='$email'";
    $result = mysqli_query($conn, $checkUser);

    if (mysqli_num_rows($result) > 0) {
        echo "User with this email already exists.";
    } else {
        // Insert new user
        $sql = "INSERT INTO User (username, email, password) VALUES ('$username', '$email', '$password')";
        if (mysqli_query($conn, $sql)) {
            header("Location: user_login.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form action="user_register.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" required><br>
            <label for="email">Email:</label>
            <input type="email" name="email" required><br>
            <label for="password">Password:</label>
            <input type="password" name="password" required><br>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="user_login.php">Login here</a></p>
    </div>
</body>
</html>
