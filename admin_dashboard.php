<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// ✅ Count unread messages
$file = "messages.json";
$messages = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
$unreadCount = 0;
foreach ($messages as $msg) {
    if (!isset($msg['read']) || $msg['read'] === false) {
        $unreadCount++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - Deanworks</title>
  <style>
    body {
      margin: 0;
      font-family: 'Open Sans', sans-serif;
      background: #fffef7;
    }
    header {
     background-color: #0ABAB5;
      padding: 10px 50px;  /* smaller vertical padding to compensate */
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      height: 100px; /* fix header height */
      overflow: visible; /* allow logo to overflow */
}
    .dean img {
      height: 170px; /* bigger than header height */
      width: auto;
      margin-top: -8; /* move it up so it overlaps */
      display: block;
      object-fit: contain;
}
    .logout-btn {
      background: #e62828ff;
      color: white;
      text-decoration: none;
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: bold;
    }
    .logout-btn:hover {
      background: #e63946;
    }
    .container {
      max-width: 1200px;
      margin: 30px auto;
      padding: 0 20px;
    }
    .container h1 {
      color: #333;
    }
    .container p {
      color: black;
      font-size: 16px;
      margin-bottom: 30px;
    }
    .dashboard {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }
    .card {
      background: white;
      padding: 20px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }
    .card h3 {
      color: #000;
      margin-bottom: 10px;
    }
    .card p {
      color: #555;
      font-size: 14px;
      margin-bottom: 15px;
    }
    .btn {
      display: inline-block;
      padding: 10px 15px;
      background: #0ABAB5;
      color: white;
      font-weight: bold;
      text-decoration: none;
      border-radius: 6px;
      transition: background 0.3s ease;
    }
    .btn:hover {
      background: #e63946;
    }
    footer {
      text-align: center;
      padding: 20px;
      background-color: #0ABAB5;
      color: #555;
      margin-top: 230px;
    }
  </style>
</head>
<body>
<header>
   <div class="dean">
    <img src="images/dw.png" alt="Deanworks Logo" />
  </div>
  <a class="logout-btn" href="logout.php">Logout</a>
</header>

<div class="container">
  <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
  <p>Here’s an overview of your store management options.</p>

  <div class="dashboard">
    <div class="card">
      <h3>Products</h3>
      <p>View, add, or edit the products available in your store.</p>
      <a href="admin_products.php" class="btn">Manage Products</a>
    </div>

    <div class="card">
      <h3>Settings</h3>
      <p>Update website settings, admin password, and preferences.</p>
      <a href="admin_settings.php" class="btn">Update Settings</a>
    </div>

    <div class="card">
  <h3>
  Messages<?= $unreadCount > 0 ? " ({$unreadCount} new)" : "" ?>
</h3>
  <p>View customer inquiries and respond to them.</p>
  <a href="admin_messages.php" class="btn">View Messages</a>
</div>

  </div>
</div>
<!-- Footer -->
  <footer>
    &copy; 2025 Deanworks. All rights reserved.
  </footer>
</body>
</html>
