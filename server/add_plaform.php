<?php
// Include database connection file
require_once 'connect.php';

// Initialize variables
$errorMessage = '';
$successMessage = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get platform name
    $platform_name = $_POST['platform_name'] ?? '';
    
    // Validate inputs
    if (empty($platform_name)) {
        $errorMessage = 'Platform Name is required.';
    } elseif (!empty($_FILES['img']['name'])) {
        // Handle file upload
        $img = file_get_contents($_FILES['img']['tmp_name']);
        $img_type = $_FILES['img']['type'];

        // Check for valid image type
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($img_type, $allowed_types)) {
            $errorMessage = 'Invalid image type. Allowed types: JPG, PNG, GIF.';
        } else {
            // Save to database
            try {
                $stmt = $pdo->prepare("INSERT INTO platformtb (platform_name, img) VALUES (:platform_name, :img)");
                $stmt->bindParam(':platform_name', $platform_name, PDO::PARAM_STR);
                $stmt->bindParam(':img', $img, PDO::PARAM_LOB);
                $stmt->execute();

                $successMessage = 'Platform added successfully!';
            } catch (PDOException $e) {
                $errorMessage = 'Database error: ' . $e->getMessage();
            }
        }
    } else {
        $errorMessage = 'Platform Icon is required.';
    }
}

if (!empty($successMessage)) {
    header('Location: ../pages/platforms.php?success=' . urlencode($successMessage));
    exit;
} else {
    header('Location: ../pages/platforms.php?error=' . urlencode($errorMessage));
    exit;
}
?>
