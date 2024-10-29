<!DOCTYPE HTML>
<html>
<style>
/* Your existing styles */
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
    margin-bottom: 20px;
}

body {
    background-image: url('https://st4.depositphotos.com/1022135/25748/i/450/depositphotos_257486682-stock-photo-group-young-people-sportswear-talking.jpg');
    background-size: cover;
    margin: 0;
    right: 0;
    left: 0;
}

.edit {
    width: 50%;
    height: 1%;
    background: #c4d7f5;
    color: black;
    text-align: center;
    padding: 70px;
    margin: 0 auto;
    font-size: 120%;
    border-style: ridge;
    overflow: hidden;
    margin-bottom: 150px;
}

input {
    height: 40px;
    width: 250px;
}

table {
    margin-left: auto;
    margin-right: auto;
}


footer {
    position: fixed; 
    right: 0;
    left: 0;
    text-align: center;
    color: white; 
    background: #405dde;
    border-style: ridge;
    margin: 0 auto;
    padding-top: 20px;
    padding-bottom: 20px;
    bottom: 0;
    border-style: ridge;
}
</style>
<body>
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
?>

<header>
    <h1 style="font-size: 40px">Huan Fitness Pal</h1>
    <h4 style="font-size: 20px"><i>For all your fitness needs...</i></h4>
</header>

<div class="edit">
    <p> You are editing the following record:<br> </p>

    <?php
    if ($result && $result->num_rows > 0) {
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
    echo "</form>";
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
