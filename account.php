<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: admin_dashboard.php");
    exit;
}
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Deanworks Admin</title>
  <style>
    body {font-family: 'Segoe UI', sans-serif;background: #fff9db;display: flex;justify-content: center;align-items: center;height: 100vh;}
    .login-container {background: #fff;padding: 30px;border-radius: 12px;box-shadow: 0 4px 15px rgba(0,0,0,0.1);width: 100%;max-width: 400px;text-align: center;}
    h2 {color: #8b5e00;margin-bottom: 20px;}
    input[type="text"], input[type="password"] {width: 100%;padding: 12px;margin-bottom: 15px;border: 1px solid #ccc;border-radius: 8px;}
    input[type="submit"] {width: 100%;padding: 12px;background: #f39c12;color: white;border: none;font-weight: bold;border-radius: 8px;cursor: pointer;transition: 0.3s;}
    input[type="submit"]:hover {background: #d35400;}
    .error {color: red;margin-bottom: 10px;font-weight: bold;}
    .back-button {display: inline-block;margin-top: 10px;color: #f39c12;text-decoration: none;border: 2px solid #f39c12;padding: 8px;border-radius: 6px;}
    .back-button:hover {background: #f39c12;color: white;}
  </style>
</head>
<body>
<div class="login-container">
  <h2>Owner Login</h2>
  <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <form method="post" action="authenticate.php">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" value="Login">
  </form>
  <a href="index.html" class="back-button">Back</a>
</div>
</body>
</html>