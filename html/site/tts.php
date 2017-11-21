<?php
	include "../../db.php";
	include "../user.php";
	
	$warn = "";
	
	if(isset($_POST['text'])) {
		$sql = "SELECT * FROM `files` ORDER BY `ID` DESC LIMIT 1";
		$result = $conn->query($sql);
		$id = 0;
		if($result->num_rows == 1) {
			$row = $result->fetch_assoc();
			$id = $row['ID'];
		}
		$target_dir = "/var/www/files/";
		$target_file = $target_dir.$id;
		if(strlen($_POST['text']) > 200) {
			shell_exec("pico2wave -w ".$target_file.".wav \"".$_POST['text']."\"");
			shell_exec("lame ".$target_file.".wav ".$target_file.".mp3");
			shell_exec("rm -f ".$target_file.".wav");
		} else {
			shell_exec("gtts-cli \"".$_POST['text']."\" -l 'en' -o ".$target_file.".mp3");
		}
		$target_file = $target_file.".mp3";
		$sql = "INSERT INTO `files` (`user_id`, `display_name`, `file_name`, `public`, `hidden`) VALUES (?, ?, ?, 0, 0)";
		$stmt = $conn->prepare($sql);
		$name = 'TTS: "'.$_POST['text'].'"';
		$stmt->bind_param("iss", $user_id, $name, $target_file);
		$stmt->execute();
		$stmt->close();
		$warn = "File successfully created.";
	}
?>
<html lang="en">
	<head>
		<title>TTS</title>
		<meta charset="utf-8">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	</head>
	<body>
		<?php
			include "navbar.php";
		?>
		<div class="container mt-3">
			<h1>Create a Text-to-Speech File</h1>
			<p>If your TTS request is more than 200 characters long, your file will be created using a lower quality TTS engine.</p>
			<form method="post">
				<div class="form-group">
					<label for="name">Text to say</label>
					<input id="name" class="form-control" type="text" name="text" required autocomplete="off" placeholder="Text to say" />
				</div>
				<input type="submit" class="btn btn-primary" />
			</form>
			<p><?php echo $warn; ?></p>
		</div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
	</body>
</html>
