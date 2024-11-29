<?php
// Include database connection
include_once "connect.php";

// Check if admin_id is provided
if (isset($_POST['admin_id'])) {
    $admin_id = $_POST['admin_id'];

    try {
        // Start a transaction
        $conn->beginTransaction();

        // Get the archived admin details
        $stmt_get = $conn->prepare("SELECT * FROM archived_admintb WHERE admin_id = ?");
        $stmt_get->execute([$admin_id]);
        $admin = $stmt_get->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            // Insert the admin back into the admintb table
            $stmt_restore = $conn->prepare("INSERT INTO admintb (admin_id, username, email, role, status) 
                VALUES (?, ?, ?, ?, ?)");
            $stmt_restore->execute([
                $admin['admin_id'],
                $admin['username'],
                $admin['email'],
                $admin['role'],
                $admin['status']
            ]);

            // Delete the admin from the archived_admintb table
            $stmt_delete = $conn->prepare("DELETE FROM archived_admintb WHERE admin_id = ?");
            $stmt_delete->execute([$admin_id]);

            // Commit the transaction
            $conn->commit();

            // Redirect or notify success
            header("Location: admin_dashboard.php?message=Admin restored successfully");
        } else {
            // Admin not found
            header("Location: admin_dashboard.php?error=Admin not found in archived");
        }
    } catch (PDOException $e) {
        $conn->rollBack();
        // Handle error
        echo "Error restoring admin: " . $e->getMessage();
    }
} else {
    // Admin ID not provided
    echo "Admin ID is required.";
}
?>
