<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$dbname = "tianggedb"; // replace with your database name

try {
    // Create PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $search_term = isset($_GET['search']) ? $_GET['search'] : '';
    $selected_table = isset($_GET['table_select']) ? $_GET['table_select'] : 'seller';

    // Display Seller Table
    if ($selected_table == 'seller') {
        // Prepare SQL query with placeholders
        $sql = "SELECT seller_id,  CONCAT(first_name, ' ', middle_name, ' ', last_name) AS full_name, status 
                FROM sellertb 
                WHERE seller_id LIKE :search OR /:search OR CONCAT(first_name, ' ', middle_name, ' ', last_name) LIKE :search OR status LIKE :search";

        $stmt = $conn->prepare($sql);
        $search_like = '%' . $search_term . '%';
        $stmt->bindParam(':search', $search_like, PDO::PARAM_STR);
        $stmt->execute();

        // Check if we have data
        if ($stmt->rowCount() > 0) {
            echo "<h2 style='text-align: center;'>Seller Table</h2>";
            echo "<table>";
            echo "<tr><th>Seller ID</th><th>Email Address</th><th>Full Name</th><th>Status</th></tr>";

            // Fetch and display data
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['seller_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                echo "<td class='status-cell'>" . htmlspecialchars($row['status']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='text-align: center;'>No seller data found.</p>";
        }
    }

    // Display Administrator Table
    elseif ($selected_table == 'administrator') {
        // Prepare SQL query with placeholders
        $sql = "SELECT userid, email, username, status 
                FROM admintb 
                WHERE userid LIKE :search OR email LIKE :search OR username LIKE :search OR status LIKE :search";

        $stmt = $conn->prepare($sql);
        $search_like = '%' . $search_term . '%';
        $stmt->bindParam(':search', $search_like, PDO::PARAM_STR);
        $stmt->execute();

        // Check if we have data
        if ($stmt->rowCount() > 0) {
            echo "<h2 style='text-align: center;'>Administrator Table</h2>";
            echo "<table>";
            echo "<tr><th>User ID</th><th>Email Address</th><th>Username</th><th>Status</th></tr>";

            // Fetch and display data
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['userid']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                echo "<td class='status-cell'>" . htmlspecialchars($row['status']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='text-align: center;'>No administrator data found.</p>";
        }
    }
} catch (PDOException $e) {
    // Handle connection or query errors
    echo "Connection failed: " . $e->getMessage();
}
?>
