<?php
include 'db.php';

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$dob = $_POST['dob'];
$student_id = $_POST['student_id'];

// Check if the passwords match
if ($_POST['password'] !== $_POST['confirm_password']) {
    echo "Passwords do not match.";
    exit();
}

$sql = "INSERT INTO users (fullname, email, username, password, dob, student_id) VALUES ('$fullname', '$email', '$username', '$password', '$dob', '$student_id')";

if ($conn->query($sql) === TRUE) {
    $userId = $conn->insert_id;
    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['user_id'] = $userId; // Store user ID in session
    header("Location: ../dashboard.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
