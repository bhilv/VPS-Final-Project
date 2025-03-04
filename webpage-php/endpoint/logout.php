<?php
session_start();
// Unset all session variables and destroy the session
session_unset();
session_destroy();

// Redirect to login page (index.php)
header("Location: ../index.php");
exit();
?>
