<?php
session_start();
require 'conn.php'; // Include your database connection file

function getActiveUsersCount($conn) {
    $sql = "SELECT COUNT(*) as count FROM users WHERE status = 'approved'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the count from the result
        $row = $result->fetch_assoc();
        return $row['count'];
    } else {
        return 0;
    }
}

function getActiveUsers($conn) {
    $sql = "SELECT user_id, username, email FROM users WHERE status = 'active'";
    $result = $conn->query($sql);
    $activeUsers = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $activeUsers[] = $row;
        }
    }
    return $activeUsers;
}

function getTicketCountByStatus($conn, $status) {
    $sql = "SELECT COUNT(*) as count FROM rental_requests WHERE status = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $status);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'];
}

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}

// Handle logout
if (isset($_GET['logout'])) {
    // Destroy the session
    session_destroy();
    // Redirect to login page
    header("Location: login.php");
    exit();
}

// SQL query to get the total count of available tools
$query = "SELECT COUNT(*) AS total_tools FROM tools WHERE status = 'available'";
$result = mysqli_query($conn, $query);

// Fetch the result
$row = mysqli_fetch_assoc($result);
$total_tools = $row['total_tools'] ? $row['total_tools'] : 0;


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
    <link rel="stylesheet" href="css/admin.css?v=2">
    <title>Admin Dashboard</title>
</head>
<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
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
                            <li class="nav-item"><a class="nav-link fw-bold" aria-current="page" href="#">Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link" href="inventory.php">Inventory</a></li>
                            <li class="nav-item"><a class="nav-link" href="manageuser.php">Manage Users</a></li>
                            <li class="nav-item"><a class="nav-link" href="ticket.php">Tickets</a></li>
                            <a href="?logout=true" class="btn btn-primary rounded-pill px-4">Logout</a>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Dashboard -->
    <div class="container mt-5">
        <h1 class="mb-4">Dashboard</h1>
        <div class="row">
            <div class="col-md-6">
                <canvas id="myChart"></canvas>
            </div>
            <div class="col-md-6">
                <!-- Dashboard Content -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Active Users</h5>
                        <?php
                        $activeUsersCount = getActiveUsersCount($conn);
                        ?>
                        <p class="card-text">There are <span id="totalUsers"><?php echo $activeUsersCount; ?></span> active users.</p>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Total Tickets</h5>
                        <?php
                        $pendingTickets = getTicketCountByStatus($conn, 'Pending');
                        $approvedTickets = getTicketCountByStatus($conn, 'Approved');
                        $completedTickets = getTicketCountByStatus($conn, 'Completed');
                        ?>
                        <p class="card-text">Pending: <span id="pendingTickets"><?php echo $pendingTickets; ?></span></p>
                        <p class="card-text">Approved: <span id="approvedTickets"><?php echo $approvedTickets; ?></span></p>
                        <p class="card-text">Completed: <span id="completedTickets"><?php echo $completedTickets; ?></span></p>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Total Inventory</h5>
                        <p class="card-text">Total Tools:  <?php echo $total_tools; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function fetchActiveUsers() {
            fetch('fetch_active_users.php') // Call PHP script
                .then(response => response.json()) // Convert response to JSON
                .then(data => {
                    document.getElementById('totalUsers').textContent = data.count; // Update the number in the UI
                })
                .catch(error => console.error('Error fetching active users:', error));
        }

        // Fetch active users count every 10 seconds
        setInterval(fetchActiveUsers, 10000);
        fetchActiveUsers(); // Fetch immediately on page load

        var xValues = ["Pending Tickets", "Approved Tickets", "Completed Tickets"];
        var yValues = [
            <?php echo $pendingTickets; ?>, 
            <?php echo $approvedTickets; ?>, 
            <?php echo $completedTickets; ?>
        ];
        var barColors = [
            "#f39c12",
            "#27ae60",
            "#2980b9"
        ];

        new Chart("myChart", {
            type: "doughnut",
            data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
            },
            options: {
            title: {
                display: true,
                text: "Ticket Status Overview"
            }
            }
        });
    </script>
</body>
</html>
