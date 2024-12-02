<?php
$host = "localhost"; // Database host
$username = "root";  // Database username
$password = "";      // Database password
$dbname = "tianggedb"; // Database name

if ($_FILES["backup_file"]["error"] === UPLOAD_ERR_OK) {
    $backupFile = $_FILES["backup_file"]["tmp_name"];

    // Command for restoring the database
    $command = "mysql --user=$username --password=$password --host=$host $dbname < $backupFile";

    // Execute the command
    exec($command, $output, $return_var);

    if ($return_var === 0) {
        echo json_encode([
            "status" => "success",
            "message" => "Restore successful!"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Restore failed!"
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Error uploading file!"
    ]);
}
?>
