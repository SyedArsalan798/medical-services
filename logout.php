<?php
session_start();

// Unset the doctor dashboard session variables
unset($_SESSION['patient_id']);
unset($_SESSION['email']);
unset($_SESSION['password']);

// Redirect to the login page
header('Location: login.php');
exit;
?>