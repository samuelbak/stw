<html>
<head>
<title>Login</title>
<link rel="stylesheet" type="text/css" href="/styles/login.css">
</head>

<body>


<form id='register' action='?submitted' method='post' accept-charset='UTF-8'>
<fieldset >
<legend>Nuovo utente</legend>
<input type='hidden' name='submitted' id='submitted' value='1'/>
<label for='nome' >Nome:</label>
<input type='text' name='nome' id='nome'  maxlength="50" />
<label for='cognome' >Cognome:</label>
<input type='text' name='cognome' id='cognome'  maxlength="50" />
<label for='username' >UserName:</label>
<input type='text' name='username' id='username'  maxlength="50" />
<br>
<label for='password' >Password:</label>
<input type='password' name='password' id='password' maxlength="50" />
<label for='password2' >Reinserisci password:</label>
<input type='password' name='password2' id='password2' maxlength="50" />
<br><br>
<input type='submit' name='Submit' value='Registrati' />

<?php 
if(isset($_POST['submitted'])){
	if (NewUser()){
		echo "<script type='text/javascript'> document.location = '/pages/home.php'; </script>";
		Login();
	}
	else{
		echo "<br> Nome utente già esistente";
	}
}

function NewUser(){
	$servername = "localhost";
	$usernameDb = "webuser";
	$passwordDb = "webpassword";
	$dbname = "virtualcampus";
	
	if(empty($_POST['username']))
	{
		return false;
	}
	
	if(empty($_POST['password']))
	{
		return false;
	}
	
	$firstName = trim($_POST['nome']);
	$lastName = trim($_POST['cognome']);
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	$password2 = trim($_POST['password2']);
	
	if(!CheckPwd($password, $password2))
		return false;
		
	
	if(!IsUserAvailable($username))
		return false;
	
	$conn = new mysqli($servername, $usernameDb, $passwordDb, $dbname);
	
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
		echo "db error";
	}
	
	$qry = "INSERT INTO users (nome, cognome, username, password, isAdmin) VALUES  ('$firstName', '$lastName' ,'$username', '$password', '0')";
	
	if ($conn->query($qry) === TRUE) {
		return true;
	} else {
		return false;
	}
}

function Login()
{
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	$userDetail = CheckLoginInDB($username,$password);

	$row = mysqli_fetch_assoc($userDetail);
	set_cookie($username, $row["isAdmin"]);
	return true;
}

function set_cookie($username, $isAdmin){
	$cookie_name = "user";
	$user = array("user"=>$username, "isAdmin"=>$isAdmin);
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

	$qry = "Select username, password, isAdmin from users ".
			" where username='$username' and password='$password' ";
	
	$result = mysqli_query($conn, $qry);

	if($result && mysqli_num_rows($result) > 0){
		return $result;
	}
	else
		return false;
}

function IsUserAvailable($username){
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
	
	$qry = 	"Select username from users ".
			" where username='$username'";
	$result = mysqli_query($conn, $qry);
	
	if($result && mysqli_num_rows($result) > 0){
		return false;
	}
	else
		return true;
}

function CheckPwd($pwd1, $pwd2){
	if ($pwd1 == $pwd2)
		return true;
	else 
		return false;
}


?>
 
</fieldset>
</form>
	
</body>
</html>