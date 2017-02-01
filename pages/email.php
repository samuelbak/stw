<?php require('../util/dbConnection.php'); ?>
<?php require('../util/cookie.php'); ?>

<Html>
<head>
	<link rel="stylesheet" type="text/css" href="/styles/email.css">
</head>
<body>
<div id="emailList_iframe_div">
	<iframe id="iframe_emailList" src="about:blank" name="iframe_emailList"></iframe>
</div>
<div id="emailView_iframe_div">
	<iframe id="iframe_emailView" src="about:blank" name="iframe_emailView"></iframe>
</div>
<div id="emailMenu_iframe_div">
	<iframe id="iframe_emailMenu" src="/pages/emailMenu.php" name="iframe_emailMenu">
	</iframe>
</div>
</body>
</Html>

<?php
/*
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
*/
?>