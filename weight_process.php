<?php
session_start();
include("database.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $weight = $_POST['weight'];
    $userid = $_SESSION['userID'];

    $sql = "INSERT INTO weight (UserID, date, weight) VALUES ('$userid','$date', '$weight')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    echo "Date: " . htmlspecialchars($date) . "<br>";
    echo "Weight: " . htmlspecialchars($weight) . "<br>";
    mysqli_close($conn);
}
?>

echo "<script>
    alert('New record created successfully');
    window.location.href='weight.php';
</script>";