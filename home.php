<?php
session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>TREKKR</title>
    <link rel="stylesheet" href="main.css" type="text/css">
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true&libraries=places"></script>
    <script src="map.js"></script>
  </head>

  <body>
        <h1>Trekkr</h1>
	<b>create personalize go see upload share - by mjwang and ty12</b>
	
        <div id="navigation">
	<?php
	if ($_SESSION['loggedin']) {
		echo "<strong>Welcome " .$_SESSION['username'] ."!</strong>";
	?>
            New Trek | <a href="mytreks.php">My Treks</a> | <a href="logout.php">Logout</a>
	<?php
	}
	else { 
		echo "<strong>Welcome! You are not logged in: </strong>";
		?>
            New Trek | <a href="login.php">Login</a> | <a href="register.php">Register</a>
	<?php
	}
	?>

        </div>
        <div id="place_search">
                Place: <input type="text" name="place" id="place">
                <input type="button" class="user" onclick="place_submit()" value="Search">      
        </div>
        <div id="map"></div>
        <div id="attractions">
            <h2>Suggested Attractions</h2>
        </div>

	<div id="save_location">
		<input type="button" class="user" onclick="save_lookup()" value="Save Trek">
	</div>

  </body>
</html>
