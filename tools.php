<?php
session_start();
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
    <script>
    function checkLogin() {
        <?php if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true): ?>
            alert("You need to login first.");
            return false;
        <?php else: ?>
            return true;
        <?php endif; ?>
    }

    function addToBasket(category, name, quantity, img) {
        if (!checkLogin()) return;
        // Code to add item to basket
        alert("You need to login first");
    }

    function filterCards() {
        if (!checkLogin()) return;
        // Code to filter cards
    }
    </script>
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
            <a href="index.php">Home</a>
            <a href="about.php">About Us</a>
            <a href="">Borrow Tools</a>
            <a href="contact.php">Contact Us</a>
        </div>
        <div class="icons">
            <div id="account-icon" data-bs-toggle="modal" data-bs-target="#accountModal">
                <a href="login.php" class="btn-rounded-pill">Login</a>
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
            <label><input type="checkbox" onclick="filterCards()"> In Stock</label>
            <label><input type="checkbox" onclick="filterCards()"> Out of Stock</label>
        </div>
        <div class="filter-group">
            <br>
            <h3>Categories</h3>
            <label><input type="checkbox" onclick="filterCards()"> Baking Tools</label>
            <label><input type="checkbox" onclick="filterCards()"> Bar Tools</label>
            <label><input type="checkbox" onclick="filterCards()"> Glassware</label> <!-- Ensure this matches the card description -->
            <label><input type="checkbox" onclick="filterCards()"> Kitchenware</label>
            <label><input type="checkbox" onclick="filterCards()"> Servingware</label>
        </div>
    </div>

    <div class="content">
        <div class="grid">
            <?php
            require 'conn.php'; // Include the database connection
            $sql = "SELECT * FROM tools";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card">';
                    echo '<img src="' . $row['image_url'] . '" alt="' . $row['tool_name'] . '">';
                    echo '<p class="description">' . $row['category'] . ' | In Stock: ' . $row['stock_quantity'] . '</p>';
                    echo '<h3>' . $row['tool_name'] . '</h3>';
                    echo '<div class="quantity-selector">';
                    echo '<button onclick="decreaseQuantity(this)">-</button>';
                    echo '<span>1</span>';
                    echo '<button onclick="increaseQuantity(this)">+</button>';
                    echo '</div>';
                    echo '<button class="add-to-cart-btn" onclick="addToBasket(\'' . $row['category'] . '\', \'' . $row['tool_name'] . '\', parseInt(this.previousElementSibling.querySelector(\'span\').textContent), \'' . $row['image_url'] . '\')">Add to Basket</button>';
                    echo '</div>';
                }
            } else {
                echo '<p>No tools found in inventory.</p>';
            }
            $conn->close();
            ?>
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

<script src="script.js" defer></script>
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
        
            // ✅ Ensure Borrowing Time is between 5:00 AM and 11:59 PM
            borrowTimeInput.addEventListener("input", function () {
                let time = this.value;
                if (time < "05:00" || time > "23:59") {
                    alert("You can only borrow between 5:00 AM and 11:59 PM.");
                    this.value = "05:00"; // Default to 5:00 AM if invalid
                }
            });
        
            // ✅ Ensure Returning Time is at least 30 minutes after Borrowing Time
            returnTimeInput.addEventListener("input", function () {
                if (returnDateInput.value === borrowDateInput.value) { // Same day return
                    let borrowTime = borrowTimeInput.value;
                    let returnTime = returnTimeInput.value;
        
                    if (returnTime <= borrowTime) {
                        alert("Returning time must be at least 30 minutes after borrowing time.");
                        this.value = "";
                    }
                }
            });
        });

</script>
</body>
</html>