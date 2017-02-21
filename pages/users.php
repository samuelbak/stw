<?php require('../util/dbConnection.php'); ?>
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

$users = GetUsersList();
if ($users == false)
	echo "Qualcosa è andato storto :(";
else{
	while ($row = $users->fetch_assoc()){
		echo "<a href='/pages/userDetail.php?id=".$row['id']."' target='iframe_userDetail'>".$row['cognome']." ".$row['nome']."</a><br>";
	}
}

function GetUsersList(){
	$qry = "SELECT * FROM users WHERE NOT username = 'admin' ORDER BY cognome ASC";
	
	$result = SendQuery($qry);
	
	if ($result->num_rows <= 0)
		return false;
	else
		return $result;
}
?>


