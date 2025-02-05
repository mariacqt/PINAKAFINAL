<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - HM Kitchen Tools</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/about.css?v=2">
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
                            <li class="nav-item"><a class="nav-link text-white" href="index.php">Home</a></li>
                            <li class="nav-item"><a href="about.php" class="nav-link text-white fw-bold">About Us</a></li>
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

    <div class="text-center">
        <img src="images/about.jpg" class="img-fluid full-width-img shadow-sm" alt="Kitchen Tools">
    </div>

    <!-- About Us Section -->
    <div class="container my-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Our Team</h2>
            <p class="text-muted">Meet the talented individuals behind HM Kitchen Tools.</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 text-center mb-4">
                <div class="team-card shadow-sm p-3">
                    <img src="images/raebv.jpg" alt="Raebv Lielmo Inocentes" class="img-fluid rounded-circle team-photo mb-3">
                    <h5>Raebv Lielmo Inocentes</h5>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 text-center mb-4">
                <div class="team-card shadow-sm p-3">
                    <img src="images/heart.jpg" alt="Ma. Criselle Trinidad" class="img-fluid rounded-circle team-photo mb-3">
                    <h5>Ma. Criselle Trinidad</h5>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 text-center mb-4">
                <div class="team-card shadow-sm p-3">
                    <img src="images/cama.jpg" alt="Paula Aliyah Cama" class="img-fluid rounded-circle team-photo mb-3">
                    <h5>Paula Aliyah Cama</h5>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 text-center mb-4">
                <div class="team-card shadow-sm p-3">
                    <img src="images/avatar.jpg" alt="Mark Reinier Garcia" class="img-fluid rounded-circle team-photo mb-3">
                    <h5>Mark Reinier Garcia</h5>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>