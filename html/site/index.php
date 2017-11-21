<!DOCTYPE html>
<?php
	include "../../db.php";
	include "../user.php";
?>
<html lang="en">
	<head>
		<title>Play</title>
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
					<div class="card mb-3 mt-3">
						<div class="card-block">
							<h3 class="card-title">Your Files</h3>
							<div class="table-responsive">
								<table class="table table-hover">
									<thead class="thead-inverse">
										<tr>
											<th>Filename</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody id='personal-file-list'></tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="card mb-3">
						<div class="card-block">
							<h3 class="card-title">Public Files</h3>
							<div class="table-responsive">
								<table class="table table-hover">
									<thead class="thead-inverse">
										<tr>
											<th>Filename</th>
											<th>Owner</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody id='public-file-list'></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-sm-12">
					<div class="card mb-3 mt-3">
						<div class="card-block">
							<h3 class="card-title">Now Playing</h3>
							<div class="table-responsive">
								<table class="table table-hover">
									<thead class="thead-inverse">
										<tr>
											<th>Song Name</th>
											<th>User</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody id='now-playing'></tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-block">
						<h3 class="card-title">Playback Queue</h3>
							<div class="table-responsive">
								<table class="table table-hover">
									<thead class="thead-inverse">
										<tr>
											<th>Song Name</th>
											<th>User</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody id="queue"></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			
			$(document).ready(function() {
				setInterval(updateData, 1000);
				updateData();
			});
			
			function updateData() {
				$.ajax({
					type: "POST",
					url: "updateQueue.php",
					success: function(data) {
						$("#queue").html(data);
					}
				});
				$.ajax({
					type: "POST",
					url: "updateFiles.php",
					success: function(data) {
						$("#personal-file-list").html(data);
					}
				});
				$.ajax({
					type: "POST",
					url: "updatePublic.php",
					success: function(data) {
						$("#public-file-list").html(data);
					}
				});
				$.ajax({
					type: "POST",
					url: "updatePlaying.php",
					success: function(data) {
						$("#now-playing").html(data);
					}
				});
			}
			
			function play(file) {
				$.ajax({
					type: "POST",
					data: {filename: file},
					url: "play.php",
					success: function(data) {
						$("#status").html(data);
						updateData();
					}
				});
			}
			
			function remove(id) {
				$.ajax({
					type: "POST",
					data: {id: id},
					url: "remove.php",
					success: function(data) {
						updateData();
					}
				});
			}
			
			function publicize(id) {
				$.ajax({
					type: "POST",
					data: {id: id},
					url: "publicize.php",
					success: function(data) {
						updateData();
					}
				});
			}
			
			function dequeue(id) {
				$.ajax({
					type: "POST",
					data: {id: id},
					url: "dequeue.php",
					success: function(data) {
						updateData();
					}
				});
			}
			
			function stop() {
				$.ajax({
					type: "POST",
					url: "stop.php",
					success: function(data) {
						updateData();
					}
				});
			}
		</script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	</body>
</html>
