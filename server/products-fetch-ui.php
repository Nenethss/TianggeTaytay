<?php
require("connect.php");
require("mysql-php-executions.php");

$component = $_GET["component"];

$response = ["success" => false, "message" => "Failed to read data", "data" => []];

if ($component == "category") {
    $categories_data = readData($conn, "categorytb");
    $categories = [];
    $response = [];

    foreach ($categories_data["data"] as $category) {
        $category_name = $category["category_name"];
        array_push($categories, $category_name);
    }

    $response = ["success" => true, "message" => "Data read successfully", "categories" => $categories];
} else if ($component == "type") {
    $product_type = readData($conn, "producttypetb");
    $product_types = [];
    $response = [];

    foreach ($product_type["data"] as $type) {
        $type_name = $type["typename"];
        array_push($product_types, $type_name);
    }

    $response = ["success" => true, "message" => "Data read successfully", "product_types" => $product_types];
} else if ($component == "price") {
    $stmt = "SELECT MIN(CAST(price as FLOAT )) as min_price, MAX(CAST(price as FLOAT )) as max_price FROM producttb";
    $result = $conn->query($stmt);

    if ($result->rowCount() > 0) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $min_price = $row["min_price"];
        $max_price = $row["max_price"];
        $response = ["success" => true, "message" => "Data read successfully", "min_price" => $min_price, "max_price" => $max_price];
    }
}


echo json_encode($response);
