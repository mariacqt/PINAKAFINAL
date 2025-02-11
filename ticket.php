<?php
session_start();
require 'conn.php'; // Ensure database connection is included

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Handle search
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $query_all = "SELECT * FROM rental_requests WHERE student_name LIKE ?";
    $stmt_search = $conn->prepare($query_all);
    $search_param = "%" . $search_query . "%";
    $stmt_search->bind_param("s", $search_param);
    $stmt_search->execute();
    $result_all = $stmt_search->get_result();
} else {
    $query_all = "SELECT * FROM rental_requests";
    $result_all = $conn->query($query_all);
}

if (!$result_all) {
    die("Database query failed: " . $conn->error); // Debugging error message
}
if (!$result_all) {
    die("Database query failed: " . $conn->error); // Debugging error message
}
// Handle logout
if (isset($_GET['logout'])) {
    // Destroy the session
    session_destroy();
    // Redirect to login page
    header("Location: login.php");
    exit();
}

// Fetch admin data from the database
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT username, email FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if (!$admin) {
        echo "Admin not found.";
        exit();
    }
} else {
    echo "User ID not set in session.";
    exit();
}

// Fetch pending users from the database
$query = "SELECT user_id, student_number, username, email, cor FROM users WHERE status = 'pending'";
$result = $conn->query($query);

// Handle ticket approval
if (isset($_POST['approve_ticket_id'])) {
    $approve_ticket_id = $_POST['approve_ticket_id'];
    $query_approve = "UPDATE rental_requests SET status = 'Approved', approved_timestamp = NOW() WHERE request_id = ?";
    $stmt_approve = $conn->prepare($query_approve);
    $stmt_approve->bind_param("i", $approve_ticket_id);
    $stmt_approve->execute();

    // Update stock quantity in tools table
    $query_tools = "SELECT tools_data FROM rental_requests WHERE request_id = ?";
    $stmt_tools = $conn->prepare($query_tools);
    $stmt_tools->bind_param("i", $approve_ticket_id);
    $stmt_tools->execute();
    $result_tools = $stmt_tools->get_result();
    $tools_data = $result_tools->fetch_assoc()['tools_data'];
    $tools = json_decode($tools_data, true);

    foreach ($tools as $tool) {
        $query_update_stock = "UPDATE tools SET stock_quantity = stock_quantity - ? WHERE tool_name = ?";
        $stmt_update_stock = $conn->prepare($query_update_stock);
        $stmt_update_stock->bind_param("is", $tool['quantity'], $tool['name']);
        $stmt_update_stock->execute();
    }

    header("Location: ticket.php");
    exit();
}

// Handle ticket completion
if (isset($_POST['complete_ticket_id'])) {
    $complete_ticket_id = $_POST['complete_ticket_id'];
    $remarks = $_POST['remark']; // Ensure 'remarks' is the correct field name from your form
    
// Fetch tools data for the completed ticket
$query_tools = "SELECT tools_data FROM rental_requests WHERE request_id = ?";
$stmt_tools = $conn->prepare($query_tools);
$stmt_tools->bind_param("i", $complete_ticket_id);
$stmt_tools->execute();
$result_tools = $stmt_tools->get_result();
$tools_data = $result_tools->fetch_assoc()['tools_data'];
$tools = json_decode($tools_data, true);

// Update stock quantity in tools table
foreach ($tools as $tool) {
    $query_update_stock = "UPDATE tools SET stock_quantity = stock_quantity + ? WHERE tool_name = ?";
    $stmt_update_stock = $conn->prepare($query_update_stock);
    $stmt_update_stock->bind_param("is", $tool['quantity'], $tool['name']);
    $stmt_update_stock->execute();
}

    
    // Prepare the update query
    $query_complete = "UPDATE rental_requests 
                       SET status = 'Completed', 
                           remark = ?, 
                           completed_timestamp = NOW() 
                       WHERE request_id = ?";
    $stmt_complete = $conn->prepare($query_complete);
    $stmt_complete->bind_param("si", $remarks, $complete_ticket_id);

    // Execute the query
    if ($stmt_complete->execute()) {
        header("Location: ticket.php"); // Redirect to the same page after completing
        exit();
    } else {
        echo "Error updating ticket: " . $stmt_complete->error;
    }
}

