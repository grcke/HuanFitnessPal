<?php
$id = isset($_GET["id"]) ? intval($_GET["id"]) : "";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hfp";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "DELETE FROM request WHERE id=$id";

if (mysqli_query($conn,$sql)) {
  #echo "Record deleted successfully";
  header("location: admin.php");
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

?>
