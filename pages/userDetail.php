<?php require('../util/dbConnection.php'); ?>
<?php require('../util/cookie.php'); ?>
<html>
<head>
</head>
<body>

<form id='createExam' action='?addCourse' method='post' accept-charset='UTF-8'>
	<fieldset >
	<legend>Assegna corso</legend>
	<input type='hidden' name='addCourse' id='addCourse' value='1'/>
	<?php
	if (isset($_GET['id'])){
		echo "<input type='hidden' name='userId' id='userId' value='".$_GET['id']."'/>";
		$courses = GetCourses();
		$active = GetActive($_GET['id']);
		$checked = "";
		
		if ($courses == false)
			echo "<option value='0'>Non sono presenti corsi</option>";
		else{
			while ($courseRow = $courses->fetch_assoc()){
				while($activeRow = $active->fetch_assoc()){
					if($courseRow['id'] == $activeRow['idCorso']){
						$checked = "checked='checked'";
						break;
					}
					else{
						$checked = "";
					}
				}
				$active->data_seek(0);
				echo "<input type='checkbox' name='".$courseRow['id']."' value='".$courseRow['id']."' ".$checked."/>".$courseRow['nome']."<br>";
				$checked = "";
			}
			echo "<br>";
			echo "<input type='submit' name='Submit' value='Assegna' />";
		}
	}
	?>
	
</fieldset>
</form> 

<fieldset>
	<legend>Esito esami</legend>
	<?php
		if (isset($_GET['id'])){
			$examsList = GetExamReserved($_GET['id']);
			while ($exam = mysqli_fetch_assoc($examsList)){
				$examDesc = GetExamDetailFromId($exam['idEsame']);
				echo "<p>".$examDesc['nome']." ".$examDesc['data']." ".$examDesc['luogo']."</p>";
				CreateModifyForm($examDesc['id'], $_GET['id']);
			}
		}
	?>
</fieldset>

<fieldset>
	<legend>Rendi amministratore</legend>
	<?php if (isset($_GET['id'])){
		$checked = "";
		if (isAdmin($_GET['id']) == 1)
			$checked = "checked='checked'";
	echo "<form id='makeAdmin' action='?makeAdmin' method='post' accept-charset='UTF-8'>";
		echo "<input type='hidden' name='userId' id='userId' value='".$_GET['id']."'/>";
		echo "<input type='checkbox' name='admin' value='admin' ".$checked."> Amministratore";
		echo "<input type='submit' name='Submit' value='Applica'/>";		
	echo "</form>";
	}
	?>
</fieldset>
 
</body>
</html>

<?php
	if (!isset($_GET['id'])){
		header("about:blank");
	}
	if (isset($_POST['addCourse'])){
		if(AssignCourse($_POST))
			echo "Corso assegnato correttamente";
		else 
			echo "Qualcosa è andato storto";
	}	
	if (isset($_POST['Submit'])){
		if($_POST['Submit']=="Modifica"){
			if(isset($_POST['Notifica']))
				EditResults($_POST['userId'],$_POST['examId'],$_POST['selEsito'],1);
			else 
				EditResults($_POST['userId'],$_POST['examId'],$_POST['selEsito'],0);
		}
		if($_POST['Submit']=="Applica"){
			if(isset($_POST['admin']))
				$query = "UPDATE users SET isAdmin='1' WHERE id='".$_POST['userId']."'";
			else 
				$query = "UPDATE users SET isAdmin='0' WHERE id='".$_POST['userId']."'";
			SendQuery($query);
		}
	}
?>
	
<?php
function isAdmin($userId){
	$query = "SELECT isAdmin FROM users WHERE id='".$userId."'";
	$result = SendQuery($query);
	$row = mysqli_fetch_assoc($result);
	return $row['isAdmin'];
}

function EditResults($userId, $examId, $result, $notify){
	$examDetail = GetExamDetailFromId($examId);
	$object = "Aggiornamento esame ".$examDetail['nome'];
	if($result == 0){
		$text = "Non superato";
		$query = "UPDATE results SET stato='".$text."', corretto='1', verbalizzato='1' WHERE idUtente='".$userId."' AND idEsame='".$examId."'";
	}
	if($result == 1){
		$text = "In attesa di esito";
		$query = "UPDATE results SET stato='".$text."', corretto='0', verbalizzato='0' WHERE idUtente='".$userId."' AND idEsame='".$examId."'";
	}
	if($result>=18 || $result <=30){
		$text = $result."/30";
		$query = "UPDATE results SET stato='".$text."', corretto='1', verbalizzato='0' WHERE idUtente='".$userId."' AND idEsame='".$examId."'";
	}
	if($result == 31){
		$text = "30 e lode";
		$query = "UPDATE results SET stato='".$text."', corretto='1', verbalizzato='1', accettato='1' WHERE idUtente='".$userId."' AND idEsame='".$examId."'";
		}
	if(isset($query)){
		SendQuery($query);
		SendMail($userId, GetUserId(), $object, $text);
	}
}

