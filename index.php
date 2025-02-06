<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HM Kitchen Tool</title>
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
                            <li class="nav-item"><a class="nav-link text-white fw-bold" href="#">Home</a></li>
                            <li class="nav-item"><a href="about.php" class="nav-link text-white">About Us</a></li>
                            <li class="nav-item"><a href="tools.php" class="nav-link text-white">Borrow Tools</a></li>
                            <li class="nav-item"><a href="contact.php" class="nav-link text-white">Contact</a></li>
                            <li class="nav-item d-lg-none"><a href="login.php" class="btn btn-primary rounded-pill px-4">Login</a></li>
                        </ul>
                    </div>
                    <div class="d-none d-lg-block">
                        <a href="login.php" class="btn btn-primary rounded-pill px-4">Login</a>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <!-- Hero Section -->
    <section class="hero text-center py-5 bg-light">
        <div class="container">
            <h1 class="display-5 fw-bold text-primary">Welcome to HM Kitchen Tools</h1>
            <p class="lead text-muted">Easily borrow and return kitchen tools with our user-friendly platform. Say goodbye to the hassle of borrowing kitchen tools.</p>
        </div>
    </section>
    
    <!-- Hero Image -->
    <div class="text-center">
        <img src="images/tools.png" class="img-fluid full-width-img shadow-lg rounded" alt="Kitchen Tools" id="tools">
    </div>
    <section class="announcements-section bg-white py-5">
        <div class="container">
            <h2 class="fw-bold text-center mb-4">Latest Announcements</h2>
            <div class="list-group">
                <div class="list-group-item list-group-item-action">
                    <h5 class="mb-1">New Kitchen Tools Added to Inventory</h5>
                    <p class="mb-1">Discover the latest kitchen tools available for borrowing now!</p>
                    <small>Posted on January 15, 2025</small>
                </div>
                <div class="list-group-item list-group-item-action">
                    <h5 class="mb-1">Scheduled Maintenance</h5>
                    <p class="mb-1">Our platform will undergo maintenance on January 20, 2025.</p>
                    <small>Posted on January 5, 2025</small>
                </div>
            </div>  
        </div>
    </section>
    <!-- Borrowing Section -->
    <section class="borrowing-section bg-light py-5 text-center position-relative">
        <div class="container">
            <h2 class="fw-bold mb-4">Start Borrowing Kitchen Tools Today</h2>
            <p class="text-muted mb-4">Explore our wide range of kitchen tools available for borrowing and make your cooking experience hassle-free.</p>
            <a href="tools.php" class="btn btn-primary px-4 py-2 rounded-pill">Browse Inventory</a>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section bg-white py-5">
        <div class="container text-center">
            <h2 class="fw-bold mb-4">Contact Us</h2>
            <p class="text-muted mb-5">Feel free to reach out to us for any inquiries or assistance regarding our kitchen tools inventory management system.</p>
            <div class="row g-4">
                <div class="col-12 col-md-4">
                    <div class="contact-item border p-4 rounded shadow-sm">
                        <i class="fas fa-envelope mb-3 text-primary" style="font-size: 40px;"></i>
                        <h3>Email</h3>
                        <p class="text-muted">We value your feedback and suggestions. Let us know how we can improve our services to better meet your needs.</p>
                        <p class="fw-bold">hmkitcheninfo@gmail.com</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="contact-item border p-4 rounded shadow-sm">
                        <i class="fas fa-phone mb-3 text-primary" style="font-size: 40px;"></i>
                        <h3>Phone</h3>
                        <p class="text-muted">For any technical support or issues with the system, please contact our support team for immediate assistance.</p>
                        <p class="fw-bold">+639171621854</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="contact-item border p-4 rounded shadow-sm">
                        <i class="fas fa-map-marker-alt mb-3 text-primary" style="font-size: 40px;"></i>
                        <h3>Office</h3>
                        <p class="text-muted">Stay connected with us on social media for updates, tips, and news related to kitchen tools and inventory management.</p>
                        <p class="fw-bold">372 Valencia PUP Hasmin Building, Sta. Mesa, Manila</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>