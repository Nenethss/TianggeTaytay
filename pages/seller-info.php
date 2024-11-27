<?php
include("../server/fetchinformation.php");
include("../server/fetchstoreinfo.php");
$username = htmlspecialchars($seller['username'] ?? 'N/A');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Tiangge Taytay</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../style/navandfoot.css">
    <link rel="stylesheet" href="../style/storeinfo.css">
    <link rel="stylesheet" href="../style/seller-info.css">
</head>

<style>
.hidden {
    display: none;
}

.basic-info {
    display: flex;
    width: 100%;
    justify-content: space-between;
}

.basic-info input {
    width: 100%;
}

.basic-info div {
    display: flex;
    width: 32%;
    flex-direction: column;
}

.edit-container img {
    width: 15px;
    height: 15px;
}

#updateInfo h2 {
    font-size: 22px;
    margin-bottom: 16px;
    color: #0033a0;
    text-align: left !important;
}
</style>

<body>

    <nav class="navbar">
        <div class="left-side">
            <a href="seller.php"><img src="../assets/shoppingbag.png" alt=""></a>
            <div class="input-with-icon">
                <img class="search-icon" src="../assets/Vector.png" alt="">
                <input type="text" placeholder="Search for Products...">
            </div>
        </div>
        <div class="right-side">
            <ul>
                <li class="selected"><a href="#">Home</a></li>
                <li><a href="about.php" target="_blank">About</a></li>
                <li><a href="products.php" target="_blank">Products</a></li>
                <li><a href="store.php" target="_blank">Store</a></li>
                <li><a href="contact.php" target="_blank">Contact us</a></li>
            </ul>
        </div>


        <div class="dropdown-container" id="dropdown">
            <!-- Store Image -->
            <img style="border-radius: 50px; width: 60px; height: 60px;" src="<?php echo $store_img; ?>"
                alt="Store Image">
            <!-- Arrow Icon -->
            <img id="arrow" style="width: 20px; height: 20px; transform: rotate(90deg);"
                src="../assets/arrowrightblack.png" alt="">
        </div>

        <!-- Dropdown Menu -->
        <div class="dropdown-menu" id="dropdown-menu">
            <a href="#"><?php echo $store_name; ?></a>
            <a href="seller-info.php">Manage Account</a>
            <a href="store-info.php">Manage Store</a>
            <a style="color: red;" href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="main">
        <div class="sidebar">
            <a href="#" class="active">Manage Account</a>
            <a href="store-info.php">Manage Store</a>
        </div>
        <div class="">
            <div class="rounded-box" id="accountInfo">
                <div class="section">
                    <div class="section-header">
                        <h2>Account Information</h2>
                        <button class="edit-btn">
                            <img src="../assets/pencil.svg" alt="Edit">
                            Edit
                        </button>
                    </div>
                    <div class="info-row">
                        <div class="info-group">
                            <div><strong>Username</strong></div>
                            <p id="username"><?= $username; ?></p>
                        </div>
                        <div class="info-group">
                            <div><strong>Email</strong></div>
                            <p><?php echo htmlspecialchars($seller['seller_email'] ?? 'N/A'); ?></p>
                        </div>
                    </div>
                    <div class="info-group">
                        <div><strong>Password</strong></div>
                        <p>
                            <?php 
                        $password = $seller['password'] ?? 'N/A';
                        $maskedPassword = str_repeat('•', strlen($password));
                        echo htmlspecialchars($maskedPassword);
                        ?>
                        </p>
                    </div>
                </div>
            </div>

            <div id="personalInfo" class="rounded-box">
                <div class="section">
                    <div class="section-header">
                        <h2>Personal Information</h2>
                        <button class="edit-btn">
                            <img src="../assets/pencil.svg" alt="Edit">
                            Edit
                        </button>
                    </div>
                    <div class="info-row">
                        <div class="info-group">
                            <div><strong>First Name</strong></div>
                            <p><?php echo htmlspecialchars($seller['first_name'] ?? 'N/A'); ?></p>
                        </div>
                        <div class="info-group">
                            <div><strong>Last Name</strong></div>
                            <p><?php echo htmlspecialchars($seller['last_name'] ?? 'N/A'); ?></p>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-group">
                            <div><strong>Middle Name</strong></div>
                            <p><?php echo htmlspecialchars($seller['middle_name'] ?? 'N/A'); ?></p>
                        </div>
                        <div class="info-group">
                            <div><strong>Contact Number</strong></div>
                            <p><?php echo htmlspecialchars($seller['seller_contact'] ?? 'N/A'); ?></p>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-group">
                            <div><strong>Birthday</strong></div>
                            <p><?php echo htmlspecialchars($seller['birthday'] ?? 'N/A'); ?></p>
                        </div>
                        <div class="info-group">
                            <div><strong>Age</strong></div>
                            <p><?php echo htmlspecialchars($seller['age'] ?? 'N/A'); ?></p>
                        </div>
                    </div>
                    <div class="info-group">
                        <div><strong>Address</strong></div>
                        <p><?php echo htmlspecialchars(($seller['houseno'] ?? '') . ' ' . ($seller['baranggay'] ?? '') . ' ' . ($seller['municipality'] ?? '') . ' ' . ($seller['province'] ?? '') ?: 'N/A'); ?>
                        </p>

                    </div>
                </div>
            </div>

            <form class="hidden" id="updateInfo" method="POST" action="../server/updateSeller.php">
                <input type="hidden" name="username" value="<?= htmlspecialchars($username); ?>">
                <h2>Personal Information</h2>
                <div class="basic-info">
                    <div>
                        <label for="firstname">First Name</label>
                        <input type="text" name="firstname" id="firstname"
                            value="<?= htmlspecialchars($seller['first_name'] ?? ''); ?>" required>
                    </div>
                    <div>
                        <label for="middlename">Middle Name (Optional)</label>
                        <input type="text" name="middlename" id="middlename"
                            value="<?= htmlspecialchars($seller['middle_name'] ?? ''); ?>">
                    </div>
                    <div>
                        <label for="lastname">Surname</label>
                        <input type="text" name="lastname" id="lastname"
                            value="<?= htmlspecialchars($seller['last_name'] ?? ''); ?>" required>
                    </div>
                </div>
                <div class="basic-info">
                    <div>
                        <label for="contact">Contact</label>
                        <input type="text" name="contact" id="contact"
                            value="<?= htmlspecialchars($seller['seller_contact'] ?? ''); ?>" required>
                    </div>
                    <div>
                        <label for="birthday">Birthday</label>
                        <input type="date" name="birthday" id="birthday"
                            value="<?= htmlspecialchars($seller['birthday'] ?? ''); ?>" required>
                    </div>
                    <div>
                        <label for="age">Age</label>
                        <input type="number" name="age" id="age" value="<?= htmlspecialchars($seller['age'] ?? ''); ?>"
                            required>
                    </div>
                </div>
                <div class="basic-info">
                    <div>
                        <label for="province">Province</label>
                        <input type="text" name="province" id="province"
                            value="<?= htmlspecialchars($seller['province'] ?? ''); ?>" required>
                    </div>
                    <div>
                        <label for="municipality">Municipality</label>
                        <input type="text" name="municipality" id="municipality"
                            value="<?= htmlspecialchars($seller['municipality'] ?? ''); ?>" required>
                    </div>
                    <div>
                        <label for="baranggay">Baranggay</label>
                        <input type="text" name="baranggay" id="baranggay"
                            value="<?= htmlspecialchars($seller['baranggay'] ?? ''); ?>" required>
                    </div>
                </div>
                <div>
                    <label for="houseno">House No.</label>
                    <input type="text" name="houseno" id="houseno"
                        value="<?= htmlspecialchars($seller['houseno'] ?? ''); ?>" required>
                </div>
                <div class="add-button">
                    <button style="margin-right: 20px;" type="button" id="cancelButton">Cancel</button>
                    <button type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <div class="top-footer">
            <div class="footer-logo">
                <img src="../assets/tianggeportal.png" alt="">
                <p>Find quality clothes and<br> garments in Taytay Tiangge<br> anytime and anywhere you are!</p>
            </div>

            <div class="footer-info">
                <h4 class="first-category">Information</h4>
                <ul>
                    <li><a href="about.php">About</a></li>
                    <li><a href="terms.php">Terms & Conditions</a></li>
                    <li><a href="privacy.php">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="footer-info">
                <h4 class="second-category">Categories</h4>
                <ul>
                    <li><a href="products.php">Men's Fashion</a></li>
                    <li><a href="products.php">Women's Fashion</a></li>
                    <li><a href="products.php">Kid's</a></li>
                </ul>
                <div class="footer-products-shortcut">
                    <a style="color: #029f6f;" href="products.php">Find More</a> <img src="../assets/greenright.png"
                        alt="">
                </div>
            </div>
            <div class="footer-info">
                <h4 class="third-category">Help & Support</h4>
                <ul>
                    <li><a href="contact.php">Contact Us</a></li>
                </ul>
            </div>
        </div>
        <div class="bottom-footer">
            <p>e-Tiangge Portal © 2024.<br>
                All Rights Reserved.</p>
            <img src="../assets/municipalitylogo.png" alt="">
            <img src="../assets/smiletaytay.png" alt="">
        </div>
    </footer>


    <script src="../script/drop-down.js"></script>
    <script src="../script/formshow.js"></script>
</body>

</html>