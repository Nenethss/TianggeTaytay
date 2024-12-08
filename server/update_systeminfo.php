<?php
include '../server/connect.php'; // Include the database connection

session_start();

$userid = $_SESSION['userid'];

// Fetch store details from the database
$stmt = $conn->prepare("SELECT userid, username, password, first_name, middle_name, surname, email, role, img FROM admintb WHERE userid = :userid");
$stmt->execute(['userid' => $userid]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if ($admin) {
    $admin_id = $admin['userid'];
    $adminUsername = $admin['username']; 
    $adminRole = $admin['role'];
    $adminEmail = $admin['email'];
} 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['success' => false, 'message' => 'No action performed.'];

    try {
        if (isset($_FILES['systemlogo']) && $_FILES['systemlogo']['error'] === UPLOAD_ERR_OK) {
            $logoData = file_get_contents($_FILES['systemlogo']['tmp_name']);
            $sql = "UPDATE systeminfo SET systemlogo = :systemlogo WHERE id = 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':systemlogo', $logoData, PDO::PARAM_LOB);
            $stmt->execute();

            $action = $adminUsername . " updated the system logo";
            $logSql = "INSERT INTO actlogtb (usertype, email, action) 
                       VALUES (:usertype, :email, :action)";

            $logStmt = $conn->prepare($logSql);
            $logStmt->bindParam(':usertype', $adminRole);
            $logStmt->bindParam(':email', $adminEmail);
            $logStmt->bindParam(':action', $action);

            // Execute the log query
            $logStmt->execute();

            header("Location: ../pages/settings.php?section=general");
        }

        if (!empty($_POST['terms'])) {
            $terms = $_POST['terms'];
            $sql = "UPDATE systeminfo SET TC = :TC WHERE id = 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':TC', $terms);
            $stmt->execute();

            $action = $adminUsername . " updated the Terms and Condition";
            $logSql = "INSERT INTO actlogtb (usertype, email, action) 
                       VALUES (:usertype, :email, :action)";

            $logStmt = $conn->prepare($logSql);
            $logStmt->bindParam(':usertype', $adminRole);
            $logStmt->bindParam(':email', $adminEmail);
            $logStmt->bindParam(':action', $action);

            // Execute the log query
            $logStmt->execute();

            header("Location: ../pages/settings.php?section=general");
        }

        if (!empty($_POST['privacy'])) {
            $privacy = $_POST['privacy'];
            $sql = "UPDATE systeminfo SET PP = :PP WHERE id = 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':PP', $privacy);
            $stmt->execute();

            $action = $adminUsername . " updated the Pricavy Policy";
            $logSql = "INSERT INTO actlogtb (usertype, email, action) 
                       VALUES (:usertype, :email, :action)";

            $logStmt = $conn->prepare($logSql);
            $logStmt->bindParam(':usertype', $adminRole);
            $logStmt->bindParam(':email', $adminEmail);
            $logStmt->bindParam(':action', $action);

            // Execute the log query
            $logStmt->execute();

            header("Location: ../pages/settings.php?section=general");
        }

        if (!empty($_POST['about'])) {
            $privacy = $_POST['about'];
            $sql = "UPDATE systeminfo SET about = :about WHERE id = 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':about', $privacy);
            $stmt->execute();

            $action = $adminUsername . " updated the About";
            $logSql = "INSERT INTO actlogtb (usertype, email, action) 
                       VALUES (:usertype, :email, :action)";

            $logStmt = $conn->prepare($logSql);
            $logStmt->bindParam(':usertype', $adminRole);
            $logStmt->bindParam(':email', $adminEmail);
            $logStmt->bindParam(':action', $action);

            // Execute the log query
            $logStmt->execute();

            header("Location: ../pages/settings.php?section=general");
        }

        if (!empty($_POST['contact'])) {
            $privacy = $_POST['contact'];
            $sql = "UPDATE systeminfo SET contact_info = :contact_info WHERE id = 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':contact_info', $privacy);
            $stmt->execute();

            $action = $adminUsername . " updated the About";
            $logSql = "INSERT INTO actlogtb (usertype, email, action) 
                       VALUES (:usertype, :email, :action)";

            $logStmt = $conn->prepare($logSql);
            $logStmt->bindParam(':usertype', $adminRole);
            $logStmt->bindParam(':email', $adminEmail);
            $logStmt->bindParam(':action', $action);

            // Execute the log query
            $logStmt->execute();

            header("Location: ../pages/settings.php?section=general");
        }

        if (!empty($_POST['uv'])) {
            $privacy = $_POST['uv'];
            $sql = "UPDATE systeminfo SET uv = :uv WHERE id = 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':uv', $privacy);
            $stmt->execute();

            $action = $adminUsername . " updated the uv";
            $logSql = "INSERT INTO actlogtb (usertype, email, action) 
                       VALUES (:usertype, :email, :action)";

            $logStmt = $conn->prepare($logSql);
            $logStmt->bindParam(':usertype', $adminRole);
            $logStmt->bindParam(':email', $adminEmail);
            $logStmt->bindParam(':action', $action);

            // Execute the log query
            $logStmt->execute();

            header("Location: ../pages/settings.php?section=general");
        }

        if (!empty($_POST['jeep'])) {
            $privacy = $_POST['jeep'];
            $sql = "UPDATE systeminfo SET jeep = :jeep WHERE id = 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':jeep', $privacy);
            $stmt->execute();

            $action = $adminUsername . " updated the jeep";
            $logSql = "INSERT INTO actlogtb (usertype, email, action) 
                       VALUES (:usertype, :email, :action)";

            $logStmt = $conn->prepare($logSql);
            $logStmt->bindParam(':usertype', $adminRole);
            $logStmt->bindParam(':email', $adminEmail);
            $logStmt->bindParam(':action', $action);

            // Execute the log query
            $logStmt->execute();

            header("Location: ../pages/settings.php?section=general");
        }

        if (!empty($_POST['mrt'])) {
            $privacy = $_POST['mrt'];
            $sql = "UPDATE systeminfo SET mrt = :mrt WHERE id = 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':mrt', $privacy);
            $stmt->execute();

            $action = $adminUsername . " updated the mrt";
            $logSql = "INSERT INTO actlogtb (usertype, email, action) 
                       VALUES (:usertype, :email, :action)";

            $logStmt = $conn->prepare($logSql);
            $logStmt->bindParam(':usertype', $adminRole);
            $logStmt->bindParam(':email', $adminEmail);
            $logStmt->bindParam(':action', $action);

            // Execute the log query
            $logStmt->execute();

            header("Location: ../pages/settings.php?section=general");
        }

        if (!empty($_POST['uv_bus'])) {
            $privacy = $_POST['uv_bus'];
            $sql = "UPDATE systeminfo SET uv_bus = :uv_bus WHERE id = 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':uv_bus', $privacy);
            $stmt->execute();

            $action = $adminUsername . " updated the uv_bus";
            $logSql = "INSERT INTO actlogtb (usertype, email, action) 
                       VALUES (:usertype, :email, :action)";

            $logStmt = $conn->prepare($logSql);
            $logStmt->bindParam(':usertype', $adminRole);
            $logStmt->bindParam(':email', $adminEmail);
            $logStmt->bindParam(':action', $action);

            // Execute the log query
            $logStmt->execute();

            header("Location: ../pages/settings.php?section=general");
        }

        if (!empty($_POST['ride_apps'])) {
            $privacy = $_POST['ride_apps'];
            $sql = "UPDATE systeminfo SET ride_apps = :ride_apps WHERE id = 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':ride_apps', $privacy);
            $stmt->execute();

            $action = $adminUsername . " updated the ride_apps";
            $logSql = "INSERT INTO actlogtb (usertype, email, action) 
                       VALUES (:usertype, :email, :action)";

            $logStmt = $conn->prepare($logSql);
            $logStmt->bindParam(':usertype', $adminRole);
            $logStmt->bindParam(':email', $adminEmail);
            $logStmt->bindParam(':action', $action);

            // Execute the log query
            $logStmt->execute();

            header("Location: ../pages/settings.php?section=general");
        }

    } catch (Exception $e) {
        $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
