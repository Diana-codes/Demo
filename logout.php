<?php
session_start(); // Start or resume the session

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect the user to the login page
header('Location: login.php');
exit();
?>
