<!DOCTYPE HTML>
<html>
<style>

header{
	right: 0;
	left: 0;
	text-align: center;
	color: white; 
	background: #405dde;
	border-style: ridge;
	margin: 0 auto;
	padding-top: 20px;
	padding-bottom: 20px;
	margin-bottom: 20px;
}

body{
	background-image: url('https://st4.depositphotos.com/1022135/25748/i/450/depositphotos_257486682-stock-photo-group-young-people-sportswear-talking.jpg');
	background-size: cover;
	margin: 0;
	right: 0;
	left: 0;
}

.forgot{
	width: 40%;
	height: 250px;
	background: #c4d7f5;
	color: black;
	text-align: center;
	padding: 70px;
	margin: 0 auto;
	font-size: 120%;
	border-style: ridge;
}

input{
	height: 30px;
	width: 210px;
}

.invalid {
	color: gray;
}
.valid {
	color: green;
}

footer{
	right: 0;
	left: 0;
	text-align: center;
	color: white; 
	background: #405dde;
	border-style: ridge;
	margin: 0 auto;
	padding-top: 20px;
	padding-bottom: 20px;
	position: fixed;
	bottom: 0;
	border-style: ridge;
}
</style>

<body>

<header>
	<h1 style="font-size: 40px">Huan Fitness Pal</h1>
	<h4 style="font-size: 20px"><i>For all your fitness needs...</i></h4>
</header>

<div class="forgot">
    <h1 style="font-size: 35px">Forgot Password?</h1>
	<h4 style="font-size: 20px">Please input your email address.</h4>

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

    <!-- only show this form when the user has not chosen their email yet -->
    <?php if (!isset($_SESSION['reset_email'])): ?>
        <form action="forgot_password_process.php" method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="submit" value="Reset Password">
        </form>
    <?php endif; ?>

    <!-- only show this form when the user has chosen the email they want to reset password for -->
    <?php if (isset($_SESSION['reset_email'])): ?>
        <h2>Reset Your Password</h2>
        <form action="reset_password.php" method="POST">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_SESSION['reset_email']); ?>">
            <input type="password" name="old_password" placeholder="Old Password" id="old_password" required onkeyup="validatePassword()"><br><br>
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

    <form action="clear_session.php" method="POST" id="goBackForm" style="display:inline;">
        <br>
        <input type="submit" value="Go Back" class="back-button">
    </form>
    
    <script>
        var goBackClicked = false; // to track if the go back button was clicked
        var isSubmittingForm = false;

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

        // only show the confirmation when reset_email is set
        <?php if (isset($_SESSION['reset_email'])): ?>
        window.addEventListener("beforeunload", function (e) {
            // if Go Back button was clicked or if user is submitting form, don't show confirmation
            if (goBackClicked || isSubmittingForm) return;

            navigator.sendBeacon('clear_session.php'); // clear the session when leaving the page

            var confirmationMessage = "Are you sure you want to leave? This will reset what you've entered.";
            e.returnValue = confirmationMessage; 
            return confirmationMessage;
        });

        // confirmation for the "Go Back" button
        document.getElementById("goBackForm").addEventListener("submit", function(e) {
            goBackClicked = true; 

            var confirmation = confirm("Are you sure you want to go back? You will lose all your entered information.");
            if (!confirmation) {
                goBackClicked = false;  // reset if user cancels pop up
                e.preventDefault();  // prevent form submission
            }
        });

        // set the submitting flag when the form is submitted
        document.querySelector('form[action="reset_password.php"]').addEventListener("submit", function() {
            isSubmittingForm = true;
        });
        <?php endif; ?>
    
    </script>
</div>

<footer>
	<h4>
	<i>Huan Sdn. Bhd</i><br>
	<i>All Rights Reserved&copy</i>
	</h4>
</footer>

</body>
</html>
