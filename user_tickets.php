<?php
session_start();
require 'conn.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
$student_id = $_SESSION['user_id']; // Ensure correct session variable

// Fetch user info
$query = "SELECT username, student_number, email FROM users WHERE user_id= ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Fetch rental requests for the logged-in user, sorted by status
$query = "SELECT * FROM rental_requests WHERE student_id = ? ORDER BY status";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$tickets_result = $stmt->get_result();

// Store rental requests in an array for reuse
$tickets = [];
while ($row = $tickets_result->fetch_assoc()) {
    $tickets[] = $row;
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/landingstyle.css?v=2">
    <title>My Rental Requests</title>
</head>
<body>

    <!-- Navbar -->
    <header class="border-bottom py-3" style="background-color: #1a237e;">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid d-flex justify-content-between align-items-center">
                    <a class="navbar-brand" href="#">
                        <img src="icons/hm-pup.png" alt="Logo" class="logo" style="width: 155px; height: 30px;">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item"><a class="nav-link text-white" href="user_home.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link text-white" href="user_about.php">About Us</a></li>
                            <li class="nav-item"><a class="nav-link text-white" href="user_tools.php">Borrow Tools</a></li>
                            <li class="nav-item"><a class="nav-link text-white" href="user_contact.php">Contact</a></li>
                            <li class="nav-item"><a class="nav-link text-white fw-bold" href="user_tickets.php">My Requests</a></li>
                        </ul>
                    </div>
                    <div>
                        <img src="icons/user-icon.png" alt="Account Icon" style="width: 33px; height: 33px;" data-bs-toggle="modal" data-bs-target="#accountModal">
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Account Modal -->
    <div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark-blue text-white text-center">
                    <h5 class="modal-title fw-bold w-100" id="accountModalLabel">Account Information</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="fw-bold">Student Name:</label>
                        <div class="info-box">
                            <span id="student-name"><?php echo htmlspecialchars($user['username']); ?></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Student Number:</label>
                        <div class="info-box">
                            <span id="student-number"><?php echo htmlspecialchars($user['student_number']); ?></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Email:</label>
                        <div class="info-box">
                            <span id="email"><?php echo htmlspecialchars($user['email']); ?></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="?logout=true" class="btn btn-danger me-auto">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Request Tabs -->
    <div class="container mt-5">
        <h1>My Rental Requests</h1>
        <ul class="nav nav-tabs" id="requestTabs">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#pending">Pending</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#approved">Approved</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#declined">Declined</a></li>
        </ul>

        <div class="tab-content mt-3">
            <?php
            $statuses = ["Pending", "Approved", "Declined"];
            foreach ($statuses as $status):
            ?>
            <div class="tab-pane fade <?php echo $status === 'Pending' ? 'show active' : ''; ?>" id="<?php echo strtolower($status); ?>">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Request ID</th>
                            <th>Borrow Date</th>
                            <th>Return Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tickets as $ticket): ?>
                            <?php if ($ticket['status'] === $status): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($ticket['request_id']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['borrowing_date']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['returning_date']); ?></td>
                                    <td><button class="btn btn-primary btn-sm" onclick="viewInfo(<?php echo $ticket['request_id']; ?>)">View Info</button></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Request Info Modal -->
    <div class="modal fade" id="requestInfoModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Request Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="request-info"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    function viewInfo(requestId) {
        fetch('view_request_info.php?request_id=' + requestId)
            .then(response => response.json())
            .then(data => {
                let infoHtml = `
                    <p><strong>Student Name:</strong> ${data.student_name}</p>
                    <p><strong>Course & Section:</strong> ${data.course_section}</p>
                    <p><strong>Subject:</strong> ${data.subject}</p>
                    <p><strong>Professor:</strong> ${data.professor}</p>
                    <p><strong>Borrow Date:</strong> ${data.borrowing_date}</p>
                    <p><strong>Return Date:</strong> ${data.returning_date}</p>
                    <p><strong>Status:</strong> ${data.status}</p>
                    <p><strong>Tools Borrowed:</strong> ${data.tools_data}</p>
                `;
                document.getElementById('request-info').innerHTML = infoHtml;
                new bootstrap.Modal(document.getElementById('requestInfoModal')).show();
            })
            .catch(error => console.error('Error:', error));
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
