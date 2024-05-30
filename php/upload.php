<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $fileName = basename($_FILES['file']['name']);
    $targetDir = "../uploads/";
    $targetFilePath = $targetDir . $fileName;
    $userId = $_SESSION['user_id'];

    // Allowed file types
    $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'doc', 'docx', 'pdf', 'ppt', 'pptx', 'xls', 'xlsx', 'zip', 'rar');

    // Get the file extension
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Check if the file type is allowed
    if (in_array($fileType, $allowedFileTypes)) {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
            $sql = "INSERT INTO uploads (filename, user_id) VALUES ('$fileName', '$userId')";
            if ($conn->query($sql) === TRUE) {
                $_SESSION['success'] = "File uploaded successfully.";
            } else {
                $_SESSION['error'] = "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            $_SESSION['error'] = "Sorry, there was an error uploading your file.";
        }
    } else {
        $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG, GIF, DOC, DOCX, PDF, PPT, PPTX, XLS, XLSX, ZIP, and RAR files are allowed.";
    }
}
$conn->close();
header("Location: ../content_sharing.php");
exit();
?>
