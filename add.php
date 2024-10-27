<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Request</title>
</head>
<body>

<h2>User Request</h2>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <label for="name">Insert Name</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <label for="email">Select Email</label><br>
    <select name="email" id="email" required>
        <option value="">Choose an email</option>
        <?php
        include("database.php");

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
    $requestdate = $_POST['requestdate'];
    $requesttime = $_POST['requesttime'];
    $email = $_POST['email'];
    $name = $_POST['name'];

    if (!empty($email) && !empty($name)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO appointment (email, app_date, app_time, name) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $email, $requestdate, $requesttime, $name); // Bind the name parameter

        if (mysqli_stmt_execute($stmt)) {
            header("Location: admin.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Please select a valid email and insert your name.";
    }

    mysqli_close($conn);
}
?>

</body>
</html>