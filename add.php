<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Request</title>
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
        input[type="text"],
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
        .cancel-button {
            background-color: #dc3545;
        }
        .cancel-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<h2>User Request</h2>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <label for="name">Insert Name</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Select Email</label>
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
    </select>

    <label for="requestdate">Date</label>
    <input type="date" id="date" name="requestdate" value="<?= date("Y-m-d") ?>" max="2025-12-31" min="<?= date("Y-m-d") ?>" required>

    <label for="requesttime">Time</label>
    <input type="time" id="time" name="requesttime" required>

    <label for="status">Status</label>
    <select name="status" id="status" required>
        <option value="Pending">Pending</option>
        <option value="Completed">Completed</option>
    </select>

    <button type="submit" name="confirm">Confirm</button>
    <button type="button" class="cancel-button" onclick="window.location.href='admin.php';">Cancel</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm'])) {
    $requestdate = $_POST['requestdate'];
    $requesttime = $_POST['requesttime'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $status = $_POST['status']; 

    if (!empty($email) && !empty($name)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO appointment (email, app_date, app_time, name, status) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssss", $email, $requestdate, $requesttime, $name, $status); 

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
