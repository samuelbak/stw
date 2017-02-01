<?php
	function GetUserId(){
		$userDetail = json_decode($_COOKIE['user'], true);
		$userName = $userDetail['user'];
	
		$query = "SELECT id FROM users WHERE username='".$userName."'";
	
		$result = SendQuery($query);
	
		if($result){
			$val = mysqli_fetch_assoc($result);
			return $val['id'];
		}
		return "nope";
	}
?>