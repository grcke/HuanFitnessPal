<?php
$userid = $_SESSION['userID'];
$dbname = $_POST['dbname'];

$mysqli = new mysqli("localhost", "root", "", "hfp");

$tableHeaders = [];
$query = '';

// Determine the table, columns, and query based on the `dbname` parameter
if ($dbname === 'weight') {
    $tableHeaders = ['Date', 'Weight'];
    $query = "SELECT RecordID, date, weight FROM weight WHERE userid = ?";
} elseif ($dbname === 'water') {
    $tableHeaders = ['DateTime', 'Amount'];
    $query = "SELECT RecordID, DateTime, ammount FROM water WHERE userid = ?";
} elseif ($dbname === 'exercise') {
    $tableHeaders = ['Start', 'End', 'Record'];
    $query = "SELECT RecordID, start, end, record FROM exercise WHERE userid = ?";
} else {
    echo "Invalid request type.";
    $mysqli->close();
    exit;
}

// Prepare and execute the query
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();

// Check for query success
if ($result && $result->num_rows > 0) {
    // Display the results in an HTML table
    echo "<table border='1'>";
    echo "<tr>";
    foreach ($tableHeaders as $header) {
        echo "<th>{$header}</th>";
    }
    echo "<th>Actions</th>"; // Add Actions column header
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $key => $column) {
            if ($key !== 'RecordID') { // Skip RecordID in the displayed columns
                echo "<td>{$column}</td>";
            }
        }
        echo "<td>";
        // Use RecordID for the edit and delete actions
        echo "<a href='editdb.php?recordid={$row['RecordID']}&db={$dbname}'>Edit</a> | ";
        echo "<a href='delrec.php?recordid={$row['RecordID']}&db={$dbname}' onclick='return confirm(\"Are you sure?\");'>Delete</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No results found.";
}

// Close the database connection
$stmt->close();
$mysqli->close();
?>
