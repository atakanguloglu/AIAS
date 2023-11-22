<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the signin page or any other desired page after signout
header("Location: signin.php");
exit();
?>