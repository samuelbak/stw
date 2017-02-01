<html>
<head>
	<link rel="stylesheet" type="text/css" href="/styles/users.css">
</head>

<body>

<div id="userDetail_iframe_div">
	<iframe id="userDetail_iframe" src="/pages/userDetail.php" name="iframe_userDetail"></iframe>
</div>


</body>
</html>	

<?php
/*
$userDetail = json_decode($_COOKIE['user'], true);
$isAdmin = $userDetail['isAdmin'];
if (!$isAdmin==1){
	echo "Non hai i privilegi per visualizzare questa pagina";
}else{
	echo "Gestione utenti";
}
*/
?>

<?php 

$users = GetUsersList();
if ($users == false)
	echo "Qualcosa è andato storto :(";
	else{
		while ($row = $users->fetch_assoc()){
			//echo "<p>".$row['id']."  ".$row['username']."  ".$row['nome']."  ".$row['cognome']."</p><br>";
			echo "<a href='/pages/userDetail.php?id=".$row['id']."' target='iframe_userDetail'>".$row['cognome']." ".$row['nome']."</a><br>";
		}
	}


function GetUsersList(){
	$servername = "localhost";
	$usernameDb = "webuser";
	$passwordDb = "webpassword";
	$dbname = "virtualcampus";
	
	$conn = new mysqli($servername, $usernameDb, $passwordDb, $dbname);
	
	if (!$conn) {
		return false;
	}
	
	$qry = "SELECT * FROM users WHERE NOT username = 'admin' ORDER BY cognome ASC";
	
	$result = $conn->query($qry);
	
	if ($result->num_rows <= 0)
		return false;
	else
		return $result;
}
?>


