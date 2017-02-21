<html>
<head>
<title>Virtual Campus</title>
<link rel="stylesheet" type="text/css" href="styles/index.css">
</head>

<body>
<?php
if(isset($_COOKIE['user'])) {
	echo "<script type='text/javascript'> document.location = 'pages/home.php'; </script>";
} else {
	echo "<script type='text/javascript'> document.location = 'pages/login.php'; </script>";
}
?>
</body>
</html>	