<?php
// Include your database connection file (if needed)
include('conn.php'); // Replace with your actual DB connection file

// You can fetch any data from the session or database if needed
// For example, you can fetch the user's name from the session if needed
session_start();
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to view this page.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation</title>
    <link rel="stylesheet" href="css/confirmation.css">

</head>
<body>

<div class="confirmation-container">
    <h2>Your borrow request has been submitted successfully!</h2>
    <p>Thank you for your request. You will be notified when your request is processed.</p>
    <p><a href="user_home.php">Go back to the homepage</a></p>
</div>

</body>
</html>
