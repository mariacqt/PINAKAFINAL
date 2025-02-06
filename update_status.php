<?php
require 'conn.php'; // Include your database connection file

if (isset($_GET['request_id']) && isset($_GET['status'])) {
    $request_id = $_GET['request_id'];
    $status = $_GET['status'];
    $query = "UPDATE rental_requests SET status = ? WHERE request_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $request_id);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>