<?php if (isset($_GET['success']) || isset($_GET['error'])): ?>
  <div id="notif" class="floating-notif <?= isset($_GET['success']) ? 'success' : 'error' ?>">
    <?= isset($_GET['success']) ? '✅ Message sent successfully!' : '❌ ' . htmlspecialchars($_GET['error']) ?>
  </div>
<?php endif; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Deanworks - Contact Us</title>
  <style>
    * {
      .floating-notif {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  padding: 16px 24px;
  border-radius: 8px;
  font-size: 16px;
  font-weight: bold;
  text-align: center;
  z-index: 9999;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
  animation: fadeOut 3s forwards;
}
.floating-notif.success {
  background-color: #d4edda;
  color: #155724;
}
.floating-notif.error {
  background-color: #f8d7da;
  color: #721c24;
}
@keyframes fadeOut {
  0% { opacity: 1; }
  80% { opacity: 1; }
  100% { opacity: 0; display: none; }
}

      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    body {
      background-color: #fffdf5;
      color: #333;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    header {
      background-color: #0ABAB5;
      padding: 10px 50px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      height: 120px;
      overflow: visible;
    }
    .dean img {
      height: 170px;
      width: auto;
      margin-top: -8px;
      display: block;
      object-fit: contain;
    }
    nav ul {
      display: flex;
      gap: 25px;
      list-style: none;
    }
    nav a {
      text-decoration: none;
      color: #333;
      font-weight: 500;
      transition: color 0.3s ease, border-bottom 0.3s ease;
      padding-bottom: 3px;
    }
    nav a:hover,
    nav a.active {
      color: #ff4b2b;
      border-bottom: 2px solid #ff4b2b;
    }
    main {
      flex: 1;
      padding: 40px 60px;
      max-width: 900px;
      margin: auto;
    }
    h1 {
      text-align: center;
      color: #000000;
      margin-bottom: 40px;
      font-size: 2rem;
    }
    .contact-container {
      display: flex;
      flex-wrap: wrap;
      gap: 40px;
      justify-content: space-between;
    }
    .contact-form,
    .contact-info {
      flex: 1 1 400px;
    }
    .contact-form form {
      display: flex;
      flex-direction: column;
    }
    .contact-form label {
      margin-top: 15px;
      font-weight: bold;
    }
    .contact-form input,
    .contact-form textarea {
      margin-top: 5px;
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 14px;
    }
    .contact-form button {
      margin-top: 20px;
      padding: 12px;
      background-color: #ff4b2b;
      color: white;
      border: none;
      border-radius: 25px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }
    .contact-form button:hover {
      background-color: #e63946;
      transform: scale(1.05);
    }
    .contact-info h2 {
      color: #010101ff;
      margin-bottom: 20px;
    }
    .contact-info p {
      margin-bottom: 10px;
      line-height: 1.6;
    }
    footer {
      text-align: center;
      padding: 20px;
      background-color: #0ABAB5;
      color: #555;
      margin-top: 40px;
    }
    @media (max-width: 768px) {
      .contact-container {
        flex-direction: column;
      }
      main {
        padding: 20px;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="dean">
      <img src="images/dw.png" alt="Deanworks Logo" />
    </div>
    <nav>
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="products.php">Products</a></li>
        <li><a href="contact.php" class="active">Contact Us</a></li>
        <a href="login.php">Login</a>
      </ul>
    </nav>
  </header>
  <main>
    <h1>Contact Us</h1>
    <div class="contact-container">
      <div class="contact-form">
        <form action="contact_submit.php" method="POST">
          <label for="name">Your Name</label>
          <input type="text" id="name" name="name" required>
          <label for="email">Your Email</label>
          <input type="email" id="email" name="email" required>
          <label for="message">Message</label>
          <textarea id="message" name="message" rows="6" required></textarea>
          <button type="submit">Send Message</button>
        </form>
      </div>
      <div class="contact-info">
        <h2>Get in touch!</h2>
        <p><strong>Address:</strong> Mandaluyong City, Philippines</p>
        <p><strong>Email:</strong> deanworksph@gmail.com</p>
        <p><strong>Phone:</strong> 0936-188-6373</p>
        <p>We’re happy to answer your questions and hear your feedback.</p>
        <div style="margin-top: 20px;">
          <h3>Follow Us</h3>
          <div style="margin-top: 30px;">
            <a href="https://web.facebook.com/rmarketingservicesph" target="_blank" style="margin-right: 15px;">
              <img src="https://cdn-icons-png.flaticon.com/512/145/145802.png" alt="Facebook" width="32" height="32" />
            </a>
            <a href="https://www.instagram.com/deanworksph?igsh=MmxldjdzcnF0NWho" target="_blank">
              <img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" alt="Instagram" width="32" height="32" />
            </a>
          </div>
        </div>
      </div>
    </div>
  </main>
  <footer>
    &copy; 2025 Deanworks. All rights reserved.
  </footer>
  <script>
    setTimeout(() => {
      const notif = document.getElementById('notif');
      if (notif) notif.style.display = 'none';
    }, 3000);
  </script>
</body>
</html>
