<!DOCTYPE html>
<?php
	include "../db.php";
	
	$warn = "";
	
	if(isset($_POST['username']) && isset($_POST['password'])) {
		$uname = $_POST['username'];
		$pass = passwordHash($_POST['password']);
		
		$stmt = $conn->prepare("SELECT COUNT(*) FROM `users` WHERE `username`=? AND `password`=?");
		$stmt->bind_param("ss", $uname, $pass);
		$stmt->execute();
		$count = 0;
		$stmt->bind_result($count);
		$stmt->fetch();
		$stmt->close();
		
		if($count == 1) {
			$stmt = $conn->prepare("SELECT `ID`, `active` FROM `users` WHERE `username`=? AND `password`=?");
			$stmt->bind_param("ss", $uname, $pass);
			$stmt->execute();
			$id = 0;
			$active = 0;
			$stmt->bind_result($id, $active);
			$stmt->fetch();
			$stmt->close();
			$conn->close();
			
			if($active == 1) {
				session_start();
				$_SESSION['uname'] = $uname;
				$_SESSION['pass'] = $pass;
				$_SESSION['user_id'] = $id;
				
				header("Location: /site/catan/catan.php");
				
			} else {
				$warn = "Your account has not been approved. Contact Brandon Cox.";
			}
		} else {
			$warn = "Incorrect username or password.";
		}
	}
?>
<html lang="en">
	<head>
		<title>Login</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	</head>
	<body>
		<div class="container mt-3">
			<h1>Login</h1>
			<form method="post">
				<div class="form-group">
					<label for="uname">Username</label>
					<input id="uname" class="form-control" type="text" name="username" value="" placeholder="Enter username" />
				</div>
				<div class="form-group">
					<label for="pass">Password</label>
					<input id="pass" class="form-control" type="password" name="password" value="" placeholder="Enter password" />
				</div>
				<input type="submit" class="btn btn-primary" value="Login" />
				<a href="account/create.php">Create account</a>
				<br />
				<a href="graph.html">Graph demo</a>
				<p><?php echo $warn; ?></p>
			</form>
		</div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	</body>
</html>
