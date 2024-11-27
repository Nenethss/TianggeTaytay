<?php
// Start session to access session variables
session_start();

// Include database connection
include("connect.php");

try {
    // Ensure the session contains the username
    if (!isset($_SESSION['username'])) {
        throw new Exception("No user is logged in.");
    }

    $username = $_SESSION['username']; // Get logged-in username from session

    // Query to fetch seller data based on username
    $sql = "SELECT * FROM sellertb WHERE username = :username";
    $stmt = $conn->prepare($sql);

    // Bind the username parameter
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);

    // Execute the query
    $stmt->execute();

    // Fetch data as an associative array
    $seller = $stmt->fetch(PDO::FETCH_ASSOC);

    // Handle case where no data is found
    if (!$seller) {
        $seller = [
            'username' => 'N/A',
            'email' => 'N/A',
            'first_name' => 'N/A',
            'last_name' => 'N/A',
            'middle_name' => 'N/A',
            'contact_number' => 'N/A',
            'birthday' => 'N/A',
            'age' => 'N/A',
            'place_of_birth' => 'N/A',
            'province' => 'N/A',
            'municipality' => 'N/A',
            'baranggay' => 'N/A',
            'houseno' => 'N/A'
        ];
    }
} catch (Exception $e) {
    // Handle errors
    die("Error: " . $e->getMessage());
}
?>
