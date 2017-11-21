<!DOCTYPE html>
<?php
	$warn = "";
	if(isset($_GET['warn']) && $_GET['warn'] == 1) {
		$warn = "That username has already been taken.";
	} else if(isset($_GET['warn']) && $_GET['warn'] == 2) {
		$warn = "Password must be at least 6 characters long.";
	}
?>
<html lang="en" >
	<head>
		<title>Create an Account</title>
		<meta charset="utf-8">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
	</head>
	<body>
		<div class="container mt-3">
			<h1>Create an Account</h1>
			<p>Note: Once you have submitted this form, Brandon Cox must manually approve of your account. Contact him to finalize your account.</p>
			<form id='form' method="post" action="validate.php" >
				<div class="form-group">
					<label for="name">Name</label>
					<input id='name' class="form-control" type="text" name="username" value="" required placeholder="Enter username" />
				</div>
				<div class="form-group">
					<label for="pass">Password</label>
					<input id='pass' class="form-control" type="password" name="password" value="" required placeholder="Enter password" />
				</div>
				<div class="form-group">
					<label for="pass_conf">Confirm password</label>
					<input id='pass_conf' class="form-control" type="password" name="password" value="" required placeholder="Confirm password" />
				</div>
				<input type="submit" class="btn btn-primary" />
				<p id='warn'><?php echo $warn; ?></p>
			</form>
		</div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
	</body>
	
	<script>
		$(document).ready(function() {
			$('#form').submit(function(e) {
				var name = $('#name').val();
				var pass = $('#pass').val();
				var pass_conf = $('#pass_conf').val();
				if(pass != pass_conf) {
					e.preventDefault();
					$('#warn').html("Passwords do not match.");
				} else if(pass.length < 6) {
					e.preventDefault();
					$('#warn').html("Password must be at least 6 characters long.");
				} else if(name.length == 0) {
					e.preventDefault();
					$('#warn').html("Username must have at least 1 character.");
				}
			});
		});
	</script>
</html>
