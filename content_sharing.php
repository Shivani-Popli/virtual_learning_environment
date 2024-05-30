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
    <title>Content Sharing</title>
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
            <h1>Content Sharing</h1>
            
            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="error">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                echo '<div class="success">' . $_SESSION['success'] . '</div>';
                unset($_SESSION['success']);
            }
            ?>

            <form action="php/upload.php" method="post" enctype="multipart/form-data">
                <label for="file">Select file to upload:</label>
                <input type="file" id="file" name="file" required>
                <button type="submit" class="btn">Upload</button>
            </form>
            <div class="content-section">
                <div class="content-box">
                    <h3>Your Uploaded Files</h3>
                    <ul>
                        <?php
                        include 'php/db.php';
                        $userId = $_SESSION['user_id'];
                        
                        $result = $conn->query("SELECT id, filename FROM uploads WHERE user_id = $userId");
                        
                        while ($row = $result->fetch_assoc()) {
                            echo '<li><span>' . $row['filename'] . '</span>';
                            echo ' - <a href="php/share.php?file_id=' . $row['id'] . '">Share</a>';
                            echo ' - <a href="php/delete.php?file_id=' . $row['id'] . '">Delete</a></li>';
                        }
                        ?>
                    </ul>
                </div>
                <div class="content-box">
                    <h3>Files Shared with You</h3>
                    <ul>
                        <?php
                        $result = $conn->query("
                            SELECT u.filename, us.username 
                            FROM uploads u
                            JOIN shared_files sf ON u.id = sf.file_id
                            JOIN users us ON sf.from_user_id = us.id
                            WHERE sf.to_user_id = $userId
                        ");
                        
                        while ($row = $result->fetch_assoc()) {
                            echo '<li><span>' . $row['filename'] . '</span>';
                            echo ' - Shared by ' . $row['username'] . '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
