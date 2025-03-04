<?php
include('../conn/conn.php');

// Only handle POST requests from the login form
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../index.php");
    exit();
}

// Retrieve username and password from POST data
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Prepare and execute a query to get the stored hash for this username
$stmt = $conn->prepare("SELECT `tbl_user_id`, `password` FROM `tbl_user` WHERE `username` = :username");
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $storedHash = $user['password'];

    // Verify the entered password against the stored hash
    if (password_verify($password, $storedHash)) {
        // Password is correct – log the user in
        session_regenerate_id(true);  // prevent session fixation by regenerating ID :contentReference[oaicite:3]{index=3}
        // Store important user data in session
        $_SESSION['user_id']   = $user['tbl_user_id'];
        $_SESSION['username']  = $username;
        // (Optional) you could store other info like first name for greeting, if needed.

        // Redirect to the protected home page (dashboard)
        header("Location: ../home.php");
        exit();
    } else {
        // Password is incorrect
        header("Location: ../index.php?error=1");  // redirect back to login form with error
        exit();
    }
} else {
    // No user found with that username
    header("Location: ../index.php?error=1");
    exit();
}
?>
