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

.login{
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

p{
	font-size: 90%;
}

input{
	height: 30px;
	width: 210px;
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

<body>
<header>
	<h1 style="font-size: 40px">Huan Fitness Pal</h1>
	<h4 style="font-size: 20px"><i>For all your fitness needs...</i></h4>
</header>

<!--
creates a div which then calls and hosts the elements from login.php
this is not used for the other phps due to inconvenience - the format used for this php was as a test and it stuck
-->
<div class="login">
	<?php include 'login.php';?>
</div>

<footer>
	<h4>
	<i>Huan Sdn. Bhd</i><br>
	<i>All Rights Reserved&copy</i>
	</h4>
</footer>

</body>
</html>
