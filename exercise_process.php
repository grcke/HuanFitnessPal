<?php
session_start();
include("database.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $start = $_POST['start'];
    $end = $_POST['end'];
    $exercise = $_POST['exercise'];
    $userid = $_SESSION['userID'];

    $sql = "INSERT INTO exercise (UserID, start, end, record) VALUES ('$userid','$start', '$end', '$exercise')";
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
    window.location.href='exercise.php';
</script>";