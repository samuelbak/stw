<?php
function SendQuery($query){
	/*
	$servername = "localhost";		//local
	$usernameDb = "webuser";
	$passwordDb = "webpassword";
	$dbname = "virtualcampus";
	*/
	$servername = "localhost";		//remote
	$usernameDb = "s.bacchetta";
	$passwordDb = "b4cch3tt4";
	$dbname = "s_bacchetta";
	
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