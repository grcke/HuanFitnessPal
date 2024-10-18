<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
    <h1>Sign Up</h1>

    <!-- display error messages -->
    <?php
        session_start();
        if (isset($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $error) {
                echo "<div style='color: red;'>$error</div>";
            }
            unset($_SESSION['errors']); // clear errors after displaying
        }
        if (isset($_SESSION['success'])) {
            echo "<div style='color: green;'>" . $_SESSION['success'] . "</div>";
            unset($_SESSION['success']); // clear success message after displaying
        }
    ?>

    <form action="signup_process.php" method="POST">
        <select name="type" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        
        <input type="email" name="email" placeholder="Email" required>
        
        <input type="password" name="password" placeholder="Password" id="password" required onkeyup="validatePassword()">

        <input type="password" name="repeat_password" placeholder="Repeat Password" required>
        
        <input type="submit" value="Sign Up">

        <p>Already registered? <a href="Homepage.php">Login here</a>.</p>

        <p>Password must meet the following requirements:</p>
        <ul>
            <li id="length" class="invalid">At least 8 characters long</li>
            <li id="uppercase" class="invalid">At least one uppercase letter (A-Z)</li>
            <li id="number" class="invalid">At least one number (0-9)</li>
            <li id="special" class="invalid">At least one special character (e.g., !@#$%^&*)</li>
        </ul>
    </form>

    <script>
    // function to validate password
    function validatePassword() {
        var password = document.getElementById("password").value;
        
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
