<?php
session_start();
include 'database.php';

if (isset($_POST['message_id'])) {
    $message_id = mysqli_real_escape_string($conn, $_POST['message_id']);
    
    // delete the message from the database
    $deleteQuery = "DELETE FROM contact_messages WHERE id = '$message_id'";
    if (mysqli_query($conn, $deleteQuery)) {
        echo "<script>alert('Message marked as read successfully!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Error marking message as read: " . mysqli_error($conn) . "'); window.location.href='admin.php';</script>";
    }
} else {
    echo "<script>alert('No message selected!'); window.location.href='admin.php';</script>";
}
?>
