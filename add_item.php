<?php
session_start();
require 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $tool_name = $_POST['tool_name'];
    $category = $_POST['category'];
    $stock_quantity = $_POST['stock_quantity'];
    $status = $_POST['status'];

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        $image_error = $_FILES['image']['error'];

        // Set allowed image extensions
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);

        // Check if file type is allowed
        if (in_array(strtolower($image_extension), $allowed_extensions)) {
            // Set the upload directory
            $upload_dir = 'tools/';
            $image_path = $upload_dir . basename($image_name);

            // Move the uploaded file to the uploads folder
            if (move_uploaded_file($image_tmp_name, $image_path)) {
                // Insert the new item into the database
                $sql = "INSERT INTO tools (tool_name, category, stock_quantity, status, image_url) 
                        VALUES ('$tool_name', '$category', '$stock_quantity', '$status', '$image_path')";

                if ($conn->query($sql) === TRUE) {
                    header("Location: inventory.php"); // Redirect to inventory page after successful insertion
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "File upload failed!";
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    } else {
        echo "Error uploading file. Please try again.";
    }
}
?>
