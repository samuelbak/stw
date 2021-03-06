<?php require('../util/dbConnection.php'); ?>
<html>
<head>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://jqueryui.com/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
  </script>
</head>

<body>

<form id='createExam' action='?submitted' method='post' accept-charset='UTF-8'>
	<fieldset >
	<legend>Crea esame</legend>
	<input type='hidden' name='submitted' id='submitted' value='1'/>
	<label for='courseName' >Corso: </label>
	<select name="corso">
	<?php
		$courses = GetCourses();
		if ($courses == false)
			echo "<option value='0'>Non sono presenti corsi</option>";
		else{
			while ($row = $courses->fetch_assoc()){
				echo "<option value=".$row['id'].">".$row['nome']."</option>";
			}
		}
	?>
	</select>
	<br>
	<label for='date' >Data: </label>
	<input type='text' name='date' id='datepicker' /> 
	<br>
	<label for='time' >Orario: </label>
	<input type='text' name='time' id='time' />
	<br>
	<label for='loc' >Localit�: </label>
	<input type='text' name='loc' id='loc' /> 
	<br>
	<input type='submit' name='Submit' value='Crea' />
</fieldset>
</form>

<?php 
if(isset($_POST['submitted']) && $_POST['corso']!=0){
	if(CreateExam($_POST['corso'], $_POST['date'], $_POST['time'], $_POST['loc'])){
		echo "Esame creato correttamente";
	}else 
		echo "Qualcosa � andato storto";	
}
else{
	echo "Nessun corso selezionato";
}

function GetCourses(){
	$qry = "SELECT id, nome FROM courses";
	
	$result = SendQuery($qry);
	
	if ($result->num_rows <= 0)
		return false;
	else
		return $result;
}

function CreateExam($idRef, $data, $ora, $loc){
	$dataFormatted = str_replace("/", "-", $data);
	$year = substr($dataFormatted, -4);
	$dataFormatted = $year."-".$dataFormatted;
	$dataFormatted = substr($dataFormatted, 0,10);

	if(strlen($ora)==5){
		$oraFormatted = $ora.":00";
	}else 
		return false;
	//YYYY-MM-DD HH:MM:SS
	$dateTime = $dataFormatted." ".$oraFormatted;
	
	$qry = "INSERT INTO exams (idCorso, data, loc) VALUES ('$idRef', '$dateTime', '$loc')";
	
	$result = SendQuery($qry);
	
	if ($result === TRUE) {
		return true;
	} else {
		return false;
	}
}
?>

</body>
</html>