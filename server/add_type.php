<?php
// Include database connection
include('connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['typename'])) {
    $type_name = $_POST['typename'];

    // Check if type name is empty
    if (empty($type_name)) {
        header('Location: ../pages/settings.php?section=type&rror=Type name cannot be empty');
        exit();
    }

    // Insert the new type into the database
    try {
        $stmt = $conn->prepare("INSERT INTO producttypetb (typename) VALUES (:typename)");
        $stmt->bindParam(':typename', $type_name, PDO::PARAM_STR);
        $stmt->execute();

        // Redirect back with success message
        header('Location: ../pages/settings.php?section=type&success=Type added successfully');
        exit();
    } catch (PDOException $e) {
        // Handle any errors
        header('Location: ../pages/settings.php?section=type&error=Failed to add type: ' . $e->getMessage());
        exit();
    }
} else {
    // If the form is not submitted, redirect back
    header('Location: ../pages/settings.php?section=type&error=Invalid request');
    exit();
}
?>
