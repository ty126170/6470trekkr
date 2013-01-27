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
	<div id="header">Login to your Trekkr Account here!</div>
	
	<?php
	if ($_SESSION['loggedin']) {
		// auto redirect to home (cannot login as more than one user)
		header('location:home.php');
	}
	else { ?>
        <div id="navigation">
            <a href="home.php">New Trek</a> | Login | <a href="register.php">Register</a>
        </div>

	<?php
	}

	$success = false;
	// check if login attempt
	if (isset($_POST["username"]) && isset($_POST["password"])) {
	require("db.php");	// establish DB connection
	$user = $_POST["username"];
	$pass = sha1($_POST["password"]);
	$query = "SELECT PASSWORD from users WHERE USERNAME='" . mysql_real_escape_string($user) . "'";
	$result = mysql_query($query, $db) or die(mysql_error());
	$row = mysql_fetch_assoc($result);
	if ($pass == $row["PASSWORD"]) {
	$success = true;
	$_SESSION['loggedin']=TRUE;
	$_SESSION['username']=$user;
	header('location:home.php');
	}
	else {
	echo "Invalid username or password <br />";
	}
	}
	// not logged in
	if (!$success) {	// show form
	?>
        <div id="login_box">
            <form action="<?php $_SERVER["PHP_SELF"]?>" method="post">
                Username: <input type="text" name="username" id="username"><br>
                Password: <input type="password" name="password" id="password">
	    <input type="submit" name="login_button" value="login" class="user" /><a href="register.php">Register</a>
            </form>
           
	    <?php }?>
        </div>
    </body>
</html>
