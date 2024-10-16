<?php
session_start();
include("database.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$type = $_POST['type'];
	$email = $_POST['email'];
	$password = $_POST["password"];
	$passwordRepeat = $_POST["repeat_password"];

	$passwordHash = password_hash($_POST['password'],PASSWORD_DEFAULT); // secure password

	$errors = array(); // array to store error msgs

	// check if user already exists
	$sql = "SELECT * FROM userinfo WHERE email = ?;";
	$stmt = mysqli_prepare($conn, $sql);
	mysqli_stmt_bind_param($stmt,"s",$email);
	mysqli_stmt_execute($stmt);

	// fetch result
	$result = mysqli_stmt_get_result($stmt);

    // check whether if user already exists
	if (mysqli_num_rows($result) > 0) {
        // if user already exists, just display this error msg
		$_SESSION['errors'] = array("User already exists!");
        header("Location: signup.php");
        exit();
	}

    // validation check  
    if (empty($email) || empty($password) || empty($passwordRepeat)) {
        array_push($errors,"All fields are required");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid");
    }
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