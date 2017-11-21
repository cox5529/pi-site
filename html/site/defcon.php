<?php
	include "../../db.php";
	include "../user.php";
	
	$warn1 = "";
	$warn2 = "";
	
	if(isset($_POST['location']) and isset($_POST['state'])) {
		$stmt = $conn->prepare("INSERT INTO `defcon` (`type`, `location`, `user_id`) VALUES (?, ?, ?)");
		$stmt->bind_param("isi", $_POST['state'], $_POST['location'], $user_id);
		$stmt->execute();
		$stmt->close();
		$warn1 = "DEFCON status pushed successfully.";
	} else if(isset($_POST['phone-submit'])) {
		if($_POST['phone-submit'] == "Set address" and isset($_POST['phone'])) {
			$stmt = $conn->prepare("UPDATE `users` SET `phone`=? WHERE `ID`=?");
			$stmt->bind_param("si", $_POST['phone'], $user_id);
			$stmt->execute();
			$stmt->close();
			$warn2 = "Address set successfully.";
		} else if($_POST['phone-submit'] == "Clear address") {
			$sql = "UPDATE `users` SET `phone`=NULL WHERE `ID`=$user_id";
			$conn->query($sql);
			$warn2 = "Address cleared.";
		} else {
			$warn2 = "You must enter an address or select 'Clear Address'.";
		}
	}
	
?>
<html lang="en">
	<head>
		<title>DEFCON Alert</title>
		<meta charset="utf-8">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	</head>
	<body>
		<?php
			include "navbar.php";
		?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-6 col-sm-12">
					<div class="card mt-3">
						<div class="card-block">
							<h3 class="card-title">Send a DEFCON alert</h3>
							<form method="post">
							<div class="form-group">
								<label for="state">DEFCON state</label>
								<select name='state' class='form-control' id='state'>
									<option>5</option>
									<option>4</option>
									<option>3</option>
									<option>2</option>
									<option>1</option>
								</select>
							</div>
							<div class="form-group">
								<label for="name">Location</label>
								<input id="name" class="form-control" type="text" name="location" required autocomplete="off" placeholder="Location" />
							</div>
							<input type="submit" class="btn btn-primary" />
						</form>
						<p><?php echo $warn1; ?></p>
						</div>
					</div>
					<div class="card mt-3">
						<div class="card-block">
							<h3 class="card-title">Number meanings</h3>
							<div class="table-responsive">
								<table class="table table-hover">
									<thead class='thead-inverse'>
										<th>State</th>
										<th>Meaning</th>
									</thead>
									<tbody>
										<tr>
											<td>5</td>
											<td>No Carson present</td>
										</tr>
										<tr>
											<td>4</td>
											<td>Carson spotted, but Carson has not noticed you</td>
										</tr>
										<tr>
											<td>3</td>
											<td>Carson has noticed you</td>
										</tr>
										<tr>
											<td>2</td>
											<td>Carson has started talking to you but is not following you</td>
										</tr>
										<tr>
											<td>1</td>
											<td>Carson is following and talking to you</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-sm-12">
					<div class="card mt-3">
						<div class="card-block">
							<h3 class="card-title">Set your alert address</h3>
							<p>Note that your alert address must be an email address, but you can enter your phone number as an email address. See the 'Entering a phone number' table for more information.</p>
							<form method="post">
								<div class="form-group">
									<label for="address">Alert address</label>
									<input id="phone" class="form-control" type="text" name="phone" autocomplete="off" placeholder="Location" />
								</div>
								<input type="submit" value='Set address' name='phone-submit' class="btn btn-primary" />
								<input type="submit" value='Clear address' name='phone-submit' class="btn btn-primary" />
							</form>
							<p><?php echo $warn2; ?></p>
						</div>
					</div>
					<div class="card mt-3">
						<div class="card-block">
							<h3 class="card-title">Entering a phone number</h3>
							<p>Replace '5011234567' with your phone number. Pick which one to use based on your carrier. Google 'how to send sms to phone number with x carrier' if your carrier is not listed. If you give an MMS address, then the texts will all appear to be from the same address.</p>
							<div class="table-responsive">
								<table class="table table-hover">
									<thead class='thead-inverse'>
										<th>Carrier</th>
										<th>Format</th>
									</thead>
									<tbody>
										<tr>
											<td>AT&amp;T</td>
											<td>5011234567@mms.att.net</td>
										</tr>
										<tr>
											<td>Boost Mobile</td>
											<td>5011234567@myboostmobile.com</td>
										</tr>
										<tr>
											<td>Cricket</td>
											<td>5011234567@mms.mycricket.com</td>
										</tr>
										<tr>
											<td>Metro PCS</td>
											<td>5011234567@mymetropcs.com</td>
										</tr>
										<tr>
											<td>Sprint</td>
											<td>5011234567@pm.sprint.com</td>
										</tr>
										<tr>
											<td>Straight Talk</td>
											<td>5011234567@mypixmessages.com</td>
										</tr>
										<tr>
											<td>T-Mobile</td>
											<td>5011234567@tmomail.net</td>
										</tr>
										<tr>
											<td>US Cellular</td>
											<td>5011234567@mms.uscc.net</td>
										</tr>
										<tr>
											<td>Verizon</td>
											<td>5011234567@vzwpix.com</td>
										</tr>
										<tr>
											<td>Virgin Mobile</td>
											<td>5011234567@vmpix.com</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	</body>
</html>
