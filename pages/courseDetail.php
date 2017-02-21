<?php require('../util/dbConnection.php'); ?>
<html>
<head>
</head>

<body>

	<?php 
		if(isset($_GET['id'])){
			$courseDetail = GetCourseDetail($_GET['id']);
			echo "<h1>".$courseDetail['nome']."</h1>";
			echo "<h3>".$courseDetail['descrizione']."</h3>";
		}
	?>

</body>
</html>

<?php 

function GetCourseDetail($courseId){
	$query = "SELECT nome, descrizione FROM courses WHERE id='".$courseId."'";
	return mysqli_fetch_assoc(SendQuery($query));
}
?>