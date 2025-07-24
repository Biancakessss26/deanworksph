<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: admin_dashboard.php");
    exit;
}

// ✅ Secure session-based flash error
$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Deanworks Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Open Sans', sans-serif;
    }
    body {
      margin: 0;
      padding: 0;
      background: #fffef7;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    .login-container {
      background: #0ABAB5;
      padding: 40px 30px;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
      width: 90%;
      max-width: 400px;
      text-align: center;
    }
    h2 {
      margin-bottom: 1.5em;
      color: #333;
      font-size: 1.8rem;
    }
    label {
      display: block;
      text-align: left;
      font-weight: bold;
      margin-bottom: 5px;
      color: #555;
    }
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
      transition: border 0.3s ease;
    }
    input[type="text"]:focus,
    input[type="password"]:focus {
      border-color: #ff4b2b;
      outline: none;
      box-shadow: 0 0 5px rgba(255, 75, 43, 0.4);
    }
    input[type="submit"] {
      width: 100%;
      padding: 12px;
      background: #ff4b2b;
      color: white;
      border: none;
      font-weight: bold;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.2s ease;
    }
    input[type="submit"]:hover {
      background: #e63946;
      transform: scale(1.03);
    }
    .error {
      color: #c0392b;
      margin-bottom: 15px;
      font-weight: bold;
      background: #ffe5e5;
      padding: 8px;
      border-radius: 6px;
    }
    .back-button {
      display: block;
      text-align: center;
      margin-top: 15px;
      color: #333;
      font-weight: bold;
      text-decoration: none;
      padding: 10px;
      border: 2px solid #333;
      border-radius: 8px;
      transition: all 0.3s ease;
    }
    .back-button:hover {
      background: #ff4b2b;
      color: white;
      border-color: #ff4b2b;
    }
    .footer {
      margin-top: 20px;
      font-size: 12px;
      color: #555;
    }
  </style>
</head>
<body>

<div class="login-container">
  <h2>Admin Login</h2>

  <?php if ($error): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="post" action="authenticate.php">
    <label for="username">Username</label>
    <input type="text" id="username" name="username" placeholder="Enter your username" required>
    
    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Enter your password" required>
    
    <input type="submit" value="Login">
  </form>

  <a href="index.html" class="back-button">Back</a>

 <div class="footer">&copy; <?= date('Y') ?> Deanworks. All rights reserved.</div>
</div>

</body>
</html>
