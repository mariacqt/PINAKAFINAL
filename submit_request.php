<?php
require 'conn.php'; // Include database connection

// Get form data
$cartData = $_POST['cart-data'];  // The cart data in JSON format
$studentName = $_POST['student-name'];
$studentId = $_POST['student-id'];
$courseSection = $_POST['course-section'];
$subject = $_POST['subject'];
$professor = $_POST['professor'];
$userClassification = $_POST['user-classification'];
$borrowingDate = $_POST['borrowing-date'];
$borrowingTime = $_POST['borrowing-time'];
$returningDate = $_POST['returning-date'];
$requestTimestamp = $_POST['request-timestamp'];

// Check if cart-data is set and not empty
if (empty($cartData)) {
    die("Error: Cart data is missing or empty.");
}

// Decode the cart data from JSON
$cartItems = json_decode($cartData, true);

// Check if json_decode was successful
if ($cartItems === null) {
    die("Error: Failed to decode JSON. Invalid format or empty data.");
}

// Prepare tools data as JSON string
$toolsData = json_encode($cartItems);

// Set status to 'Pending' by default
$status = 'Pending';

// Prepare the SQL query to insert the data
$stmt = $conn->prepare("INSERT INTO rental_requests (student_id, student_name, course_section, subject, professor, user_classification, borrowing_date, borrowing_time, returning_date, tools_data, request_timestamp, status) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

// Check if preparation was successful
if ($stmt === false) {
    echo "Error preparing statement: " . $conn->error;
    exit;  // Exit if preparation fails
}

// Set the approved_timestamp as NULL (for now)
$approvedTimestamp = NULL;

// Bind parameters for the main request data, JSON tools data, and status
$stmt->bind_param("ssssssssssss", $studentId, $studentName, $courseSection, $subject, $professor, $userClassification, $borrowingDate, $borrowingTime, $returningDate, $toolsData, $requestTimestamp, $status);

// Execute the statement
if ($stmt->execute()) {
  
} else {
    echo "Error executing statement: " . $stmt->error;
}

// Close the statement after execution
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Rental Request Confirmation</title>
    
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        text-align: center;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 30px;
        width: 100%;
        max-width: 500px;
    }

    h1 {
        color: #061274;
        font-size: 24px;
    }

    p {
        font-size: 16px;
        color: #333;
        margin-bottom: 20px;
    }

    a {
        color: #061274;
        font-size: 18px;
        text-decoration: none;
        font-weight: bold;
    }

    a:hover {
        color: #003366;
    }
</style>


</head>
<body>
    <div class="container">
        <h1>Rental Request Submitted Successfully!</h1>
        <p>Your rental request has been submitted successfully. You can manage your rental tools below:</p>
        <a href="user_tickets.php">Click here to go to your requested tools</a>
    </div>
</body>
</html>

