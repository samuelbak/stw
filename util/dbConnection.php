<?php
function SendQuery($query){
	$servername = "localhost";
	$usernameDb = "webuser";
	$passwordDb = "webpassword";
	$dbname = "virtualcampus";

	$conn = new mysqli($servername, $usernameDb, $passwordDb, $dbname);

	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
		echo "db error";
		return false;
	}

	$result = $conn->query($query);

	$conn->close();

	return $result;
}
?>