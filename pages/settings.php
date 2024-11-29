<?php
session_start(); // Start session
include_once '../server/connect.php';

// Check if there's an error or success message passed via URL query parameters
$errorMessage = isset($_GET['error']) ? $_GET['error'] : '';
$successMessage = isset($_GET['success']) ? $_GET['success'] : '';

list($categoryHTML, $categories) = include_once '../server/fetchcategory.php';
include_once '../server/fetchtype.php';

include_once '../server/list_categories.php';
include_once '../server/list_type.php';
include_once '../server/list_admin.php';

if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Use the seller_id from the session
$userid = $_SESSION['userid'];

// Fetch store details from the database
$stmt = $conn->prepare("SELECT username, password, first_name, middle_name, surname, email, role FROM admintb WHERE userid = :userid");
$stmt->execute(['userid' => $userid]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if ($admin) {
    // Data fetched successfully
    $username = $admin['username'];
    $fname = $admin['first_name'];
    $mname = $admin['middle_name'];
    $lname = $admin['surname'];
    $email = $admin['email'];
    $role = $admin['role'];
} else {
    // Handle case where no admin record was found
    echo "No admin record found for the given user ID.";
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Tiangge Taytay</title>
    <link rel="stylesheet" href="../style/sidebars.css">
    <link rel="stylesheet" href="../style/settings.css">
</head>

<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');


@font-face {
    font-family: "Kenzoestic";
    src: url("./kenzoestic/Kenzoestic\ Black.ttf");
}

label {
    align-content: center;
}

.top-bar {
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #ffffff;
    position: fixed;
    top: 0;
    right: 0;
    width: 100%;
    height: 50px;
    z-index: 1;
}

body {
    font-family: 'Roboto';
    background-color: #f5f6fa;
}

#add-category-form,
#add-type-form {
    padding: 10px;
    flex-direction: column;
    background-color: white;
    justify-content: space-around;
    align-items: flex-start;
}

select {
    width: 150px !important;
    background-color: white !important;
    color: #2d2d2d !important;
    border: 1px solid #cccccc !important;
    height: 40px !important;
    margin-left: 20px !important;
}

#add-category-form input,
#add-type-form input {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;

}

#add-category-form button,
#add-type-form button {
    width: 90px;
    font-weight: 600;
    padding: 10px;
    border-radius: 10px;
}

.close-btn {
    background-color: white;
    border: 1px solid #0033A0;
    color: #0033A0;
}

.add-btn {
    width: 150px !important;
    cursor: pointer;
    background-color: #0033a0;
    color: white;
    border: none;
}

.search {
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.archive.admin table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin-bottom: 20px;
    border-radius: 20px;
    margin-top: 20px !important;
    overflow: hidden;
}

.search button {
    font-weight: 600;
    color: white;
    width: 90px;
    height: 40px;
    border: none;
    background-color: #0033A0;
    cursor: pointer;
}

.delete-btn {
    width: 50px;
    height: 50px;
    border-radius: 50px;
    color: white;
    border: none;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
}

td {
    border: none;
    align-content: center;
    padding: 10px;
}

.search input {
    width: 76%;
    height: 40px;
    border-radius: 5px;
    padding-left: 10px;
    font-size: 15px;
}
</style>

