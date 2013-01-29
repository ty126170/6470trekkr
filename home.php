<?php
session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>TREKKR</title>
    <link rel="stylesheet" href="main.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="print.css" type="text/css" media="print"/>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/jquery-ui.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true&libraries=places"></script>
    <script src="map.js"></script>
  </head>

  <body>
        <h1>Trekkr</h1>
	    <div id="header">Plan, Upload, Share Your Own Walking Tour</div>
	
        <div id="navigation">
        	<?php
        	if ($_SESSION['loggedin']) {
        		echo "<strong>Welcome " .$_SESSION['username'] ."!</strong>";
        	?>
                    New Trek | <a href="mytreks.php">My Treks</a> | <a href="logout.php">Logout</a>
        	<?php
        	}
        	else { 
        		echo "<strong>Welcome! You are not logged in! </strong>";
        		?>
                  <br>  New Trek | <a href="login.php">Login</a> | <a href="register.php">Register</a>
        	<?php
        	}
        	?>

        </div>
        <div id="place_search">
                Place: <input type="text" name="place" id="place">
                <input type="button" class="user" onclick="place_submit()" value="Search">      
        </div>
        
        <div id="map"></div>
        <div id="trip_box">
            <h2>Your Trek Stops</h2>
            <div id="trip" class="sortableList">
            </div>
        </div>
        <div id="attraction_box">
            <h2>Other Local Attractions</h2>
            <div id="attractions" class="sortableList">
            </div>
        </div>


	    <div id="save_location">
            <br> <input type="button" class="user" onclick="window.print()" value="Print Directions">
		    <input type="button" class="user" onclick="save_lookup()" value="Save Trek">
	    </div>
    
        <div id="direction_box">
            <h2>Trek Directions</h2>
        </div>

  </body>

</html>
