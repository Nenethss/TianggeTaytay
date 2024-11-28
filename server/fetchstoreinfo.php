<?php


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
    SELECT seller.username, seller.password, store.storename, store.description, store.img, store.store_contact, seller.created_at, seller.seller_contact, seller.seller_email, store.store_email,
    seller.age, seller.birthday, seller.first_name, seller.middle_name, seller.last_name, seller.province, seller.municipality, seller.baranggay, seller.houseno 
    FROM storetb AS store
    JOIN sellertb AS seller ON store.sellerid = seller.seller_id
    WHERE seller.seller_id = :sellerid
");
$stmt->execute(['sellerid' => $seller_id]);
$store = $stmt->fetch(PDO::FETCH_ASSOC);

// Set default store info
$seller_username = html_entity_decode($store['username'] ?? 'No Store Found');
$seller_password = html_entity_decode($store['password']);
$store_name = html_entity_decode($store['storename'] ?? 'No Store Found');
$store_description = $store['description'] ?? 'No Description';
$store_img = isset($store['img']) ? 'data:image/png;base64,' . base64_encode($store['img']) : '../assets/storepic.png';
$store_contact = $store['store_contact'] ?? 'No Contact Info';
$store_email = $store['store_email'] ?? 'No Email';
$created_at = $store['created_at'] ?? 'N/A';
$seller_contact = $store['seller_contact'] ?? 'No Contact Info';
$seller_email = $store['seller_email'] ?? 'No Email';
$seller_age = $store['age'] ?? 'No Email';
$seller_birthday = $store['birthday'] ?? 'No Email';
$seller_fname = $store['first_name'] ?? 'No Email';
$seller_mname = $store['middle_name'] ?? 'No Email';
$seller_lname = $store['last_name'] ?? 'No Email';
$seller_province = $store['province'] ?? 'No Email';
$seller_municipality = $store['municipality'] ?? 'No Email';
$seller_baranggay = $store['baranggay'] ?? 'No Email';
$seller_houseno = $store['houseno'] ?? 'No Email';

// Fetch total number of products
$stmt = $conn->prepare("SELECT COUNT(*) AS total_products FROM producttb WHERE storename = :storename");
$stmt->execute(['storename' => $store_name]);
$product_count = $stmt->fetch(PDO::FETCH_ASSOC)['total_products'] ?? 0;

// Get the current page from the query string (default to 1 if not provided)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 12; // Set the number of items per page
$offset = ($page - 1) * $items_per_page; // Calculate the offset for the query

$current_page = $page;
// Query to fetch the products with pagination
$stmt = $conn->prepare("
    SELECT * FROM producttb WHERE storename = :storename LIMIT :limit OFFSET :offset
");
$stmt->bindParam(':storename', $store_name);
$stmt->bindParam(':limit', $items_per_page, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare an array to hold the product details along with the first image
$product_details = [];

foreach ($products as $product) {
    // Fetch the first image for the product (LIMIT 1)
    $stmt = $conn->prepare("
        SELECT img FROM product_img_tb WHERE product_id = :product_id LIMIT 1
    ");
    $stmt->execute(['product_id' => $product['productid']]);
    $image = $stmt->fetch(PDO::FETCH_ASSOC);

    // If an image exists, add it to the product data
    if ($image) {
        $product['first_image'] = $image['img']; // Store the first image's data
    } else {
        $product['first_image'] = null; // No image found
    }

    // Add the product data (with the first image) to the final result
    $product_details[] = $product;
}

// Query to get the total number of products (for pagination)
$total_stmt = $conn->prepare("SELECT COUNT(*) FROM producttb WHERE storename = :storename");
$total_stmt->execute(['storename' => $store_name]);
$total_products = $total_stmt->fetchColumn();
$total_pages = ceil($total_products / $items_per_page);

// Return product details and pagination information to the frontend
$response = [
    'product_details' => $product_details,
    'total_pages' => $total_pages,
    'current_page' => $page
];

// You can encode this into 



// Example of displaying product info with the first image


// Fetch categories
$stmt = $conn->prepare("SELECT categoryid, category_name FROM categorytb");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch product types
$stmt = $conn->prepare("SELECT typeid, typename FROM producttypetb");
$stmt->execute();
$product_types = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch stall numbers based on storename
// Fetch stall number(s) for the given store
$stmt = $conn->prepare("SELECT stallnumber FROM stalltb WHERE storename = :storename");
$stmt->execute(['storename' => $store_name]);
$stalls = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if there are stalls, and store them in a variable
$stallNumbers = [];
if (!empty($stalls)) {
    foreach ($stalls as $stall) {
        $stallNumbers[] = htmlspecialchars($stall['stallnumber']);
    }
} else {
    $stallNumbers[] = 'No Stall Found';
}


$query = "SELECT lazada, shopee FROM storetb WHERE storename = :storename";
$stmt = $conn->prepare($query);
$stmt->bindParam(':storename', $store_name, PDO::PARAM_STR);
$stmt->execute();
$store = $stmt->fetch(PDO::FETCH_ASSOC);

$lazada_field = $store['lazada'] ?? null;
$shopee_field = $store['shopee'] ?? null;

$query = "SELECT status FROM sellertb WHERE seller_id = :seller_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':seller_id', $seller_id, PDO::PARAM_INT);
$stmt->execute();
$seller = $stmt->fetch(PDO::FETCH_ASSOC);

$status = $seller['status'] ?? null; // Get the status or default to null

?>