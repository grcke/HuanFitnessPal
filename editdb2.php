<?php
session_start();
$userid = $_SESSION['userID'];
$recordID = $_POST['recordid'];
$dbname = $_POST['db'];

$mysqli = new mysqli("localhost", "root", "", "hfp");

if ($dbname === 'weight') {
    $query = "UPDATE weight SET Date = ? , Weight = ?  WHERE userid = ? AND RecordID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssii", $_POST['date'], $_POST['weight'], $userid, $recordID);
} elseif ($dbname === 'water') {
    $query = "SELECT DateTime, ammount FROM water WHERE userid = ? AND RecordID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ii", $userid, $recordID);
} elseif ($dbname === 'exercise') {
    $query = "SELECT start, end, record FROM exercise WHERE userid = ? AND RecordID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ii", $userid, $recordID);
} else {
    echo "Invalid request type.";
    $mysqli->close();
    exit;
}

$stmt->execute();
$result = $stmt->get_result();

echo "<script>
    alert('Record edited successfully');
    window.location.href='" . htmlspecialchars($dbname) . ".php';
</script>";
?>