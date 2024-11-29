<?php
// Check if there's an error or success message passed via URL query parameters
$errorMessage = isset($_GET['error']) ? $_GET['error'] : '';
$successMessage = isset($_GET['success']) ? $_GET['success'] : '';

list($categoryHTML, $categories) = include_once '../server/fetchcategory.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Tiangge Taytay</title>
    <link rel="stylesheet" href="../style/sidebarr.css">
    <link rel="stylesheet" href="../style/setting.css">
</head>

<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');


@font-face {
    font-family: "Kenzoestic";
    src: url("./kenzoestic/Kenzoestic\ Black.ttf");
}

body {
    font-family: 'Roboto';
}

#add-category-form {
    padding: 10px;
    top: 50%;
    left: 70%;
    transform: translate(-50%, -50%);
    flex-direction: column;
    position: absolute;
    border-radius: 10px;
    border: 1px solid #d2d2d2;
    width: 350px;
    height: 180px;
    background-color: white;
    justify-content: space-around;
    align-items: flex-start;

}

#add-category-form img {
    width: 15px;
    height: 15px;
    cursor: pointer;
    text-align: right;
}

#add-category-form input {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;

}

#add-category-form button {
    width: 90px;
    font-weight: 600;
    padding: 10px;
}

.close-btn {
    background-color: white;
    border: 1px solid #0033A0;
    color: #0033A0;
}

