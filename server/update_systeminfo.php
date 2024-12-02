<?php
include '../server/connect.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['success' => false, 'message' => 'No action performed.'];

    try {
        if (isset($_FILES['systemlogo']) && $_FILES['systemlogo']['error'] === UPLOAD_ERR_OK) {
            $logoData = file_get_contents($_FILES['systemlogo']['tmp_name']);
            $sql = "UPDATE systeminfo SET systemlogo = :systemlogo WHERE id = 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':systemlogo', $logoData, PDO::PARAM_LOB);
            $stmt->execute();
            header("Location: ../pages/settings.php?section=general");
        }

        if (!empty($_POST['terms'])) {
            $terms = $_POST['terms'];
            $sql = "UPDATE systeminfo SET TC = :TC WHERE id = 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':TC', $terms);
            $stmt->execute();
            header("Location: ../pages/settings.php?section=general");
        }

        if (!empty($_POST['privacy'])) {
            $privacy = $_POST['privacy'];
            $sql = "UPDATE systeminfo SET PP = :PP WHERE id = 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':PP', $privacy);
            $stmt->execute();
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
