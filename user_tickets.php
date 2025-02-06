<?php
include 'conn.php';
session_start();
$user_id = $_SESSION['user_id'];
// Fetch user data from the database
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT username, student_number, email FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo "User not found.";
        exit();
    }
} 
// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Handle ticket rejection
if (isset($_POST['reject_ticket_id'])) {
    $reject_ticket_id = $_POST['reject_ticket_id'];
    $query_reject = "UPDATE rental_requests SET status = 'Completed', remark = 'Out of Stock' WHERE request_id = ?";
    $stmt_reject = $conn->prepare($query_reject);
    $stmt_reject->bind_param("i", $reject_ticket_id);
    $stmt_reject->execute();
    header("Location: user_tickets.php");
    exit();
}

// Construct queries for different statuses
$query_pending = "SELECT * FROM rental_requests WHERE status = 'Pending' AND student_id = ? ORDER BY request_timestamp DESC";
$query_approved = "SELECT * FROM rental_requests WHERE status = 'Approved' AND student_id = ? ORDER BY request_timestamp DESC";
$query_completed = "SELECT * FROM rental_requests WHERE status = 'Completed' AND student_id = ? ORDER BY request_timestamp DESC";

// Prepare and execute queries
$stmt_pending = $conn->prepare($query_pending);
$stmt_pending->bind_param("s", $user['student_number']);
$stmt_pending->execute();
$result_pending = $stmt_pending->get_result();

$stmt_approved = $conn->prepare($query_approved);
$stmt_approved->bind_param("s", $user['student_number']);
$stmt_approved->execute();
$result_approved = $stmt_approved->get_result();

