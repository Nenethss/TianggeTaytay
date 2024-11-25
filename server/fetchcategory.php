<?php
// Include database connection
include_once "connect.php";

try {
    $query = "SELECT * FROM categorytb";  // Replace with your actual table name
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Store category HTML in a variable
    $categoryHTML = "";

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categoryHTML .= '<div class="category">';
            $categoryHTML .= '<img src="data:image/png;base64,' . base64_encode($row['img']) . '" alt="' . htmlspecialchars($row['category_name']) . '">';
            $categoryHTML .= '<p>' . htmlspecialchars($row['category_name']) . '</p>';
            $categoryHTML .= '</div>';
        }
    } else {
        $categoryHTML = "<p>No categories found.</p>";
    }
} catch (PDOException $e) {
    $categoryHTML = "<p>Error fetching categories: " . $e->getMessage() . "</p>";
}

// Export the category HTML for inclusion
return $categoryHTML;
?>
