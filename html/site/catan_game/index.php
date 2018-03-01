<?php
	include "../../../db.php";
	include "../../user.php";
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
            integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"
            integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
            crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Test Client</title>
</head>
<body>
<div class="container-fluid">
    <div class='row'>
        <div class='col-xl-3 col-sm-12'>
            <div class='card'>
                <div id='player-0' class='card-body'>
                </div>
            </div>
        </div>
        <div class='col-xl-3 col-sm-12 offset-xl-6'>
            <div class='card'>
                <div id='player-1' class='card-body'>
                </div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-xl-3 col-sm-12'>
            <h3>Console</h3>
            <div class="first-row" id='console'></div>
        </div>
        <div class='col-xl-6 col-sm-12 text-center'>
            <canvas id='board' onclick='receiveInput(event);' width="570" height="580" style='border: 1px solid black;'>
            </canvas>
        </div>
        <div class='col-xl-3 col-sm-12'>
            <h3>Actions</h3>
            <form id="form">
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th>Game name</th>
                        <th>Participants</th>
                        <th>Winner</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody id="game-list">

                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <div class='row align-items-end'>
        <div class='col-xl-3 col-sm-12'>
            <div class='card'>
                <div id='player-3' class='card-body'>
                </div>
            </div>
        </div>
        <div class='col-xl-6 col-sm-12'>
            <table class='table'>
                <tbody>
                <tr>
                    <td><img src='/images/wood.png' class='resource-icon'/> <span id='wood-amt'>0</span></td>
                    <td><img src='/images/sheep.png' class='resource-icon'/> <span id='sheep-amt'>0</span></td>
                    <td><img src='/images/wheat.png' class='resource-icon'/> <span id='wheat-amt'>0</span></td>
                    <td><img src='/images/stone.png' class='resource-icon'/> <span id='stone-amt'>0</span></td>
                    <td><img src='/images/brick.png' class='resource-icon'/> <span id='brick-amt'>0</span></td>
                </tr>
                <tr>
                    <td>Monopolies: <span id='monopoly-amt'>0</span></td>
                    <td>Years of plenty: <span id='yop-amt'>0</span></td>
                    <td>Road buildings: <span id='rb-amt'>0</span></td>
                    <td>Knights: <span id='knight-amt'>0</span></td>
                    <td>Victory points: <span id='vp-amt'>0</span></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class='col-xl-3 col-sm-12'>
            <div class='card'>
                <div id='player-2' class='card-body'>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script>
	var username = "<?php echo $uname; ?>";
	var address = "ws://<?php echo $_SERVER['SERVER_ADDR']; ?>:1185";
	var imageDirectory = "/images/";
</script>
<script src="constantsCatan.js"></script>
<script src="catan.js"></script>
<script src="drawCatan.js"></script>