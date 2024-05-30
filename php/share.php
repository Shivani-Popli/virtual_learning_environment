<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.html");
    exit();
}

include 'db.php';

$fileId = $_GET['file_id'];
$userId = $_SESSION['user_id'];

// Fetch the file information
$fileResult = $conn->query("SELECT filename FROM uploads WHERE id = $fileId AND user_id = $userId");
$file = $fileResult->fetch_assoc();

if (!$file) {
    echo "File not found or you don't have permission to share this file.";
    exit();
}

// Fetch all users except the current user
$userResult = $conn->query("SELECT id, username FROM users WHERE id != $userId");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Share File</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include '../templates/header.php'; ?>
    <div class="container">
        <div class="dashboard-content">
            <div class="nav-options">
                <a href="../dashboard.php" class="btn">Dashboard</a>
                <a href="logout.php" class="btn">Logout</a>
            </div>
            <h1>Share File: <?php echo $file['filename']; ?></h1>
            <form action="process_share.php" method="post">
                <input type="hidden" name="file_id" value="<?php echo $fileId; ?>">
                <label for="user_id">Select User to Share With:</label>
                <select name="user_id" id="user_id" required>
                    <?php
                    while ($row = $userResult->fetch_assoc()) {
                        echo '<option value="' . $row['id'] . '">' . $row['username'] . '</option>';
                    }
                    ?>
                </select>
                <button type="submit" class="btn">Share</button>
            </form>
        </div>
    </div>
    <?php include '../templates/footer.php'; ?>
</body>
</html>
