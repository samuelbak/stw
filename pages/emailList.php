<html>
<head></head>
<body>
	<?php 
		if(isset($_GET['display'])){
			$emailsList = GetEmailsList(GetUserId(),$_GET['display']);
			while ($email = mysqli_fetch_assoc($emailsList)){
				echo "<a href='/pages/emailView.php?id=".$email['id']."&action=".$_GET['display']."' target='iframe_emailView'>".$email['oggetto']."</a><br>";
			}
		}
	
	?>

</body>
</html>

<?php
/*
CREATE TABLE `virtualcampus`.`emails` ( `id` INT NOT NULL AUTO_INCREMENT , `idMittente` INT NOT NULL , `idDestinatario` INT NOT NULL , `oggetto` VARCHAR(64) NOT NULL , `testo` TEXT NOT NULL , `data` DATETIME NOT NULL , `letto` BOOLEAN NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
 */
function GetEmailsList($userId, $folder){
	if($folder == "sent")
		$query = "SELECT * FROM emails WHERE idMittente='".$userId."' ORDER BY data ASC";
	if($folder == "received")
		$query = "SELECT * FROM emails WHERE idDestinatario='".$userId."' ORDER BY data ASC";
	return SendQuery($query);
	
}

function GetUserId(){
	$userDetail = json_decode($_COOKIE['user'], true);
	$userName = $userDetail['user'];

	$query = "SELECT id FROM users WHERE username='".$userName."'";

	$result = SendQuery($query);

	if($result){
		$val = mysqli_fetch_assoc($result);
		return $val['id'];
	}
	return "nope";

}

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