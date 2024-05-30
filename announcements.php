<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Announcements</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <div class="container">
        <div class="dashboard-content">
            <div class="nav-options">
                <a href="dashboard.php" class="btn">Dashboard</a>
                <a href="php/logout.php" class="btn">Logout</a>
            </div>
            <h1>Announcements</h1>
            <p>Stay updated with the latest announcements.</p>
            <ul class="announcement-list">
                <?php
                // Fetch and display announcements
                include 'php/db.php';
                $result = $conn->query("SELECT * FROM announcements");
                while ($row = $result->fetch_assoc()) {
                    echo '<li class="announcement-item">' . $row['announcement'] . '</li>';
                }
                ?>
            </ul>
        </div>
    </div>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
