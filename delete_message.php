<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = trim($_POST['email']);
    $file = __DIR__ . "/messages.json";

    if (!file_exists($file)) {
        echo "❌ File not found.";
        exit;
    }

    $messages = json_decode(file_get_contents($file), true);
    if (!is_array($messages)) {
        echo "❌ Invalid JSON.";
        exit;
    }

    $originalCount = count($messages);
    $messages = array_filter($messages, fn($msg) => $msg['email'] !== $email);

    if (count($messages) < $originalCount) {
        if (file_put_contents($file, json_encode(array_values($messages), JSON_PRETTY_PRINT))) {
            echo "✅ Deleted";
        } else {
            echo "❌ Failed to update file.";
        }
    } else {
        echo "⚠️ No message found with that email.";
    }
} else {
    echo "❌ Invalid request.";
}
?>
