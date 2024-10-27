<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hfp";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 

    $sql = "SELECT userID, requestdate, requesttime FROM request WHERE userID = $id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        die("Record not found.");
    }
} else {
    die("No ID provided.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestdate = mysqli_real_escape_string($conn, $_POST['requestdate']);
    $requesttime = mysqli_real_escape_string($conn, $_POST['requesttime']);

    $updateSql = "UPDATE request SET requestdate='$requestdate', requesttime='$requesttime' WHERE userID=$id";
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

<form action="<?php echo $_SERVER['PHP_SELF'] . "?id=" . $id; ?>" method="POST">
    <label for="requestdate">Request Date</label><br>
    <input type="date" id="requestdate" name="requestdate" value="<?php echo htmlspecialchars($row['requestdate']); ?>" required><br><br>

    <label for="requesttime">Request Time</label><br>
    <input type="time" id="requesttime" name="requesttime" value="<?php echo htmlspecialchars($row['requesttime']); ?>" required><br><br>

    <button type="submit">Update Request</button>
</form>

</body>
</html>