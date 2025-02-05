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

// Fetch tools from the database
$sql = "SELECT * FROM tools"; // Adjust table name if necessary
$result = $conn->query($sql);

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
    <title>Inventory Management</title>
</head>
<body>
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
                            <li class="nav-item"><a class="nav-link fw-bold" href="">Inventory</a></li>
                            <li class="nav-item"><a class="nav-link" href="manageuser.php">Manage Users</a></li>
                            <li class="nav-item"><a class="nav-link" href="ticket.php">Tickets</a></li>
                            <a href="?logout=true" class="btn btn-primary rounded-pill px-4">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Inventory Management -->
    <div class="container mt-5">
        <h1>Inventory Management</h1>
        <div class="row">
            <div class="col-md-12">
                <!-- Inventory Table -->
                <div class="card mt-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Item Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<th scope='row'>" . $row['tool_id'] . "</th>";
                                        echo "<td>" . $row['tool_name'] . "</td>";
                                        echo "<td>" . $row['category'] . "</td>";
                                        echo "<td>" . $row['stock_quantity'] . "</td>";
                                        echo "<td>" . $row['status'] . "</td>";
                                        echo "<td>";
                                        echo "<button class='btn btn-primary btn-sm'>Edit</button> ";
                                        
                                        echo "<form action='delete_item.php' method='POST' style='display:inline-block;'>";
                                        echo "<input type='hidden' name='tool_id' value='" . $row['tool_id'] . "'>";
                                        echo "<button type='submit' class='btn btn-danger btn-sm'>Delete</button>";
                                        echo "</form>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center'>No inventory items found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Add Item Form -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Add New Item</h5>
                        <form action="add_item.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="itemName" class="form-label">Item Name</label>
                                <input type="text" class="form-control" id="itemName" name="tool_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <input type="text" class="form-control" id="category" name="category" required>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="stock_quantity" required>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="available">Available</option>
                                    <option value="out_of_stock">Out of Stock</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Item</button>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>

              
