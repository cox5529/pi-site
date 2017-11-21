<?php
	include "../../db.php";
	include "../user.php";

	$sql = "SELECT * FROM `files` WHERE `user_id`=".$user_id." AND `hidden`=0";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo "<td>".$row['display_name']."</td>";
		echo "<td>";
		echo "<div class='btn-group' role='group'>";
		echo "<button type='button' class='btn btn-secondary' onclick='play(\"".$row['file_name']."\")'>Play</button>";
		echo "<button type='button' class='btn btn-secondary' onclick='remove(\"".$row['ID']."\")'>Delete</button>";
		if($row['public'] == 0) {
			echo "<button type='button' class='btn btn-secondary' onclick='publicize(\"".$row['ID']."\")'>Share</button>";
		} else {
			echo "<button type='button' class='btn btn-secondary' onclick='publicize(\"".$row['ID']."\")'>Unshare</button>";
		}
		echo "</div>";
		echo "</td>";
		echo "</tr>";
	}
?>
