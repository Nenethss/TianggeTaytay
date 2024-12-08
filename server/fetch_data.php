<?php
require_once('connect.php');

// Get search term and table selection from query parameters
$search_term = isset($_GET['search']) ? $_GET['search'] : '';
$selected_table = isset($_GET['table_select']) ? $_GET['table_select'] : 'seller';

// Prepare the search term for SQL LIKE
$search_like = '%' . $search_term . '%';

// Handle different table selections
if ($selected_table === 'administrator') {
  $sql = "
        SELECT userid, email, username, status 
        FROM admintb 
        WHERE userid LIKE :search_like OR email LIKE :search_like OR username LIKE :search_like OR status LIKE :search_like
    ";
} elseif ($selected_table === 'seller') {
  $sql = "
    SELECT sellertb.seller_id, sellertb.seller_email AS seller_email, 
           CONCAT(sellertb.first_name, ' ', sellertb.middle_name, ' ', sellertb.last_name) AS full_name, 
           sellertb.status, sellertb.permit, stalltb.stallnumber, stalltb.storename
    FROM sellertb
    INNER JOIN storetb ON sellertb.seller_id = storetb.sellerid
    INNER JOIN stalltb ON storetb.storename = stalltb.storename
    WHERE storetb.storename LIKE :search_like
    ORDER BY 
        CASE 
            WHEN sellertb.status = 'pending' THEN 1
            WHEN sellertb.status = 'verified' THEN 2
            ELSE 3
        END
";
} else {
  echo "<p style='text-align: center;'>Invalid table selection.</p>";
  exit;
}

// Prepare and execute the query
$stmt = $conn->prepare($sql);
$stmt->bindParam(':search_like', $search_like, PDO::PARAM_STR);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display the results
if ($selected_table === 'administrator') {
  if (count($results) > 0) {
    echo "<table>";
    echo "<tr><th>Admin ID</th><th>Email Address</th><th>Username</th><th>Status</th><th>Action</th></tr>";

    foreach ($results as $row) {
      echo "<tr>";
      echo "<td>" . htmlspecialchars($row['userid']) . "</td>";
      echo "<td>" . htmlspecialchars($row['email']) . "</td>";
      echo "<td>" . htmlspecialchars($row['username']) . "</td>";
      echo "<td>
                    <form method='POST'>
                        <select name='status' class='status-dropdown' data-userid='" . htmlspecialchars($row['userid']) . "'>
                            <option value='active' " . ($row['status'] === 'active' ? 'selected' : '') . ">Active</option>
                            <option value='inactive' " . ($row['status'] === 'inactive' ? 'selected' : '') . ">Inactive</option>
                        </select>
                        <input type='hidden' name='userid' value='" . htmlspecialchars($row['userid']) . "'>
                    </form>
                  </td>";
      echo '<td>
                    <form action="../server/archive_admin.php" method="POST" style="display:inline;">
                        <input type="hidden" name="userid" value="' . htmlspecialchars($row['userid']) . '">
                        <button type="submit" class="delete-btn"><img src="../assets/archived.png" alt=""></button>
                    </form>
                    </td>';

      echo "</tr>";
    }
    echo "</table>";
  } else {
    echo "<p style='text-align: center;'>No administrator data found.</p>";
  }
} elseif ($selected_table === 'seller') {
  if (count($results) > 0) {
    echo "<table>";
    echo "<tr><th>Seller ID</th><th>Email Address</th><th>Full Name</th><th>Store Name</th><th>Status</th><th>Permit</th></tr>";

    foreach ($results as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['seller_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['seller_email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['storename'] ?? 'N/A') . "</td>";
        echo "<td>
                        <select name='status' class='status-dropdown' data-userid='" . htmlspecialchars($row['seller_id']) . "' 
                            onchange='updateSelectStyle(this)'>
                            <option data-class='verified' value='Verified'" . ($row['status'] === 'Verified' ? ' selected' : '') . ">Verified</option>
                            <option data-class='pending' value='Pending'" . ($row['status'] === 'Pending' ? ' selected' : '') . ">Pending</option>
                        </select>
                      </td>";
        if (!empty($row['permit'])) {
            $permit_data = base64_encode($row['permit']);
            $permit_link = "data:application/octet-stream;base64," . $permit_data;
            echo "<td><button class='modal' onclick='showModal(\"" . $permit_link . "\")'>View Permit</button></td>";
        } else {
            echo "<td>N/A</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
  if (count($results) > 0) {
    echo "<table>";
    echo "<tr><th>Seller ID</th><th>Email Address</th><th>Full Name</th><th>Store Name</th><th>Status</th><th>Permit</th></tr>";

    foreach ($results as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['seller_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['seller_email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['storename'] ?? 'N/A') . "</td>";
        echo "<td>
                        <select name='status' class='status-dropdown' data-userid='" . htmlspecialchars($row['seller_id']) . "' 
                            onchange='updateSelectStyle(this)'>
                            <option data-class='verified' value='Verified'" . ($row['status'] === 'Verified' ? ' selected' : '') . ">Verified</option>
                            <option data-class='pending' value='Pending'" . ($row['status'] === 'Pending' ? ' selected' : '') . ">Pending</option>
                        </select>
                      </td>";
        if (!empty($row['permit'])) {
            $permit_data = base64_encode($row['permit']);
            $permit_link = "data:application/octet-stream;base64," . $permit_data;
            echo "<td><button class='modal' onclick='showModal(\"" . $permit_link . "\")'>View Permit</button></td>";
        } else {
            echo "<td>N/A</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}
}

}

// Handle status update for administrator
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userid'])) {
  $userid = $_POST['userid'];
  $new_status = $_POST['status'];

  $update_sql = "UPDATE admintb SET status = :new_status WHERE userid = :userid";
  $update_stmt = $conn->prepare($update_sql);
  $update_stmt->bindParam(':new_status', $new_status, PDO::PARAM_STR);
  $update_stmt->bindParam(':userid', $userid, PDO::PARAM_STR);

  if ($update_stmt->execute()) {
    echo "<p style='color: green;'>Status updated successfully.</p>";
  } else {
    echo "<p style='color: red;'>Error updating status.</p>";
  }
}

$conn = null; // Close connection