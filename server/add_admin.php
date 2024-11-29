<?php
// Include database connection file
require_once('connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firstName = $_POST['first_name'];
    $middleName = $_POST['middle_name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Check if the username or email already exists
        $checkQuery = "SELECT * FROM admintb WHERE username = :username OR email = :email";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // If the username or email already exists, redirect with an error message
            header('Location: ../pages/settings.php?error=Username or email already exists');
            exit;
        } else {
            // Prepare the insert query
            $sql = "INSERT INTO admintb (first_name, middle_name, surname, email, username, password) 
                    VALUES (:first_name, :middle_name, :surname, :email, :username, :password)";

            // Prepare the statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters to the query
            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':middle_name', $middleName);
            $stmt->bindParam(':surname', $surname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);

            // Execute the query
            if ($stmt->execute()) {
                // Redirect with a success message
                header('Location: ../pages/settings.php?success=Admin added successfully');
                exit;
            } else {
                // If there was an error adding the admin
                header('Location: ../pages/settings.php?error=Error adding admin');
                exit;
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
