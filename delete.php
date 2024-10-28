<?php
session_start();
include("database.php");

if (isset($_GET['email']) && isset($_GET['app_date']) && isset($_GET['app_time'])) {
    $email = mysqli_real_escape_string($conn, $_GET['email']);
    $app_date = mysqli_real_escape_string($conn, $_GET['app_date']);
    $app_time = mysqli_real_escape_string($conn, $_GET['app_time']);

    $sql = "DELETE FROM appointment WHERE email='$email' AND app_date='$app_date' AND app_time='$app_time' LIMIT 1";

    if (mysqli_query($conn, $sql)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "Required parameters for deletion are missing.";
}

mysqli_close($conn);
?>