<?php
session_start();
require 'conn.php'; // Include your database connection file

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
    <title>User Management</title>
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
                            <li class="nav-item"><a class="nav-link fw-bold" aria-current="page" href="">Manage Users</a></li>
                            <li class="nav-item"><a class="nav-link" href="ticket.php">Tickets</a></li>
                            <a href="?logout=true" class="btn btn-primary rounded-pill px-4">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- User Management -->
    <div class="container mt-5">
        <h1>User Management</h1>
        <div class="row">
            <div class="col-md-12">
<!-- Pending Users Table -->
                <div class="container mt-4">
                <h2 class="text-center">Pending Users</h2>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col-6">Student Number/ Teacher Number</th>
                                <th>Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['student_number']); ?></td>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td>
                            <?php if (!empty($row['cor']) && $_SESSION['is_admin'] == 1): ?>
                                            <a href="view_file.php?user_id=<?php echo urlencode($row['user_id']); ?>" class="btn btn-info btn-sm mb-2" target="_blank">View COR</a>
                                        <?php endif; ?>
                                    <a href="approve_user.php?user_id=<?php echo $row['user_id']; ?>" class="btn btn-success btn-sm mb-2">Approve</a>
                                    <a href="delete_user.php?user_id=<?php echo $row['user_id']; ?>" class="btn btn-danger btn-sm mb-2">Reject</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
<!-- Active Users Table -->
                <div class="container mt-4">
                <h2 class="text-center">Active Users</h2>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Student Number/ Teacher Number</th>
                                <th>Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Fetch and display active users from the database -->
                            <?php
                            $query = "SELECT user_id, student_number, username, email FROM users WHERE status = 'approved'";
                            $result = $conn->query($query);
                            while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['student_number']); ?></td>
                                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td>
                                        <a href="edit_user.php?user_id=<?php echo $row['user_id']; ?>" class="btn btn-primary btn-sm mb-2">Edit</a>
                                        <a href="delete_user.php?user_id=<?php echo $row['user_id']; ?>" class="btn btn-danger btn-sm mb-2">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>