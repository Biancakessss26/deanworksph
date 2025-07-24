<?php
session_start();

// ✅ Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// ✅ Validate Product ID
$id = $_GET['id'] ?? null;
if ($id === null || !is_numeric($id) || !isset($_SESSION['products'][$id])) {
    header("Location: manage_products.php");
    exit();
}

$product = $_SESSION['products'][$id];

// ✅ Flash message
$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

// ✅ Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['products'][$id]['name'] = htmlspecialchars(trim($_POST['name']));
    $_SESSION['products'][$id]['img'] = htmlspecialchars(trim($_POST['img']));
    $_SESSION['flash'] = "updated";
    header("Location: edit_product.php?id=" . $id);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Product - Deanworks Admin</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background-color: #fff8dc;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .container {
      background: #0ABAB5;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
      text-align: center;
      transition: all 0.3s ease-in-out;
    }
    h1 {
      font-size: 22px;
      color: #000000ff;
      text-align: center;
      margin-bottom: 20px;
    }
    label {
      font-weight: bold;
      color: #333;
      display: block;
      margin-bottom: 5px;
    }
    input[type="text"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
    }
    input[type="text"]:focus {
      border-color: #ffffffff;
      outline: none;
      box-shadow: 0 0 5px rgba(204,153,0,0.4);
    }
    .preview-box {
      text-align: center;
      border: 1px dashed #ccc;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 6px;
      background: #fffef0;
    }
    .preview-box img {
      max-height: 150px;
      max-width: 100%;
      border-radius: 6px;
    }
    .button-group {
      display: flex;
      justify-content: space-between;
      gap: 10px;
    }
    input[type="submit"], .back-btn {
      flex: 1;
      padding: 10px;
      border: none;
      border-radius: 6px;
      font-size: 15px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s ease-in-out;
    }
    input[type="submit"] {
      background: #6c757d;
      color: white;
    }
    input[type="submit"]:hover {
      background:  #555;
    }
    .back-btn {
      text-align: center;
      background: #6c757d;
      color: white;
      text-decoration: none;
    }
    .back-btn:hover {
      background: #555;
    }
    /* ✅ Modal */
    .modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 999;
    }
    .modal-content {
      background: white;
      padding: 20px 30px;
      border-radius: 8px;
      text-align: center;
      width: 280px;
      animation: fadeIn 0.3s ease-in-out;
    }
    .modal-content i {
      font-size: 40px;
      margin-bottom: 10px;
    }
    .success i { color: #28a745; }
    .modal-content h3 {
      margin-bottom: 10px;
      color: #333;
    }
    .close-btn {
      background: #cc9900;
      color: white;
      padding: 8px 15px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    .close-btn:hover {
      background: #b27600;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.9); }
      to { opacity: 1; transform: scale(1); }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Edit Product</h1>
    <form method="post">
      <label>Product Name:</label>
      <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

      <label>Image Path:</label>
      <input type="text" name="img" id="imgPath" value="<?= htmlspecialchars($product['img']) ?>" required oninput="previewImage()">

      <div class="preview-box" id="previewBox">
        <img id="imgPreview" src="<?= htmlspecialchars($product['img']) ?>" alt="Image Preview">
      </div>

      <div class="button-group">
        <input type="submit" value="Save Changes">
        <a href="admin_products.php" class="back-btn">Back</a>
      </div>
    </form>
  </div>

  <!-- ✅ Modal -->
  <div class="modal" id="statusModal">
    <div class="modal-content success" id="modalContent">
      <i class="fas fa-check-circle"></i>
      <h3 id="modalMessage">Product updated successfully!</h3>
      <button class="close-btn" onclick="redirectNow()">Close</button>
    </div>
  </div>

  <script>
    function previewImage() {
      const imgPath = document.getElementById('imgPath').value;
      const previewBox = document.getElementById('previewBox');
      const imgPreview = document.getElementById('imgPreview');
      if (imgPath.trim() !== '') {
        imgPreview.src = imgPath;
        previewBox.style.display = 'block';
      } else {
        previewBox.style.display = 'none';
      }
    }
    function showModal(message) {
      document.getElementById('modalMessage').textContent = message;
      document.getElementById('statusModal').style.display = "flex";
    }
    function redirectNow() {
      window.location.href = "admin_products.php";
    }
    <?php if ($flash === "updated"): ?>
      showModal("Product updated successfully!");
      setTimeout(redirectNow, 2000); // ✅ Auto redirect after 2s
    <?php endif; ?>
  </script>
</body>
</html>
