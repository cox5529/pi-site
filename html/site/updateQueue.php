<?php
	include "../../db.php";
	include "../user.php";
	
	$sql = "SELECT `queue`.`ID` AS `queue_id`, `users`.`ID` AS `user_id`, `users`.`username` AS `uname`, `files`.`display_name` AS `song_name` FROM `queue` INNER JOIN `users` ON `queue`.`user_id`=`users`.`ID` INNER JOIN `files` ON `files`.`file_name`=`queue`.`filename` ORDER BY `queue`.`ID`";
	$result = $conn->query($sql);
	
	while($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo "<td>".$row['song_name']."</td>";
		echo "<td>".$row['uname']."</td>";
		if($user_id == $row['user_id'] or $is_admin) {
			echo "<td><button class='btn btn-secondary' onclick='dequeue(".$row['queue_id'].");' >Remove</button></td>";
		}
		echo "</tr>";
	}
	$conn->close();
?>
