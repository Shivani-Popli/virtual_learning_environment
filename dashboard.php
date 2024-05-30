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
    <title>Dashboard</title>
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
            <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
            <div class="options">
                <a href="content_sharing.php" class="option">
                    <h2>Content Sharing</h2>
                    <p>Share and access educational content.</p>
                </a>
                <a href="live_classes.php" class="option">
                    <h2>Live Classes</h2>
                    <p>Join live interactive sessions.</p>
                </a>
                <a href="announcements.php" class="option">
                    <h2>Announcements</h2>
                    <p>Stay updated with the latest announcements.</p>
                </a>
            </div>
        </div>
    </div>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
