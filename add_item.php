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
                        VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssiss", $tool_name, $category, $stock_quantity, $status, $image_path);

                try {
                    $stmt->execute();
                    header("Location: inventory.php"); // Redirect to inventory page after successful insertion
                    exit();
                } catch (mysqli_sql_exception $e) {
                    if ($stmt->errno == 1062) { // Duplicate entry error code
                        $error_message = "Error: Tool with the same name already exists.";
                    } else {
                        $error_message = "Error: " . $stmt->error;
                    }
                }
            } else {
                $error_message = "File upload failed!";
            }
        } else {
            $error_message = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    } else {
        $error_message = "Error uploading file. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="css/otheradmins.css" rel="stylesheet">
    <title>Add Tool</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Add New Tool</h1>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger">
                <?php echo $error_message; ?>
               
            </div> 
            <a href="inventory.php" class="btn btn-primary mt-3">Back to Inventory</a>
        <?php endif; ?>
