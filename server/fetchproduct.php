<?php
// Include database connection
include_once "connect.php";

try {
    // SQL query to fetch the first 4 products (ordered by product_id in ascending order)
    $queryFirst4 = "SELECT product_name, price, img FROM producttb ORDER BY productid ASC LIMIT 4";
    $stmtFirst4 = $conn->prepare($queryFirst4);
    $stmtFirst4->execute();

    // SQL query to fetch the last 4 products (ordered by product_id in descending order)
    $queryLast4 = "SELECT product_name, price, img FROM producttb ORDER BY productid DESC LIMIT 4";
    $stmtLast4 = $conn->prepare($queryLast4);
    $stmtLast4->execute();

    // Store product HTML for new arrivals
    $productHTML = "";

    // Fetch the first 4 products (NEW ARRIVALS)
    if ($stmtFirst4->rowCount() > 0) {
        while ($row = $stmtFirst4->fetch(PDO::FETCH_ASSOC)) {
            // Check if the image is valid
            $imageData = $row['img'];
            $imageType = 'image/png'; // Default image type, change if necessary (e.g., image/jpeg)

            // Base64 encode the image data
            $base64Image = base64_encode($imageData);

            // Generate HTML for each product
            $productHTML .= '<div class="new-arrival-item">';
            $productHTML .= '<img src="data:' . $imageType . ';base64,' . $base64Image . '" alt="' . htmlspecialchars($row['product_name']) . '">';
            $productHTML .= '<p>'  . htmlspecialchars($row['product_name']) . '</p>';
            $productHTML .= '<p class="product-price"> ₱' . number_format(htmlspecialchars($row['price']), 2) . '</p>'; // Format price as currency
            $productHTML .= '</div>';
        }
    } else {
        $productHTML .= "<p>No products found in the new arrivals.</p>";
    }

    // Store product HTML for most viewed
    $lastproductHTML = "";

    // Fetch the last 4 products (MOST VIEWED)
    if ($stmtLast4->rowCount() > 0) {
        while ($row = $stmtLast4->fetch(PDO::FETCH_ASSOC)) {
            // Check if the image is valid
            $imageData = $row['img'];
            $imageType = 'image/png'; // Default image type, change if necessary (e.g., image/jpeg)

            // Base64 encode the image data
            $base64Image = base64_encode($imageData);

            // Generate HTML for each product
            $lastproductHTML .= '<div class="new-arrival-item">';
            $lastproductHTML .= '<img src="data:' . $imageType . ';base64,' . $base64Image . '" alt="' . htmlspecialchars($row['product_name']) . '">';
            $lastproductHTML .= '<p>'  . htmlspecialchars($row['product_name']) . '</p>';
            $lastproductHTML .= '<p class="product-price"> ₱' . number_format(htmlspecialchars($row['price']), 2) . '</p>'; // Format price as currency
            $lastproductHTML .= '</div>';
        }
    } else {
        $lastproductHTML .= "<p>No products found in the most viewed section.</p>";
    }
} catch (PDOException $e) {
    $productHTML = "<p>Error fetching products: " . $e->getMessage() . "</p>";
    $lastproductHTML = "<p>Error fetching most viewed products: " . $e->getMessage() . "</p>";
}


return $lastproductHTML;
return $productHTML;

// Return the HTML for both the first 4 and the last 4 products
?>
