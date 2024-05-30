<?php
session_start();
include dirname(__FILE__) . '/../php/db.php'; // Correct path to db.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['delete_meeting']) && isset($_POST['meeting_id'])) {
        $meeting_id = $_POST['meeting_id'];

        // Prepare an SQL statement
        $stmt = $conn->prepare("DELETE FROM meetings WHERE id = ?");
        $stmt->bind_param("i", $meeting_id);

        // Execute the statement
        if ($stmt->execute()) {
            header("Location: ../live_classes.php");
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>
