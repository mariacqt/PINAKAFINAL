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

// Fetch tools data from the database
$query_tools = "SELECT * FROM tools";
$result_tools = $conn->query($query_tools);
$tools = [];
if ($result_tools->num_rows > 0) {
    while ($row = $result_tools->fetch_assoc()) {
        $tools[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUP HM Kitchen</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/tools.css">
    <link rel="icon" href="icons/pup-logo.png" type="image/png">
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="icons/hm-pup.png" alt="Logo" style="width: 155px; height: 30px;">
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Search for tools...">
            <button>
                <img src="icons/search-icon.png" alt="Search Icon" class="search-icon">
            </button>
        </div>
        <div class="flex-container">
            <a href="user_home.php">Home</a>
            <a href="user_about.php">About Us</a>
            <a href=""><strong>Borrow Tools</strong></a>
            <a href="user_contact.php">Contact Us</a>
            <a href="user_tickets.php">My Tickets</a>
        </div>
        <div class="icons">
            <div id="account-icon" onclick="openAccount()">
                <img src="icons/user-icon.png" alt="Account Icon" style="width: 33px; height: 33px;">
            </div>
            <div id="cart-icon" onclick="openCart()">
                <img src="icons/basket-icon.png" alt="Cart Icon" style="width: 35px; height: 35px;">
                <span id="cart-count" class="cart-count">0</span> <!-- Added cart count -->
            </div>
        </div>
    </div>
    
    <div class="sidebar">
        <br> <br> <br>
        <h2>Filters &nbsp;<img src="icons/filter-icon.png" style="width: 20px; height: 20px;"> </h2>
        <div class="filter-group">
            <br>
            <h3>Availability</h3>
            <label><input type="checkbox"> In Stock</label>
            <label><input type="checkbox"> Out of Stock</label>
        </div>
        <div class="filter-group">
            <br>
            <h3>Categories</h3>
            <label><input type="checkbox"> Baking Tools</label>
            <label><input type="checkbox"> Bar Tools</label>
            <label><input type="checkbox"> Glassware</label> <!-- Ensure this matches the card description -->
            <label><input type="checkbox"> Kitchenware</label>
            <label><input type="checkbox"> Servingware</label>
            <label><input type="checkbox"> Silverware</label>
            <label><input type="checkbox"> Tableware</label>
            <span class="clear-btn" onclick="clearFilters()">Clear</span>
        </div>
    </div>
    <div class="content">
    <div class="grid">
        <?php foreach ($tools as $tool): ?>
            <div class="card">
                <img src="<?php echo $tool['image_url']; ?>" alt="<?php echo $tool['tool_name']; ?>">
                <p class="description"><?php echo $tool['category']; ?> | In Stock: <?php echo $tool['stock_quantity']; ?></p>
                <h3><?php echo $tool['tool_name']; ?></h3>
                <div class="quantity-selector">
                    <button onclick="decreaseQuantity(this)">-</button>
                    <span>1</span>
                    <button onclick="increaseQuantity(this)" <?php echo $tool['stock_quantity'] == 0 ? 'disabled' : ''; ?>>+</button>
                </div>
                <button class="add-to-cart-btn" onclick="addToCart('<?php echo $tool['category']; ?>', '<?php echo $tool['tool_name']; ?>', parseInt(this.previousElementSibling.querySelector('span').textContent), '<?php echo $tool['image_url']; ?>')" <?php echo $tool['stock_quantity'] == 0 ? 'disabled' : ''; ?>><?php echo $tool['stock_quantity'] == 0 ? 'Out of Stock' : 'Add to Basket'; ?></button>
            </div>
        <?php endforeach; ?>
    </div>
</div>
    </div>
    <div class="popup" id="cart-popup">
        <div class="popup-content">
            <h2>Your Basket</h2>
            <div id="cart-items"></div>
            <div id="total-items" style="text-align: center; margin-top: 20px;">
                <b>Items to be borrowed: <span id="total-quantity">0</b></span>
            </div>
            <button class="close" onclick="closeCart()">x</button>
            <button class="submit-rental-btn" onclick="submitRentalRequest()">Submit Borrow Request</button>
        </div>
    </div>

    <div class="popup" id="account-popup">
        <div class="popup-content">
            <h2>Account Information</h2>
            <div>
                <label for="student-name"><b>Student Name:</b></label>
                <span id="student-name"><?php echo htmlspecialchars($user['username']); ?></span>
            </div>
            <div>
                <label for="student-number"><b>Student Number:</b></label>
                <span id="student-number"><?php echo htmlspecialchars($user['student_number']); ?></span>
            </div>
            <div>
                <label for="email"><b>Email:</b></label>
                <span id="email"><?php echo htmlspecialchars($user['email']); ?></span>
            </div>
            <button class="logout-btn" onclick="confirmLogout()">Logout</button>
            <button class="close" onclick="closeAccount()">x</button>
        </div>
    </div>
    <div class="popup" id="terms-popup">
        <div class="popup-content">
            <h2>Terms & Conditions</h2>
            <h4 style="color: red;"> FAILURE TO COMPLY WILL LEAD TO REJECTION OF REQUEST.</h4>
            <p>▸ <b>DOUBLE CHECK YOUR LIST OF TOOLS BEFORE SUBMITTING YOUR REQUEST.</b></p>
            <p>▸ <b>STRICTLY 1 TRANSACTION AT A TIME, UNTIL COMPLETION:</b> Each user is strictly allowed one transaction ticket at a time, which must be fully completed before a new ticket can be issued.</p>
            <p>▸ <b>STRICTLY NO ID, NO PROCESSING:</b> Surrender your <b>PHYSICAL ID</b> and approved ticket to the GIS in-charge to receive borrowed items.</p>
            <p>▸ <b>FOR DAMAGED OR MISSING ITEMS:</b> The borrower is responsible for repair or replacement. Please discuss with the GIS in-charge to determine the steps.</p>
            <button class="cancel" onclick="closeTerms()">Cancel</button>
            <button class="confirm" onclick="proceedToForm()">Proceed</button>
        </div>
    </div>
    
 
    <div class="popup" id="form-popup">
        <div class="popup-content">
            <h2>Borrow Request Form</h2>
            <form action="submit_request.php" method="POST">
    <br>
    <label for="student-id">Student ID:</label>
    <input type="text" id="student-name" name="student-id" value="<?php echo htmlspecialchars($user['student_number']); ?>" readonly>
    
    <label for="student-name">Student Name:</label>
    <input type="text" id="student-id" name="student-name" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
    
    <label for="course-section">Course & Section:</label>
    <input type="text" id="course-section" name="course-section" placeholder="BSHM 1-1" required>
    
    <label for="subject">Subject:</label>
    <input type="text" id="subject" name="subject" placeholder="Enter a subject" required>
    
    <label for="professor">Professor:</label>
    <input type="text" id="professor" name="professor" placeholder="Dela Cruz, Juan B." required>
    
    <label>User Classification:</label>
    <div class="radio-buttons-container">
        <label><input type="radio" name="user-classification" value="HM Student" required> HM Student</label>
        <label><input type="radio" name="user-classification" value="Non-HM Student" required> Non-HM Student</label>
        <label><input type="radio" name="user-classification" value="PUP Employee" required> PUP Employee</label>
    </div>
    
    <label for="request-date">Borrowing Date:</label>
    <input type="date" id="request-date" name="borrowing-date" required>
    <input type="time" id="borrowing-time" name="borrowing-time" required>

    <label for="returning-date">Returning Date:</label>
    <input type="date" id="returning-date" name="returning-date" required>

    <input type="hidden" name="cart-data" id="cart-data" value='{"tool_name":"Example Tool","quantity":1}'>

    
    <input type="hidden" id="request-timestamp" name="request-timestamp">
    <button type="submit">Submit</button>
    <button type="button" onclick="closeForm()">Cancel</button>
</form>



        </div>
    </div>
    <div class="popup" id="confirmation-popup">
        <div class="popup-content">
            <h2>Confirmation</h2>
            <p id="confirmation-message"></p>
            <button class="cancel" onclick="closeConfirmation()">Cancel</button>
            <button class="confirm" onclick="confirmAction()">Confirm</button>
        </div>
    </div>
    <div class="popup" id="logout-confirmation-popup">
        <div class="popup-content">
            <h2>Logout Confirmation</h2>
            <p>Are you sure you want to logout?</p>
            <button class="cancel" onclick="closeLogoutConfirmation()">Cancel</button>
            <a href="?logout=true"></href><button class="confirm" onclick="logout()">Logout</button></a>
        </div>
    </div>

<script src="script.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let today = new Date();
    let tomorrow = new Date(today);
    tomorrow.setDate(today.getDate() + 1); // Set tomorrow as the borrowing date
    let tomorrowDate = tomorrow.toISOString().split("T")[0]; // Format tomorrow's date (YYYY-MM-DD)
    let todayTime = today.toTimeString().split(" ")[0].substring(0, 5); // Format time (HH:mm)

    // Define valid borrow time range (from 06:00 AM to 11:59 PM)
    let minTime = "06:00";
    let maxTime = "23:59";

    const borrowDateInput = document.getElementById("request-date");
    const borrowTimeInput = document.getElementById("borrowing-time");
    const returnDateInput = document.getElementById("returning-date");

    // Set the minimum and maximum value for borrowing date and return date to tomorrow
    borrowDateInput.value = tomorrowDate;
    borrowDateInput.setAttribute("min", tomorrowDate); // Restrict Borrowing Date to Tomorrow or Future
    returnDateInput.setAttribute("min", tomorrowDate); // Restrict Returning Date to Tomorrow or Future

    // Set the borrow time to be between 6:00 AM and 11:59 PM
    borrowTimeInput.setAttribute("min", minTime); // Borrow time can't be before 6:00 AM
    borrowTimeInput.setAttribute("max", maxTime); // Borrow time can't be after 11:59 PM

    // Set initial value for borrow time to 6:00 AM if it's before
    if (todayTime < minTime) {
        borrowTimeInput.value = minTime;
    } else {
        borrowTimeInput.value = todayTime;
    }

    // Ensure return date is not earlier than borrow date
    borrowDateInput.addEventListener("change", function () {
        returnDateInput.setAttribute("min", this.value); // Prevent return before borrow date
    });

    // Restrict return date if it's earlier than borrow date
    borrowDateInput.addEventListener("input", function () {
        if (this.value < tomorrowDate) this.value = tomorrowDate;
    });

    returnDateInput.addEventListener("input", function () {
        if (this.value < borrowDateInput.value) this.value = borrowDateInput.value;
    });
});

</script>







</body>
</html>



