<?php
session_start();

// Hardcoded login credentials (you can change these)
$valid_username = "Deanworks";
$valid_password = "dean123";

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Check credentials
if ($username === $valid_username && $password === $valid_password) {
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    session_regenerate_id(true); // security
    header("Location: admin_dashboard.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid username or password!";
    header("Location: login.php");
    exit();
}
