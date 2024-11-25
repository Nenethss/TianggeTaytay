<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/register.css">
    <link rel="stylesheet" href="../style/navandfoot.css">
    <title>e-Tiangge Taytay</title>
</head>
<body>

<div class="progress-container">
    <div class="progress-sub-container">
        <div class="progress-number">
            <div><p>1</p></div>
            <p>Account Credentials</p>
        </div>
        <div class="progress-number">
            <div><p>2</p></div>
            <p>Personal Information</p>
        </div>
        <div class="progress-number">
            <div><p>3</p></div>
            <p>Store Details</p>
        </div>
        <div class="progress-number">
            <div><p>4</p></div>
            <p>Agreement Section</p>
        </div>
    </div>
    <div class="progress-bar"></div>
</div>

<!-- Single Hero Text Section -->
<div id="heroText"class="hero-text active" id="hero-text">
    <h1 id="hero-title">Register</h1>
    <p id="hero-description" style="text-align: center;">Create your seller account to post and market your products!</p>
</div>

<div class="container">
    <form id="registrationForm" action="../server/save_registration.php" method="POST" enctype="multipart/form-data">
        <!-- Step 1 -->
        <div class="form-step active" id="step1">
            <h2>Account Information</h2>
            <label>Username</label>
            <input type="text" name="username" required>
            <label>Email</label>
            <input type="email" name="email" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" required>
            <div style="display: flex; justify-content: flex-end;" class="form-buttons">
                <button type="button" onclick="nextStep(1)">Next</button>
            </div>
        </div>
        
        <!-- Step 2: Personal Information -->
        <div class="form-step" id="step2">
            <h2>Personal Information</h2>
            <label>First Name</label>
            <input type="text" name="first_name" required>
            
            <label>Middle Name (Optional)</label>
            <input type="text" name="middle_name">
            
            <label>Last Name</label>
            <input type="text" name="last_name" required>
            
            <label>Contact Number</label>
            <input type="text" name="contact" required>
            
            <div style="display: flex; justify-content: space-between;">
            <div style="width: 50%;">
            <label>Birthday</label>
            <input type="date" name="birthday" required>
            </div>
            <div>
            <label>Age</label>
            <input type="number" name="age" required>
            </div>
            
            </div>
            
            <label>Address</label>
            <input type="text" name="address" required>
            
            <div class="form-buttons">
                <button class="back-button" type="button" onclick="previousStep(2)">Back</button>
                <a href="#heroText"><button type="button" onclick="nextStep(2)">Next</button></a>
            </div>
        </div>
        
        <!-- Step 3: Store Details -->
        <div class="form-step" id="step3">
            <h2>Store Details</h2>
            <label>Store Name</label>
            <input type="text" name="store_name" required>
            
            <label>Upload Business Permit</label>
            <input type="file" name="business_permit" required>
            
            <label>Link Your Shopee Account</label>
            <input type="url" name="shopee_link">
            
            <label>Link Your Lazada Account</label>
            <input type="url" name="lazada_link">
            
            <div class="form-buttons">
                <button class="back-button" type="button" onclick="previousStep(3)">Back</button>
                <button type="button" onclick="nextStep(3)">Next</button>
            </div>
        </div>
        
        <!-- Step 4: Agreement -->
        <div class="form-step" id="step4">
            <h2>Agreement Section</h2>
            <p class="text-desc">I agree to the Terms and Conditions and acknowledge that my personal data will be collected, stored, and processed in accordance with the Privacy Policy. By checking the box below, I confirm that I have read, understood, and accept these terms.</p>
            
            <div class="checkbox-container">
            <input class="checkbox" type="checkbox" name="agreement" required> 
            <p>By checking this box, I acknowledge and agree to the above statementm</p>
            </div>
            
            <div class="form-buttons">
                <button class="back-button" type="button" onclick="previousStep(4)">Back</button>
                <a href="#progressContainer"><button type="submit">Submit</button></a>
            </div>
        </div>
        
        <!-- Step 5: Success (Optional, displayed after submission) -->
        <div class="form-step" id="step5">
            <h4 style="margin-bottom: 20px;">Thank you for your interest in joining the E-Tiangge Portal!</h4>
            <p style="text-align: justify; font-size: 17px; font-weight: 450;">Your registration has been received successfully. Please wait while we review and verify your information. You will receive a confirmation email once your account is approved and ready to post products. We appreciate your patience and look forward to having you as part of our community!</p>
        </div>
    </form>
</div>


<div class="home-btn-container">
        
        <a href="home.php"><img src="../assets/arrowrightblack.png" alt="">Return to Homepage</a>
    
</div>

<div class="divider">
        <div></div>
</div>

<div class="login-shorcut-container">
        
        <p>Already have an Account?</p><a href="login.php">Login Now</a>
    
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
                    <a style="color: #029f6f;" href="products.php">Find More</a> <img src="../assets/greenright.png" alt="">
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

<script src="../script/script.js"></script>

</body>
</html>
