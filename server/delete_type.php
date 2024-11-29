<?php
// Include database connection
include('connect.php');

// Check if type ID is provided
if (isset($_POST['typeid']) && !empty($_POST['typeid'])) {
    $typeid = $_POST['typeid'];

    // Delete the type from the database
    try {
        // Check if the type exists before trying to delete
        $stmt = $conn->prepare("SELECT * FROM productypetb WHERE typeid = :typeid");
        $stmt->bindParam(':typeid', $typeid, PDO::PARAM_INT);
        $stmt->execute();
        $type = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($type) {
            // Type exists, delete it
            $stmt = $conn->prepare("DELETE FROM productypetb WHERE typeid = :typeid");
            $stmt->bindParam(':typeid', $typeid, PDO::PARAM_INT);
            $stmt->execute();

            // Redirect with success message
            header('Location: ../admin/types.php?success=Type deleted successfully');
            exit();
        } else {
            // Type does not exist
            header('Location: ../admin/types.php?error=Type not found');
            exit();
        }
    } catch (PDOException $e) {
        // Handle any errors
        header('Location: ../admin/types.php?error=Failed to delete type: ' . $e->getMessage());
        exit();
    }
} else {
    // Type ID is missing or invalid
    header('Location: ../admin/types.php?error=Invalid type ID');
    exit();
}
?>
