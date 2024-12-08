<?php

    // Database connection details
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'tianggedb';

    // Tables to back up with both structure and data
    $tablesWithData = [
        'admintb', 'sellertb', 'actlogtb', 'storetb', 'stalltb',
        'categorytb', 'producttypetb', 'platformtb', 'systeminfo'
    ];

    // Tables to back up with structure only
    $tablesWithStructureOnly = [
        'producttb','archived_admintb', 'archived_categories', 'archived_productypetb','product_img_tb'
    ];

    try {
        // Connect to the database
        $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $backupSQL = '';

        // Backup tables with both structure and data
        foreach ($tablesWithData as $table) {
            // Fetch the CREATE TABLE statement
            $stmt = $pdo->query("SHOW CREATE TABLE `$table`");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $createTableSQL = $row['Create Table'] . ";\n\n";

            // Fetch table data
            $dataStmt = $pdo->query("SELECT * FROM `$table`");
            $insertSQL = '';
            while ($row = $dataStmt->fetch(PDO::FETCH_ASSOC)) {
                $values = array_map([$pdo, 'quote'], array_values($row));
                $insertSQL .= "INSERT INTO `$table` VALUES (" . implode(", ", $values) . ");\n";
            }

            // Append the structure and data to the backup SQL
            $backupSQL .= "-- Table structure and data for `$table`\n";
            $backupSQL .= $createTableSQL . "\n";
            $backupSQL .= "-- Dumping data for table `$table`\n";
            $backupSQL .= $insertSQL . "\n\n";
        }

        // Backup tables with structure only
        foreach ($tablesWithStructureOnly as $table) {
            // Fetch the CREATE TABLE statement
            $stmt = $pdo->query("SHOW CREATE TABLE `$table`");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $createTableSQL = $row['Create Table'] . ";\n\n";

            // Append the structure to the backup SQL
            $backupSQL .= "-- Table structure only for `$table`\n";
            $backupSQL .= $createTableSQL . "\n\n";
        }

        // Save to a file
        $backupFile = '../backup/Backup_Data_' . date('m-d-Y') . '.sql';
        file_put_contents($backupFile, $backupSQL);

        header("Location: ../pages/settings.php?section=backup&success=Backup completed successfully.  $backupFile");

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

?>
