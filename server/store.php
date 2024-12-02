<?php
require("connect.php");
require("mysql-php-executions.php");

$storename = $_GET["storename"];
$response = readData($conn, "storetb", ["storename" => $storename]);
$stallNumber = readData($conn, "stalltb", ["storename" => $storename]);
$product_count = countData($conn, "producttb", ["storename" => $storename]);

$response["data"]["0"]["img"] = base64_encode($response["data"]["0"]["img"]);
$response["data"]["0"]["product_count"] = $product_count;
$response["data"][0]["stall_numbers"] = implode(", ", array_map(function ($stall) {
    return $stall["stallnumber"];
}, $stallNumber["data"]));

echo json_encode($response);
