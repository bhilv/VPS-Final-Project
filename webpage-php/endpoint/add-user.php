<?php
include ('../conn/conn.php');

$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$contactNumber = $_POST['contact_number'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

try {
    // Check if the user already exists
    $stmt = $conn->prepare("SELECT `first_name`, `last_name` FROM `tbl_user` WHERE `first_name` = :first_name AND `last_name` = :last_name");
    $stmt->execute([
        'first_name' => $firstName,
        'last_name' => $lastName
    ]);
    $nameExist = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($nameExist)) {
        // Begin transaction
        $conn->beginTransaction();

        // **Hash the password before storing it**
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the insert statement
        $insertStmt = $conn->prepare("INSERT INTO `tbl_user` (`tbl_user_id`, `first_name`, `last_name`, `contact_number`, `email`, `username`, `password`) 
                                      VALUES (NULL, :first_name, :last_name, :contact_number, :email, :username, :password)");

        // Bind parameters
        $insertStmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
        $insertStmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $insertStmt->bindParam(':contact_number', $contactNumber, PDO::PARAM_STR); // Changed from INT to STR to avoid leading zero issues
        $insertStmt->bindParam(':email', $email, PDO::PARAM_STR);
        $insertStmt->bindParam(':username', $username, PDO::PARAM_STR);
        $insertStmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR); // Store the hashed password

        $insertStmt->execute();

        // Commit the transaction
        $conn->commit();

        echo "
        <script>
            alert('Registered Successfully');
            window.location.href = 'http://vps-final-project-for-cyber-academy-hi-michael.xyz/index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('User Already Exists');
            window.location.href = 'http://vps-final-project-for-cyber-academy-hi-michael.xyz/index.php';
        </script>
        ";
    }

} catch (PDOException $e) {
    // Rollback transaction if something fails
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}

?>
