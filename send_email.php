<?php
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';         // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'your@gmail.com';     // Your email
        $mail->Password = 'your_app_password';  // App password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Email setup
        $mail->setFrom($email, 'Website Visitor');
        $mail->addAddress('your@gmail.com', 'Site Owner');

        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        echo '✅ Message sent successfully!';
    } catch (Exception $e) {
        echo "❌ Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request.";
}
