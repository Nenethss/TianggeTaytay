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
    SELECT store.storename, store.description, store.img, store.store_contact, seller.created_at, seller.seller_contact, seller.seller_email, store.store_email
    FROM storetb AS store
    JOIN sellertb AS seller ON store.sellerid = seller.seller_id
    WHERE seller.seller_id = :sellerid
");
$stmt->execute(['sellerid' => $seller_id]);
$store = $stmt->fetch(PDO::FETCH_ASSOC);

// Set default store info
$store_name = html_entity_decode($store['storename'] ?? 'No Store Found');
$store_description = $store['description'] ?? 'No Description';
$store_img = isset($store['img']) ? 'data:image/png;base64,' . base64_encode($store['img']) : '../assets/storepic.png';
$store_contact = $store['store_contact'] ?? 'No Contact Info';
$store_email = $store['store_email'] ?? 'No Email';
$created_at = $store['created_at'] ?? 'N/A';
$seller_contact = $store['seller_contact'] ?? 'No Contact Info';
$seller_email = $store['seller_email'] ?? 'No Email';

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


?>