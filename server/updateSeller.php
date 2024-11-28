<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include("connect.php");

    // Retrieve form values
    $username = $_POST['newusername'];
    $password = $_POST['newpassword'];
    $seller_email = $_POST['seller_email'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'] ?? null;
    $lastname = $_POST['lastname'];
    $contact = $_POST['contact'];
    $birthday = $_POST['birthday'];
    $age = $_POST['age'];
    $province = $_POST['province'];
    $municipality = $_POST['municipality'];
    $baranggay = $_POST['baranggay'];
    $houseno = $_POST['houseno'];
    $current_username = $_POST['current_username'];

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $passwordQuery = "password = :newpassword,";
    } else {
        $passwordQuery = ""; // Skip updating the password
    }
    
    // Update Query
    $updateQuery = "UPDATE sellertb 
                    SET
                        username = :newusername,
                        $passwordQuery
                        seller_email = :seller_email,
                        first_name = :firstname, 
                        middle_name = :middlename, 
                        last_name = :lastname, 
                        seller_contact = :seller_contact, 
                        birthday = :birthday, 
                        age = :age, 
                        province = :province, 
                        municipality = :municipality, 
                        baranggay = :baranggay, 
                        houseno = :houseno 
                    WHERE username = :current_username";
    
    $updateStmt = $conn->prepare($updateQuery);
    
    // Bind Parameters
    $params = [
        ':newusername' => $username,
        ':seller_email' => $seller_email,
        ':firstname' => $firstname,
        ':middlename' => $middlename,
        ':lastname' => $lastname,
        ':seller_contact' => $contact,
        ':birthday' => $birthday,
        ':age' => $age,
        ':province' => $province,
        ':municipality' => $municipality,
        ':baranggay' => $baranggay,
        ':houseno' => $houseno,
        ':current_username' => $current_username,
    ];
    if (!empty($password)) {
        $params[':newpassword'] = $hashedPassword;
    }
    
    try {
        $updateStmt->execute($params);
        header("Location: ../pages/seller-info.php");
    } catch (PDOException $e) {
        echo "Error updating seller info: " . $e->getMessage();
    }
    
}
?>
