<?php
require("connect.php");
require("mysql-php-executions.php");

$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
$typename = isset($_GET["type"]) ? $_GET["type"] : null;
$category = isset($_GET["category"]) ? $_GET["category"] : null;
$storename = isset($_GET["store"]) ? $_GET["store"] : null;
$max = isset($_GET["max"]) ? (int)$_GET["max"] : 12;

$page = max($page, 1); // Ensure page is at least 1
$offset = ($page - 1) * $max;
$conditions = [];

if ($typename) {
    $conditions["typename"] = $typename;
}

if ($category) {
    $conditions["category_name"] = $category;
}

if ($storename) {
    $conditions["storename"] = $storename;
}

// Fetch total records count
$total_response = readData($conn, "producttb", $conditions);
$total_records = count($total_response["data"]);

// Fetch paginated product data
$product_data = readData($conn, "producttb", $conditions, $max, $offset);
$products = [];

foreach ($product_data["data"] as $data) {
    $img_data = readData($conn, "product_img_tb", ["product_id" => $data["productid"]], 1)["data"][0];
    $product = [
        "product_id" => $data["productid"],
        "product_name" => $data["product_name"],
        "price" => $data["price"],
        "img" => $img_data["img"] ? base64_encode($img_data["img"]) : "default-image.jpg", // Use a default image path
    ];

    array_push($products, $product);
}

$response = [
    "success" => true,
    "data" => $products,
    "total_records" => $total_records,
    "pages" => ceil($total_records / $max),
    "page" => $page,
    "start" => $offset + 1,
    "end" => min($offset + $max, $total_records),
];

echo json_encode($response);
