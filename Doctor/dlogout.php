<?php
session_start();

// Unset the doctor dashboard session variables
unset($_SESSION['demail']);
unset($_SESSION['dpassword']);

// Redirect to the login page
header('Location: dlogin.php');
exit;
?>
