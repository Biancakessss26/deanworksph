<?php
session_start();

// ✅ Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// ✅ Initialize products array if not set
if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = [];
}

// ✅ Flash message (get & clear) now used for modal
$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

// ✅ Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $img = htmlspecialchars(trim($_POST['img']));

    if (!empty($name) && !empty($img)) {
        $_SESSION['products'][] = [
            'name' => $name,
            'img' => $img
        ];
        $_SESSION['flash'] = "success";
    } else {
        $_SESSION['flash'] = "error";
    }

    header("Location: add_product.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Product</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { 
      font-family: 'Segoe UI', sans-serif; 
      background: linear-gradient(135deg, #f9f9f9, #ffc7df);
      margin: 0;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
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
    .container:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 24px rgba(0,0,0,0.15);
    }
    h1 {
      margin-bottom: 20px;
      color: #333;
      font-size: 22px;
      letter-spacing: 0.5px;
    }
    form { text-align: left; }
    label { 
      font-weight: bold; 
      display: block; 
      margin-bottom: 5px; 
      color: #444;
      font-size: 14px;
    }
    input[type="text"] { 
      width: 100%; 
      padding: 10px; 
      margin-bottom: 15px; 
      border: 1px solid #ccc; 
      border-radius: 6px; 
      font-size: 14px;
      transition: border 0.2s ease-in-out;
    }
    input[type="text"]:focus {
      border-color: #000000ff;
      outline: none;
      box-shadow: 0 0 5px rgba(216,154,0,0.4);
    }
    .button-group {
      display: flex;
      gap: 10px;
      margin-top: 10px;
    }
    input[type="submit"],
    .back-btn { 
      flex: 1;
      background: #eeeeeeff; 
      color: black; 
      padding: 10px; 
      border: none; 
      border-radius: 6px; 
      cursor: pointer; 
      font-size: 15px;
      font-weight: bold;
      text-align: center;
      text-decoration: none;
      transition: background 0.3s ease-in-out;
    }
    input[type="submit"]:hover { background: #e54d4dff; }
    .back-btn { background: #eeeeeeff; }
    .back-btn:hover { background: #e54d4dff; }
    .preview-box {
      display: none;
      justify-content: center;
      align-items: center;
      border: 1px dashed #ccc;
      border-radius: 6px;
      background: #fff;
      margin-top: 10px;
      padding: 5px;
      height: 160px;
      text-align: center;
    }
    img.preview { 
      max-width: 100%; 
      max-height: 150px; 
      border-radius: 6px; 
      transition: all 0.3s ease-in-out;
    }
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
      z-index: 9999;
    }
    .modal-content {
      background: white;
      padding: 20px 30px;
      border-radius: 10px;
      text-align: center;
      width: 280px;
      animation: fadeIn 0.3s ease-in-out;
    }
    .modal-content i {
      font-size: 40px;
      margin-bottom: 10px;
    }
    .success i { color: #28a745; }
    .error i { color: #dc3545; }
    .modal-content h3 {
      margin: 0 0 10px;
      font-size: 18px;
      color: #333;
    }
    .close-btn {
      margin-top: 10px;
      background: #e54d4dff;
      color: white;
      padding: 8px 15px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
      transition: background 0.3s ease-in-out;
    }
    .close-btn:hover { background: #5a6268; }
    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.9); }
      to { opacity: 1; transform: scale(1); }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Add New Product</h1>
    <form method="post">
      <label>Product Name:</label>
      <input type="text" name="name" placeholder="Enter product name" required>
      <label>Image Path (e.g., images/product.png):</label>
      <input type="text" name="img" id="imgPath" placeholder="Enter image URL" required oninput="previewImage()">
      <div class="preview-box" id="previewBox">
        <img id="imgPreview" class="preview" src="" alt="Image Preview">
      </div>
      <div class="button-group">
        <input type="submit" value="Add Product">
        <a href="admin_products.php" class="back-btn"> Back</a>
      </div>
    </form>
  </div>

  <!-- ✅ Modal -->
  <div class="modal" id="statusModal">
    <div class="modal-content" id="modalContent">
      <i class="fas"></i>
      <h3 id="modalMessage"></h3>
      <button class="close-btn" onclick="redirectNow()">Close</button>
    </div>
  </div>

  <script>
    function previewImage() {
      const imgPath = document.getElementById('imgPath').value;
      const imgPreview = document.getElementById('imgPreview');
      const previewBox = document.getElementById('previewBox');
      if (imgPath.trim() !== '') {
        imgPreview.src = imgPath;
        previewBox.style.display = 'flex';
      } else {
        previewBox.style.display = 'none';
      }
    }

    function showModal(type, message) {
      const modal = document.getElementById('statusModal');
      const modalContent = document.getElementById('modalContent');
      const modalMessage = document.getElementById('modalMessage');
      const modalIcon = modalContent.querySelector('i');
      modalMessage.textContent = message;
      modalContent.className = "modal-content " + type;
      modalIcon.className = "fas " + (type === "success" ? "fa-check-circle" : "fa-times-circle");
      modal.style.display = "flex";
    }

    function redirectNow() {
      window.location.href = "admin_products.php";
    }

    <?php if ($flash === "success"): ?>
      showModal("success", "Product added successfully!");
      setTimeout(redirectNow, 2000); // ✅ Auto redirect after 2 seconds
    <?php elseif ($flash === "error"): ?>
      showModal("error", "Failed to add product. Please try again.");
    <?php endif; ?>
  </script>
</body>
</html>
