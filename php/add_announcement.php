<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: /assesment3/admin_login.html");
    exit();
}

include __DIR__ . '/db.php'; // Correct path to db.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $announcement = $_POST['announcement'];

    $stmt = $conn->prepare("INSERT INTO announcements (announcement) VALUES (?)");
    $stmt->bind_param("s", $announcement);

    if ($stmt->execute()) {
        header("Location: /assesment3/admin_page.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
