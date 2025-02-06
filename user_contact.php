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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/landingstyle.css?v=2">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <title>Contact Us - PUP Hasmin</title>
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
                            <li class="nav-item"><a href="user_contact.php" class="nav-link text-white  fw-bold">Contact</a></li>
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
    <!-- Hero Section -->
    <section class="hero-section bg-primary text-white text-center py-5">
        <div class="container">
            <h1 class="display-4 fw-bold">Get in Touch with Us</h1>
            <p class="lead">Have questions or need assistance? We're here to help!</p>
        </div>
    </section>

    <!-- Contact Form Section -->
    <div class="container my-5">
        <div class="row">
            <!-- Contact Form -->
            <div class="col-md-6">
                <h2 class="fw-bold mb-4">Send Us a Message</h2>
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success" role="alert">
                        Your message has been sent successfully!
                    </div>
                <?php elseif (isset($_GET['error'])): ?>
                    <div class="alert alert-danger" role="alert">
                        There was an error sending your message. Please try again.
                    </div>
                <?php endif; ?>
                <form action="user_cont.php" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Your Full Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Your Email Address" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="4" placeholder="Your Message" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary px-4" name="btn-send">Send Message</button>
                </form>
            </div>

            <!-- Contact Details -->
            <div class="col-md-6">
                <h2 class="fw-bold mb-4">Contact Details</h2>
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                        <strong>Address:</strong> 372 Valencia PUP Hasmin Building, Sta. Mesa, Manila
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-phone text-primary me-2"></i>
                        <strong>Phone:</strong> +639171621854
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-envelope text-primary me-2"></i>
                        <strong>Email:</strong> hmkitcheninfo@gmail.com
                    </li>
                </ul>
        
            </div>
        </div>
    </div>
    <!-- Map Section -->
    <section class="map-section bg-light py-5">
        <div class="container text-center">
            <h2 class="fw-bold mb-4">Find Us Here</h2>
            <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3860.9721184604987!2d120.9993268758933!3d14.600664185885623!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c9e4f51e0271%3A0x98cd26e0cf20f440!2sPUP%20Hasmin%20Building!5e0!3m2!1sen!2sph!4v1738514507908!5m2!1sen!2sph" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
