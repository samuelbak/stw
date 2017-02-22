<?php require('../util/dbConnection.php'); ?>
<?php require('../util/cookie.php'); ?>

<html>
<head></head>
<body>
	<?php 
		if(isset($_GET['display'])){
			$emailsList = GetEmailsList(GetUserId(),$_GET['display']);
			while ($email = mysqli_fetch_assoc($emailsList)){
				if ($email['letto']==1)
					echo "<a href='./emailView.php?id=".$email['id']."&action=".$_GET['display']."' target='iframe_emailView'>".$email['oggetto']."</a><br>";
				else 
					echo "<a href='./emailView.php?id=".$email['id']."&action=".$_GET['display']."' target='iframe_emailView'><b>".$email['oggetto']."</b></a><br>";
			}
		}
	?>
</body>
</html>
<?php	
	function GetEmailsList($userId, $folder){
		if($folder == "sent")
			$query = "SELECT * FROM emails WHERE idMittente='".$userId."' ORDER BY data ASC";
		if($folder == "received")
			$query = "SELECT * FROM emails WHERE idDestinatario='".$userId."' ORDER BY data ASC";
		return SendQuery($query);	
	}
?>