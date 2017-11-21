<?php	
	session_start();

	function kick() {
		header("Location: /index.php");
	}
	$uname = "";
	$pass = "";
	$user_id = 0;
	$is_admin = false;
	if(isset($_SESSION['uname']) and isset($_SESSION['pass']) and isset($_SESSION['user_id'])) {
		$uname = $_SESSION['uname'];
		$pass = $_SESSION['pass'];
		$user_id = $_SESSION['user_id'];
		
		$stmt = $conn->prepare("SELECT COUNT(*) FROM `users` WHERE `username`=? AND `password`=? AND `ID`=?");
		$stmt->bind_param("ssi", $uname, $pass, $user_id);
		$stmt->execute();
		$count = 0;
		$stmt->bind_result($count);
		$stmt->fetch();
		$stmt->close();
		if($count == 0) {
			kick();
		}
		
		$stmt = $conn->prepare("SELECT `admin` FROM `users` WHERE `username`=? AND `password`=? AND `ID`=?");
		$stmt->bind_param("ssi", $uname, $pass, $user_id);
		$stmt->execute();
		$a = 0;
		$stmt->bind_result($a);
		$stmt->fetch();
		$stmt->close();
		if($a == 1) {
			$is_admin = true;
		}
	} else {
		kick();
	}
	
?>
