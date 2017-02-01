<html>
<head>
<link rel="stylesheet" type="text/css" href="/styles/courses.css">
</head>

<body>

<div id="courseDetail_iframe_div">
<iframe id="courseDetail_iframe" src="about:blank" name="iframe_courseDetail"></iframe>
</div>


</body>
</html>

<?php 

	$courses = GetCoursesEnabledFromUserId(GetUserId());
	while ($rowCourse = mysqli_fetch_assoc($courses)){
		$examName = GetExamName($rowCourse['idCorso']);
		echo "<a href='/pages/courseDetail.php?id=".$rowCourse['idCorso']."' target='iframe_courseDetail'>".$examName."</a><br>";
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