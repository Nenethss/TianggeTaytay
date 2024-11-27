<?php


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Tiangge Taytay</title>
    <link rel="stylesheet" href="../style/sidebar.css">
    <link rel="stylesheet" href="../style/users.css">

</head>

<body>
    <!-- Sidebar -->
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
            <li class="active">
                <a href="users.php">
                    <img class="sidebar-icon" src="../assets/users-white.png" alt="Users"
                        data-active-src="../assets/users-white.png"> Users
                </a>
            </li>
            <li>
                <a href="reports.php">
                    <img class="sidebar-icon" src="../assets/reports.png" alt="Reports"
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

    <!-- Main content -->
    <div class="content">
        <div class="top-bar"></div>
        <h1>E-TIANGGE PORTAL</h1>
        <!-- Container to hold search box and dropdown side by side -->
        <div class="container">
            <!-- Search Box -->
            <input type="text" id="search" placeholder="Search..." onkeyup="searchData()">

            <!-- Dropdown to select which table to display -->
            <form method="GET">
                <select name="table_select" onchange="this.form.submit()">
                    <option value="seller"
                        <?php echo isset($_GET['table_select']) && $_GET['table_select'] == 'seller' ? 'selected' : ''; ?>>
                        Seller Table</option>
                    <option value="administrator"
                        <?php echo isset($_GET['table_select']) && $_GET['table_select'] == 'administrator' ? 'selected' : ''; ?>>
                        Administrator Table</option>
                </select>
            </form>
        </div>

        <div id="table-container">
            <!-- The tables will be loaded dynamically here -->
        </div>
    </div>

    <script>
    // Get all the sidebar list items (excluding logout)
    const sidebarItems = document.querySelectorAll('.sidebar ul li:not(.logout)');

    // Loop through all sidebar items and add a click event listener
    sidebarItems.forEach(item => {
        item.addEventListener('click', function() {
            // Remove the 'active' class from all items and revert their icons to blue
            sidebarItems.forEach(i => {
                i.classList.remove('active'); // Remove 'active' class from all items
                const icon = i.querySelector('.sidebar-icon');
                const defaultIconSrc = icon.getAttribute('src').replace('-white',
                ''); // Get the default blue icon (remove any '-white' part)
                icon.src = defaultIconSrc; // Set the icon back to the default blue
            });

            // Add the 'active' class to the clicked item and change its icon to white
            this.classList.add('active');
            const icon = this.querySelector('.sidebar-icon');
            const activeIconSrc = icon.getAttribute('data-active-src'); // Get the white icon path
            icon.src = activeIconSrc; // Set the icon to the white version
        });
    });

    // Function to perform search
    function searchData() {
        let searchTerm = document.getElementById('search').value;
        let tableSelect = document.querySelector('[name="table_select"]').value;

        // Prepare the URL with search term and selected table
        let url = '../server/fetch_data.php?search=' + searchTerm + '&table_select=' + tableSelect;

        // Make the AJAX request to fetch data
        fetch(url)
            .then(response => response.text())
            .then(data => {
                // Update the table container with the returned HTML
                document.getElementById('table-container').innerHTML = data;
            });
    }

    // Automatically call the search function when the page loads to display the initial table
    window.onload = searchData;
    </script>
</body>

</html>