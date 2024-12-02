<?php
session_start(); // Start session
include_once 'connect.php';

$sql = "SELECT * FROM actlogtb";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Fetch all data
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Debugging
    if (empty($logs)) {
        echo "<div>No records found in actlogtb.</div>";
    }
?>