<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// ✅ Load PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$file = __DIR__ . "/messages.json";
$messages = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

$id = isset($_GET['id']) ? (int)$_GET['id'] : -1;
if (!isset($messages[$id])) {
    die("Message not found.");
}

$message = $messages[$id];

// ✅ Mark as read automatically
$message['read'] = true;
$messages[$id] = $message;
file_put_contents($file, json_encode($messages, JSON_PRETTY_PRINT));

// ✅ Handle reply with PHPMailer
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reply = htmlspecialchars($_POST['reply']);

    $mail = new PHPMailer(true);

    try {
        // ✅ SMTP Configuration (Use your real Gmail or hosting SMTP settings)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'yourgmail@gmail.com'; // ✅ change this
        $mail->Password = 'your_app_password';   // ✅ use Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // ✅ Sender & Recipient
        $mail->setFrom('yourgmail@gmail.com', 'Deanworks');
        $mail->addAddress($message['email'], $message['name']);

        // ✅ Email Content
        $mail->isHTML(true);
        $mail->Subject = "Reply from Deanworks";
        $mail->Body = nl2br($reply);
        $mail->AltBody = $reply;

        $mail->send();
        $success = "✅ Reply sent successfully to " . htmlspecialchars($message['email']);
    } catch (Exception $e) {
        $error = "❌ Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>View Message - Deanworks</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #fffef7;
        padding: 20px;
    }

    .box {
        background: white;
        padding: 20px 25px;
        border-radius: 10px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.1);
        max-width: 650px;
        margin: auto;
    }

    h2 {
        color: #333;
        margin-bottom: 10px;
    }

    strong {
        color: #444;
    }

    .success {
        color: green;
        font-weight: bold;
        margin-top: 10px;
    }

    .error {
        color: red;
        font-weight: bold;
        margin-top: 10px;
    }

    textarea {
        width: 100%;
        height: 120px;
        margin-top: 10px;
        padding: 10px;
        font-family: Arial, sans-serif;
        font-size: 14px;
        border-radius: 5px;
        border: 1px solid #ccc;
        resize: vertical;
    }

    button {
        margin-top: 10px;
        padding: 10px 18px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
    }

    button:hover {
        background: #0056b3;
    }

    a {
        display: inline-block;
        margin-top: 15px;
        text-decoration: none;
        color: #555;
        font-weight: bold;
    }

    a:hover {
        text-decoration: underline;
    }

    /* ✨ Wrap long messages nicely */
    .box p:last-of-type {
        white-space: pre-wrap;
        word-wrap: break-word;
        overflow-wrap: break-word;
        line-height: 1.6;
    }
</style>
</head>
<body>
<div class="box">
    <h2>Message from <?= htmlspecialchars($message['name']) ?></h2>
    <p><strong>Email:</strong> <?= htmlspecialchars($message['email']) ?></p>
    <p><strong>Date:</strong> <?= $message['date'] ?></p>
    <p><strong>Message:</strong></p>
    <p><?= nl2br(htmlspecialchars($message['message'])) ?></p>

    <?php if (!empty($success)): ?>
        <p class="success"><?= $success ?></p>
    <?php elseif (!empty($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="reply">Reply:</label>
        <textarea name="reply" required></textarea>
        <button type="submit">Send Reply</button>
    </form>

    <a href="admin_messages.php">⬅ Back to Messages</a>
</div>
</body>
</html>
