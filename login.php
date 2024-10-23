<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Log In</h1>

    <?php
    session_start();
    include("database.php");
    if (isset($_SESSION['errors'])) {
        foreach ($_SESSION['errors'] as $error) {
            echo "<div class='error'>$error</div>";
        }
        unset($_SESSION['errors']); // clear the errors after displaying
    }
    ?>

    <form action="login_process.php" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>
    <p><a href="forgot_password.php">Forgot Password?</a></p>
    <p>Don't have an account? <a href="signup.php">Create an account.</a></p>
</body>
</html>