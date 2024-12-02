<?php
// Include database connection
include_once "connect.php";

if (isset($_POST['userid'])) {
    $userid = $_POST['userid'];

    try {
        // Begin a transaction
        $conn->beginTransaction();

        // Step 1: Select the record to be archived
        $query_select = "SELECT * FROM admintb WHERE userid = :userid";
        $stmt_select = $conn->prepare($query_select);
        $stmt_select->bindParam(':userid', $userid, PDO::PARAM_INT);
        $stmt_select->execute();
        $category = $stmt_select->fetch(PDO::FETCH_ASSOC);

        if ($category) {
            // Step 2: Insert the record into archived_categories
            $query_archive = "INSERT INTO archived_admintb (admin_id, username, email, role) VALUES (:admin_id, :username, :email, :role)";
            $stmt_archive = $conn->prepare($query_archive);
            $stmt_archive->bindParam(':admin_id', $category['admin_id'], PDO::PARAM_INT);
            $stmt_archive->bindParam(':username', $category['username'], PDO::PARAM_STR);
            $stmt_archive->bindParam(':email', $category['email'], PDO::PARAM_STR);
            $stmt_archive->bindParam(':role', $category['role'], PDO::PARAM_STR);
            $stmt_archive->execute();

            // Step 3: Delete the record from categorytb
            $query_delete = "DELETE FROM admintb WHERE userid = :userid";
            $stmt_delete = $conn->prepare($query_delete);
            $stmt_delete->bindParam(':userid', $userid, PDO::PARAM_INT);
            $stmt_delete->execute();

            // Commit the transaction
            $conn->commit();
            header("Location: ../pages/users.php?section=categories&success=Admin archived successfully");
        } else {
            echo "Admin not found.";
        }
    } catch (PDOException $e) {
        // Rollback the transaction if something goes wrong
        $conn->rollBack();
        echo "Error archiving Admin: " . $e->getMessage();
    }
} else {
    echo "No Admin ID provided.";
}
?>
