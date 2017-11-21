<?php
	include "../../db.php";
	include "../user.php";
	
	$sql = "SELECT * FROM `playing`";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()) {
		if($row['user_id'] == $user_id or $is_admin == 1) {
			shell_exec("sudo killall omxplayer.bin");
		}
	}
	$conn->close();
?>
