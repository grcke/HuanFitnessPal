<?php
$userid = $_SESSION['userID'];
$dbname = $_POST['dbname'];

$mysqli = new mysqli("localhost", "root", "", "hfp");

$tableHeaders = [];
$query = '';

// Determine the table, columns, and query based on the `type` parameter
if ($dbname === 'weight') {
    $tableHeaders = ['Date', 'Weight'];
    $query = "SELECT date, weight FROM weight where userID = $userid";
} elseif ($dbname === 'water') {
    $tableHeaders = ['DateTime', 'Amount'];
    $query = "SELECT DateTime, ammount FROM water where userID = $userid";
} elseif ($dbname === 'exercise') {
    $tableHeaders = ['Start', 'End', 'Record'];
    $query = "SELECT start, end, record FROM exercise where userID = $userid";
} else {
    echo "Invalid request type.";
    $mysqli->close();
    exit;
}

// Execute the query and fetch results
$result = $mysqli->query($query);

// Check for query success
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
} else {
    echo "No results found.";
}

// Close the database connection
$mysqli->close();
?>


