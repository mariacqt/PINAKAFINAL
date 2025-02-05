<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements - HM Kitchen Tools</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="landingstyle.css?v=2">
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
                            <li class="nav-item"><a class="nav-link text-white fw-bold" href="#">Home</a></li>
                            <li class="nav-item"><a href="about.php" class="nav-link text-white">About Us</a></li>
                            <li class="nav-item"><a href="tools.php" class="nav-link text-white">Borrow Tools</a></li>
                            <li class="nav-item"><a href="contact.php" class="nav-link text-white">Contact</a></li>
                        </ul>
                    </div>
                    <div class="icons">
                        <div id="account-icon" data-bs-toggle="modal" data-bs-target="#accountModal">
                        <a href="login.php" class="btn btn-primary rounded-pill px-4">Login</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section bg-primary text-white text-center py-5">
        <div class="container">
            <h1 class="display-4 fw-bold">Latest Announcements</h1>
            <p class="lead">Stay updated with the latest news, updates, and events from HM Kitchen Tools!</p>
        </div>
    </section>

    <!-- Search and Featured Announcements -->
    <div class="container my-5">
        <div class="row">
            <!-- Search Bar -->
            <div class="col-md-12 mb-4">
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search announcements..." aria-label="Search">
                    <button class="btn btn-primary" type="submit">Search</button>
                </form>
            </div>
        </div>

        <!-- Featured Announcements -->
        <div class="row">
            <div class="col-12">
                <h2 class="fw-bold mb-4">Featured Announcement</h2>
                <div class="card mb-4 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="images/announcement-featured.jpg" class="img-fluid rounded-start" alt="Featured Announcement">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">New Kitchen Tools Added to the Inventory</h5>
                                <p class="card-text">We’re excited to announce the addition of new tools to our inventory! Borrow the latest cooking equipment to enhance your culinary experience.</p>
                                <p class="card-text"><small class="text-muted">Posted on January 15, 2025</small></p>
                                <a href="#" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Announcements List -->
    <div class="container my-5">
        <h2 class="fw-bold mb-4">All Announcements</h2>
        <div class="row">
            <!-- Announcement Item -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Reminder: Return Borrowed Tools on Time</h5>
                        <p class="card-text">Please ensure all borrowed tools are returned by the due date to avoid penalties.</p>
                        <p class="card-text"><small class="text-muted">Posted on January 10, 2025</small></p>
                        <a href="#" class="btn btn-outline-primary btn-sm">Read More</a>
       
