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
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $updateSql = "UPDATE appointment SET app_date='$requestdate', app_time='$requesttime', status='$status' WHERE email='$email'";
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #343a40;
        }
        form {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #495057;
            text-align: center;
        }
        input[type="date"],
        input[type="time"],
        select,
        button {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px;
            border: 1px solid #007BFF;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box; 
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 18px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h2>Edit User Request</h2>

<form action="<?php echo $_SERVER['PHP_SELF'] . "?id=" . urlencode($email); ?>" method="POST">
    <label for="requestdate">Request Date</label>
    <input type="date" id="requestdate" name="requestdate" value="<?php echo htmlspecialchars($row['app_date']); ?>" required>

    <label for="requesttime">Request Time</label>
    <input type="time" id="requesttime" name="requesttime" value="<?php echo htmlspecialchars($row['app_time']); ?>" required>

    <label for="status">Status</label>
    <select id="status" name="status" required>
        <option value="Pending" <?php echo $row['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
        <option value="Completed" <?php echo $row['status'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
    </select>

    <button type="submit">Update Request</button>
</form>

</body>
</html>
