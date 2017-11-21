<?php
	include "../../db.php";
	include "../user.php";

	$sql = "SELECT `files`.`display_name`, `users`.`username`, `files`.`file_name` FROM `files` JOIN `users` ON `files`.`user_id`=`users`.`ID` WHERE `files`.`public`=1 AND `files`.`hidden`=0 ORDER BY `files`.`ID` DESC";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo "<td>".$row['display_name']."</td>";
		echo "<td>".$row['username']."</td>";
		echo "<td>";
		echo "<div class='btn-group' role='group'>";
		echo "<button type='button' class='btn btn-secondary' onclick='play(\"".$row['file_name']."\")'>Play</button>";
		echo "</div>";
		echo "</td>";
		echo "</tr>";
	}
?>
