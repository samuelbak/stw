<html>
<head>
	<link rel="stylesheet" type="text/css" href="/styles/emailMenu.css">
</head>
<body>
	<a href="#" onClick="changetwo('/pages/emailView.php?action=new','about:blank')">Nuovo messaggio</a>
	<a href="#" onClick="changetwo('about:blank','/pages/emailList.php?display=received')">Posta in arrivo</a>
	<a href="#" onClick="changetwo('about:blank','/pages/emailList.php?display=sent')">Posta inviata</a>
</body>
<script type="text/javascript">
	function changetwo(url1, url2){
		parent.document.getElementById("iframe_emailView").src=url1
		parent.document.getElementById("iframe_emailList").src=url2
	}
</script>
</html>