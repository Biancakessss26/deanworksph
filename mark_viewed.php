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

    $updated = false;
    foreach ($messages as &$msg) {
        if ($msg['email'] === $email && (!isset($msg['read']) || $msg['read'] === false)) {
            $msg['read'] = true;
            $updated = true;
        }
    }

    if ($updated) {
        if (file_put_contents($file, json_encode($messages, JSON_PRETTY_PRINT))) {
            echo "✅ Marked as viewed";
        } else {
            echo "❌ Failed to update file.";
        }
    } else {
        echo "⚠️ No matching unread message.";
    }
} else {
    echo "❌ Invalid request.";
}
?>
