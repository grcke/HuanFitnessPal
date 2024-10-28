<?php
session_start();
$userid = $_SESSION['userID'];
$recordID = $_GET['recordid'];
$dbname = $_GET['db'];

$mysqli = new mysqli("localhost", "root", "", "hfp");

// Prepare the DELETE query based on the dbname
if ($dbname === 'weight') {
    $query = "DELETE FROM weight WHERE userid = ? AND RecordID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ii", $userid, $recordID);
} elseif ($dbname === 'water') {
    $query = "DELETE FROM water WHERE userid = ? AND RecordID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ii", $userid, $recordID);
} elseif ($dbname === 'exercise') {
    $query = "DELETE FROM exercise WHERE userid = ? AND RecordID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ii", $userid, $recordID);
} else {
    echo "Invalid request type.";
    $mysqli->close();
    exit;
}

// Execute the delete query
if ($stmt->execute()) {
    echo "<script>
        alert('Record deleted successfully');
        window.location.href='" . htmlspecialchars($dbname) . ".php';
    </script>";
} else {
    echo "Error deleting record.";
}

// Close the statement and connection
$stmt->close();
$mysqli->close();
?>
