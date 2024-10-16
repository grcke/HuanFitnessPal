<?php
session_start();
unset($_SESSION['reset_email']); // clear the stored email

header("Location: login.php"); // redirect to login page
exit();
?>