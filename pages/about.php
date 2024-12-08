<?php
//map location to mga tols
$latitude = 14.557675;
$longitude = 121.132690;

//eto yugn initial zoom
$zoomLevel = 18;

include_once '../server/connect.php';

$sql = "SELECT systemlogo, about, uv, jeep, mrt, uv_bus, ride_apps FROM systeminfo WHERE id = 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Tiangge Taytay</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="../style/about.css">
    <link rel="stylesheet" href="../style/navandfoot.css">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets//favicon-32x32.png">

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

</head>

<body>

    <div class="register">
        <p>Become a Seller? <a href="register.php">Register Now</a></p>
    </div>

    <!-- Navbar Section -->
    <nav class="navbar">
        <div class="left-side">
            <a href="#"><img src="../assets/shoppingbag.png" alt=""></a>
            <div class="input-with-icon">
                <img class="search-icon" src="../assets/Vector.png" alt="">
                <input type="text" placeholder="Search for Products...">
            </div>
        </div>
        <div class="right-side">
            <ul>
                <li><a href="home.php">Home</a></li>
                <li class="selected"><a href="about.php">About</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="store.php">Store</a></li>
                <li><a href="contact.php">Contact us</a></li>
            </ul>
        </div>
    </nav>


    <section class="terms-conditions">
    <section class="terms-conditions privacy">
        <?= html_entity_decode($data['about']) ?>
    </section>
        <div class="map-tiangge">
            <h1>HOW TO GO TO TAYTAY TIANGGE</h1>
            <div class="outer-container">
                <div class="map-container">
                    <div id="map"></div>
                </div>
            </div>
        </div>
        <div class="images">
            <!-- Clickable Images -->
            <img src="../assets/uv.png" onclick="showInfo('uv')" style="cursor: pointer;">
            <img src="../assets/jeep.png" onclick="showInfo('jeep')" style="cursor: pointer;">
            <img src="../assets/mrt.png" onclick="showInfo('mrt')" style="cursor: pointer;">
            <img src="../assets/uvbus.png" onclick="showInfo('bus')" style="cursor: pointer;">
            <img src="../assets/grab.png" onclick="showInfo('grab')" style="cursor: pointer;">
        </div>

        <!-- Info Sections -->
        <div id="uv-info" class="info-box" style="display: block;">
        <?= html_entity_decode($data['uv']) ?>
        </div>

        <div id="jeep-info" class="info-box" style="display: none;">
            <?= html_entity_decode($data['jeep']) ?>
        </div>

        <div id="mrt-info" class="info-box" style="display: none;">
        <?= html_entity_decode($data['mrt']) ?>
        </div>

        <div id="bus-info" class="info-box" style="display: none;">
        <?= html_entity_decode($data['uv_bus']) ?>
        </div>

        <div id="grab-info" class="info-box" style="display: none;">
        <?= html_entity_decode($data['ride_apps']) ?>
        </div>
    </section>

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

    <script>
    //Pang start nung map with coordinates
    var map = L.map('map').setView([<?php echo $latitude; ?>, <?php echo $longitude; ?>], <?php echo $zoomLevel; ?>);

    //tile layer
    //pede baguhin tile layer para sa ibang design
    //ewan ko kung pano ko nagamit gmaps ang alam ko may bayad to e hahaha
    L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
        attribution: '&copy; <a href="https://www.google.com/intl/en-US_US/help/terms_maps.html">Google Maps</a>'
    }).addTo(map);

    //marker sa map hehe
    var marker = L.marker([<?php echo $latitude; ?>, <?php echo $longitude; ?>]).addTo(map);

    // yung pop up pag nai click yung marker
    marker.bindPopup("<b>TAYTAY CAPITAL TIANGGE</b><br />HIGHWAY 2000, CORNER Market Rd, Taytay, 1920 Rizal");


    // JavaScript function to show the text when the UV image is clicked
    function showInfo(type) {
        // Hide all info boxes
        const allInfoBoxes = document.querySelectorAll('.info-box');
        allInfoBoxes.forEach((box) => {
            box.style.display = 'none';
        });

        // Show the specific info box
        const infoDiv = document.getElementById(type + '-info');
        infoDiv.style.display = 'block';
    }
    </script>
</body>

</html>