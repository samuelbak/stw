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
	
	function set_cookie($nome, $cognome, $username, $isAdmin){
		$cookie_name = "user";
		$user = array("nome"=> $nome, "cognome"=>$cognome, "user"=>$username, "isAdmin"=>$isAdmin);
		setcookie($cookie_name, json_encode($user), time() + (86400 * 30), "/"); // 86400 = 1 day
	}
?>