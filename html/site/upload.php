<!DOCTYPE html>
<?php
	include "../../db.php";
	include "../user.php";
	
	$warn = "";
	
	if(isset($_POST['name'])) {
		$sql = "SELECT * FROM `files` ORDER BY `ID` DESC LIMIT 1";
		$result = $conn->query($sql);
		$id = 0;
		if($result->num_rows == 1) {
			$row = $result->fetch_assoc();
			$id = $row['ID'];
		}
		$fileExtension = pathinfo(basename($_FILES['file']['name']), PATHINFO_EXTENSION);
		$target_dir = "/var/www/files/";
		$target_file = $target_dir.$id.".".$fileExtension;
		if(check_file_is_audio($_FILES['file']['tmp_name'])) {
			if($_FILES['file']['size'] < 30000000) {
				if(move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
					$sql = "INSERT INTO `files` (`user_id`, `display_name`, `file_name`, `public`, `hidden`) VALUES (?, ?, ?, 0, 0)";
					$stmt = $conn->prepare($sql);
					$stmt->bind_param("iss", $user_id, $_POST['name'], $target_file);
					$stmt->execute();
					$stmt->close();
					$warn = "File successfully uploaded.";
				} else {
					$warn = "File failed to upload.";
				}
			} else {
				$warn = "File must be smaller than 30MB.";
			}
		} else {
			$warn = "File was not an audio file.";
		}
	}
	
	function check_file_is_audio( $tmp ) {
		$allowed = array(
			'audio/mpeg', 'audio/x-mpeg', 'audio/mpeg3', 'audio/x-mpeg-3', 'audio/aiff', 
			'audio/mid', 'audio/x-aiff', 'audio/x-mpequrl','audio/midi', 'audio/x-mid', 
			'audio/x-midi','audio/wav','audio/x-wav','audio/xm','audio/x-aac','audio/basic',
			'audio/flac','audio/mp4','audio/x-matroska','audio/ogg','audio/s3m','audio/x-ms-wax',
			'audio/xm'
		);
		
		// check REAL MIME type
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$type = finfo_file($finfo, $tmp );
		finfo_close($finfo);
		
		// check to see if REAL MIME type is inside $allowed array
		if( in_array($type, $allowed) ) {
			return true;
		} else {
			return false;
		}
	}
?>
<html lang="en">
	<head>
		<title>Upload</title>
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
			<h1>Upload a file</h1>
			<p>File must be an audio file.</p>
			<form enctype="multipart/form-data" method="post">
				<div class="form-group">
					<label for="name">Name</label>
					<input id="name" class="form-control" type="text" name="name" required autocomplete="off" placeholder="Name" />
				</div>
				<div class="form-group">
					<label for="file">File</label>
					<input id="file" accept="audio/*" class="form-control-file" type="file" name="file" required autocomplete="off" />
				</div>
				<input type="submit" class="btn btn-primary" />
			</form>
			<p><?php echo $warn; ?></p>
		</div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	</body>
</html>
