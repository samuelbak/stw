<?php require('../util/dbConnection.php'); ?>
<?php require('../util/cookie.php'); ?>
<html>
<head>
</head>
<body>

<form id='reserveExam' action='' method='get' accept-charset='UTF-8'>
	<fieldset >
		<legend>Prenota esame</legend>
			<?php
			$userId = GetUserId();
			$courses = GetCoursesEnabledFromUserId($userId);
			while ($rowCourse = mysqli_fetch_assoc($courses)){
				$examDetail = GetExamsDetail($rowCourse['idCorso']);
				$examName = GetExamName($rowCourse['idCorso']);
				while ($rowExam = mysqli_fetch_assoc($examDetail)){
					if(isset($rowExam['data'])){
						if(IsExamReserved($rowExam['id'], $userId))
							$reserved = "disabled";
						else 
							$reserved = "";
						echo $examName."\t";
						echo $rowExam['data']."\t".$rowExam['loc']."\t";
						echo "<button  name='idExam' value='".$rowExam['id']."' ".$reserved.">Prenota</button><br>";
					}
				}
			}
			?>
	</fieldset>
</form>

<form id='examDetail' action='' method='get' accept-charset='UTF-8'>
	<fieldset>
		<legend>Esami</legend>
		<?php 
			$examsList = GetExamReserved(GetUserId());
			while ($exam = mysqli_fetch_assoc($examsList)){
				$examDesc = GetExamDetailFromId($exam['idEsame']);
				echo "<p>".$examDesc['nome']." ".$examDesc['data']." ".$examDesc['luogo']."  ".CreateResultLinks($examDesc['id'])."</p>";
			}
		?>
	</fieldset>
</form>
</body>
</html>



<?php
	if(isset($_GET['idExam'])){
		InsertExam($_GET['idExam']);
		echo "<script type='text/javascript'>document.location='/pages/reservation.php';</script>";
	}
	
	if(isset($_GET['action']) && isset($_GET['resultsId'])){
		UpdateResults($_GET['action'], $_GET['resultsId']);
		echo "<script type='text/javascript'>document.location='/pages/reservation.php';</script>";
	}
?>
<?php
function UpdateResults($action, $resultsId){
	if($action==1)
		$query = "UPDATE results SET verbalizzato='1', accettato='1' WHERE id='".$resultsId."'";
	else
		$query = "UPDATE results SET verbalizzato='1', accettato='0' WHERE id='".$resultsId."'";
	
	SendQuery($query);
}

function CreateResultLinks($examId){
	$query = "SELECT * FROM results WHERE idEsame='".$examId."'";
	$result = SendQuery($query);
	$row = mysqli_fetch_assoc($result);
	$stato = $row['stato'];
	if($row['corretto']==1 && $row['verbalizzato']==0){
		return $stato." <a href='?action=1&resultsId=".$row['id']."'>Accetta</a>  <a href='?action=0&resultsId=".$row['id']."'>Rifiuta</a>";
	}
	if($row['corretto']==1 && $row['verbalizzato']==1 && $row['accettato']==0)
		return $stato." Rifiutato";
	if($row['corretto']==1 && $row['verbalizzato']==1 && $row['accettato']==1)
		return $stato." Accettato";
	else{
		return $stato;
	}
}

function IsExamReserved($examId, $userId){
	$query = "SELECT id FROM results WHERE idUtente='".$userId."' AND idEsame='".$examId."'";
	$result = SendQuery($query);
	if ($result->num_rows == 0)
		return false;
	else 
		return true;
}

function GetExamReserved($userId){
	$query = "SELECT * FROM results WHERE idUtente='".$userId."' ORDER BY id ASC";
	return SendQuery($query);
}

function GetExamDetailFromId($examId){
	$query = "SELECT * FROM exams WHERE id='".$examId."'";
	$examDetail = mysqli_fetch_array(SendQuery($query));
	$query = "SELECT nome FROM courses WHERE id='".$examDetail['idCorso']."'";
	//echo $query;
	$courseName = mysqli_fetch_assoc(SendQuery($query));
	$name = $courseName['nome'];
	return array("id"=>$examDetail['id'], "nome"=>$name, "data"=>$examDetail['data'], "luogo"=>$examDetail['loc']);
}

function InsertExam($examId){
	$query = 	"INSERT INTO results (idUtente, idEsame, corretto, stato, verbalizzato) 
				VALUES ('".GetUserId()."', '".$examId."', '0', 'In attesa di esito', '0')";
	return SendQuery($query);
}

function GetExamName($courseId){
	$query = "SELECT nome FROM courses WHERE id='".$courseId."'";
	$result = SendQuery($query);
	$ar = mysqli_fetch_assoc($result);
	return $ar['nome'];
}

function GetExamsDetail($examId){
	$query = "SELECT * FROM exams WHERE idCorso='".$examId."'";
	return SendQuery($query);
	
}

function GetCoursesEnabledFromUserId($userId){
	$query = "SELECT idCorso FROM usersdetail WHERE idUtente='".$userId."'";
	return SendQuery($query);
}

?>