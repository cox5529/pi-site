<!DOCTYPE html>
<?php
	include "../../../db.php";
	include "../../user.php";
	include "catan_funcs.php";
?>
<html lang="en">
	<head>
		<title>The Holy Trinity of Catan</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	</head>
	<body>
		<?php
			include "../navbar.php";
		?>
		<div class="container-fluid">
			<h1>Praise be unto the Gods of Catan!</h1>
			<hr />
			<div class="row">
				<?php
					$sql = "SELECT * FROM `catan_gods`";
					$result = $conn->query($sql);
					if($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							echo "<div class='col-lg-4 col-sm-12'>";
								echo "<div class='card mb-3 mt-3'>";
									echo "<h3 class='card-header'>".$row['name']."</h3>";
									if(is_angry($row['ID'], $conn, $user_id)) {
										echo "<img class='card-img-top' src='".$row['image_angry']."' />";
									} else {
										echo "<img class='card-img-top' src='".$row['image_normal']."' />";
									}
									echo "<div class='card-block'>";
										echo "<h4 class='card-title'>God of ".$row['god_of']."</h4>";
										echo "<p class='card-text'>".$row['description']."</p>";
										echo "<a href='blessing.php?god_id=".$row['ID']."' class='btn btn-primary'>Request Blessing</a> ";
										echo "<a href='consult.php?god_id=".$row['ID']."' class='btn btn-primary'>Consult</a>";
									echo "</div>";
								echo "</div>";
							echo "</div>";
						}		
					}
				?>
			</div>
		</div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	</body>
</html>
