<?php
session_start();
require 'conn.php'; // Include your database connection file

if (!isset($_GET['ticket_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Ticket ID is required']);
    exit();
}

$ticket_id = $_GET['ticket_id'];

// Fetch ticket info
$query = "SELECT t.*, u.username AS student_name, u.course_sec, u.subject, u.prof, u.user_class FROM tickets t JOIN users u ON t.user_id = u.user_id WHERE t.ticket_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $ticket_id);
$stmt->execute();
$result = $stmt->get_result();
$ticket = $result->fetch_assoc();

if (!$ticket) {
    http_response_code(404);
    echo json_encode(['error' => 'Ticket not found']);
    exit();
}

// Fetch borrowed items (assuming you have a table for borrowed items)
$query = "SELECT item_name FROM borrowed_items WHERE ticket_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $ticket_id);
$stmt->execute();
$result = $stmt->get_result();
$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row['item_name'];
}

$ticket['items'] = $items;

echo json_encode($ticket);
?>