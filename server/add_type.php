<?php
// Include database connection
include('connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['type_name'])) {
    $type_name = $_POST['type_name'];

    // Check if type name is empty
    if (empty($type_name)) {
        header('Location: ../admin/types.php?error=Type name cannot be empty');
        exit();
    }

    // Insert the new type into the database
    try {
        $stmt = $conn->prepare("INSERT INTO productypetb (typename) VALUES (:typename)");
        $stmt->bindParam(':typename', $type_name, PDO::PARAM_STR);
        $stmt->execute();

        // Redirect back with success message
        header('Location: ../admin/types.php?success=Type added successfully');
        exit();
    } catch (PDOException $e) {
        // Handle any errors
        header('Location: ../admin/types.php?error=Failed to add type: ' . $e->getMessage());
        exit();
    }
} else {
    // If the form is not submitted, redirect back
    header('Location: ../admin/types.php?error=Invalid request');
    exit();
}
?>
