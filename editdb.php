<?php
session_start();
$userid = $_SESSION['userID'];
$recordID = $_GET['recordid'];
$dbname = $_GET['db'];

$mysqli = new mysqli("localhost", "root", "", "hfp");

if ($dbname === 'weight') {
    $tableHeaders = ['Date', 'Weight'];
    $query = "SELECT date, weight FROM weight WHERE userid = $userid AND RecordID = $recordID";
} elseif ($dbname === 'water') {
    $tableHeaders = ['DateTime', 'Amount'];
    $query = "SELECT DateTime, ammount FROM water WHERE userid = $userid AND RecordID = $recordID";
} elseif ($dbname === 'exercise') {
    $tableHeaders = ['Start', 'End', 'Record'];
    $query = "SELECT start, end, record FROM exercise WHERE userid = $userid AND RecordID = $recordID";
} else {
    echo "Invalid request type.";
    $mysqli->close();
    exit;
}

$stmt = $mysqli->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

echo "You are editing the following record:<br>";

if ($result && $result->num_rows > 0) {
    // Display the results in an HTML table
    echo "<table border='1'>";
    echo "<tr>";
    foreach ($tableHeaders as $header) {
        echo "<th>{$header}</th>";
    }
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $column) {
            echo "<td>{$column}</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}

?>

<h3> Enter new info here: </h3>

<?php
if ($dbname === 'weight') {
    ?>
<form action="editdb2.php" method="POST">
    <label for="date">Date:</label>
    <input type="date" name="date" id="date" required>
    <label for="weight">Weight:</label>
    <input type="number" name="weight" id="weight" required>
    <input type="submit" value="Submit">
    <input type="hidden" name="recordid" value="<?php echo htmlspecialchars($recordID); ?>">
    <input type="hidden" name="db" value="<?php echo htmlspecialchars($dbname); ?>">
</form>
<?php
} elseif ($dbname === 'water') {
    ?>
<form action="editdb2.php" method="POST">
    <label for="date">Date:</label>
    <input type="datetime-local" name="date" id="date" required>
    <label for="weight">Amount:</label>
    <input type="number" name="weight" id="weight" required>
    <input type="submit" value="Submit">
    <input type="hidden" name="recordid" value="<?php echo htmlspecialchars($recordID); ?>">
    <input type="hidden" name="db" value="<?php echo htmlspecialchars($dbname); ?>">
</form>
<?php
} elseif ($dbname === 'exercise') {
    ?>
<form action="editdb2.php" method="POST">
    <label for="date">Start:</label>
    <input type="datetime-local" name="date" id="date" required>
    <label for="weight">End:</label>
    <input type="datetime-local" name="weight" id="weight" required>
    <label for="weight">Record:</label>
    <input type="text" name="record" id="record" required>
    <input type="submit" value="Submit">
    <input type="hidden" name="recordid" value="<?php echo htmlspecialchars($recordID); ?>">
    <input type="hidden" name="db" value="<?php echo htmlspecialchars($dbname); ?>">
</form>
<?php
}

echo "<form action='" . htmlspecialchars($dbname) . ".php' method='GET'>";
echo "<input type='submit' value='Back'>";
echo "</form>"

?>