<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hfp";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM request";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Request Date</th>
                <th>Request Time</th>
                <th>Actions</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['userID']) . "</td>";
        echo "<td>" . htmlspecialchars($row['requestdate']) . "</td>";
        echo "<td>" . htmlspecialchars($row['requesttime']) . "</td>";
        echo "<td>
                <form action='edit.php' method='GET' style='display:inline;'>
                    <input type='hidden' name='id' value='" . urlencode($row['userID']) . "'>
                    <button type='submit' style='padding: 5px 10px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;'>Edit</button>
                </form>
                <form action='delete.php' method='GET' style='display:inline;' onsubmit=\"return confirm('Are you sure you want to delete this record?');\">
                    <input type='hidden' name='id' value='" . urlencode($row['userID']) . "'>
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

mysqli_close($conn);
?>
