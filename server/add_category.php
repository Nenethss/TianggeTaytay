<?php
// Include database connection
include_once "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['category_name'])) {
    try {
        // Sanitize the category name input
        $category_name = htmlspecialchars($_POST['category_name']);

        // Check if the category already exists in the database
        $query_check = "SELECT COUNT(*) FROM categorytb WHERE category_name = :category_name";
        $stmt_check = $conn->prepare($query_check);
        $stmt_check->bindParam(':category_name', $category_name, PDO::PARAM_STR);
        $stmt_check->execute();
        
        // If the category exists (count > 0), show an error message
        if ($stmt_check->fetchColumn() > 0) {
            // Redirect with error message
            header("Location: ../pages/settings.php?section=categories&error=Category%20with%20this%20name%20already%20exists.");
            exit();
        } else {
            // Prepare and execute the insert query
            $query = "INSERT INTO categorytb (category_name) VALUES (:category_name)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
            $stmt->execute();

            // Redirect back to the categories page after successful insertion with a success message
            header("Location: ../pages/settings.php?section=categories&success=Category%20added%20successfully.");
            exit();
        }
    } catch (PDOException $e) {
        // Redirect with error message if there is a database exception
        header("Location: ../pages/settings.php?section=categories&error=Error%20adding%20category:%20" . urlencode($e->getMessage()));
        exit();
    }
}
?>
