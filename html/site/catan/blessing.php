<!DOCTYPE html>
<?php
	include "../../../db.php";
	include "../../user.php";
	include "catan_funcs.php";
	
	$god_id = 0;
	$angry = false;
	$busy = false;
	$name = "";
	$image_normal = "";
	$image_angry = "";
	$god_of = "";
	$angry_text = "";
	$busy_text = "";
	
	if(isset($_GET['god_id'])) {
		$god_id = $_GET['god_id'];
		$stmt = $conn->prepare("SELECT `name`, `image_normal`, `image_angry`, `god_of`, `angry_text`, `busy_text` FROM `catan_gods` WHERE `ID`=?");
		$stmt->bind_param("i", $god_id);
		$stmt->execute();
		$stmt->bind_result($name, $image_normal, $image_angry, $god_of, $angry_text, $busy_text);
		if(!$stmt->fetch()) {
			$stmt->close();
			header("Location: catan.php");
		} else {
			$stmt->close();
			$angry = is_angry($god_id, $conn, $user_id);
			$busy = is_busy($god_id, $conn, $user_id);
			if(!$busy) {
				set_busy($god_id, $conn, $user_id);
			}
		}
	} else {
		header("Location: catan.php");
	}
	
	
?>
<html lang="en">
	<head>
		<title>Request <?php echo $name; ?>'s Blessing</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="catan_scripts.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	</head>
	<body>
		<div class="container-fluid mt-3">
			<h1 class="card-title">Request <?php echo $name; ?>'s Blessing</h1>
			<div class="row">
				<div class="col-lg-5 col-sm-12">
					<div class="card">
						<?php
							if($angry) {
								echo "<img class='card-img-top' src='$image_angry' />";
							} else {
								echo "<img class='card-img-top' src='$image_normal' />";
							}
						?>
						<div class="card-block">
							<p id='msg' class="card-text"></p>
							<div id='responses' />
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	</body>
</html>

<script>
	
	var god = {
		<?php
			echo "name: \"$name\",
		angry: ";
			if($angry) echo "true,\n";
			else echo "false,\n";
			echo "\t\tbusy: ";
			if($busy) echo "true,\n";
			else echo "false,\n";
			echo "\t\tgod_of: \"$god_of\",
		angry_text: \"$angry_text\",
		busy_text: \"$busy_text\",
		user_name: \"$uname\",
		busy_with: ";
			
			if($busy) {
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
				$row = $result->fetch_assoc();
				echo "\"".$row['username']."\",\n";
			} else {
				echo "\"\",\n";
			}
			echo "\t\tangry_responses: [\n";
			$sql = "SELECT * FROM `catan_responses` WHERE `consult_id`=-1 AND `god_id`=$god_id AND `is_angry`=1";
			$result = $conn->query($sql);
			if($result->num_rows > 0) {
				$i = 0;
				while($resp = $result->fetch_assoc()) {
					if($i!=0) echo ", \n";
					$i += 1;
					echo "\t\t\t{\n\t\t\t\ttext: \"".$resp['text']."\",\n";
					echo "\t\t\t\tweight: ".$resp['weight']."\n\t\t\t}";
				}
			}
			echo "\n\t\t],\n";
			echo "\t\tnormal_responses: [\n";
			$sql = "SELECT * FROM `catan_responses` WHERE `consult_id`=-1 AND `god_id`=$god_id AND `is_angry`=0";
			$result = $conn->query($sql);
			if($result->num_rows > 0) {
				$i = 0;
				while($resp = $result->fetch_assoc()) {
					if($i!=0) echo ", \n";
					$i += 1;
					echo "\t\t\t{\n\t\t\t\ttext: \"".$resp['text']."\",\n";
					echo "\t\t\t\tweight: ".$resp['weight']."\n\t\t\t}";
				}
			}
			echo "\n\t\t]\n";
		?>
	};
	
	function fill_options(options) {
		$("#responses").empty();
		options.forEach(function(elem, i, arr) {
			$("#responses").append("<button id='opt" + i + "' type='button' onclick='clicked(" + i + ");' class='btn btn-primary'>" + elem.text + "</button><br /><br />");
		});
	}
	
	$(document).ready(function() {
		if(god.busy) {
			$("#msg").html(replace_keys(god.busy_text, god.busy_with));
			$("#responses").append("<a href='/site/catan/catan.php' class='btn btn-primary'>I will return</a>");
		} else {
			var list;
			if(god.angry) {
				list = god.angry_responses;
				$("#responses").append("<a href='/site/catan/catan.php' class='btn btn-primary'>I see the error in my ways</a>");
			} else {
				list = god.normal_responses;
				$("#responses").append("<a href='/site/catan/catan.php' class='btn btn-primary'>Thank you for your guidance</a>");
			}
			var total = 1;
			var r = Math.random();
			for(var i = 0; i < list.length; i++) {
				total -= list[i].weight;
				if(r > total) {
					$("#msg").html(replace_keys(list[i].text));
					break;
				}
			}
			
		}
	});
</script>
