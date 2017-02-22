<?php require('../util/dbConnection.php'); ?>
<?php require('../util/cookie.php'); ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../styles/courses.css">
</head>

<body>

<div id="courseDetail_iframe_div">
<iframe id="courseDetail_iframe" src="about:blank" name="iframe_courseDetail"></iframe>
</div>

<?php 

	$courses = GetCoursesEnabledFromUserId(GetUserId());
	while ($rowCourse = mysqli_fetch_assoc($courses)){
		$examName = GetExamName($rowCourse['idCorso']);
		echo "<a href='./courseDetail.php?id=".$rowCourse['idCorso']."' target='iframe_courseDetail'>".$examName."</a><br>";
	}

function GetCoursesEnabledFromUserId($userId){
	$query = "SELECT * FROM usersdetail WHERE idUtente='".$userId."'";
	return SendQuery($query);
}

function GetExamName($courseId){
	$query = "SELECT nome FROM courses WHERE id='".$courseId."'";
	$result = SendQuery($query);
	$ar = mysqli_fetch_assoc($result);
	return $ar['nome'];
}
?>
</body>
</html>
