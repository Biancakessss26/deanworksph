<!DOCTYPE html>
<html>
<head>
    <title>Contact Form</title>
</head>
<body>
    <h2>Contact Us</h2>
    <form action="send_email.php" method="POST">
        <label>Your Email:</label><br>
        <input type="email" name="email" required><br><br>
        
        <label>Subject:</label><br>
        <input type="text" name="subject" required><br><br>

        <label>Message:</label><br>
        <textarea name="message" rows="5" required></textarea><br><br>

        <input type="submit" value="Send">
    </form>
</body>
</html>