<body>
    <div class="top-bar"></div>

    <div class="sidebar">
        <div class="logo">
            <img src="../assets/e-logo.png" alt="Logo">
        </div>
        <ul>
            <li>
                <a href="dashboard.php">
                    <img class="sidebar-icon" src="../assets/dashboard.png" alt="Dashboard"
                        data-active-src="../assets/dashboard-white.png"> Dashboard
                </a>
            </li>
            <li>
                <a href="users.php">
                    <img class="sidebar-icon" src="../assets/users.png" alt="Users"
                        data-active-src="../assets/users-white.png"> Users
                </a>
            </li>
            <li class="active">
                <a href="reports.php">
                    <img class="sidebar-icon" src="../assets/reports-white.png" alt="Reports"
                        data-active-src="../assets/reports-white.png"> Reports
                </a>
            </li>
            <li>
                <a href="settings.php">
                    <img class="sidebar-icon" src="../assets/settings.png" alt="Settings"
                        data-active-src="../assets/settings-white.png"> Settings
                </a>
            </li>
            <!-- Add more sidebar items here -->
            <li class="logout">
                <a href="logout.php">
                    <img class="sidebar-icon sidebar-icon-logout" src="../assets/logout.png" alt="Logout"> Logout
                </a>
                </a>
            </li> <!-- Logout button -->
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-container">
        <h2 class="header">SETTINGS</h2>
        <div class="main-content">
            <div class="left-container">
                <p style="border-top-left-radius: 10px;" class="sidebar-item active" data-section="admin">Admin</p>
                <p class="sidebar-item" data-section="categories">Categories</p>
                <p class="sidebar-item" data-section="type">Product Type</p>
                <p class="sidebar-item" data-section="general-information">General Information</p>
                <p class="sidebar-item" data-section="archive">Archive</p>
                <p class="sidebar-item" data-section="backup-restore">Back-up & Restore</p>
                <p class="sidebar-item" data-section="account">Account Information</p>
            </div>


            <div class="right-container">
                <!-- Display error message if it exists -->


                <!-- Admin Section (Initially Active) -->
                <div class="section-container admin-section active">
                    <form id="adminForm" action="../server/add_admin.php" method="POST">
                        <div class="form-container">
                            <div class="left-form">
                                <h2 style="margin-bottom: 15px;">Personal Information</h2>
                                <div class="form-group">
                                    <label for="firstName">First Name</label>
                                    <input type="text" id="firstName" name="first_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="middleName">Middle Name</label>
                                    <input type="text" id="middleName" name="middle_name">
                                </div>
                                <div class="form-group">
                                    <label for="surname">Surname</label>
                                    <input type="text" id="surname" name="surname" required>
                                </div>
                            </div>
                            <div class="right-form">
                                <h2 style="margin-bottom: 15px;">Account Information</h2>
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" id="username" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" required>
                                </div>
                            </div>
                        </div>
                        <div class="button-group">
                            <?php if ($errorMessage): ?>
                            <div id="error-message" class="error-message-container">
                                <p style="color: red;"><?php echo htmlspecialchars($errorMessage); ?></p>
                            </div>
                            <?php endif; ?>
                            <?php if ($successMessage): ?>
                            <div id="success-message" class="success-message-container">
                                <p style="color: green;"><?php echo htmlspecialchars($successMessage); ?></p>
                            </div>
                            <?php endif; ?>
                            <div style="dislay: flex;">
                                <button type="button" id="clearBtn" class="btn btn-cancel">Clear</button>
                                <button type="submit" class="btn btn-submit">Add Admin</button>
                            </div>
                        </div>
                    </form>
                    <table>
                        <thead>
                            <tr>
                                <th>Admin ID</th>
                                <th>Email</th>
                                <th>Full Name</th>
                                <th>Role</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($admins)): ?>
                            <?php foreach ($admins as $admin): ?>
                            <tr>
                                <td><?php echo "DI-0" . htmlspecialchars($admin['userid']); ?></td>
                                <td><?php echo htmlspecialchars($admin['email']); ?></td>
                                <td><?php echo htmlspecialchars($admin['fullname']); ?></td>
                                <td><?php echo htmlspecialchars($admin['role']); ?></td>
                                <td><?php echo htmlspecialchars($admin['status']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="5">No admins found.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>



                <!-- Category Section -->
                <!-- Category Section -->
                <div class="section-container categories-section">
                    <form action="../server/add_category.php" method="POST" class="add-category-form"
                        id="add-category-form">
                        <h2 style="margin-bottom: 15px;">Add Category</h2>
                        <div class="form-group">
                            <label for="surname">Category Name</label>
                            <input type="text" id="category_name" name="category_name" required>
                        </div>

                        <div style="display: flex; justify-content: flex-end; width: 100%;">
                            <?php if ($errorMessage): ?>
                            <div id="cat-error-message" class="error-message-container">
                                <p style="color: red;"><?php echo htmlspecialchars($errorMessage); ?></p>
                            </div>
                            <?php endif; ?>
                            <?php if ($successMessage): ?>
                            <div id="cat-success-message" class="success-message-container">
                                <p style="color: green;"><?php echo htmlspecialchars($successMessage); ?></p>
                            </div>
                            <?php endif; ?>
                            <button type="button" class="close-btn" id="clearBtn"
                                style="margin-right: 10px;">Cancel</button>
                            <button class="add-btn" type="submit" style="cursor: pointer;">Add Category</button>
                        </div>
                    </form>

                    <!-- Table to display categories -->
                    <table style="margin-top: 30px;" border="1" cellpadding="10" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Category ID</th>
                                <th>Category Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($category['categoryid']); ?></td>
                                <td><?php echo htmlspecialchars($category['category_name']); ?></td>
                                <td>
                                    <!-- Delete Button -->
                                    <!-- <form action="../server/delete_category.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="categoryid"
                                            value="?php echo htmlspecialchars($category['categoryid']); ?>">
                                        <button type="submit" class="delete-btn">Delete</button>
                                    </form> -->

                                    <!-- Archive Button -->
                                    <form action="../server/archive_category.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="categoryid"
                                            value="<?php echo htmlspecialchars($category['categoryid']); ?>">
                                        <button type="submit" class="delete-btn"><img src="../assets/archive.png"
                                                alt=""></button>
                                    </form>
                                </td>

                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="3">No categories found.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Type Section -->
                <div class="section-container type-section">
                    <form action="../server/add_type.php" method="POST" class="add-type-form" id="add-type-form">

                        <h2 style="margin-bottom: 15px;">Product Type</h2>

                        <div class="form-group">
                            <label for="surname">Type Name</label>

                            <input type="text" id="type_name" name="typename" required>

                        </div>

                        <div style="display: flex; justify-content: flex-end; width: 100%;">
                            <?php if ($errorMessage): ?>
                            <div id="type-error-message" class="error-message-container">
                                <p style="color: red;"><?php echo htmlspecialchars($errorMessage); ?></p>
                            </div>
                            <?php endif; ?>
                            <?php if ($successMessage): ?>
                            <div id="type-success-message" class="success-message-container">
                                <p style="color: green;"><?php echo htmlspecialchars($successMessage); ?></p>
                            </div>
                            <?php endif; ?>
                            <button type="button" class="close-btn" id="clearBtn"
                                style="margin-right: 10px;">Clear</button>
                            <button class="add-btn" type="submit" style="cursor: pointer;">Add Type</button>
                        </div>
                    </form>
                    <!-- Type Table -->
                    <table style="margin-top: 30px;" border="1" cellpadding="10" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Type ID</th>
                                <th>Type Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($types)): ?>
                            <?php foreach ($types as $type): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($type['typeid']); ?></td>
                                <td><?php echo htmlspecialchars($type['typename']); ?></td>
                                <td>
                                    <!-- Delete Button -->
                                    <!-- <form action="../server/delete_type.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="typeid"
                                            value="?php echo htmlspecialchars($type['typeid']); ?>">
                                        <button type="submit" class="delete-btn">Delete</button>
                                    </form> -->

                                    <!-- Archive Button -->
                                    <form action="../server/archive_type.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="typeid"
                                            value="<?php echo htmlspecialchars($type['typeid']); ?>">
                                        <button type="submit" class="delete-btn"><img src="../assets/archive.png"
                                                alt=""></button>
                                    </form>
                                </td>

                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="3">No types found.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="section-container archive-section">
                    <div style="margin-bottom: 15px; width: 100%; display: flex; justify-content: flex-end;">


                        <label for="">Filter by</label>
                        <select name="" id="archive-select">
                            <option data-section="archiveAdmin style=" background-color: white; color: black;"
                                value="Admin">User
                                Type</option>
                            <option data-section="archiveAdmin" style="background-color: white; color: black;"
                                value="Admin">Admin</option>
                            <option data-section="archiveCategory" style="background-color: white; color: black;"
                                value="Category">Category</option>
                            <option data-section="archiveType" style="background-color: white; color: black;"
                                value="Type">Type</option>
                        </select>

                    </div>

                    <!-- Archive Category Section -->
                    <div style="display: none;" class="archive-container archiveCategory-section" id="archive-category">
                        <h2 style="margin-bottom: 15px;">Archived Categories</h2>
                        <table style="margin-top: 10px;" border="1" cellpadding="10" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Category ID</th>
                                    <th>Category Name</th>
                                    <th>Archived At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($archived_categories)): ?>
                                <?php foreach ($archived_categories as $category): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($category['categoryid']); ?></td>
                                    <td><?php echo htmlspecialchars($category['category_name']); ?></td>
                                    <td><?php echo htmlspecialchars($category['archived_at']); ?></td>
                                    <td>
                                        <form action="../server/restore_category.php" method="POST"
                                            style="display:inline;">
                                            <input type="hidden" name="categoryid"
                                                value="<?php echo htmlspecialchars($category['categoryid']); ?>">
                                            <button type="submit" class="delete-btn"><img src="../assets/archive.png"
                                                    alt=""></button>
                                        </form>
                                    </td>

                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="3">No archived categories found.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Archive Type Section -->
                    <div style="display: none;" class="archive-container archiveCategory-section" id="archive-type">
                        <h2 style="margin-bottom: 15px;">Archived Types</h2>
                        <table style="margin-top: 10px;" border="1" cellpadding="10" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Type ID</th>
                                    <th>Type Name</th>
                                    <th>Archived At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($archived_types)): ?>
                                <?php foreach ($archived_types as $type): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($type['typeid']); ?></td>
                                    <td><?php echo htmlspecialchars($type['typename']); ?></td>
                                    <td><?php echo htmlspecialchars($type['archived_at']); ?></td>
                                    <td>
                                        <form action="../server/restore_type.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="typeid"
                                                value="<?php echo htmlspecialchars($type['typeid']); ?>">
                                            <button type="submit" class="delete-btn"><img src="../assets/archive.png"
                                                    alt=""></button>
                                        </form>
                                    </td>

                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="3">No archived types found.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Archive Admin Section -->
                    <div class="archive-container archiveAdmin" id="archive-admin">
                        <h2 style="margin-bottom: 15px;">Archived Admins</h2>
                        <table style="margin-top: 10px;" border="1" cellpadding="10" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Admin ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($archived_admins)): ?>
                                <?php foreach ($archived_admins as $admin): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($admin['admin_id']); ?></td>
                                    <td><?php echo htmlspecialchars($admin['username']); ?></td>
                                    <td><?php echo htmlspecialchars($admin['email']); ?></td>
                                    <td><?php echo htmlspecialchars($admin['role']); ?></td>
                                    <td>
                                        <!-- Restore Button -->
                                        <form action="../server/restore_admin.php" method="POST"
                                            style="display:inline;">
                                            <input type="hidden" name="admin_id"
                                                value="<?php echo htmlspecialchars($admin['admin_id']); ?>">
                                            <button type="submit" class="restore-btn"><img src="../assets/archive.png"
                                                    alt=""></button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="5">No archived admins found.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="section-container account-section">
                <form id="adminForm" action="../server/add_admin.php" method="POST">
                        <div class="form-container">
                            <div class="left-form">
                                <h2 style="margin-bottom: 15px;">Personal Information</h2>
                                <div class="form-group">
                                    <label for="firstName">First Name</label>
                                    <input type="text" id="firstName" value="<?php echo $fname; ?>" name="first_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="middleName">Middle Name</label>
                                    <input type="text" id="middleName" name="middle_name">
                                </div>
                                <div class="form-group">
                                    <label for="surname">Surname</label>
                                    <input type="text" id="surname" name="surname" required>
                                </div>
                            </div>
                            <div class="right-form">
                                <h2 style="margin-bottom: 15px;">Account Information</h2>
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" id="username" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" required>
                                </div>
                            </div>
                        </div>
                        <div class="button-group">
                            <?php if ($errorMessage): ?>
                            <div id="error-message" class="error-message-container">
                                <p style="color: red;"><?php echo htmlspecialchars($errorMessage); ?></p>
                            </div>
                            <?php endif; ?>
                            <?php if ($successMessage): ?>
                            <div id="success-message" class="success-message-container">
                                <p style="color: green;"><?php echo htmlspecialchars($successMessage); ?></p>
                            </div>
                            <?php endif; ?>
                            <div style="dislay: flex;">
                                <button type="button" id="clearBtn" class="btn btn-cancel">Clear</button>
                                <button type="submit" class="btn btn-submit">Add Admin</button>
                            </div>
                        </div>
                    </form>
                </div>


            </div> <!-- Other Sections Here -->
        </div>
    </div>

    <script src="../script/setting_script.js"></script>
    <script>
    document.getElementById('archive-select').addEventListener('change', function() {
        var selectedValue = this.value;

        // Hide all sections
        document.querySelectorAll('.archive-container').forEach(function(container) {
            container.style.display = 'none';
        });

        // Show the selected section
        if (selectedValue === 'Admin') {
            document.getElementById('archive-admin').style.display = 'block';
        } else if (selectedValue === 'Category') {
            document.getElementById('archive-category').style.display = 'block';
        } else if (selectedValue === 'Type') {
            document.getElementById('archive-type').style.display = 'block';
        }
    });
    document.addEventListener("DOMContentLoaded", function() {
        // Handle success/error message visibility
        setTimeout(function() {
            const successMessage = document.getElementById("successmessage");
            if (successMessage) {
                successMessage.style.display = "none";
            }
            const errorMessage = document.getElementById("errormessage");
            if (errorMessage) {
                errorMessage.style.display = "none";
            }
        }, 3000);

        // Toggle Category Form
        document.getElementById("add-category-button").onclick = function() {
            const form = document.getElementById("add-category-form");
            form.style.display = form.style.display === "none" ? "flex" : "none";
        };
        document.getElementById("close-category-form").onclick = function() {
            const form = document.getElementById("add-category-form");
            form.style.display = "none";
        };

        // Toggle Type Form
        document.getElementById("add-type-button").onclick = function() {
            const form = document.getElementById("add-type-form");
            form.style.display = form.style.display === "none" ? "flex" : "none";
        };
        document.getElementById("close-type-form").onclick = function() {
            const form = document.getElementById("add-type-form");
            form.style.display = "none";
        };
    });
    </script>

</body>

</html>