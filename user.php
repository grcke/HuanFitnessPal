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
	margin: 0;
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

/*
Actual magic with 1% height and hidden overflow
which allows the div to expand with the content.
*/
.user{
	width: 50%;
	height: 1%;
	background: #c4d7f5;
	color: black;
	text-align: center;
	padding: 70px;
	margin: 0 auto;
	font-size: 120%;
	border-style: ridge;
	overflow: hidden;
	margin-bottom: 150px;
}

input{
	height: 40px;
	width: 250px;
	font-size: 75%;
}

footer{
	position: fixed; 
	right: 0;
	left: 0;
	text-align: center;
	color: white; 
	background: #405dde;
	border-style: ridge;
	margin: 0 auto;
	padding-top: 20px;
	padding-bottom: 20px;
	bottom: 0;
	border-style: ridge;
}

</style>


<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'user') {
    header("Location: Homepage.php");
    exit();
}
?>

<body>
<header>
	<h1 style="font-size: 40px">Huan Fitness Pal</h1>
	<h4 style="font-size: 20px"><i>For all your fitness needs...</i></h4>
</header>

<div class="user">
	<h3> Welcome to Huan Fitness Pal, <?php echo $_SESSION['email']; ?>! </h3>

	<form action="weight.php" method="POST">
			<input type="submit" value="Body Weight Records">
	</form>

	<form action="exercise.php" method="POST">
			<input type="submit" value="Exercise Records">
	</form>

	<form action="water.php" method="POST">
			<input type="submit" value="Water Consumption Records">
	</form>

	<form action="nutritionist.php" method="POST">
			<input type="submit" value="Book Appointment with Nutritionist">
	</form>

	<form action="contact.php" method="POST">
			<input type="submit" value="Contact Us">
	</form>

	<form action="news.php" method="POST">
			<input type="submit" value="News">
	</form>

	<form action="logout.php" method="POST">
			<input type="submit" value="Logout">
	</form>
</div>

<footer>
	<h4>
	<i>Huan Sdn. Bhd</i><br>
	<i>All Rights Reserved&copy</i>
	</h4>
</footer>

</body>
</html>