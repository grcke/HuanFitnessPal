<?php
session_start();
include("database.php");

// Check if the 'email' parameter exists in the GET request
if (isset($_GET['id'])) {
    $email = mysqli_real_escape_string($conn, $_GET['id']); // Sanitize the input

    // Prepare the DELETE query
    $sql = "DELETE FROM appointment WHERE email='$email'";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        header("Location: admin.php"); // Redirect to the admin page after successful deletion
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "No email provided for deletion.";
}

mysqli_close($conn);
?>