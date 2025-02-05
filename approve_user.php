<?php
session_start();
require 'conn.php'; // Include your database connection file

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $query = "UPDATE users SET status = 'approved' WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "User approved successfully.";
    } else {
        $_SESSION['error'] = "Error approving user.";
    }
}

header("Location: manageuser.php");
exit();
?>