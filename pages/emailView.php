<?php require('../util/dbConnection.php'); ?>
<?php require('../util/cookie.php'); ?>

<html>
<head></head>
<body>
<?php 
if(isset($_GET['action'])){
	if($_GET['action']=="new")
		CreateMailForm($_GET['action']);
	if($_GET['action']=="received"){
		$email = GetEmailDetail($_GET['id']);
		DisplayMail($email);
		$query = "UPDATE emails SET letto=1 WHERE id=".$email['id'];
		SendQuery($query);
	}
	if($_GET['action']=="sent"){
		print_r(GetEmailDetail($_GET['id']));		
	}
	if($_GET['action']=="forward"){
	
	}
	if($_GET['action']=="Invia"){
		
	}
}
if(isset($_POST['Submit'])){
	if($_POST['Submit']=="Invia"){
		$uId = GetUserId();
		$query = 	"INSERT INTO emails (idMittente, idDestinatario, oggetto, testo) ".
					"VALUES ('".$uId."', '".$_POST['destinatario']."', '".$_POST['oggetto']."', '".$_POST['testo']."')";
		SendQuery($query);
	}
	if($_POST['Submit']=="Rispondi"){
		CreateAnswerForm($_POST['emailId']);
	}
}
?>
</body>
</html>

<?php
function DisplayMail($email){
	$mittente = GetUserDetail($email['idMittente']);
	$destinatario = GetUserDetail($email['idDestinatario']);
	echo "<h2>".$email['oggetto']."</h2>";
	echo "<h3>".$mittente['cognome']." ".$mittente['nome']."</h3>";
	echo "<p>Inviato: ".$email['data']."</p>";
	echo "<br>";
	echo "<p>".$email['testo']."</p>";
	echo "<br>";
	echo "<form id='answerMail' action='?action=Rispondi' method='post' accept-charset='UTF-8'>\n";
	echo "<input type='hidden' name='emailId' value='".$email['id']."'>";
	echo "<input type='submit' name='Submit' value='Rispondi'/>\n";
	echo "</form>";
}
function CreateAnswerForm($mailId){
	$email = GetEmailDetail($mailId);
	$destinatario = GetUserDetail($email['idMittente']);
	echo	"<form id='answerMail' action='?action=Rispondi' method='post' accept-charset='UTF-8'>\n";
	echo 	"<legend><strong>Rispondi</strong></legend>\n";
	echo	"<label>A: ".$destinatario['cognome']." ".$destinatario['nome']."</label><br>";
	echo	"<label>Oggetto: </label>\n";
	echo 	"<input type='text' name='oggetto' id='oggetto' value='Re: ".$email['oggetto']."'> \n";
	echo	"<br>\n";
	echo 	"<textarea name='testo' rows='10' cols='30'>".$email['testo']."</textarea>";
	echo	"<br>\n";
	echo 	"<input type='hidden' name='destinatario' value='".$email['idMittente']."'>";
	echo	"<input type='submit' name='Submit' value='Invia' />\n";
	echo	"</form>\n";
}
function CreateMailForm($action){
	if ($action == "new"){
		echo	"<form id='newMail' action='?action=Invia' method='post' accept-charset='UTF-8'>\n";
		echo 	"<legend><strong>Nuova email</strong></legend>\n";
		echo	"<label for='courseName'>A: </label>\n";
		echo	"<select name='destinatario'>\n";
		CreateUserSelect();
		echo 	"</select>\n";
		echo	"<br>\n";
		echo	"<label for='time' >Oggetto: </label>\n";
		echo 	"<input type='text' name='oggetto' id='oggetto' />\n";
		echo	"<br>\n";
		echo 	"<textarea name='testo' rows='10' cols='30'></textarea>";
		echo	"<br>\n";
		echo	"<input type='submit' name='Submit' value='Invia' />\n";
		echo	"</form>\n";
	}
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

function GetUserDetail($id){
	$query = "SELECT u.nome, u.cognome FROM users AS u WHERE id=".$id;
	return mysqli_fetch_assoc(SendQuery($query));
}
?>

