<?php
require('connect.php');
require('mysql-php-executions.php');

$id = $_GET['id'];

$response = [];
$productData = readData($conn, 'producttb', ['productid' => $id]);
$imagesData = readData($conn, 'product_img_tb', ['product_id' => $id]);
$images = [];

foreach ($imagesData['data'] as $image) {
    $images[] = base64_encode($image['img']);
}

// $result = updateData($connect, 'users', ['name' => 'Jane Doe', 'age' => 35], ['id' => 1]);

updateData($conn, "producttb", 
    ['views' => $productData['data'][0]['views'] + 1], 
    ['productid' => $id]
);


$response = [
    'success' => true,
    'message' => "Data fetched successfully",
    'product' => $productData["data"][0],
    'images' => $images
];

echo json_encode($response);
