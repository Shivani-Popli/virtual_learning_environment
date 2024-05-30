<?php
include __DIR__ . '/db.php'; // Correct path to db.php

$admin_username = 'admin'; // Define the admin username
$admin_password = password_hash('admin', PASSWORD_DEFAULT); // Define and hash the admin password

$stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $admin_username, $admin_password);

if ($stmt->execute()) {
    echo "Admin user created successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
