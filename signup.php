<!DOCTYPE html>
<html lang="en">
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

.contain{
	width: 50%;
	height: 300px;
	background: #c4d7f5;
	color: black;
	padding: 60px;
	margin: 0 auto;
	border-style: ridge;
}

.signup{
	display: inline-block;
	float: left;
	text-align: center;
}

.condition{
	display: inline-block;
	float: right;
	text-align: center;
}

input{
	height: 30px;
	width: 210px;
}

select{
	height: 35px;
	width: 218px;
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

<div class="contain">
	<div class="signup">
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
			<select name="type" required style="margin-bottom: 10px;">
				<option value="user">User</option>
				<option value="admin">Admin</option>
			</select>
			
			<input type="email" name="email" placeholder="Email" required style="margin-bottom: 10px;"><br>
			
			<input type="password" name="password" placeholder="Password" id="password" required onkeyup="validatePassword()" style="margin-bottom: 10px;">

			<input type="password" name="repeat_password" placeholder="Repeat Password" required style="margin-bottom: 10px;">

			<!--reCAPTCHA widget -->
			<div class="g-recaptcha" align="center" data-sitekey="6LeE6mkqAAAAABtQbXRo5_Eh4ZIsoVna-zNOleji" style="margin-bottom: 10px;"></div>
			
			<input type="submit" value="Sign Up">
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
		
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	</div>
	
	<div class="condition" style="margin-top: 20px;">
		<p style="font-size: 20px;">Already registered? <a href="Homepage.php">Login here</a>.</p>

		<p style="font-size: 17px;">Password must meet the following requirements:</p>
		<ul style="text-align: left; font-size: 17px;">
			<li id="length" class="invalid">At least 8 characters long</li>
			<li id="uppercase" class="invalid">At least one uppercase letter (A-Z)</li>
			<li id="number" class="invalid">At least one number (0-9)</li>
			<li id="special" class="invalid">At least one special character (e.g., !@#$%^&*)</li>
		</ul>
	</div>
</div>
<footer>
	<h4>
	<i>Huan Sdn. Bhd</i><br>
	<i>All Rights Reserved&copy</i>
	</h4>
</footer>
</body>
</html>
