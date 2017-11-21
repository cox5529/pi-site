<?php
	include "../../db.php";
	include "../user.php";
	
	if(isset($_POST['filename'])) {
		$fname = $_POST['filename'];
		$stmt = $conn->prepare("INSERT INTO `queue` (`user_id`, `filename`) VALUES (?, ?)");
		$stmt->bind_param("is", $user_id, $fname);
		$stmt->execute();
		$stmt->close();
	}
?>
