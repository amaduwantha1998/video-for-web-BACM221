<?php
session_start();
// include 'includes/connect.php'; // No actual database connection for now

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; // No md5 hashing for mock login

    // Debugging: Output received credentials
    error_log("Received Username: " . $username);
    error_log("Received Password: " . $password);

    // Mock login credentials
    $mock_username = "admin";
    $mock_password = "password"; // Plain text password for mock login
    $mock_role = "Admin";

    if ($username === $mock_username && $password === $mock_password) {
        $_SESSION['username'] = $mock_username;
        $_SESSION['role'] = $mock_role;
        header("Location: dashboard.php");
        exit(); // Important to exit after header redirect
    } else {
        echo "Invalid credentials (mock login).";
    }
}
?>
