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
            background-image: url('https://st4.depositphotos.com/1022135/25748/i/450/depositphotos_257486682-stock-photo-group-young-people-sportswear-talking.jpg');
            background-size: cover;
            margin: 0;
            padding: 0;
        }
        header {
            right: 0;
            left: 0;
            text-align: center;
            color: white;
            background: #405dde;
            border-style: ridge;
            margin: 0;
            padding-top: 20px;
            padding-bottom: 20px;
        }
        .urequest-panel {
            width: 80%;
            max-width: 1000px;
            background: rgba(255, 255, 255, 0.9);
            color: black;
            text-align: center;
            padding: 40px;
            margin: 50px auto;
            font-size: 1.1em;
            border-style: ridge;
            border-width: 2px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .urequest-panel h2 {
            margin-bottom: 30px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        label {
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="date"],
        input[type="time"],
        select {
            width: 90%;
            max-width: 300px;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #405dde;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background-color: #405dde;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            margin: 5px;
        }
        button:hover {
            background-color: #364cb1;
        }
        footer {
            right: 0;
            left: 0;
            text-align: center;
            color: white; 
            background: #405dde;
            border-style: ridge;
            margin: 0 auto;
            padding-top: 20px;
            padding-bottom: 20px;
            position: fixed;
            bottom: 0;
            border-style: ridge;
        }
    </style>
</head>
<body>

<header>
    <h1 style="font-size: 40px">Huan Fitness Pal</h1>
    <h4 style="font-size: 20px"><i>For all your fitness needs...</i></h4>
</header>

<div class="urequest-panel">
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
        <button type="button" class="cancel-button" onclick="window.location.href='admin.php';">Cancel</button>
    </form>
</div>

<footer>
    <h4>
    <i>Huan Sdn. Bhd</i><br>
    <i>All Rights Reserved&copy</i>
    </h4>
</footer>

</body>
</html>
