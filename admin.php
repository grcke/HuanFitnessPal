<!DOCTYPE HTML>
<html>
<head>
<style>
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
    
    body {
        background-image: url('https://st4.depositphotos.com/1022135/25748/i/450/depositphotos_257486682-stock-photo-group-young-people-sportswear-talking.jpg');
        background-size: cover;
        margin: 0;
    }
    
    .admin-panel {
        width: 80%;
        max-width: 1000px;
        background: #ffffffcc;
        color: black;
        text-align: center;
        padding: 20px;
        margin: 0 auto;
        font-size: 1.1em;
        border-style: ridge;
        overflow: hidden;
    }

    h2, h3 {
        color: #333;
    }

    .search-form, .add-form, .logout-form {
        margin: 20px 0;
    }

    .search-form input, .search-form button, .add-form button, .logout-form button, .search-form select {
        padding: 10px;
        margin-right: 10px;
        border: 1px solid #007BFF;
        border-radius: 5px;
        font-size: 16px;
        outline: none;
    }

    .search-form button {
        background-color: #007BFF;
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .search-form button:hover {
        background-color: #0056b3;
    }

    .search-form select {
        background-color: #f2f2f2;
        color: #333;
        appearance: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #fff;
    }

    .data-table th, .data-table td {
        padding: 15px;
        border: 1px solid #ddd;
        text-align: center;
    }

    .data-table th {
        background-color: #405dde;
        color: white;
    }

    .action-buttons form {
        display: inline;
    }

    .edit-button, .delete-button, .read-button {
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    .edit-button {
        background-color: #4CAF50;
    }
    .edit-button:hover {
        background-color: #388e3c;
    }

    .delete-button {
        background-color: #f44336;
    }
    .delete-button:hover {
        background-color: #d32f2f;
    }

    .read-button {
        background-color: #007BFF;
    }
    .read-button:hover {
        background-color: #0056b3;
    }

    footer {
        right: 0;
        left: 0;
        text-align: center;
        color: white; 
        background: #405dde;
        border-style: ridge;
        padding-top: 20px;
        padding-bottom: 20px;
        position: sticky;
        bottom: 0;
        width: 100%;
        z-index: 10;
    }
</style>
</head>

<body>
<header>
    <h1 style="font-size: 40px">Huan Fitness Pal</h1>
    <h4 style="font-size: 20px"><i>For all your fitness needs...</i></h4>
</header>

<div class="admin-panel">
    <?php
    session_start();
    include 'database.php';

    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
        header("Location: Homepage.php");
        exit();
    }

    if (isset($_SESSION['email'])) {
        $userEmail = htmlspecialchars($_SESSION['email']);
        echo "<h2>Admin Control Panel</h2>";
        echo "<h3>You are currently logged in as: $userEmail</h3>";

        // search and filter form
        ?>
        <form action="" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search by Name or Email" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit">Search</button>
            <input type="date" name="request_date" value="<?php echo isset($_GET['request_date']) ? htmlspecialchars($_GET['request_date']) : ''; ?>">
            <input type="time" name="request_time" value="<?php echo isset($_GET['request_time']) ? htmlspecialchars($_GET['request_time']) : ''; ?>">
            <select name="status">
                <option value="">-- Select Status --</option>
                <option value="Pending" <?php echo (isset($_GET['status']) && $_GET['status'] === 'Pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="Complete" <?php echo (isset($_GET['status']) && $_GET['status'] === 'Complete') ? 'selected' : ''; ?>>Complete</option>
            </select>
            <button type="submit">Filter</button>
        </form>
        <?php

        $filters = [];
        if (!empty($_GET['search'])) {
            $filtervalues = mysqli_real_escape_string($conn, $_GET['search']);
            $filters[] = "CONCAT(name, email) LIKE '%$filtervalues%'";
        }
        if (!empty($_GET['request_date'])) {
            $request_date = mysqli_real_escape_string($conn, $_GET['request_date']);
            $filters[] = "app_date = '$request_date'";
        }
        if (!empty($_GET['request_time'])) {
            $request_time = mysqli_real_escape_string($conn, $_GET['request_time']);
            $filters[] = "app_time = '$request_time'";
        }
        if (!empty($_GET['status'])) {
            $status = mysqli_real_escape_string($conn, $_GET['status']);
            $filters[] = "status = '$status'";
        }

        $filterQuery = count($filters) > 0 ? " WHERE " . implode(" AND ", $filters) : '';
        $sql = "SELECT * FROM appointment" . $filterQuery;
        $result = mysqli_query($conn, $sql);

        // display appointments
        ?>
        <table class="data-table" style="width:100%; border-collapse:collapse; margin-top:20px; background-color:#fff;">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Request Date</th>
                <th>Request Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        <?php

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['app_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['app_time']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td class="action-buttons">
                        <form action="edit.php" method="GET" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['email']); ?>">
                            <button type="submit" class="edit-button">Edit</button>
                        </form>
                        <form action="delete.php" method="GET" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this record?');">
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($row['email']); ?>">
                            <input type="hidden" name="app_date" value="<?php echo htmlspecialchars($row['app_date']); ?>">
                            <input type="hidden" name="app_time" value="<?php echo htmlspecialchars($row['app_time']); ?>">
                            <button type="submit" class="delete-button">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='6'>No records found!</td></tr>";
        }
        ?>
        </table>

        <form action="add.php" method="GET" class="add-form">
            <button type="submit">Add New Appointment</button>
        </form>

        <!-- display user messages -->
        <h3>User Messages</h3>
        <?php
        $messageQuery = "SELECT * FROM contact_messages ORDER BY created_at DESC";
        $messageResult = mysqli_query($conn, $messageQuery);
        ?>
        <table class="data-table" style="width:100%; border-collapse:collapse; margin-top:20px; background-color:#fff;">
            <tr>
                <th>Email</th>
                <th>Message</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        <?php

        if (mysqli_num_rows($messageResult) > 0) {
            while ($msgRow = mysqli_fetch_assoc($messageResult)) {
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($msgRow['email']); ?></td>
                    <td><?php echo htmlspecialchars($msgRow['message']); ?></td>
                    <td><?php echo htmlspecialchars($msgRow['created_at']); ?></td>
                    <td class="action-buttons">
                        <form action="delete_message.php" method="POST" onsubmit="return confirm('Are you sure you want to mark this message as read?');" style="display:inline;">
                            <input type="hidden" name="message_id" value="<?php echo htmlspecialchars($msgRow['id']); ?>">
                            <button type="submit" class="read-button">Read</button>
                        </form>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='4'>No messages found!</td></tr>";
        }
        ?>
        </table>

        <form action="logout.php" method="POST" class="logout-form">
            <button type="submit">Logout</button>
        </form>
        <?php
    } else {
        echo "<h3>No user is logged in.</h3>";
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
