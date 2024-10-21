<?php
session_start();
?>

<h3> Welcome to Huan Fitness Pal!, <?php echo $_SESSION['email']; ?> </h3>

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

<form action="logout.php" method="POST">
        <input type="submit" value="Logout">
</form>