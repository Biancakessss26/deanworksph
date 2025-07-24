<?php
session_start();

// ✅ Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// ✅ Function to load default products
function loadDefaultProducts() {
    return [
        ['name' => 'Ecobag', 'img' => 'images/ecobag.png'],
        ['name' => 'Cap', 'img' => 'images/cap.png'],
        ['name' => 'Pen', 'img' => 'images/pen.png'],
        ['name' => 'USB Port', 'img' => 'images/usb.png'],
        ['name' => 'Tumbler', 'img' => 'images/tumbler.png'],
        ['name' => 'Mugs', 'img' => 'images/mugs.png'],
        ['name' => 'Packaging Design', 'img' => 'images/packaging.png'],
        ['name' => 'Foldable Fan', 'img' => 'images/fan.png'],
        ['name' => 'Umbrella', 'img' => 'images/umbrella.png'],
        ['name' => 'Jute Sack Bags', 'img' => 'images/sackbag.png'], 
        ['name' => 'Booth', 'img' => 'images/booth.png'],
        ['name' => 'Card Holder', 'img' => 'images/cardholder.png'],
        ['name' => 'Shelf Talker', 'img' => 'images/shelf.png'],
        ['name' => 'Canvass', 'img' => 'images/canvass.png'],
        ['name' => 'Gadget Organizer', 'img' => 'images/gadget.png'],
        ['name' => 'Plastic Pouches', 'img' => 'images/pouches.png'],
        ['name' => 'Sublimation', 'img' => 'images/sublimation.png'],
        ['name' => 'Polo Shirt Embroid', 'img' => 'images/polo.png'],
        ['name' => 'Jacket', 'img' => 'images/jacket.png'],
        ['name' => 'T-Shirt', 'img' => 'images/tshirt.png']
    ];
}

// ✅ Initialize products if empty
if (!isset($_SESSION['products']) || empty($_SESSION['products'])) {
    $_SESSION['products'] = loadDefaultProducts();
}

// ✅ Flash message (get & clear)
$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

// ✅ Handle Delete Action
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (isset($_SESSION['products'][$id])) {
        unset($_SESSION['products'][$id]);
        $_SESSION['products'] = array_values($_SESSION['products']); // Reindex
        $_SESSION['flash'] = "🗑 Product deleted successfully!";
        header("Location: admin_products.php");
        exit();
    }
}

// ✅ Handle Reset Action
if (isset($_GET['reset'])) {
    $_SESSION['products'] = loadDefaultProducts();
    $_SESSION['flash'] = "🔄 Products reset to default!";
    header("Location: admin_products.php");
    exit();
}

$totalProducts = count($_SESSION['products']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Products - Deanworks Admin</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #fffbe3;
      margin: 0;
    }

    /* ✅ Dashboard-Style Header */
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
    .container {
      padding: 20px 40px
      ;
    }

    h1 {
      color: #2a2a2aff;
      text-align: center;
      margin-bottom: 20px;
    }
    .flash {
      background: #d4edda;
      color: #155724;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 15px;
      border: 1px solid #c3e6cb;
    }

    .buttons {
      display: flex;
      gap: 10px;
      margin-bottom: 15px;
      flex-wrap: wrap;
    }

    .btn {
      display: inline-block;
      padding: 10px 15px;
      color: black;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
    }

    .back-btn {
      background-color: #ffffffff;
    }
    .back-btn:hover {
      background-color: #e12e2eff;
    }

    .add-new {
      background-color: #ffffffff;
    }
    .add-new:hover {
      background-color: #e12e2eff;
    }

    .product-count {
      font-weight: bold;
      margin-top: 10px;
      color: #333;
    }

    .search-box {
      margin-top: 10px;
    }
    .search-box input {
      width: 250px;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
      gap: 20px;
      margin-top: 30px;
    }

    .product-card {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      text-align: center;
      padding: 10px;
    }

    .product-card img {
      width: 100%;
      height: 130px;
      object-fit: cover;
      border-radius: 6px;
    }

    .product-name {
      font-weight: bold;
      margin: 10px 0 5px;
      color: #333;
    }

    .action-buttons {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-top: 10px;
    }

    .action-buttons a {
      text-decoration: none;
      padding: 6px 10px;
      font-size: 0.8rem;
      border-radius: 4px;
      color: white;
    }

    .edit-btn {
      background-color: #256997ff;
    }
    .delete-btn {
      background-color: #c0392b;
    }
  </style>
</head>
<body>

<!-- ✅ Dashboard-Style Header -->
<header>
  <div class="dean">
    <img src="images/dw.png" alt="Deanworks Logo">
  </div>
</header>

<div class="container">
  <h1>Manage Products</h1>

  <?php if ($flash): ?>
    <div class="flash"><?= $flash ?></div>
  <?php endif; ?>

  <div class="buttons">
    <a href="admin_dashboard.php" class="btn back-btn"> Back</a>
    <a href="add_product.php" class="btn add-new">Add New Product</a>
    </div>

  <div class="product-count">Total Products: <?= $totalProducts ?></div>

  <div class="search-box">
    <input type="text" id="searchInput" placeholder="🔍 Search products..." onkeyup="filterProducts()">
  </div>

  <div class="product-grid" id="productGrid">
    <?php if (!empty($_SESSION['products'])): ?>
      <?php foreach ($_SESSION['products'] as $index => $product): ?>
        <div class="product-card">
          <img src="<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
          <div class="product-name"><?= htmlspecialchars($product['name']) ?></div>
          <div class="action-buttons">
            <a href="edit_product.php?id=<?= $index ?>" class="edit-btn">Edit</a>
            <a href="admin_products.php?delete=<?= $index ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No products available.</p>
    <?php endif; ?>
  </div>
</div>

<script>
  function filterProducts() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const cards = document.querySelectorAll('.product-card');
    let visibleCount = 0;

    cards.forEach(card => {
      const name = card.querySelector('.product-name').textContent.toLowerCase();
      if (name.includes(input)) {
        card.style.display = "block";
        visibleCount++;
      } else {
        card.style.display = "none";
      }
    });

    document.querySelector('.product-count').textContent = "Total Products: " + visibleCount;
  }
</script>

</body>
</html>
