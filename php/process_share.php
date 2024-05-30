<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.html");
    exit();
}

include 'db.php';

$fileId = $_POST['file_id'];
$toUserId = $_POST['user_id'];
$fromUserId = $_SESSION['user_id'];

// Ensure the user has permission to share this file
$fileResult = $conn->query("SELECT filename FROM uploads WHERE id = $fileId AND user_id = $fromUserId");
$file = $fileResult->fetch_assoc();

if (!$file) {
    echo "File not found or you don't have permission to share this file.";
    exit();
}

// Insert a record in the shared_files table
$stmt = $conn->prepare("INSERT INTO shared_files (file_id, from_user_id, to_user_id) VALUES (?, ?, ?)");
$stmt->bind_param("iii", $fileId, $fromUserId, $toUserId);

if ($stmt->execute()) {
    header("Location: ../content_sharing.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
