<?php require('../util/dbConnection.php'); ?>
<?php require('../util/cookie.php'); ?>

<?php 
	$userId = GetUserId();
	$query = "SELECT COUNT(*) AS unread FROM (SELECT * FROM emails WHERE emails.idDestinatario=".$userId." AND emails.letto=0) AS received";
	$row = mysqli_fetch_assoc(SendQuery($query));
	$unread = $row['unread'];
	
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="/styles/emailMenu.css">
</head>
<body>
	<a href="#" onClick="changetwo('/pages/emailView.php?action=new','about:blank')">Nuovo messaggio</a>
	<a href="#" onClick="changetwo('about:blank','/pages/emailList.php?display=received')">Posta in arrivo (<?php echo $unread; ?>)</a>
	<a href="#" onClick="changetwo('about:blank','/pages/emailList.php?display=sent')">Posta inviata</a>
</body>
<script type="text/javascript">
	function changetwo(url1, url2){
		parent.document.getElementById("iframe_emailView").src=url1
		parent.document.getElementById("iframe_emailList").src=url2
	}
</script>
</html>