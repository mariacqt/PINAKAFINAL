<?php
// view_file.php

// Include database connection
include 'conn.php';

// Check if user_id is set in the URL
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Get the file path of the COR from the database
    $query = "SELECT COR FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($cor);
    $stmt->fetch();

    if (!empty($cor)) {
        // Ensure the file exists before attempting to show it
        // Make sure the $cor does not include 'uploads/' again
        $file_path = 'uploads/' . basename($cor);  // Use basename() to avoid issues with extra paths
        echo "File path: " . $file_path; // Debugging line
        if (file_exists($file_path)) {
            // Output the COR file content (assuming PDF for this example)
            header('Content-Type: application/pdf'); // Modify this if needed for different file types
            header('Content-Disposition: inline; filename="' . basename($file_path) . '"');
            readfile($file_path);
        } else {
            echo "File not found.";
        }
    } else {
        echo "No COR found for this user.";
    }
} else {
    echo "No user ID provided.";
}
?>
