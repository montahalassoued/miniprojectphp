<?php
// Start the session
session_start();

// Destroy all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page or home page
header("Location: auth.php"); // You can change this to home.php or wherever you want to redirect the user
exit();
?>
