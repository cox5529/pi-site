<?php
	include "../../db.php";
	include "../user.php";
	
	if(isset($_POST['id'])) {
		$sql = "DELETE FROM `queue` WHERE `ID`=?";
		if(!$is_admin) {
			$sql = $sql." AND `user_id`=".$user_id;
		}
		$stmt = $conn->prepare($sql);
		$id = $_POST['id'];
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->close();
	}
	$conn->close();
?>
