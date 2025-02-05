<?php
// delete_item.php

function deleteItem($itemId) {
    // Database connection
    require 'conn.php';

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL to delete a record
    $sql = "DELETE FROM tools WHERE tool_id = ?"; // Change items to tools

    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $itemId); // Bind the tool_id parameter

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect back to inventory.php after deletion with success message
            header("Location: inventory.php?message=Item+deleted+successfully");
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Close connection
    $conn->close();
}

// Check if delete button is clicked and tool_id is set
if (isset($_POST['tool_id'])) {
    deleteItem($_POST['tool_id']);
}
?>

