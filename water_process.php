<?php
session_start();
include("database.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $water = $_POST['water'];
    $userid = $_SESSION['userID'];

    $sql = "INSERT INTO water (UserID, DateTime, ammount) VALUES ('$userid','$date', '$water')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>

echo "<script>
    alert('New record created successfully');
    window.location.href='water.php';
</script>";