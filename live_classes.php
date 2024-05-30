<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: /login.html");
    exit();
}

include __DIR__ . '/php/db.php'; // Correct path to db.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Live Classes</title>
    <link rel="stylesheet" href="/assesment3/css/styles.css"> <!-- Ensure correct path to CSS -->
</head>
<body>
    <?php include __DIR__ . '/templates/header.php'; ?> <!-- Correct path to header.php -->
    <div class="container">
        <div class="dashboard-content">
            <div class="nav-options">
                <a href="/assesment3/dashboard.php" class="btn">Dashboard</a> <!-- Correct path to dashboard.php -->
                <a href="/assesment3/php/logout.php" class="btn">Logout</a> <!-- Correct path to logout.php -->
            </div>
            <h1>Live Classes</h1>
            <button class="btn" onclick="openZoom()">Open Zoom</button>
            <form action="/assesment3/php/meetings.php" method="post"> <!-- Correct path to meetings.php -->
                <label for="topic">Meeting Topic:</label>
                <input type="text" id="topic" name="topic" required>
                
                <label for="meeting_url">Meeting URL:</label>
                <input type="text" id="meeting_url" name="meeting_url" required>
                
                <label for="meeting_description">Description:</label>
                <textarea id="meeting_description" name="meeting_description" required></textarea>
                
                <button type="submit" class="btn">Save Meeting</button>
            </form>
            <div class="shared-content">
                <h3>Scheduled Meetings</h3>
                <ul>
                    <?php
                    $result = $conn->query("SELECT * FROM meetings");
                    while ($row = $result->fetch_assoc()) {
                        echo '<li>';
                        echo '<strong>' . $row['topic'] . '</strong><br>';
                        echo '<a href="' . $row['meeting_url'] . '" target="_blank">Join Meeting</a>';
                        echo '<br>' . $row['meeting_description'];
                        echo '<br><small>Created by: ' . $row['created_by'] . '</small>';
                        // Delete button form
                        echo '<form action="/assesment3/php/delete_meeting.php" method="post">';
                        echo '<input type="hidden" name="meeting_id" value="' . $row['id'] . '">';
                        echo '<button type="submit" name="delete_meeting" class="btn">Delete</button>';
                        echo '</form>';
                        echo '</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <?php include __DIR__ . '/templates/footer.php'; ?> <!-- Correct path to footer.php -->
    <script>
        function openZoom() {
            window.open('https://zoom.us/start/videomeeting', '_blank');
        }
    </script>
</body>
</html>
