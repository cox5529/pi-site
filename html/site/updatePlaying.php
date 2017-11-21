<?php
	include "../../db.php";
	include "../user.php";
	
	$sql = "SELECT `users`.`username` AS `uname`, `files`.`display_name` AS `song_name`, `users`.`ID` AS `user_id` FROM `playing` INNER JOIN `users` ON `playing`.`user_id`=`users`.`ID` INNER JOIN `files` ON `files`.`file_name`=`playing`.`filename` ORDER BY `playing`.`ID`";
	$result = $conn->query($sql);
	
	while($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo "<td>".$row['song_name']."</td>";
		echo "<td>".$row['uname']."</td>";
		if($row['user_id'] == $user_id or $is_admin == 1) {
			echo "<td><button class='btn btn-secondary' onclick='stop()'>Stop</button></td>";
		}
		echo "</tr>";
	}
	$conn->close();
?>