$stmt_completed = $conn->prepare($query_completed);
$stmt_completed->bind_param("s", $user['student_number']);
$stmt_completed->execute();
$result_completed = $stmt_completed->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Ticket Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/landingstyle.css?v=2">
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
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item d-lg-none"><div id="account-icon" data-bs-toggle="modal" data-bs-target="#accountModal">
                                <img src="icons/user-icon.png" alt="Account Icon" style="width: 33px; height: 33px; margin-top: 15px;">
                            </div>
                            </li>
                            <li class="nav-item"><a class="nav-link text-white" href="user_home.php">Home</a></li>
                            <li class="nav-item"><a href="user_about.php" class="nav-link text-white">About Us</a></li>
                            <li class="nav-item"><a href="user_tools.php" class="nav-link text-white">Borrow Tools</a></li>
                            <li class="nav-item"><a href="user_contact.php" class="nav-link text-white">Contact</a></li>
                            <li class="nav-item"><a href="user_tickets.php" class="nav-link text-white  fw-bold">My Tickets</a></li>
                        </ul>
                    </div>
                    <div class="d-none d-lg-block">
                        <div id="account-icon" data-bs-toggle="modal" data-bs-target="#accountModal">
                            <img src="icons/user-icon.png" alt="Account Icon" style="width: 33px; height: 33px;">
                        </div>
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
    <!-- Ticket Tabs -->
    <div class="container mt-5">
        <h1 class="text-center">Tickets Transactions</h1>

        <ul class="nav nav-tabs" id="requestTabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#pending">Pending</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#approved">Approved</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#completed">Completed</a>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <!-- Pending Tab -->
            <div class="tab-pane fade show active" id="pending">
                <h3>Pending Requests</h3>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Request ID</th>
                                <th>Student Name</th>
                                <th>Course Section</th>
                                <th>Subject</th>
                                <th>Professor</th>
                                <th>Borrowing Date</th>
                                <th>Returning Date</th>
                                <th>Tools Data</th>
                                <th>Status</th>
                                <th>Request Timestamp</th>
                                <th>Approved Timestamp</th>
                       
                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result_pending->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['request_id']; ?></td>
                                    <td><?php echo $row['student_name']; ?></td>
                                    <td><?php echo $row['course_section']; ?></td>
                                    <td><?php echo $row['subject']; ?></td>
                                    <td><?php echo $row['professor']; ?></td>
                                    <td><?php echo $row['borrowing_date']; ?></td>
                                    <td><?php echo $row['returning_date']; ?></td>
                                    <td><button class="btn btn-primary btn-sm" onclick="viewTools('<?php echo htmlspecialchars($row['tools_data']); ?>')">View Tools</button></td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td><?php echo $row['request_timestamp']; ?></td>
                                    <td><?php echo $row['approved_timestamp'] ?: 'N/A'; ?></td>
                                    
                                  
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Approved Tab -->
            <div class="tab-pane fade" id="approved">
                <h3>Approved Requests</h3>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Request ID</th>
                                <th>Student Name</th>
                                <th>Course Section</th>
                                <th>Subject</th>
                                <th>Professor</th>
                                <th>Borrowing Date</th>
                                <th>Returning Date</th>
                                <th>Tools Data</th>
                                <th>Status</th>
                                <th>Request Timestamp</th>
                                <th>Approved Timestamp</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result_approved->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['request_id']; ?></td>
                                    <td><?php echo $row['student_name']; ?></td>
                                    <td><?php echo $row['course_section']; ?></td>
                                    <td><?php echo $row['subject']; ?></td>
                                    <td><?php echo $row['professor']; ?></td>
                                    <td><?php echo $row['borrowing_date']; ?></td>
                                    <td><?php echo $row['returning_date']; ?></td>
                                    <td><button class="btn btn-primary btn-sm" onclick="viewTools('<?php echo htmlspecialchars($row['tools_data']); ?>')">View Tools</button></td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td><?php echo $row['request_timestamp']; ?></td>
                                    <td><?php echo $row['approved_timestamp'] ?: 'N/A'; ?></td>
                                    
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Completed Tab -->
            <div class="tab-pane fade" id="completed">
                <h3>Completed Requests</h3>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Request ID</th>
                                <th>Student Name</th>
                                <th>Course Section</th>
                                <th>Subject</th>
                                <th>Professor</th>
                                <th>Borrowing Date</th>
                                <th>Returning Date</th>
                                <th>Tools Data</th>
                                <th>Status</th>
                                <th>Request Timestamp</th>
                                <th>Approved Timestamp</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result_completed->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['request_id']; ?></td>
                                    <td><?php echo $row['student_name']; ?></td>
                                    <td><?php echo $row['course_section']; ?></td>
                                    <td><?php echo $row['subject']; ?></td>
                                    <td><?php echo $row['professor']; ?></td>
                                    <td><?php echo $row['borrowing_date']; ?></td>
                                    <td><?php echo $row['returning_date']; ?></td>
                                    <td><button class="btn btn-primary btn-sm" onclick="viewTools('<?php echo htmlspecialchars($row['tools_data']); ?>')">View Tools</button></td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td><?php echo $row['request_timestamp']; ?></td>
                                    <td><?php echo $row['approved_timestamp'] ?: 'N/A'; ?></td>
                                    <td><?php echo $row['remark'] ?: 'Complete'; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Tools Modal -->
    <div class="modal fade" id="toolsModal" tabindex="-1" aria-labelledby="toolsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="toolsModalLabel">Borrowed Tools</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="toolsList" class="list-group">
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function viewTools(toolsData) {
            try {
                const toolsArray = JSON.parse(toolsData);
                let toolsList = '';
                toolsArray.forEach(tool => {
                    toolsList += `<li class="list-group-item"><strong>${tool.name}</strong> (Qty: ${tool.quantity})</li>`;
                });
                document.getElementById('toolsList').innerHTML = toolsList;
                var toolsModal = new bootstrap.Modal(document.getElementById('toolsModal'));
                toolsModal.show();
            } catch (error) {
                alert("Error displaying tools data.");
            }
        }
    </script>
</body>
</html>
