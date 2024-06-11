<?php
// Include session management to start the session
// include 'session.php';
session_start();
// Unset all of the session variables
// $_SESSION = array();

// Finally, destroy the session
session_destroy();

// Redirect to the login page or home page
header("Location: login.html");
// exit();
?>
