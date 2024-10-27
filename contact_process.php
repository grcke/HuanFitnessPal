<?php
session_start();
include 'database.php';

$success_message = "";
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = $_SESSION['email'] ?? '';
    $message = trim($_POST['message']);

    // validate input fields
    if (empty($name) && empty($message)) {
        $errors[] = "Name and Message are required.";
    } else if (empty($name)) {
        $errors[] = "Name is required.";
    } else if (empty($message)) {
        $errors[] = "Message is required.";
    }

    if (count($errors) == 0) {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Your message has been sent successfully!";
        } else {
            $errors[] = "Error: " . mysqli_error($conn);
        }
        $stmt->close();
    }
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
}

mysqli_close($conn);

header("Location: contact.php");
exit();
?>
