<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Settings | Deanworks Admin</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #fffce8;
      padding: 30px;
    }
    h1 {
      color: #000000ff;
    }
    form {
      background: #ffc7df;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
      transition: all 0.3s ease-in-out;
    }
    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }
    input[type="text"],
    input[type="password"],
    select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    button {
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #3e45c8ff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background-color: #b00000ff;
    }
  </style>
</head>
<body>

  <h1>Settings</h1>

  <form action="update_settings.php" method="POST">
    <label for="site_title">Site Title</label>
    <input type="text" id="site_title" name="site_title" value="Deanworks" required>

    <label for="theme">Theme</label>
    <select id="theme" name="theme">
      <option value="light" selected>Light</option>
      <option value="dark">Dark</option>
    </select>

    <label for="admin_password">Change Admin Password</label>
    <input type="password" id="admin_password" name="admin_password" placeholder="New password">

    <button type="submit">Save Settings</button>
  </form>

</body>
</html>
