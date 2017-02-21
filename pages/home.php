<?php require('../util/cookie.php'); ?>
<html>
<head>
	<title>Virtual campus</title>
	<link rel="stylesheet" type="text/css" href="/styles/home.css">
</head>

<body>

<?php 
if(!isset($_COOKIE['user'])) {
	echo "<script type='text/javascript'> document.location = '/pages/login.php'; </script>";
} else {
	$userDetail = json_decode($_COOKIE['user'], true);
	$isAdmin = $userDetail['isAdmin'];
	echo "Benvenuto: ". $userDetail['nome']." ".$userDetail['cognome']."<br>";
	if($isAdmin==0){
		echo "<div id='button_group'>";
		echo "<a href='/pages/courses.php' target='iframe_main'>Corsi disponibili</a><br>";
		echo "<a href='/pages/reservation.php' target='iframe_main'>Prenota esame</a><br>";
		echo "<a href='/pages/email.php' target='iframe_main'>Email</a><br>";
		echo "<a href='?logout'>Logout</a><br>";
		echo "</div>";
	}
	else{
		echo "<div id='button_group'>";
		echo "<a href='/pages/createCourse.php' target='iframe_main'>Crea corso</a><br>";
		echo "<a href='/pages/createExam.php' target='iframe_main'>Crea esame</a><br>";
		echo "<a href='/pages/users.php' target='iframe_main'>Gestione utenti</a><br>";
		echo "<a href='/pages/email.php' target='iframe_main'>Email</a><br>";
		echo "<a href='?logout'>Logout</a><br>";
		echo "</div>";
	}
}
?>

<?php 
if(isset($_GET['logout'])) {
	clearCookie();
	echo "<script type='text/javascript'> document.location = '/index.php'; </script>";
}
?>

<div id="main_iframe_div">
	<iframe id="main_iframe" src="/pages/welcome.php" name="iframe_main"></iframe>
</div>

</body>
</html>	
