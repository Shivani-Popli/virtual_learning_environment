<?php
session_start();
include dirname(__FILE__) . '/../php/db.php'; // Correct path to db.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $topic = $_POST['topic'];
    $meeting_url = $_POST['meeting_url'];
    $meeting_description = $_POST['meeting_description'];
    $created_by = $_SESSION['username'];

    // Prepare an SQL statement
    $stmt = $conn->prepare("INSERT INTO meetings (topic, meeting_url, meeting_description, created_by) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $topic, $meeting_url, $meeting_description, $created_by);

    // Execute the statement
    if ($stmt->execute()) {
        header("Location: ../live_classes.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
