<?php
session_start();
include("database.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$type = $_POST['type'];
	$email = $_POST['email'];
	$password = $_POST["password"];
	$passwordRepeat = $_POST["repeat_password"];
    $recaptchaResponse = $_POST['g-recaptcha-response'];

	$passwordHash = password_hash($_POST['password'],PASSWORD_DEFAULT); // secure password

	$errors = array(); // array to store error msgs

    // verify reCAPTCHA
    $secretKey = "6LeE6mkqAAAAAFRTu01gQe53i8rHXK6xMU-fUrDa";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}");
    $responseKeys = json_decode($response, true);

    // check if the reCAPTCHA was successful
    if (intval($responseKeys["success"]) !== 1) {
        $_SESSION['errors'][] = "Please complete the reCAPTCHA.";
        header("Location: signup.php");
        exit();
    }

    // validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid");
    } else {
        // check if user already exists
        $sql = "SELECT * FROM userinfo WHERE email = ?;";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // check whether user already exists
        if (mysqli_num_rows($result) > 0) {
            array_push($errors, "User already exists!");
        }
    }

    // validation check  
    if (empty($email) || empty($password) || empty($passwordRepeat)) {
        array_push($errors,"All fields are required");
    }else{
        // when all fields are filled in
        // password validation
        if (strlen($password)<8) {
            array_push($errors,"Password must be at least 8 characters long");
        }
        if (!preg_match('/[A-Z]/', $password)) {
            array_push($errors, "Password must contain at least one uppercase letter");
        }
        if (!preg_match('/[0-9]/', $password)) {
            array_push($errors, "Password must contain at least one number");
        }
        if (!preg_match('/[\W_]/', $password)) {
            array_push($errors, "Password must contain at least one special character (e.g., !@#$%^&*)");
        }
        if ($password!==$passwordRepeat) {
            array_push($errors,"Password does not match");
        }
    }
    
		
    // if there's errors display them in signup.php
    if (count($errors)>0){
        $_SESSION['errors'] = $errors;  // store errors in session
        header("Location: signup.php");
        exit();
    }else{
        // no errors, proceed
		$sql = "INSERT INTO userinfo (type, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $type, $email, $passwordHash);

		if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "User registered successfully!";
            $_SESSION['email'] = $email;
            $_SESSION['user_type'] = $type;
            $_SESSION['userID'] = mysqli_insert_id($conn);

            if ($type === 'admin') {
                header("Location: admin.php"); // redirect to admin page ! UPDATE !
            } else {
                header("Location: user.php"); // redirect to user page ! UPDATE !
            }
            exit();
        } else {
            $_SESSION['errors'] = array("Error: " . mysqli_error($conn));
        }
        header("Location: signup.php");  // redirect back to the form after success/error
        exit();
    }
}
mysqli_close($conn);
?>