<?php
session_start();

// Set timezone to Manila
date_default_timezone_set('Asia/Manila');

$file = __DIR__ . "/messages.json";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        header("Location: contact.php?error=All fields are required.");
        exit();
    }

    // Simple email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contact.php?error=Invalid email address.");
        exit();
    }

    // Prevent rapid duplicate submissions (spam protection)
    if (isset($_SESSION['last_submit']) && time() - $_SESSION['last_submit'] < 10) {
        header("Location: contact.php?error=Please wait at least 10 seconds before sending another message.");
        exit();
    }

    // Load existing messages (oldest-first)
    $messages = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    if (!is_array($messages)) {
        $messages = [];
    }

    // Add new message with current Manila time
    $messages[] = [
        "name" => $name,
        "email" => $email,
        "message" => $message,
        "date" => date("Y-m-d H:i:s"),
        "read" => false
    ];

    // Save to JSON
    $result = file_put_contents($file, json_encode($messages, JSON_PRETTY_PRINT));

    if ($result !== false) {
        $_SESSION['last_submit'] = time();
        header("Location: contact.php?success=1");
    } else {
        header("Location: contact.php?error=Failed to save your message. Please try again.");
    }
    exit();
} else {
    header("Location: contact.php");
    exit();
}
?>
