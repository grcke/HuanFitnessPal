<?php
session_start();
include("database.php");

// check if user has entered a valid email
if (!isset($_SESSION['reset_email'])) {
    $_SESSION['errors'] = array("You need to enter a valid email before changing the password.");
    header("Location: forgot_password.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $repeat_password = $_POST['repeat_password'];

    $errors = array();

    // fetch the current password from the database using the session email
    $sql = "SELECT password FROM userinfo WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['reset_email']); // use the session email
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    // if email does not exist
    if (!$row) {
        $_SESSION['errors'] = array("No user found with that email.");
        unset($_SESSION['reset_email']); // clear the stored email
        header("Location: forgot_password.php");
        exit();
    }

    $current_password_hash = $row['password'];
    
    // validation checks
    if (empty($old_password) || empty($new_password) || empty($repeat_password)) {
        $errors[] = "All fields are required.";
    }else{  // when all fields are filled in
        if (!password_verify($old_password, $current_password_hash)) {
            $errors[] = "Old password is incorrect.";
        }else{ // when old password is correct
            // ensure that new password is not the same as before
            if (password_verify($new_password, $current_password_hash)) {
                $errors[] = "New password cannot be the same as the old password.";
            }
            if ($new_password !== $repeat_password) {
                $errors[] = "Passwords do not match.";
            }
            // additional password validation checks
            if (strlen($new_password) < 8) {
                $errors[] = "Password must be at least 8 characters long.";
            }
            if (!preg_match('/[A-Z]/', $new_password)) {
                $errors[] = "Password must contain at least one uppercase letter.";
            }
            if (!preg_match('/[0-9]/', $new_password)) {
                $errors[] = "Password must contain at least one number.";
            }
            if (!preg_match('/[\W_]/', $new_password)) {
                $errors[] = "Password must contain at least one special character (e.g., !@#$%^&*).";
            }
        }
    }

    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        header("Location: forgot_password.php");
        exit();
    } else {
        // update the user's password in the database
        $passwordHash = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE userinfo SET password = ? WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $passwordHash, $_SESSION['reset_email']); // use the session email
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Password updated successfully.";
        } else {
            $_SESSION['message'] = "Error updating password.";
        }

        mysqli_stmt_close($stmt);
        unset($_SESSION['reset_email']); // clear the stored email
        header("Location: forgot_password.php");
        exit();
    }
}
mysqli_close($conn);
?>
