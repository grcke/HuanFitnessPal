<?php
session_start();
include("database.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $errors = array(); // array to store error msgs

    // validation checks
    if (empty($email) || empty($password)) {
        $errors[] = "Email and password are required.";
    }

    // only run if there's no prior errors
    if (count($errors) == 0) {
        // check if user exists
        $sql = "SELECT userID, type, password FROM userinfo WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $userID, $type, $passwordHash);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            // user exists
            mysqli_stmt_fetch($stmt); // fetch data
    
            // verify password
            if (password_verify($password, $passwordHash)) {
                // if password is correct, store user type and user id in session to be used in other functions like admin features, user features..
                $_SESSION['email'] = $email;
                $_SESSION['user_type'] = $type;
                $_SESSION['user_id'] = $userID;

                // redirect each user to their respective pages
                header("Location: " . ($type == "user" ? "user.php" : "admin.php"));
                exit();
            }else{
                $errors[] = "Invalid password. Please try again.";
            }
        }else{
            $errors[] = "No user found with this email.";
        }
        mysqli_stmt_close($stmt);
    }

    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors; // store errors in session
        header("Location: Homepage.php");
        exit();
    }
}
mysqli_close($conn);
?>