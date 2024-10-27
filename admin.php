<?php
session_start();
include 'database.php';

if (isset($_SESSION['email'])) {
    echo "<h2>Admin Control Panel</h2>";
    echo "<h3>You are currently logged in as: " . htmlspecialchars($_SESSION['email']) . "</h3>";

    // search and filter
    echo '<form action="" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search by Name or Email" value="' . (isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '') . '">
            <button type="submit">Search</button>
            <input type="date" name="request_date" value="' . (isset($_GET['request_date']) ? htmlspecialchars($_GET['request_date']) : '') . '">
            <input type="time" name="request_time" value="' . (isset($_GET['request_time']) ? htmlspecialchars($_GET['request_time']) : '') . '">
            <button type="submit">Filter</button>
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

    // fetch appointments
    $filterQuery = count($filters) > 0 ? " WHERE " . implode(" AND ", $filters) : '';
    $sql = "SELECT * FROM appointment" . $filterQuery;
    $result = mysqli_query($conn, $sql);

    // display appointments
    echo "<table class='data-table'>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Request Date</th>
            <th>Request Time</th>
            <th>Status</th> <!-- Added Status column -->
            <th>Actions</th>
        </tr>";

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['email']) . "</td>
                    <td>" . htmlspecialchars($row['app_date']) . "</td>
                    <td>" . htmlspecialchars($row['app_time']) . "</td>
                    <td>" . htmlspecialchars($row['status']) . "</td> <!-- Displaying Status -->
                    <td class='action-buttons'>
                        <form action='edit.php' method='GET' style='display:inline;'>
                            <input type='hidden' name='id' value='" . htmlspecialchars($row['email']) . "'>
                            <button type='submit' class='edit-button'>Edit</button>
                        </form>
                        <form action='delete.php' method='GET' style='display:inline;' onsubmit=\"return confirm('Are you sure you want to delete this record?');\">
                            <input type='hidden' name='id' value='" . htmlspecialchars($row['email']) . "'>
                            <button type='submit' class='delete-button'>Delete</button>
                        </form>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No records found!</td></tr>"; // Updated colspan to 6
    }
    echo "</table>";

    // appointment button
    echo "<form action='add.php' method='GET' class='add-form'>
            <button type='submit'>Add New Appointment</button>
          </form>";

    // display user messages
    echo "<h3>User Messages</h3>";
    $messageQuery = "SELECT * FROM contact_messages ORDER BY created_at DESC";
    $messageResult = mysqli_query($conn, $messageQuery);

    echo "<table class='data-table'>
            <tr>
                <th>Email</th>
                <th>Message</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>";

    if (mysqli_num_rows($messageResult) > 0) {
        while ($msgRow = mysqli_fetch_assoc($messageResult)) {
            echo "<tr>
                    <td>" . htmlspecialchars($msgRow['email']) . "</td>
                    <td>" . htmlspecialchars($msgRow['message']) . "</td>
                    <td>" . htmlspecialchars($msgRow['created_at']) . "</td>
                    <td class='action-buttons'>
                        <form action='delete_message.php' method='POST' onsubmit=\"return confirm('Are you sure you want to mark this message as read?');\" style='display:inline;'>
                            <input type='hidden' name='message_id' value='" . htmlspecialchars($msgRow['id']) . "'>
                            <button type='submit' class='read-button'>Read</button>
                        </form>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No messages found!</td></tr>";
    }
    echo "</table>";

    echo '<form action="logout.php" method="POST" class="logout-form">
            <button type="submit">Logout</button>
          </form>';
} else {
    echo "<h3>No user is logged in.</h3>";
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background-color: #f9f9f9;
    }
    h2, h3 {
        color: #333;
    }
    .search-form, .add-form, .logout-form {
        margin: 20px 0;
    }
    .search-form input, .search-form button, .add-form button, .logout-form button {
        padding: 10px;
        margin-right: 10px;
        border: 1px solid #007BFF;
        border-radius: 5px;
        font-size: 16px;
    }
    .search-form button {
        background-color: #007BFF;
        color: white;
        border: none;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #fff;
    }
    .data-table th, .data-table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }
    .data-table th {
        background-color: #f2f2f2;
    }
    .action-buttons form {
        display: inline;
    }
    .edit-button {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
    }
    .delete-button {
        background-color: #f44336;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
    }
    .read-button {
        background-color: #007BFF;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
    }
</style>
