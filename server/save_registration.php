<?php

header('Content-Type: application/json');
include_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form inputs
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $firstName = $_POST['first_name'];
    $middleName = $_POST['middle_name'] ?? null; // Optional
    $lastName = $_POST['last_name'];
    $contact = $_POST['contact'];
    $birthday = $_POST['birthday'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $storeName = $_POST['store_name'];
    $createdAt = date('Y-m-d H:i:s');
    $updatedAt = date('Y-m-d H:i:s');
    $status = 'active';

    // Default image file
    $imagePath = '../assets/storepic.png';

    // Check if the file exists and read its content
    if (file_exists($imagePath)) {
        $imageData = file_get_contents($imagePath);
    } else {
        die(json_encode(['status' => 'error', 'message' => 'Default image file not found.']));
    }

    // Validate password and confirm password
    if ($password !== $confirmPassword) {
        die(json_encode(['status' => 'error', 'message' => 'Passwords do not match.']));
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Begin transaction
        $conn->beginTransaction();

        // Insert into sellertb
        $sellerQuery = "INSERT INTO sellertb (username, password, email, first_name, middle_name, last_name, contact, birthday, age, address, status, created_at, updated_at) 
                        VALUES (:username, :password, :email, :first_name, :middle_name, :last_name, :contact, :birthday, :age, :address, :status, :created_at, :updated_at)";
        $sellerStmt = $conn->prepare($sellerQuery);
        $sellerStmt->execute([
            ':username' => $username,
            ':password' => $hashedPassword,
            ':email' => $email,
            ':first_name' => $firstName,
            ':middle_name' => $middleName,
            ':last_name' => $lastName,
            ':contact' => $contact,
            ':birthday' => $birthday,
            ':age' => $age,
            ':address' => $address,
            ':status' => $status,
            ':created_at' => $createdAt,
            ':updated_at' => $updatedAt,
        ]);

        // Get the last inserted seller_id
        $sellerId = $conn->lastInsertId();

        // Insert into storetb
        $storeQuery = "INSERT INTO storetb (sellerid, storename, img) 
                       VALUES (:sellerid, :storename, :img)";
        $storeStmt = $conn->prepare($storeQuery);
        $storeStmt->bindParam(':sellerid', $sellerId, PDO::PARAM_INT);
        $storeStmt->bindParam(':storename', $storeName, PDO::PARAM_STR);
        $storeStmt->bindParam(':img', $imageData, PDO::PARAM_LOB); // Bind as LOB
        $storeStmt->execute();

        // Commit transaction
        $conn->commit();

        // Send a JSON success response
        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        // Rollback on error
        $conn->rollBack();
        die(json_encode(['status' => 'error', 'message' => $e->getMessage()]));
    }
} else {
    die(json_encode(['status' => 'error', 'message' => 'Invalid request method.']));
}
?>
