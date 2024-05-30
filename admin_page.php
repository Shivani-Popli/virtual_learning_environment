<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: /assesment3/admin_login.html");
    exit();
}

include __DIR__ . '/php/db.php'; // Correct path to db.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Page</title>
    <link rel="stylesheet" href="/assesment3/css/styles.css"> <!-- Ensure correct path to CSS -->
</head>
<body>
    <?php include __DIR__ . '/templates/header.php'; ?> <!-- Correct path to header.php -->
    <div class="container">
        <div class="dashboard-content">
            <div class="nav-options">
                <a href="/assesment3/php/logout.php" class="btn">Logout</a> <!-- Correct path to logout.php -->
            </div>
            <h1>Manage Announcements</h1>
            <form action="/assesment3/php/add_announcement.php" method="post"> <!-- Correct path to add_announcement.php -->
                <label for="announcement">Announcement:</label>
                <textarea id="announcement" name="announcement" required></textarea>
                <button type="submit" class="btn">Add Announcement</button>
            </form>
            <div class="shared-content">
                <h3>Existing Announcements</h3>
                <ul>
                    <?php
                    $result = $conn->query("SELECT * FROM announcements");
                    while ($row = $result->fetch_assoc()) {
                        echo '<li>';
                        echo '<p>' . $row['announcement'] . '</p>';
                        echo '<small>Posted on: ' . $row['created_at'] . '</small>';
                        echo '<form action="/assesment3/php/delete_announcement.php" method="post" style="display:inline;">';
                        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                        echo '<button type="submit" class="btn">Delete</button>';
                        echo '</form>';
                        echo '</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <?php include __DIR__ . '/templates/footer.php'; ?> <!-- Correct path to footer.php -->
</body>
</html>
