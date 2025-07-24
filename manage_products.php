<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// ✅ Initialize products if not yet set
if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = [
        ['name' => 'Ecobag', 'img' => 'images/ecobag.png'],
        ['name' => 'Cap', 'img' => 'images/cap.png'],
        ['name' => 'Pen', 'img' => 'images/pen.png'],
        ['name' => 'USB Port', 'img' => 'images/usb.png']
        // ... you can keep adding your default list
    ];
}

$products = $_SESSION['products'];
?>