function SendMail($to, $from, $object, $text){
	$query ="INSERT INTO emails (idMittente, idDestinatario, oggetto, testo) ".
			"VALUES ('".$from."', '".$to."', '".$object."', '".$text."')";
	SendQuery($query);
}

function IsStateSelected($examId, $userId){
	$query = "SELECT stato FROM results WHERE idUtente='".$userId."' AND idEsame='".$examId."'";
	$result = SendQuery($query);
	$row = mysqli_fetch_assoc($result);
}

function CreateModifyForm($examId, $userId){
	echo "<form id='editExam' action='' method='post' accept-charset='UTF-8'>\n";
	echo "<input type='hidden' name='examId' id='examId' value='".$examId."'/>";
	echo "<input type='hidden' name='userId' id='user,Id' value='".$userId."'/>";
	echo "<select name='selEsito' id='selEsito'>\n";
	GetSelectionMenu($examId, $userId);
	echo "</select>\n";
	echo "<input type='submit' name='Submit' value='Modifica' />";
	echo "<input type='checkbox' name='Notifica' value='Notifica' /> Notifica";
	echo "</form>";
}

function GetSelectionMenu($examId, $userId){
	$selected = GetSelectedVal($examId, $userId);
	echo "<option ".$selected[0]." value='0'>Non superato</option>";
	echo "<option ".$selected[1]." value='1'>In attesa di esito</option>";
	echo "<option ".$selected[2]." value='2'>Rifiutato</option>";
	for ($i=18; $i<31;$i++){
		echo "<option ".$selected[$i]." value='".$i."'>".$i."</option>";
	}
	echo "<option ".$selected[31]." value='31'>30 e lode</option>";
}

function GetSelectedVal($examId, $userId){
	$selArray = array();
	for ($i = 0; $i<32; $i++)
		array_push($selArray, "");
	$query = "SELECT * FROM results WHERE idUtente='".$userId."' AND idEsame='".$examId."'";
	$result = mysqli_fetch_assoc(SendQuery($query));
	if($result['stato'] == "Non superato")
		$index == 0;
	if($result['stato']=="In attesa di esito")
		$index = 1;
	if ($result['corretto']==1 && $result['verbalizzato']==1 && $result['accettato']==0)
		$index = 2;
	if($result['accettato']==1 && $result['stato']!="30 e lode"){
		$index = substr($result['stato'],0,2);
	}
	if($result['stato']=="30 e lode")
		$index = 31;
	
	$selArray[$index] = "selected";
	return $selArray;
}

function GetExamReserved($userId){
	$query = "SELECT * FROM results WHERE idUtente='".$userId."' ORDER BY id ASC";
	return SendQuery($query);
}

function GetExamDetailFromId($examId){
	$query = "SELECT * FROM exams WHERE id='".$examId."'";
	$examDetail = mysqli_fetch_array(SendQuery($query));
	$query = "SELECT nome FROM courses WHERE id='".$examDetail['idCorso']."'";
	$courseName = mysqli_fetch_assoc(SendQuery($query));
	$name = $courseName['nome'];
	return array("id"=>$examDetail['id'], "nome"=>$name, "data"=>$examDetail['data'], "luogo"=>$examDetail['loc']);
}

function GetCourses(){
	$qry = "SELECT id, nome FROM courses ORDER BY nome ASC";
	$result =SendQuery($qry);

	if ($result->num_rows <= 0){
		return false;
	}else{
		return $result;
	}
}
	
function GetActive($user){
	$qry = "SELECT * FROM usersdetail WHERE idUtente='".$user."'";		
	$result = SendQuery($qry);
	return $result;
}
	
function AssignCourse($selection){
	SendQuery("DELETE QUICK FROM usersdetail WHERE idUtente='".$selection['userId']."'");
	$keys = array_keys($selection);
	$element = count($keys);		
	for($i = 2; $i<($element-1);$i++){
		echo SendQuery("INSERT INTO usersdetail (idUtente, idCorso) VALUES ('".$selection['userId']."', '".$selection[$keys[$i]]."')");
	}
	return true;
}
?>
