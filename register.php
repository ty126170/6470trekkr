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
	<b>register a new trekkr account to save treks and share photos!</b>
	
	<?php
	if ($_SESSION['loggedin']) {
		// auto redirect to home (cannot register when logged in)
		header('location:home.php');
	}
	else { ?>
        <div id="navigation">
            <a href="home.php">New Trek</a> | <a href="login.php">Login</a> | Register
        </div>

	<?php
	}

	$success = false;
	// Registration attempt
	if (isset($_POST["username"]) && isset($_POST["password"])) {
	require("db.php");
	$user = mysql_real_escape_string($_POST["username"]);
	$query = "SELECT COUNT(*) FROM users WHERE USERNAME='$user'";
	$result = mysql_query($query, $db);
	$row = mysql_fetch_array($result);
	if ($row["COUNT(*)"] != 0) {
	echo "The user already exists!<br />";
	}
	else {
	$pass = sha1(mysql_real_escape_string($_POST["password"]));
	$query = "INSERT INTO users VALUES ('$user', '$pass')";
	mysql_query($query, $db) or die(mysql_error());
	echo "Success! New Trekkr account created for $user<br/><br/>";	
	$success = true;
	}

	?>
	<a href="login.php">Click here to login</a>
	<?php
	}
	if (!$success) {
	?>

	<div id="register_box">
	<br/>
	<br/>
	<form action="<?php $_SERVER["PHP_SELF"]?>" method="post">
		Username: <input type="text" name="username" /><br/>
		Password: <input type="password" name="password" /><br/>
	<input type="submit" name="register_button" value="register" class="user" />
	</form>

	<?php } ?>
	</div>
    </body>
</html>
