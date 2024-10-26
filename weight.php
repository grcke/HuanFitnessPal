<?php
session_start();
?>

<h3> Welcome to Huan Fitness Pal!, <?php echo $_SESSION['email']; ?> </h3>

<p> You can record your weight here </p>

<form action="weight_process.php" method="POST">
    <label for="date">Date:</label>
    <input type="date" name="date" id="date" required>
    <label for="weight">Weight:</label>
    <input type="text" name="weight" id="weight" required>
    <input type="submit" value="Submit">
</form>

<form action="user.php" method="POST">
        <input type="submit" value="Back">
</form>


<p> to-do show weight records...</p>
