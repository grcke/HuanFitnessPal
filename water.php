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

.water{
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
?>

<body>
<header>
	<h1 style="font-size: 40px">Huan Fitness Pal</h1>
	<h4 style="font-size: 20px"><i>For all your fitness needs...</i></h4>
</header>

<!--page functions within this div here-->
<div class="water">
	<h3> Welcome to Huan Fitness Pal, <?php echo $_SESSION['email']; ?>! </h3>

	<form action="water_process.php" method="POST">
    <label for="date">Date:</label>
    <input type="datetime-local" name="date" id="date" required>
    <label for="water"><br>Water Consumption (Liters):</label>
    <input type="number" name="water" id="water" step=".01" required>
	<br>
    <input type="submit" value="Submit">
	</form>

	<form action="user.php" method="POST">
			<input type="submit" value="Back">
	</form>

	<?php
	$_POST['dbname'] = 'water';
	include 'gettable.php'; ?>

</div>

<footer>
	<h4>
	<i>Huan Sdn. Bhd</i><br>
	<i>All Rights Reserved&copy</i>
	</h4>
</footer>

</body>
</html>