<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Request</title>
</head>
<body>

<h2>User Request</h2>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <!-- Dropdown to select an email from the database -->
    <label for="email">Select Email</label><br>
    <select name="email" id="email" required>
        <option value="">Choose an email</option>
        <?php
        include("database.php");
        
        // Fetch emails with type 'user' from the userinfo table
        $emailQuery = "SELECT DISTINCT email FROM userinfo WHERE type = 'user'";
        $emailResult = mysqli_query($conn, $emailQuery);

        if (mysqli_num_rows($emailResult) > 0) {
            while ($emailRow = mysqli_fetch_assoc($emailResult)) {
                echo "<option value='" . htmlspecialchars($emailRow['email']) . "'>" . htmlspecialchars($emailRow['email']) . "</option>";
            }
        } else {
            echo "<option value=''>No emails available</option>";
        }
        ?>
    </select><br><br>

    <label for="requestdate">Date</label><br>
    <input type="date" id="date" name="requestdate" value="<?= date("Y-m-d") ?>" max="2025-12-31" min="<?= date("Y-m-d") ?>" required><br>

    <label for="requesttime">Time</label><br>
    <input type="time" id="time" name="requesttime" required><br><br>

    <button type="submit" name="confirm">Confirm</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm'])) {
    $requestdate = mysqli_real_escape_string($conn, $_POST['requestdate']);
    $requesttime = mysqli_real_escape_string($conn, $_POST['requesttime']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if (!empty($email)) {
        $sql = "INSERT INTO appointment (email, app_date, app_time) VALUES ('$email', '$requestdate', '$requesttime')";

        if (mysqli_query($conn, $sql)) {
            header("Location: admin.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Please select a valid email.";
    }

    mysqli_close($conn);
}
?>

</body>
</html>