<html>
<head>
<title>Virtual Campus</title>
<link rel="stylesheet" type="text/css" href="styles/index.css">
</head>

<body>
<?php


// Check connection
/*
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
*/

if(isset($_COOKIE['user'])) {
	echo "<script type='text/javascript'> document.location = 'pages/home.php'; </script>";
} else {
	echo "<script type='text/javascript'> document.location = 'pages/login.php'; </script>";
}
?>
	
</body>
</html>	