<?php
// Include database connection file
require_once('connect.php');

// Set the backup file name and location
$backupFile = 'backup_' . date('Y-m-d_H-i-s') . '.sql';

// Full path to mysqldump if needed (adjust for your system)
$command = "D:/xampp/mysql/bin/mysqldump -u $username -p$password $database > $backupFile";

// Execute the command and capture output
exec($command, $output, $return_var);

// Check if the command was successful
if ($return_var === 0) {
    echo "Backup created successfully!";
    echo "<br><a href='$backupFile' download>Download Backup</a>";
} else {
    echo "Backup failed. Please check your database configuration.";
    echo "<br>Return Status: $return_var";
    echo "<br>Error Output: ";
    print_r($output);
}
?>
