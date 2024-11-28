<?php
session_start();
include_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the seller is logged in
    if (!isset($_SESSION['seller_id'])) {
        header("Location: ../seller/login.php");
        exit();
    }

    // Get seller_id from session
    $seller_id = $_SESSION['seller_id'];

    // Fetch store_name for the current seller
    $stmt = $conn->prepare("SELECT storename FROM storetb WHERE sellerid = :sellerid");
    $stmt->execute(['sellerid' => $seller_id]);
    $store_name = $stmt->fetchColumn(); // Fetch the storename directly

    if (!$store_name) {
        die("Error: No store found for the logged-in seller.");
    }

    // Collect form data
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category'];
    $type_id = $_POST['type'];
    $shopee_link = $_POST['shopee_link'];
    $lazada_link = $_POST['lazada_link'];

    // Fetch category_name and typename
    $stmt = $conn->prepare("SELECT category_name FROM categorytb WHERE categoryid = :categoryid");
    $stmt->execute(['categoryid' => $category_id]);
    $category_name = $stmt->fetchColumn();

    $stmt = $conn->prepare("SELECT typename FROM producttypetb WHERE typeid = :typeid");
    $stmt->execute(['typeid' => $type_id]);
    $typename = $stmt->fetchColumn();

    // Insert product into the database
    $stmt = $conn->prepare("
        INSERT INTO producttb (product_name, category_name, typename, price, lazada_link, shopee_link, storename)
        VALUES (:product_name, :category_name, :typename, :price, :lazada_link, :shopee_link, :storename)
    ");
    $stmt->execute([
        'product_name' => $product_name,
        'category_name' => $category_name,
        'typename' => $typename,
        'price' => $price,
        'lazada_link' => $lazada_link,
        'shopee_link' => $shopee_link,
        'storename' => $store_name
    ]);

    // Get the inserted product's ID
    $product_id = $conn->lastInsertId();

    // Handle multiple image uploads
    if (!empty($_FILES['product_imgs']['name'][0])) {
        $stmt = $conn->prepare("
            INSERT INTO product_img_tb (product_id, img)
            VALUES (:product_id, :img)
        ");

        foreach ($_FILES['product_imgs']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['product_imgs']['error'][$key] === UPLOAD_ERR_OK) {
                $image_blob = file_get_contents($tmp_name);

                // Insert the image into the product_images table
                $stmt->execute([
                    'product_id' => $product_id,
                    'img' => $image_blob
                ]);
            }
        }
    }

    // Redirect back to the store-info page
    header("Location: ../pages/store-info.php");
    exit();
}
