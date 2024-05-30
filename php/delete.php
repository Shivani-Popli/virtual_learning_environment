<?php
session_start();
include 'db.php';

if (isset($_GET['file_id'])) {
    $fileId = $_GET['file_id'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Delete references in the shared_files table
        $sqlSharedFiles = "DELETE FROM shared_files WHERE file_id = ?";
        $stmtSharedFiles = $conn->prepare($sqlSharedFiles);
        $stmtSharedFiles->bind_param('i', $fileId);
        $stmtSharedFiles->execute();

        // Delete the file from the uploads table
        $sqlUploads = "DELETE FROM uploads WHERE id = ?";
        $stmtUploads = $conn->prepare($sqlUploads);
        $stmtUploads->bind_param('i', $fileId);
        $stmtUploads->execute();

        // Commit the transaction
        $conn->commit();
        
        $_SESSION['success'] = "File deleted successfully.";
    } catch (mysqli_sql_exception $exception) {
        // Rollback the transaction on error
        $conn->rollback();
        
        $_SESSION['error'] = "Error deleting file: " . $exception->getMessage();
    }

    // Close statements
    $stmtSharedFiles->close();
    $stmtUploads->close();
} else {
    $_SESSION['error'] = "Invalid file ID.";
}

$conn->close();
header("Location: ../content_sharing.php");
exit();
?>