.add-btn {

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


.search button {
    font-weight: 600;
    color: white;
    width: 90px;
    height: 40px;
    border: none;
    background-color: #0033A0;
    cursor: pointer;
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

<pre>
<?php print_r($types); ?>
</pre>

    <div class="top-bar"></div>

    <!-- Main Content -->
    <div class="main-container">
        <h2 class="header">SETTINGS</h2>
        <div class="main-content">
            <div class="left-container">
                <p class="sidebar-item active" data-section="admin">Admin</p>
                <p class="sidebar-item" data-section="categories">Categories</p>
                <p class="sidebar-item" data-section="type">Product Type</p>
                <p class="sidebar-item" data-section="general-information">General Information</p>
                <p class="sidebar-item" data-section="backup-restore">Back-up & Restore</p>
                <p class="sidebar-item" data-section="account-information">Account Information</p>
            </div>


            <div class="right-container">
                <!-- Display error message if it exists -->


                <!-- Admin Section (Initially Active) -->
                <div class="section-container admin-section active">
                    <h2 class="section-header">Admin</h2>
                    <form id="adminForm" action="../server/add_admin.php" method="POST">
                        <div class="form-container">
                            <div class="left-form">
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



                <div class="section-container categories-section">
                    <form action="../server/add_category.php" method="POST" class="add-category-form"
                        id="add-category-form" style="display: none;">
                        <h3>Add Category</h3>
                        <input type="text" id="category_name" placeholder="Category Name" name="category_name" required>
                        <div style="display: flex; justify-content: flex-end; width: 100%;">
                            <button class="close-btn" id="close" style="margin-right: 10px;">CLOSE</button>
                            <button class="add-btn" type="submit" style="cursor: pointer;">ADD</button>
                        </div>
                    </form>
                    <h2 style="margin-bottom: 15px;">Category</h2>
                    <div class="search">
                        <input placeholder="Search..." type="text">
                        <button type="button" id="add-button">ADD</button>
                    </div>

                    <!-- Table to display categories -->
                    <table border="1" cellpadding="10" cellspacing="0">
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
                                    <!-- Delete Button with category ID -->
                                    <form action="../server/delete_category.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="categoryid"
                                            value="<?php echo htmlspecialchars($category['categoryid']); ?>">
                                        <button type="submit"
                                            onclick="return confirm('Are you sure you want to delete this category?')"
                                            class="delete-btn">Delete</button>
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
                    <div class="message-container">

                        <?php if (isset($_GET['success'])): ?>
                        <div id="error-message" class="error-message-container">
                            <p style="color: red;"><?php echo htmlspecialchars($_GET['success']); ?></p>
                        </div>
                        <?php endif; ?>
                        <?php if (isset($_GET['error'])): ?>
                        <div id="success-message" class="success-message-container">
                            <p style="color: green;"><?php echo htmlspecialcharsv ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="section-container type-section">
                    <form action="../server/add_type.php" method="POST" class="add-type-form" id="add-type-form"
                        style="display: none;">
                        <h3>Add Type</h3>
                        <input type="text" id="type_name" placeholder="Type Name" name="type_name" required>
                        <div style="display: flex; justify-content: flex-end; width: 100%;">
                            <!-- <button class="close-btn" id="close" style="margin-right: 10px;">CLOSE</button> -->
                            <button class="add-btn" type="submit" style="cursor: pointer;">ADD</button>
                        </div>
                    </form>
                    <h2 style="margin-bottom: 15px;">Type</h2>
                    <div class="search">
                        <input placeholder="Search..." type="text">
                        <button type="button" id="add-button">ADD</button>
                    </div>

                    <!-- Table to display types -->
                    <table border="1" cellpadding="10" cellspacing="0">
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
                                    <!-- Delete Button with type ID -->
                                    <form action="../server/delete_type.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="typeid"
                                            value="<?php echo htmlspecialchars($type['typeid']); ?>">
                                        <button type="submit"
                                            onclick="return confirm('Are you sure you want to delete this type?')"
                                            class="delete-btn">Delete</button>
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
                    <div class="message-container">

                        <?php if (isset($_GET['success'])): ?>
                        <div id="error-message" class="error-message-container">
                            <p style="color: red;"><?php echo htmlspecialchars($_GET['success']); ?></p>
                        </div>
                        <?php endif; ?>
                        <?php if (isset($_GET['error'])): ?>
                        <div id="success-message" class="success-message-container">
                            <p style="color: green;"><?php echo htmlspecialchars($_GET['error']); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>



            </div> <!-- Other Sections Here -->

        </div>
    </div>




    </div>
    <script src="../script/adding-admin.js"></script>
    <script>
    setTimeout(function() {
        // Check if there's a success message and hide it
        var successMessage = document.getElementById("successmessage");
        if (successMessage) {
            successMessage.style.display = "none";
        }

        // Check if there's an error message and hide it
        var errorMessage = document.getElementById("errormessage");
        if (errorMessage) {
            errorMessage.style.display = "none";
        }
    }, 3000); // 3000 milliseconds = 3 seconds

    document.getElementById("add-button").onclick = function() {
        var form = document.getElementById("add-category-form");
        // Toggle the form visibility
        if (form.style.display === "none") {
            form.style.display = "flex"; // Show the form
        } else {
            form.style.display = "none"; // Hide the form
        }
    };

    document.getElementById("close").onclick = function() {
        var form = document.getElementById("add-category-form");
        // Toggle the form visibility
        if (form.style.display === "flex") {
            form.style.display = "none"; // Show the form
        }
    };

    setTimeout(function() {
        // Check if there's a success message and hide it
        var successMessage = document.getElementById("successmessage");
        if (successMessage) {
            successMessage.style.display = "none";
        }

        // Check if there's an error message and hide it
        var errorMessage = document.getElementById("errormessage");
        if (errorMessage) {
            errorMessage.style.display = "none";
        }
    }, 3000); // 3000 milliseconds = 3 seconds

    document.getElementById("add-button").onclick = function() {
        var form = document.getElementById("add-type-form");
        // Toggle the form visibility
        if (form.style.display === "none") {
            form.style.display = "flex"; // Show the form
        } else {
            form.style.display = "none"; // Hide the form
        }
    };

    document.getElementById("close").onclick = function() {
        var form = document.getElementById("add-type-form");
        // Toggle the form visibility
        if (form.style.display === "flex") {
            form.style.display = "none"; // Hide the form
        }
    };
    </script>

</body>

</html>