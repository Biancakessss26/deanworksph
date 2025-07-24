<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

$file = __DIR__ . "/messages.json";
$messages = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
$messages = is_array($messages) ? array_reverse($messages) : [];

// Pagination
$perPage = 10;
$totalMessages = count($messages);
$totalPages = max(1, ceil($totalMessages / $perPage));
$page = isset($_GET['page']) ? max(1, min((int)$_GET['page'], $totalPages)) : 1;
$start = ($page - 1) * $perPage;
$pagedMessages = array_slice($messages, $start, $perPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Customer Messages - Deanworks</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f7f7f7; padding: 40px; color:#333; }
    h1 { color: #444; font-size: 24px; margin-bottom: 20px; }
    .top-bar { display:flex; flex-wrap: wrap; justify-content:space-between; align-items:center; gap: 10px; margin-bottom:10px; }
    .back-btn { background:#6c757d; color:white; padding:8px 14px; border-radius:5px; text-decoration:none; }
    .back-btn:hover { background:#495057; }
    .filter-btn { background:#ff9800; color:white; padding:8px 14px; border:none; border-radius:5px; cursor:pointer; }
    .filter-btn:hover { background:#e68900; }
    .search-box { padding:10px 15px; border:1px solid #ccc; border-radius:8px; width:240px; font-size:14px; }
    table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 4px 8px rgba(0,0,0,0.1); margin-top:10px; border-radius:8px; overflow:hidden; }
    th, td { padding: 12px 10px; border-bottom: 1px solid #eee; text-align: left; }
    th { background: #0ABAB5; color: white; font-size: 15px; }
    tr.unread { background: #fff9c4; font-weight: bold; }
    tr:hover { background: #f1faff; }
    .pagination { margin-top: 15px; text-align: center; }
    .pagination a { display: inline-block; padding: 8px 14px; margin: 0 3px; background: #ffc7df; color: #333; text-decoration: none; border-radius: 5px; font-weight: bold; }
    .pagination a.active { background: #ff4b2b; color: white; }
    .view-btn, .delete-btn { padding: 6px 12px; font-size: 13px; border-radius: 5px; text-decoration: none; border: none; cursor: pointer; }
    .view-btn { background: #007bff; color: white; }
    .view-btn:hover { background: #0056b3; }
    .delete-btn { background: #dc3545; color: white; margin-left:4px; }
    .delete-btn:hover { background: #a71d2a; }
    .status span { padding:6px 10px; border-radius:12px; font-size:12px; font-weight:bold; }
    .status .viewed { background:#28a745; color:white; }
    .status .new { background:#ff9800; color:white; }
    .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; }
    .modal-content { background: white; padding: 20px; border-radius: 8px; max-width: 500px; width: 90%; max-height: 80vh; overflow-y: auto; box-shadow: 0 4px 10px rgba(0,0,0,0.2); }
    .close { float: right; font-size: 20px; cursor: pointer; color: red; }
    .modal-buttons { text-align: right; margin-top: 20px; }
  </style>
</head>
<body>
<h1>Customer Messages</h1>

<div class="top-bar">
    <a href="admin_dashboard.php" class="back-btn">Back</a>
    <input type="text" id="searchBox" class="search-box" placeholder="Search name or email...">
    <button class="filter-btn" id="filterUnread">Show Only Unread</button>
</div>

<?php if (empty($pagedMessages)): ?>
    <p>No messages yet.</p>
<?php else: ?>
<table id="messagesTable">
<thead>
<tr>
  <th style="width: 20%;">Name</th>
  <th style="width: 25%;">Email</th>
  <th style="width: 15%;">Date</th>
  <th style="width: 15%;">Status</th>
  <th style="width: 25%;">Action</th>
</tr>
</thead>

<tbody>
<?php foreach ($pagedMessages as $index => $msg): ?>
<tr class="<?= (!isset($msg['read']) || $msg['read'] === false) ? 'unread' : '' ?>">
  <td><?= htmlspecialchars($msg['name']) ?></td>
  <td><?= htmlspecialchars($msg['email']) ?></td>
  <td><?= date("M d, Y h:i A", strtotime($msg['date'])) ?></td>
  <td class="status">
    <?= isset($msg['read']) && $msg['read'] === true 
        ? '<span class="viewed">Viewed</span>' 
        : '<span class="new">New</span>' ?>
  </td>
  <td>
    <button class="view-btn" 
       data-name="<?= htmlspecialchars($msg['name']) ?>" 
       data-email="<?= htmlspecialchars($msg['email']) ?>" 
       data-message="<?= htmlspecialchars($msg['message']) ?>" 
       data-id="<?= $start + $index ?>">View</button>
    <button class="delete-btn" onclick="openDeleteModal('<?= htmlspecialchars($msg['email']) ?>')">Delete</button>
  </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<div class="pagination">
<?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href="?page=<?= $i ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
<?php endfor; ?>
</div>
<?php endif; ?>

<!-- View Message Modal -->
<div class="modal" id="messageModal">
  <div class="modal-content">
    <span class="close" id="closeModal">&times;</span>
    <h3 id="modalName"></h3>
    <p><strong>Email:</strong> <span id="modalEmail"></span></p>
    <p><strong>Message:</strong></p>
    <p id="modalMessage" style="white-space: pre-wrap; word-break: break-word;"></p>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal" id="deleteConfirmModal">
  <div class="modal-content">
    <span class="close" onclick="closeDeleteModal()">&times;</span>
    <h3>Are you sure?</h3>
    <p>This will permanently delete the message. Proceed?</p>
    <div class="modal-buttons">
      <button onclick="confirmDelete()" class="delete-btn">Yes, Delete</button>
    </div>
  </div>
</div>

<script>
let showUnreadOnly = false;
let emailToDelete = "";

document.getElementById("filterUnread").addEventListener("click", () => {
  showUnreadOnly = !showUnreadOnly;
  document.getElementById("filterUnread").innerText = showUnreadOnly ? "Show All" : "Show Only Unread";
  filterMessages();
});

document.getElementById("searchBox").addEventListener("input", filterMessages);

function filterMessages() {
  const search = document.getElementById("searchBox").value.toLowerCase();
  document.querySelectorAll("#messagesTable tbody tr").forEach(row => {
    const name = row.querySelector("td:nth-child(1)").innerText.toLowerCase();
    const email = row.querySelector("td:nth-child(2)").innerText.toLowerCase();
    const unreadCheck = showUnreadOnly ? row.classList.contains("unread") : true;
    row.style.display = ((name.includes(search) || email.includes(search)) && unreadCheck) ? "" : "none";
  });
}

document.querySelectorAll(".view-btn").forEach(button => {
  button.addEventListener("click", async function (e) {
    e.preventDefault();

    const name = this.getAttribute("data-name");
    const email = this.getAttribute("data-email");
    const message = this.getAttribute("data-message");

    if (!name || !email || !message) {
      alert("Missing message data.");
      return;
    }

    document.getElementById("modalName").innerText = name;
    document.getElementById("modalEmail").innerText = email;
    document.getElementById("modalMessage").innerHTML = decodeHTMLEntities(message);
    document.getElementById("messageModal").style.display = "flex";

    const res = await fetch("mark_viewed.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "email=" + encodeURIComponent(email)
    });

    if ((await res.text()).includes("✅")) {
      this.closest("tr").querySelector(".status").innerHTML =
        '<span class="viewed">Viewed</span>';
      this.closest("tr").classList.remove("unread");
    }
  });
});


document.getElementById("closeModal").onclick = () => {
  document.getElementById("messageModal").style.display = "none";
};

// === DELETE MODAL LOGIC ===
function openDeleteModal(email) {
  emailToDelete = email;
  document.getElementById("deleteConfirmModal").style.display = "flex";
}

function closeDeleteModal() {
  emailToDelete = "";
  document.getElementById("deleteConfirmModal").style.display = "none";
}

async function confirmDelete() {
  if (!emailToDelete) return;
  const res = await fetch("delete_message.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "email=" + encodeURIComponent(emailToDelete)
  });
  if ((await res.text()).includes("✅")) {
    document.querySelectorAll(`[onclick*="${emailToDelete}"]`).forEach(btn => {
      btn.closest("tr").remove();
    });
    showNotification("✅ Message deleted!", "red");
  }
  closeDeleteModal();
}

function decodeHTMLEntities(text) {
  const textarea = document.createElement('textarea');
  textarea.innerHTML = text;
  return textarea.value;
}

function showNotification(message, color = "green") {
  let notif = document.createElement("div");
  notif.innerText = message;
  notif.style.cssText = `background:${color};color:white;padding:10px;text-align:center;
    border-radius:4px;margin-bottom:10px;font-weight:bold;`;
  document.body.insertBefore(notif, document.body.firstChild);
  setTimeout(() => notif.remove(), 3000);
}
</script>
</body>
</html>