// Handle ticket rejection
if (isset($_POST['reject_ticket_id'])) {
    $reject_ticket_id = $_POST['reject_ticket_id'];
    $query_reject = "UPDATE rental_requests SET status = 'Completed', remark = 'Out of Stock', completed_timestamp = NOW() WHERE request_id = ?";
    $stmt_reject = $conn->prepare($query_reject);
    $stmt_reject->bind_param("i", $reject_ticket_id);
    $stmt_reject->execute();
    header("Location: ticket.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/otheradmins.css?v=2">
    <title>Ticket Management</title>
</head>
<body>
    <!-- Navbar -->
    <header class="bg-light border-bottom py-3 shadow-sm">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand d-flex align-items-center" href="#">
                        <img src="images/puplogo.png" alt="Logo" class="center-img" style="height: 30px; margin-right: 10px;">
                        <span class="fw-bold">HM Kitchen Tools</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a class="nav-link" href="admin.php">Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link" href="inventory.php">Inventory</a></li>
                            <li class="nav-item"><a class="nav-link" aria-current="page" href="manageuser.php">Manage Users</a></li>
                            <li class="nav-item"><a class="nav-link fw-bold" href="ticket.php">Tickets</a></li>
                            <a href="?logout=true" class="btn btn-primary rounded-pill px-4">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Request Tabs -->
    <div class="container mt-5">
        <h1 class="text-center">Manage Tickets</h1>
        <form class="d-flex mb-3" method="GET" action="ticket.php">
            <input class="form-control me-2" type="search" name="search" placeholder="Search by student name" aria-label="Search" value="<?php echo htmlspecialchars($search_query); ?>" oninput="checkSearchInput(this)">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        <ul class="nav nav-tabs" id="requestTabs">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#pending">Pending</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#approved">Approved</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#completed">Completed</a></li>
        </ul>
        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="pending">
                <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Request ID</th>
                            <th>Student ID</th>
                            <th class="col-1">Student Name</th>
                            <th>Course Section</th>
                            <th class="col-1">Subject</th>
                            <th class="col-1">Professor</th>
                            <th>User Classification</th>
                            <th class="col-1">Borrow Date</th>
                            <th class="col-1">Return Date</th>
                            <th>Requested Tools</th>
                            <th>Request Timestamp</th>
                            <th>Status</th>
                            <th class="col-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($ticket = $result_all->fetch_assoc()): ?>
                            <?php if ($ticket['status'] == 'Pending'): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($ticket['request_id']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['student_id']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['student_name']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['course_section']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['subject']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['professor']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['user_classification']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['borrowing_date']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['returning_date']); ?></td>
                                    <td><button class="btn btn-primary btn-sm" onclick="viewTools('<?php echo htmlspecialchars($ticket['tools_data']); ?>')">View Tools</button></td>
                                    <td><?php echo htmlspecialchars($ticket['request_timestamp']); ?></td>
                                    <td>Pending</td>
                                    <td>
                                        
                                        <form method="post" style="display:inline;">
                                            <input type="hidden" name="approve_ticket_id" value="<?php echo htmlspecialchars($ticket['request_id']); ?>">
                                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                        </form>
                                        <form method="post" style="display:inline;">
                                            <input type="hidden" name="reject_ticket_id" value="<?php echo htmlspecialchars($ticket['request_id']); ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                </div>
            </div>
<!-------APPROVED TICKETS --------------->
            <div class="tab-pane fade" id="approved">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Request ID</th>
                            <th>Student ID</th>
                            <th class="col-1">Student Name</th>
                            <th>Course Section</th>
                            <th class="col-1">Subject</th>
                            <th class="col-1">Professor</th>
                            <th>User Classification</th>
                            <th class="col-1">Borrow Date</th>
                            <th class="col-1">Return Date</th>
                            <th>Requested Tools</th>
                            <th>Request Timestamp</th>
                            <th class="col-3">Status</th>
                            <th class="col-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result_all->data_seek(0);
                        while ($ticket = $result_all->fetch_assoc()): ?>
                            <?php if ($ticket['status'] == 'Approved'): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($ticket['request_id']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['student_id']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['student_name']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['course_section']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['subject']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['professor']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['user_classification']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['borrowing_date']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['returning_date']); ?></td>
                                    <td><button class="btn btn-primary btn-sm" onclick="viewTools('<?php echo htmlspecialchars($ticket['tools_data']); ?>')">View Tools</button></td>
                                    <td><?php echo htmlspecialchars($ticket['approved_timestamp']); ?></td>
                                    <td>
                                        <select class="form-select form-select-sm" onchange="updateStatus('<?php echo htmlspecialchars($ticket['request_id']); ?>', this.value)">
                                            <option value="Ongoing" <?php echo $ticket['status'] == 'Ongoing' ? 'selected' : ''; ?>>Ongoing</option>
                                            <option value="Ongoing-Released" <?php echo $ticket['status'] == 'Ongoing-Released' ? 'selected' : ''; ?>>Ongoing-Released</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-success btn-sm" onclick="showCompleteModal('<?php echo htmlspecialchars($ticket['request_id']); ?>')">Complete</button>
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            </div>
            <!-----------------COMPLETED TICKETS --------------->
            <div class="tab-pane fade" id="completed">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                        <th>Request ID</th>
                            <th>Student ID</th>
                            <th class="col-1">Student Name</th>
                            <th>Course Section</th>
                            <th class="col-1">Subject</th>
                            <th class="col-1">Professor</th>
                            <th>User Classification</th>
                            <th class="col-1">Borrow Date</th>
                            <th class="col-1">Return Date</th>
                            <th>Requested Tools</th>
                            <th>Request Timestamp</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Completed On</th>
                            <th class="col-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result_all->data_seek(0);
                        while ($ticket = $result_all->fetch_assoc()): ?>
                            <?php if ($ticket['status'] == 'Completed'): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($ticket['request_id']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['student_id']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['student_name']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['course_section']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['subject']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['professor']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['user_classification']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['borrowing_date']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['returning_date']); ?></td>
                                    <td><button class="btn btn-primary btn-sm" onclick="viewTools('<?php echo htmlspecialchars($ticket['tools_data']); ?>')">View Tools</button></td>
                                    <td><?php echo htmlspecialchars($ticket['request_timestamp']); ?></td>
                                    <td>Completed</td>
                                    <td><?php echo htmlspecialchars($ticket['remark']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['completed_timestamp']); ?></td>
                                    <td>
                                        <button class="btn btn-danger btn-sm mb-2">Delete</button>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div> </div>             
        </div>
    </div>

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
    <!-- Complete Modal -->
    <div class="modal fade" id="completeModal" tabindex="-1" aria-labelledby="completeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="completeModalLabel">Complete Ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                        <input type="hidden" name="complete_ticket_id" id="complete_ticket_id">
                        <div class="mb-3">
                            <select class="form-select" name="remark" id="remarks" required>
                                <option value="Complete">Complete</option>
                                <option value="Missing">Missing</option>
                                <option value="Late">Late</option>
                                <option value="Broken">Broken</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
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

        function confirmLogout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = '?logout=true';
            }
        }

        function showCompleteModal(ticketId) {
            document.getElementById('complete_ticket_id').value = ticketId;
            var completeModal = new bootstrap.Modal(document.getElementById('completeModal'));
            completeModal.show();
        }

        function checkSearchInput(input) {
            if (input.value === "") {
                window.location.href = "ticket.php";
            }
        }
    </script>
   
</body>
</html>

