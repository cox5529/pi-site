<?php
	include "../../db.php";
	include "../user.php";
	
	if(isset($_POST['id'])) {
		$stmt = $conn->prepare("UPDATE `files` SET `hidden`=1 WHERE `ID`=?");
		$id = $_POST['id'];
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->close();
		$stmt = $conn->prepare("SELECT `file_name` FROM `files` WHERE `ID`=?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$fname = "";
		$stmt->bind_result($fname);
		$stmt->fetch();
		$stmt->close();
		unlink($fname);
	}
	$conn->close();
?>
