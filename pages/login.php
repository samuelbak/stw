<?php require('../util/dbConnection.php'); ?>
<?php require('../util/cookie.php'); ?>

<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="../styles/login.css">
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
	echo "<script type='text/javascript'> document.location = './register.php'; </script>";
}
?>


<?php 
if(isset($_POST['submitted'])){
	if (Login()){
		echo "<script type='text/javascript'> document.location = './home.php'; </script>";
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

function CheckLoginInDB($username,$password)
{
	$qry = "Select nome, cognome, username, password, isAdmin from users ".
			" where username='$username' and password='$password' ";
	$result = SendQuery($qry);
	
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