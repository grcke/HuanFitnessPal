<?php
session_start();
include("database.php");

if (isset($_GET['id'])) {
    $email = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "DELETE FROM appointment WHERE email='$email'";

    if (mysqli_query($conn, $sql)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "No email provided for deletion.";
}

mysqli_close($conn);
?>