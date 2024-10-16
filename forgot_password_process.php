<?php
session_start();
include("database.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // check if the email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errors'] = array("Invalid email format.");
        unset($_SESSION['reset_email']); // clear the stored email
        header("Location: forgot_password.php");
        exit();
    }

    // check if the user exists
    $sql = "SELECT * FROM userinfo WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['reset_email'] = $email; // store email temporarily
        $_SESSION['message'] = "Valid Account!";
    } else {
        $_SESSION['errors'] = array("No user found with that email.");
        unset($_SESSION['reset_email']); // clear the stored email
    }

    mysqli_stmt_close($stmt);
    header("Location: forgot_password.php");
    exit();
}
mysqli_close($conn);
?>
