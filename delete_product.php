<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;
if ($id !== null && isset($_SESSION['products'][$id])) {
    unset($_SESSION['products'][$id]);
    $_SESSION['products'] = array_values($_SESSION['products']); // reindex array
}
header("Location: manage_products.php");
exit();
