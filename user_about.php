<?php
session_start();
require 'conn.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - HM Kitchen Tools</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/landingstyle.css?v=2">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
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
                            <li class="nav-item"><a class="nav-link text-white " href="user_home.php">Home</a></li>
                            <li class="nav-item"><a href="user_about.php" class="nav-link text-white fw-bold">About Us</a></li>
                            <li class="nav-item"><a href="user_tools.php" class="nav-link text-white">Borrow Tools</a></li>
                            <li class="nav-item"><a href="user_contact.php" class="nav-link text-white">Contact</a></li>
                            <li class="nav-item"><a href="user_tickets.php" class="nav-link text-white">My Tickets</a></li>
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
    <div class="text-center">
        <img src="images/about.jpg" class="img-fluid full-width-img shadow-sm" alt="Kitchen Tools">
    </div>
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
    <!-- About Us Section -->
    <div class="container my-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Our Team</h2>
            <p class="text-muted">Meet the talented individuals behind HM Kitchen Tools.</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-3 text-center">
                <div class="team-card shadow-sm p-3 mb-4">
                    <img src="images/raebv.jpg" alt="Raebv Lielmo Inocentes" class="img-fluid rounded-circle team-photo mb-3">
                    <h5>Raebv Lielmo Inocentes</h5>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="team-card shadow-sm p-3 mb-4">
                    <img src="images/heart.jpg" alt="Ma. Criselle Trinidad" class="img-fluid rounded-circle team-photo mb-3">
                    <h5>Ma. Criselle Trinidad</h5>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="team-card shadow-sm p-3 mb-4">
                    <img src="images/cama.jpg" alt="Paula Aliyah Cama" class="img-fluid rounded-circle team-photo mb-3">
                    <h5>Paula Aliyah Cama</h5>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="team-card shadow-sm p-3 mb-4">
                    <img src="images/mark.jpg" alt="Mark Reinier Garcia" class="img-fluid rounded-circle team-photo mb-3">
                    <h5>Mark Reinier Garcia</h5>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
