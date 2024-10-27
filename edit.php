<?php
session_start();
include("database.php");

if (isset($_GET['id'])) {
    $email = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "SELECT * FROM appointment WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result); 
    } else {
        die("Record not found.");
    }
} else {
    die("No email provided.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestdate = mysqli_real_escape_string($conn, $_POST['requestdate']);
    $requesttime = mysqli_real_escape_string($conn, $_POST['requesttime']);

    $updateSql = "UPDATE appointment SET app_date='$requestdate', app_time='$requesttime' WHERE email='$email'";
    if (mysqli_query($conn, $updateSql)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Request</title>
</head>
<body>

<h2>Edit User Request</h2>

<form action="<?php echo $_SERVER['PHP_SELF'] . "?id=" . urlencode($email); ?>" method="POST">
    <label for="requestdate">Request Date</label><br>
    <input type="date" id="requestdate" name="requestdate" value="<?php echo htmlspecialchars($row['app_date']); ?>" required><br><br>

    <label for="requesttime">Request Time</label><br>
    <input type="time" id="requesttime" name="requesttime" value="<?php echo htmlspecialchars($row['app_time']); ?>" required><br><br>

    <button type="submit">Update Request</button>
</form>

</body>
</html>