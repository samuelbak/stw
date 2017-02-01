<?php
function SendQuery($query){
	$servername = "localhost";
	$usernameDb = "webuser";
	$passwordDb = "webpassword";
	$dbname = "virtualcampus";

	$conn = new mysqli($servername, $usernameDb, $passwordDb, $dbname);

	if (!$conn) {
		return false;
	}

	$result = $conn->query($query);

	$conn->close();

	return $result;
}
?>