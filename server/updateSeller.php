<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    include("connect.php");

    // Retrieve form values
    $username = $_POST['username'];
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

    try {
        // Update seller information
        $updateQuery = "UPDATE sellertb 
                        SET first_name = :firstname, 
                            middle_name = :middlename, 
                            last_name = :lastname, 
                            seller_contact = :seller_contact, 
                            birthday = :birthday, 
                            age = :age, 
                            province = :province, 
                            municipality = :municipality, 
                            baranggay = :baranggay, 
                            houseno = :houseno 
                        WHERE username = :username";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->execute([
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
            ':username' => $username,
        ]);

        header("Location: ../pages/seller-info.php");
    } catch (PDOException $e) {
        echo "<script>alert('Error updating seller info: " . $e->getMessage() . "');</script>";
    }
}
?>
