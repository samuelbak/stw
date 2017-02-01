<html>
<head></head>
<body>
<?php 
if(isset($_GET['action'])){
	if($_GET['action']=="new")
		CreateMailForm(0);
	if($_GET['action']=="received"){
		print_r(GetEmailDetail($_GET['id']));
	}
	if($_GET['action']=="sent"){
		
	}
	if($_GET['action']=="forward"){
	
	}
}
?>
</body>
</html>

<?php
function CreateMailForm($action){
	echo	"<form id='createExam' action='?action' method='post' accept-charset='UTF-8'>\n";
	echo 	"<fieldset>\n";
	echo 	"<legend>Nuova email</legend>\n";
	echo	"<label for='courseName'>A: </label>\n";
	echo	"<select name='destinatario'>\n";
	CreateUserSelect();
	echo 	"</select>\n";
	echo	"<br>\n";
	echo	"<label for='time' >Oggetto: </label>\n";
	echo 	"<input type='text' name='oggetto' id='oggetto' />\n";
	echo	"<br>\n";
	echo 	"<input type='text' name='testo' id='testo' />\n";
	echo	"<br>\n";
	echo	"<input type='submit' name='Submit' value='Invia' />\n";
	echo	"</fieldset>\n";
	echo	"</form>\n";
}

function CreateUserSelect(){
	$query = "SELECT * FROM users ORDER BY cognome ASC, nome";
	$result = SendQuery($query);
	while ($user = mysqli_fetch_assoc($result)){
		echo "<option value=".$user['id'].">".$user['cognome']." ".$user['nome']."</option>\n";
	}
}

function GetEmailDetail($mailId){
	$query = "SELECT * FROM emails WHERE id='".$mailId."' ORDER BY data ASC";
	return mysqli_fetch_assoc(SendQuery($query));
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

