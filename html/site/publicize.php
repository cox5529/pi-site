<?php
	include "../../db.php";
	include "../user.php";
	
	if(isset($_POST['id'])) {
		$stmt = $conn->prepare("UPDATE `files` SET `public`=IF(`public`=1,0,1) WHERE `ID`=?");
		$id = $_POST['id'];
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->close();
	}
	$conn->close();
?>
