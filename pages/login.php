<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="/styles/login.css">
</head>

<body>


<form id='login' action='?submitted' method='post' accept-charset='UTF-8'>
<fieldset >
<legend>Login</legend>
<input type='hidden' name='submitted' id='submitted' value='1'/>
 
<label for='username' >UserName:</label>
<input type='text' name='username' id='username'  maxlength="50" />
<br>
<label for='password' >Password:</label>
<input type='password' name='password' id='password' maxlength="50" /> 
<br><br>
<input type='submit' name='Submit' value='Accedi' />

<a href="?register">Registrati</a>


<?php
if(isset($_GET['register'])) {
	echo "<script type='text/javascript'> document.location = '/pages/register.php'; </script>";
}
?>


<?php 
if(isset($_POST['submitted'])){
	if (Login()){
		echo "<script type='text/javascript'> document.location = '/pages/home.php'; </script>";
	}
	else{
		echo "<br> nome utente o password errata";
	}
}

function Login()
{
	if(empty($_POST['username']))
	{
		return false;
	}
	 
	if(empty($_POST['password']))
	{
		return false;
	}
	 
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	
	$userDetail = CheckLoginInDB($username,$password);
	
	if(!$userDetail)
	{
		return false;
	}
	else{
		$row = mysqli_fetch_assoc($userDetail);
		set_cookie($row["nome"],$row["cognome"],$username, $row["isAdmin"]);
		return true;
	}
}

function set_cookie($nome, $cognome, $username, $isAdmin){
	$cookie_name = "user";
	$user = array("nome"=> $nome, "cognome"=>$cognome, "user"=>$username, "isAdmin"=>$isAdmin);
	setcookie($cookie_name, json_encode($user), time() + (86400 * 30), "/"); // 86400 = 1 day

}

function CheckLoginInDB($username,$password)
{
	$servername = "localhost";
	$usernameDb = "webuser";
	$passwordDb = "webpassword";
	$dbname = "virtualcampus";
	
	// Create connection
	$conn = new mysqli($servername, $usernameDb, $passwordDb, $dbname);
	
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
		echo "db error";
	}
	
	$qry = "Select nome, cognome, username, password, isAdmin from users ".
			" where username='$username' and password='$password' ";
	$result = mysqli_query($conn, $qry);
	
	if($result && mysqli_num_rows($result) > 0){
		return $result;
	}
	else 
		return false;
}
?>
 
</fieldset>
</form>
	
</body>
</html>