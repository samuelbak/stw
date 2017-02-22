<?php require('../util/dbConnection.php'); ?>
<html>
<head>
	
</head>

<?php
$userDetail = json_decode($_COOKIE['user'], true);
$isAdmin = $userDetail['isAdmin'];
if (!$isAdmin==1){
	echo "Non hai i privilegi per visualizzare questa pagina";
}else{
	echo "Crea corso";
}
?>

<form id='createCourse' action='?submitted' method='post' accept-charset='UTF-8'>
<fieldset >
<legend>Crea corso</legend>
<input type='hidden' name='submitted' id='submitted' value='1'/>
 
<label for='courseName' >Nome corso</label>
<input type='text' name='courseName' id='courseName'  maxlength="50" />
<br>
<label for='courseDescription' >Descrizione corso</label>
<input type='text' name='courseDescription' id='courseDescription' /> 
<br><br>
<input type='submit' name='Submit' value='Crea' />
</fieldset>
</form>
<?php 
if(isset($_POST['submitted'])){
	if (CreateCourse($_POST['courseName'], $_POST['courseDescription'])){
		echo "Corso creato con successo";
	}
	else{
		echo "Qualcosa è andato storto :(";
	}
}

function CreateCourse($courseName, $courseDescription){
	if(empty($_POST['courseName']))
	{
		return false;
	}
	
	if(empty($_POST['courseDescription']))
	{
		return false;
	}

	$name = trim($_POST['courseName']);
	$description = trim($_POST['courseDescription']);
	
	$qry = "INSERT INTO courses (nome, descrizione) VALUES  ('$name', '$description')";
	$result = SendQuery($qry);
	
	if ($result === TRUE) {
		return true;
	} else {
		return false;
	}
}

?>


</html>