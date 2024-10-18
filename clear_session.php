<?php
// clear stored email and redirect to homepage
session_start();
unset($_SESSION['reset_email']); // clear the stored email

header("Location: Homepage.php"); // redirect to homepage (login)
exit();
?>