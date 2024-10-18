<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Request</title>
</head>
<body>

<h2>User Request</h2>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <label for="requestdate">Date</label><br>
    <input type="date" id="date" name="requestdate" value="<?= date("Y-m-d") ?>" max="2025-12-31" min="<?= date("Y-m-d") ?>" required><br>
    
    <label for="requesttime">Time</label><br>
    <input type="time" id="time" name="requesttime" required><br><br>
    
    <button type="submit" name="confirm">Confirm</button>
</form>

<?php
session_start();
include("database.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm'])) {
    $requestdate = $_POST['requestdate'];
    $requesttime = $_POST['requesttime'];

    $sql = "INSERT INTO request (requestdate, requesttime) VALUES ('$requestdate', '$requesttime')";

    if (mysqli_query($conn, $sql)) {
        header("Location: view.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

</body>
</html>
