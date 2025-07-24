<?php
session_start();

// ✅ Ensure product data is loaded
if (!isset($_SESSION['products']) || empty($_SESSION['products'])) {
    $_SESSION['products'] = [
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

$products = $_SESSION['products'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Deanworks - Products</title>
  <style>
    /* Reset and Base Styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: #fffdf5;
      color: #333;
      line-height: 1.6;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    a {
      text-decoration: none;
      color: #333;
    }

    ul {
      list-style: none;
    }

    /* Header */
    header {
  background-color: #0ABAB5;
  padding: 10px 50px;  /* smaller vertical padding to compensate */
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  height: 120px; /* fix header height */
  overflow: visible; /* allow logo to overflow */
}

.dean img {
  height: 170px; /* bigger than header height */
  width: auto;
  margin-top: -8; /* move it up so it overlaps */
  display: block;
  object-fit: contain;
}

    nav.nav-links ul {
      list-style: none;
      display: flex;
      gap: 25px;
      align-items: center;
      margin: 0;
      padding: 0;
    }

    nav.nav-links a {
      font-weight: 500;
      transition: color 0.3s ease, border-bottom 0.3s ease;
      padding-bottom: 3px;
      color: #000;
    }

    nav.nav-links a:hover,
    nav.nav-links a.active {
      color: #ff4b2b;
      border-bottom: 2px solid #ff4b2b;
    }

    /* Product Section */
    .product-section {
      padding: 40px 60px;
      flex: 1;
    }

    .product-section h2 {
      text-align: center;
      margin-bottom: 40px;
      margin-top: -40px;
    }

    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 30px;
    }

    .product-card {
      background-color: #fffbe3;
      border: 1px solid #eee0b7;
      border-radius: 12px;
      padding: 20px;
      text-align: center;
      transition: transform 0.3s ease;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .product-card:hover {
      transform: scale(1.03);
    }

    .product-card img {
      max-width: 100%;
      height: 200px;
      object-fit: contain;
      margin-bottom: 15px;
    }

    .product-card h3 {
      font-size: 20px;
      margin-bottom: 10px;
    }

    .product-card p {
      font-size: 18px;
      color: #e67e22;
      margin-bottom: 10px;
    }

    /* Category Grid */
    .category-section {
      padding: 40px 60px;
      background-color: #fffbe3;
    }

    .category-section h2 {
      text-align: center;
      margin-bottom: 30px;
    }

    .category-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
      gap: 20px;
    }

    .category-card {
      background-color: #fffbe3;
      border: 1px solid #eee0b7;
      border-radius: 10px;
      padding: 15px;
      text-align: center;
      box-shadow: 0 1px 4px rgba(0,0,0,0.08);
      transition: transform 0.3s ease;
      cursor: pointer;
    }

    .category-card:hover {
      transform: scale(1.05);
      box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .category-card img {
      width: 100%;
      height: 140px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 10px;
    }

    .category-card p {
      font-weight: bold;
      font-size: 14px;
      color: #333;
    }

    /* Footer */
    footer {
      text-align: center;
      padding: 20px;
      background-color: #0ABAB5;
      color: #555;
      margin-top: auto;
    }

    @media (max-width: 600px) {
      .product-section,
      .category-section {
        padding: 20px;
      }

      header.header {
        flex-direction: column;
        align-items: flex-start;
      }

      nav.nav-links ul {
        flex-direction: column;
        gap: 10px;
        margin-top: 10px;
      }
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header class="header">
    <div class="dean">
      <img src="images/dw.png" alt="Deanworks company logo" />
    </div>
    <nav class="nav-links">
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="products.php" class="active">Products</a></li>
        <li><a href="contact.php">Contact Us</a></li>
        <li><a href="login.php">Login</a></li>
      </ul>
    </nav>
  </header>

  <!-- Product Cards -->
  <main>
    <section class="product-section">
      <section class="category-section">
        <h2>Recent Projects</h2>
        <div class="category-grid">
          <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
              <div class="category-card">
                <img src="<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                <p><?= htmlspecialchars($product['name']) ?></p>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p>No products available.</p>
          <?php endif; ?>
        </div>
      </section>
    </section>
  </main>

  <!-- Footer -->
  <footer>
    &copy; 2025 Deanworks. All rights reserved.
  </footer>

</body>
</html>





<!-- --
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Deanworks - Products</title>
  
</head>
<body>

  
  <header class="header">
    <div class="dean">
      <img src="images/dw.png" alt="Deanworks company logo" />
    </div>
    <nav class="nav-links">
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="products.html" class="active">Products</a></li>
        <li><a href="contact.php">Contact Us</a></li>
        <li><a href="login.php">Login</a></li>
      </ul>
    </nav>
  </header>

Product Cards 
  <main>
    <section class="product-section">
      <section class="category-section">
        <h2>Recent Projects</h2>
        <div class="category-grid">
          <div class="category-card">
            <img src="images/ecobag.png" alt="Ecobag">
            <p>Ecobag</p>
          </div>
          <div class="category-card">
            <img src="images/cap.png" alt="Cap">
            <p>Cap</p>
          </div>
          <div class="category-card">
            <img src="images/pen.png" alt="Pen">
            <p>Pen</p>
          </div>
          <div class="category-card">
            <img src="images/usb.png" alt="USB Port">
            <p>USB Port</p>
          </div>
          <div class="category-card">
            <img src="images/tumbler.png" alt="Tumbler">
            <p>Tumbler</p>
          </div>
          <div class="category-card">
            <img src="images/mugs.png" alt="Mugs">
            <p>Mugs</p>
          </div>
          <div class="category-card">
            <img src="images/packaging.png" alt="Packaging Design">
            <p>Packaging Design</p>
          </div>
          <div class="category-card">
            <img src="images/fan.png" alt="Foldable Fan">
            <p>Foldable Fan</p>
          </div>
          <div class="category-card">
            <img src="images/umbrella.png" alt="Umbrella">
            <p>Umbrella</p>
          </div>
          <div class="category-card">
            <img src="images/sackbag.png" alt="Jute Sack Bags">
            <p>Jute Sack Bags</p>
          </div>
          <div class="category-card">
            <img src="images/booth.png" alt="Collapsible Booth">
            <p>Booth</p>
          </div>
          <div class="category-card">
            <img src="images/cardholder.png" alt="Card Holder">
            <p>Card Holder</p>
          </div>
          <div class="category-card">
            <img src="images/shelf.png" alt="Shelf Talker">
            <p>Shelf Talker</p>
          </div>
          <div class="category-card">
            <img src="images/canvass.png" alt="Canvass">
            <p>Canvass</p>
          </div>
          <div class="category-card">
            <img src="images/gadget.png" alt="Gadget Organizer">
            <p>Gadget Organizer</p>
          </div>
          <div class="category-card">
            <img src="images/pouches.png" alt="Plastic Pouches">
            <p>Plastic Pouches</p>
          </div>
          <div class="category-card">
            <img src="images/sublimation.png" alt="Sublimation">
            <p>Sublimation</p>
          </div>
          <div class="category-card">
            <img src="images/polo.png" alt="Polo Shirt Embroid">
            <p>Polo Shirt Embroid</p>
          </div>
          <div class="category-card">
            <img src="images/jacket.png" alt="Jacket">
            <p>Jacket</p>
          </div>
          <div class="category-card">
            <img src="images/tshirt.png" alt="T-Shirt">
            <p>T-Shirt</p>
          </div>
        </div>
      </section>
    </section>
  </main>


  <footer>
    &copy; 2025 Deanworks. All rights reserved.
  </footer>

</body>
</html>
-->