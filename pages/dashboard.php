<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Tiangge Taytay</title>
    <link rel="stylesheet" href="../style/sidebar.css">
    <link rel="stylesheet" href="../style/dashboard.css">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="../assets/e-logo.png" alt="Logo">
        </div>
        <ul>
            <li class="active">
                <a href="dashboard.php">
                    <img class="sidebar-icon" src="../assets/dashboard-white.png" alt="Dashboard"
                        data-active-src="../assets/dashboard-white.png"> Dashboard
                </a>
            </li>
            <li>
                <a href="users.php">
                    <img class="sidebar-icon" src="../assets/users.png" alt="Users"
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
        <h1>Dashboard</h1>
        <div class="top-bar"></div>
        <h1>Dashboard</h1>
        <div class="top-bar"></div>
        <h1>Dashboard</h1>
        <div class="top-bar"></div>
        <h1>Dashboard</h1>
        <div class="top-bar"></div>
        <h1>Dashboard</h1>
        <div class="top-bar"></div>
        <h1>Dashboard</h1>
        <div class="top-bar"></div>
        <h1>Dashboard</h1>
        <div class="top-bar"></div>
        <h1>Dashboard</h1>
        <div class="top-bar"></div>
        <h1>Dashboard</h1>
        <div class="top-bar"></div>
        <h1>Dashboard</h1>
        <div class="top-bar"></div>
        <h1>Dashboard</h1>
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
    </script>
</body>

</html>