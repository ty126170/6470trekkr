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
    <script src="profile.js"></script>
  </head>

  <body>
        <h1>Trekkr</h1>
	<div id="header">create personalize go see upload share - by mjwang and ty12</div>

	<div id="navigation">
	<?php
	if ($_SESSION['loggedin']) { // IF LOGGED IN
		echo "<strong>Welcome " .$_SESSION['username'] ."!</strong>";
	?>
            <a href="home.php">New Trek</a> | My Treks | <a href="logout.php">Logout</a>
	    </div>
	
	<div id="user_profile">
	<br/>
	<form>
	<input type="file" name="datafile" /></br>
	<input type="image" id="user_pfpic" border="0" src="/demo_profile1.jpg" alt="add profile picture - MAKE THIS A FUNCTION <a>" value="upload" onmouseover="mouseOverImage()" onmouseout="mouseOutImage()" onclick="mouseClicked(this.form,'http://localhost/profile.php','invisible'); return false;" width="150" height="240" >
	<div id="invisible"></div>
	</form>

	</div>

	<div id="album_upload">
	<?php
	$upload_success = false;
	// check if upload attempt
	if (isset($_POST["trekname"]) && isset($_POST["geolocation"]) && isset($_POST["photo"])) {
	require("db.php");
	$user = $_SESSION['username'];
	$trek = sha1(mysql_real_escape_string($_POST["trekname"]));
	$geo = sha1(mysql_real_escape_string($_POST["geolocation"]));
	$photo = sha1(mysql_real_escape_string($_POST["photo"]));
	$query = "INSERT INTO photos VALUES ('$user', '$trek', '$geo', '$photo')";
	mysql_query($query, $db) or die(mysql_error());
	echo "Upload success <br/><br/>";	
	$upload_success = true;
	}
	else {} // no upload event???

	if (!$upload_success) {
	?>

	<div id="photo_upload">
        <form action="<?php $_SERVER["PHP_SELF"]?>" method="post">
            Trek album: <input type="text" name="trekname" id="trekname"><br>
            Geolocation (float,float): <input type="text" name="geolocation" id="geolocation"><br>
            Upload photo: <input type="text" name="photo" id="photo">
	    <input type="submit" name="upload_button" value="upload" class="user" />
        </form>
	</div>

	<?php } ?>

        </div>

<?php
	}
	else { // ELSE: NOT LOGGED IN. auto redirect to login page
		header('location:login.php');
	}
	?>

  </body>
</html>
