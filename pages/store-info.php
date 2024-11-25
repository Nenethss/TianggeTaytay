<?php
// Start session
session_start();
include_once '../server/connect.php';

// Ensure the user is a seller
if (!isset($_SESSION['seller_id']) || $_SESSION['role'] !== 'seller') {
  header("Location: login.php");
  exit();
}

// Get seller_id from session
$seller_id = $_SESSION['seller_id'];

// Fetch store details
$stmt = $conn->prepare("
    SELECT store.storename, store.description,store.img, seller.created_at, seller.contact, seller.email
    FROM storetb AS store 
    JOIN sellertb AS seller ON store.sellerid = seller.seller_id
    WHERE seller.seller_id = :sellerid
");
$stmt->execute(['sellerid' => $seller_id]);
$store = $stmt->fetch(PDO::FETCH_ASSOC);

// Set default store info
$store_name = $store['storename'] ?? 'No Store Found';
$store_img = isset($store['img']) ? 'data:image/png;base64,' . base64_encode($store['img']) : '../assets/storepic.png';
$contact = $store['contact'] ?? 'No Contact Info';
$email = $store['email'] ?? 'No Email';
$store_name = $store['storename'] ?? 'No Store Found';
$created_at = $store['created_at'] ?? 'N/A';

// Fetch total number of products
$stmt = $conn->prepare("SELECT COUNT(*) AS total_products FROM producttb WHERE storename = :storename");
$stmt->execute(['storename' => $store_name]);
$product_count = $stmt->fetch(PDO::FETCH_ASSOC)['total_products'] ?? 0;

// Fetch all products for this store
$stmt = $conn->prepare("SELECT product_name, price, img FROM producttb WHERE storename = :storename");
$stmt->execute(['storename' => $store_name]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch categories
$stmt = $conn->prepare("SELECT categoryid, category_name FROM categorytb");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch product types
$stmt = $conn->prepare("SELECT typeid, typename FROM producttypetb");
$stmt->execute();
$product_types = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Account</title>
    <link rel="stylesheet" href="../style/store-info.css">
    <link rel="stylesheet" href="../style/navandfoot.css">
</head>

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
                <li><a href="seller.php">Home</a></li>
                <li><a href="about.php"target="_blank">About</a></li>
                <li><a href="products.php"target="_blank">Products</a></li>
                <li><a href="store.php"target="_blank">Store</a></li>
                <li><a href="contact.php"target="_blank">Contact us</a></li>
            </ul>
        </div>

        <div class="dropdown-container" id="dropdown">
            <!-- Store Image -->
            <img style="border-radius: 50px; width: 60px; height: 60px;" src="<?php echo $store_img; ?>" alt="Store Image">
            <!-- Arrow Icon -->
            <img id="arrow" style="width: 20px; height: 20px; transform: rotate(90deg);" src="../assets/arrowrightblack.png" alt="">
        </div>

        <!-- Dropdown Menu -->
        <div class="dropdown-menu" id="dropdown-menu">
            <a href="#"><?php echo $store_name; ?></a>
            <a href="seller-info.php">Manage Account</a>
            <a href="#">Manage Store</a>
            <a style="color: red;" href="logout.php">Logout</a>
        </div>
    </nav>


    <div id="productFormContainer" class="hidden">
  <form class="product-form" id="addingForm" action="../server/add_product.php" method="POST" enctype="multipart/form-data">
    <!-- Close Button -->
    <img src="../assets/close.png" id="closeFormButton" class="close-btn" alt="Close">
    
    <label>Product Name</label>
    <input type="text" name="product_name" required>
    
    <label>Product Description</label>
    <input type="text" name="description" required>
    
    <label>Price</label>
    <input type="text" name="price" required>
    
    <label>Category</label>
    <select name="category" id="category">
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['categoryid']; ?>"><?php echo htmlspecialchars($category['category_name']); ?></option>
            <?php endforeach; ?>
    </select>
    
    <label>Type</label>
    <select name="type" id="type">
            <?php foreach ($product_types as $type): ?>
                <option value="<?php echo $type['typeid']; ?>"><?php echo htmlspecialchars($type['typename']); ?></option>
            <?php endforeach; ?>
    </select>
    
    <label>Product Image</label>
    <div class="file-container">
    <input type="file" name="product_img" required>
    </div>
    
    <label>Link on Shopee</label>
    <input type="url" name="shopee_link">
    
    <label>Link on Lazada</label>
    <input type="url" name="lazada_link">
    
    <div class="add-button">
    <button type="submit">Add Product</button>
    </div>
  </form>
</div>

 

<div class="main-content">
<div class="sidebar">
    <a href="#">Manage Account</a>
    <a href="seller-info.php" class="active">Manage Store</a>
    </div>
    <!-- Account Info Section -->
    <div class="account-info">
        <div class="store-info-card">
            <img style="border-radius: 50px; width: 100px; height: 100px;" src="<?php echo $store_img; ?>" alt="Store Image">
            <p style="font-weight: 600;"><?php echo $store_name; ?></p>
        </div>
        <div class="info-card middle-info-card">
          <div class="info"><img src="../assets/shipment-box.png" alt=""><p>Products: <strong><?php echo $product_count; ?></strong></p></div>
          <div class="info"><img src="../assets/joined.png" alt=""><p>Created At: <strong><?php echo $created_at; ?></strong></p></div>       
        </div>
        <div class="info-card">
          <div class="info"><img src="../assets/telephone.png" alt=""><p>Contact: <strong><?php echo $contact; ?></strong></p></div>
          <div class="info"><img src="../assets/thread.png" alt=""><p>Email: <strong><?php echo $email; ?></strong></p></div>
        </div>
    </div>

    <!-- Divider -->
    <div class="divider">
        <div></div>
    </div>

    <!-- Products Section -->
    <div class="main-products-container">
        <div class="child-container">
          <div class="header-container">
          <h2>MY PRODUCTS</h2>
          <button id="showFormButton">Add Product</button>
        </div>

            <div class="products-container">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <img src="<?php echo isset($product['img']) ? 'data:image/png;base64,' . base64_encode($product['img']) : '../assets/default-product.png'; ?>" alt="Product Image">
                            <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                            <p>₱<?php echo htmlspecialchars($product['price']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No products found for this store.</p>
                <?php endif; ?>
            </div>
        </div>
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

    <script src="../script/drop-down.js"></script>
    <script src="../script/form-show.js"></script>
</body>
</html>

