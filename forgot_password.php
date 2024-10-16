<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        /* for invalid and valid password criteria */
        .invalid {
            color: gray;
        }
        .valid {
            color: green;
        }
    </style>
</head>
<body>
    <h1>Forgot Password</h1>

    <?php
    session_start();

    if (isset($_SESSION['errors'])) {
        foreach ($_SESSION['errors'] as $error) {
            echo "<div style='color: red; font-weight: bold;'>$error</div>";
        }
        unset($_SESSION['errors']); // clear errors after displaying
    }

    if (isset($_SESSION['message'])) {
        echo "<div style='color: green; font-weight: bold;'>{$_SESSION['message']}</div>";
        unset($_SESSION['message']); // clear message after displaying
    }

    // Show account info
    if (isset($_SESSION['reset_email'])) {
        echo "<div>You are resetting the password for the account: <strong>" . htmlspecialchars($_SESSION['reset_email']) . "</strong></div>";
    }
    ?>

    <form action="forgot_password_process.php" method="POST">
        <input type="email" name="email" placeholder="Enter your email" required>
        <input type="submit" value="Reset Password">
    </form>

    <?php if (isset($_SESSION['reset_email'])): ?>
        <h2>Reset Your Password</h2>
        <form action="reset_password.php" method="POST">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_SESSION['reset_email']); ?>">
            <input type="password" name="new_password" placeholder="New Password" id="new_password" required onkeyup="validatePassword()">
            <input type="password" name="repeat_password" placeholder="Repeat Password" required onkeyup="validatePassword()">

            <p>Password must meet the following requirements:</p>
            <ul>
                <li id="length" class="invalid">At least 8 characters long</li>
                <li id="uppercase" class="invalid">At least one uppercase letter (A-Z)</li>
                <li id="number" class="invalid">At least one number (0-9)</li>
                <li id="special" class="invalid">At least one special character (e.g., !@#$%^&*)</li>
            </ul>

            <input type="submit" value="Change Password">
        </form>
    <?php endif; ?>

    <form action="clear_session.php" method="POST" style="display:inline;">
        <br>
        <input type="submit" value="Go Back" class="back-button">
    </form>
    

    <script>
    // function to validate password
    function validatePassword() {
        var password = document.getElementById("new_password").value;
        
        // validate length
        if (password.length >= 8) {
            document.getElementById("length").classList.remove("invalid");
            document.getElementById("length").classList.add("valid");
        } else {
            document.getElementById("length").classList.remove("valid");
            document.getElementById("length").classList.add("invalid");
        }

        // validate uppercase letters
        if (/[A-Z]/.test(password)) {
            document.getElementById("uppercase").classList.remove("invalid");
            document.getElementById("uppercase").classList.add("valid");
        } else {
            document.getElementById("uppercase").classList.remove("valid");
            document.getElementById("uppercase").classList.add("invalid");
        }

        // validate numbers
        if (/[0-9]/.test(password)) {
            document.getElementById("number").classList.remove("invalid");
            document.getElementById("number").classList.add("valid");
        } else {
            document.getElementById("number").classList.remove("valid");
            document.getElementById("number").classList.add("invalid");
        }

        // validate special characters
        if (/[\W_]/.test(password)) { 
            document.getElementById("special").classList.remove("invalid");
            document.getElementById("special").classList.add("valid");
        } else {
            document.getElementById("special").classList.remove("valid");
            document.getElementById("special").classList.add("invalid");
        }
    }
    </script>
</body>
</html>
