<!DOCTYPE html>
<?php
	include "../../db.php";
	
	$uname = $_POST['username'];
	$pass = $_POST['password'];
	if(strlen($pass) < 6) {
		header("Location: create.php?warn=2");
	}
	$pass = passwordHash($pass);
	
	$stmt = $conn->prepare("SELECT COUNT(*) FROM `users` WHERE `username`=?");
	$stmt->bind_param("s", $uname);
	$stmt->execute();
	$count = 0;
	$stmt->bind_result($count);
	$stmt->fetch();
	$stmt->close();
	if($count == 0) {
		$stmt = $conn->prepare("INSERT INTO `users` (`username`, `password`, `active`, `admin`) VALUES (?, ?, 0, 0)");
		$stmt->bind_param("ss", $uname, $pass);
		$stmt->execute();
		$stmt->close();
		$conn->close();
	} else {
		header("Location: create.php?warn=1");
	}
?>
<html lang="en">
	<head>
		<title>Account Created!</title>
		<meta charset="utf-8">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
	</head>
	<body>
		<div class="container mt-3">
			<p>A database entry has been made for your account. You must contact Brandon Cox in order to be able to login.</p>
			<a href="../index.php">Return to home</a>
		</div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
	</body>
</html>
