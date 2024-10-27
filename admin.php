<?php
session_start();
include 'database.php';

if (isset($_SESSION['email'])) {
    echo "<h2>Admin Control Panel</h2>";
    echo "<h3>You are currently logged in as: " . htmlspecialchars($_SESSION['email']) . "</h3>";

    echo '<form action="" method="GET" style="margin-bottom: 20px;">
            <input type="text" name="search" placeholder="Search by Name or Email" value="' . (isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '') . '">
            <button type="submit" style="padding: 5px 10px; background-color: #007BFF; color: white; border: none; border-radius: 5px;">Search</button>&emsp;&emsp;&emsp;
            <input type="date" name="request_date" value="' . (isset($_GET['request_date']) ? htmlspecialchars($_GET['request_date']) : '') . '">
            <input type="time" name="request_time" value="' . (isset($_GET['request_time']) ? htmlspecialchars($_GET['request_time']) : '') . '">
            <button type="submit" style="padding: 5px 10px; background-color: #007BFF; color: white; border: none; border-radius: 5px;">Filter</button>
          </form>';

    $filters = [];
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $filtervalues = mysqli_real_escape_string($conn, $_GET['search']);
        $filters[] = "CONCAT(name, email) LIKE '%$filtervalues%'";
    }
    if (isset($_GET['request_date']) && !empty($_GET['request_date'])) {
        $request_date = mysqli_real_escape_string($conn, $_GET['request_date']);
        $filters[] = "app_date = '$request_date'";
    }
    if (isset($_GET['request_time']) && !empty($_GET['request_time'])) {
        $request_time = mysqli_real_escape_string($conn, $_GET['request_time']);
        $filters[] = "app_time = '$request_time'";
    }

    $filterQuery = '';
    if (count($filters) > 0) {
        $filterQuery = " WHERE " . implode(" AND ", $filters);
    }

    $sql = "SELECT * FROM appointment" . $filterQuery;
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Request Date</th>
                    <th>Request Time</th>
                    <th>Actions</th>
                </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['app_date']) . "</td>";
            echo "<td>" . htmlspecialchars($row['app_time']) . "</td>";
            echo "<td>
                    <form action='edit.php' method='GET' style='display:inline;'>
                        <input type='hidden' name='id' value='" . htmlspecialchars($row['email']) . "'>
                        <button type='submit' style='padding: 5px 10px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;'>Edit</button>
                    </form>
                    <form action='delete.php' method='GET' style='display:inline;' onsubmit=\"return confirm('Are you sure you want to delete this record?');\">
                        <input type='hidden' name='id' value='" . htmlspecialchars($row['email']) . "'>
                        <button type='submit' style='padding: 5px 10px; background-color: #f44336; color: white; border: none; border-radius: 5px; cursor: pointer;'>Delete</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No records found!";
    }

    echo "<br><form action='add.php' method='GET' style='margin-top: 20px;'>
            <button type='submit' style='padding: 10px 15px; background-color: #008CBA; color: white; border: none; border-radius: 5px; cursor: pointer;'>Add</button>
          </form>";
} else {
    echo "<h3>No user is logged in.</h3>";
}
?>

<form action="logout.php" method="POST">
    <input type="submit" value="Logout">
</form>