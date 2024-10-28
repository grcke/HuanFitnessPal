<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Request</title>
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
                echo "<p>Appointment successfully added!</p>";
                header("Refresh: 1; url=admin.php"); // Redirect after 1 second
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "<p>Please fill in all fields.</p>";
        }
    }
    ?>
</div>

<footer>
    <h4>
    <i>Huan Sdn. Bhd</i><br>
    <i>All Rights Reserved&copy</i>
    </h4>
</footer>

</body>
</html>
