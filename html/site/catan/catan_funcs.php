<?php

	function is_angry($god_id, $conn, $user_id) {
		$sql = "SELECT g.`name` FROM `users_x_gods` s 
					JOIN `catan_disliked_gods` t 
						ON t.`disliked_god_id`=s.`god_id` 
					JOIN `catan_gods` g
						ON g.`ID`=t.`god_id`
					WHERE s.`user_id`=$user_id
						AND t.`god_id`=$god_id
						AND CURRENT_TIMESTAMP - s.`last_interaction` < 60 * g.`anger_timer`";
		$result = $conn->query($sql);
		if($result->num_rows > 0) {
			return true;
		}
		return false;
	}
	
	function is_busy($god_id, $conn, $user_id) {
		$sql = "SELECT g.`name`,
					g.`reload_timer`,
					g.`busy_text`,
					u.`username`,
					s.`last_interaction`
				FROM `users_x_gods` s
				JOIN `catan_gods` g
					ON g.`ID`=s.`god_id`
				JOIN `users` u
					ON s.`user_id`=u.`ID`
				WHERE CURRENT_TIMESTAMP - s.`last_interaction` < g.`reload_timer`
					AND g.`ID`=$god_id";
		$result = $conn->query($sql);
		if($result->num_rows > 0) {
			return true;
		}
		return false;
	}
	
	function set_busy($god_id, $conn, $user_id) {
		$sql = "SELECT * FROM `users_x_gods` WHERE `user_id`=$user_id AND `god_id`=$god_id";
		$result = $conn->query($sql);
		if($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$sql = "UPDATE `users_x_gods` SET `last_interaction`=CURRENT_TIMESTAMP WHERE `ID`=".$row['ID'];
			$conn->query($sql);
		} else {
			$sql = "INSERT INTO `users_x_gods` (`god_id`, `user_id`, `last_interaction`) VALUES ($god_id, $user_id, CURRENT_TIMESTAMP)";
			$conn->query($sql);
		}
	}

?>
