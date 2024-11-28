<?php
session_start();
include_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get form data
        $storename = trim($_POST['storename']);
        $description = trim($_POST['description']);
        $stallnumber = trim($_POST['stallnumber']);
        $contact = trim($_POST['contact']);
        $email = trim($_POST['email']);
        $shopee = trim($_POST['shopee_link']);
        $lazada = trim($_POST['lazada_link']);

        // Initialize img to null
        $img = null;
        if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $img = file_get_contents($_FILES['img']['tmp_name']);
        }

        if (empty($storename)) {
            throw new Exception("Store Name is required.");
        }

        // Start the transaction
        $conn->beginTransaction();

        // Update store details (excluding image for now)
        $storeUpdateQuery = "
            UPDATE storetb 
            SET description = :description, 
                store_contact = :store_contact, 
                lazada = :lazada, 
                shopee = :shopee, 
                store_email = :store_email 
            WHERE storename = :storename";
        $storeStmt = $conn->prepare($storeUpdateQuery);
        $storeStmt->bindParam(':description', $description, PDO::PARAM_STR);
        $storeStmt->bindParam(':store_contact', $contact, PDO::PARAM_STR);
        $storeStmt->bindParam(':lazada', $lazada, PDO::PARAM_STR);
        $storeStmt->bindParam(':shopee', $shopee, PDO::PARAM_STR);
        $storeStmt->bindParam(':store_email', $email, PDO::PARAM_STR);
        $storeStmt->bindParam(':storename', $storename, PDO::PARAM_STR);
        $storeStmt->execute();

        // Update store image if provided
        if ($img !== null) {
            $imageUpdateQuery = "UPDATE storetb SET img = :img WHERE storename = :storename";
            $imageStmt = $conn->prepare($imageUpdateQuery);
            $imageStmt->bindParam(':img', $img, PDO::PARAM_LOB);
            $imageStmt->bindParam(':storename', $storename, PDO::PARAM_STR);
            $imageStmt->execute();
        }

        // Update stall number
        $stallUpdateQuery = "UPDATE stalltb SET stallnumber = :stallnumber WHERE storename = :storename";
        $stallStmt = $conn->prepare($stallUpdateQuery);
        $stallStmt->bindParam(':stallnumber', $stallnumber, PDO::PARAM_STR);
        $stallStmt->bindParam(':storename', $storename, PDO::PARAM_STR);
        $stallStmt->execute();

        // Commit the transaction
        $conn->commit();

        // Redirect to the store info page
        header("Location: ../pages/store-info.php");
        exit;
    } catch (Exception $e) {
        // Rollback if something went wrong
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        die("Error: " . $e->getMessage());
    }
}
?>
