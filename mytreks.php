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
	<img id="user_pfpic" border="0" src="/demo_profile1.jpg" alt="add profile picture - MAKE THIS A FUNCTION <a>" value="upload" onmouseover="mouseOverImage()" onmouseout="mouseOutImage()" width="150" height="240" >

<form action="profile.php" method="post" enctype="multipart/form-data">
<label for="file">New Profile Picture:</label>
<input type="file" name="file" id="file"><br>
<input type="submit" name="submit" value="Upload New Profile Picture">
</form>
<div id="upload_status">Upload Status: 0</div>

<?php
// for the profile picture
if ($_SESSION['uploading_status']!="") {
echo '<script type="text/javascript">

document.getElementById("upload_status").innerHTML="Upload Status: ' .$_SESSION['uploading_status'] .'";';
echo 'document.getElementById("user_pfpic").src="' .$_SESSION['new_pfpic'] .'";';

echo 'window.setTimeout(function(){document.getElementById("upload_status").innerHTML="Upload Status: 0";},7000);';
echo '</script>';

}
$_SESSION['uploading_status']="";


// UPLOAD PHOTOS TO ALBUM
require 'db.php';

$options = '';
$filter=mysql_query("select trekname from attractions");
$counter=0;
while($row = mysql_fetch_array($filter)) {
    $options .="<option value='" .$counter ."'>" . $row['trekname'] . "</option>";
    $counter+=1;
}

$menu='<form action="album.php" method="post" enctype="multipart/form-data">
  <label for="mytreks">My Treks</label>
  <select name="mytreks" id="mytreks">
  	' . $options . '
  </select>
<label for="file2">Upload Photo:</label>
<input type="file" name="file2" id="file2"><br>
<input type="submit" name="submit2" value="Upload Photo to Album">
</form>
<div id="upload_status">Upload Status2: 0</div>';

echo $menu;

// for album uploads
if ($_SESSION['uploading_status2']!="") {
echo '<script type="text/javascript">

document.getElementById("upload_status2").innerHTML="Upload Status2: ' .$_SESSION['uploading_status2'] .'";';

echo 'window.setTimeout(function(){document.getElementById("upload_status2").innerHTML="Upload Status2: 0";},7000);';
echo '</script>';

}
$_SESSION['uploading_status2']="";



	}
	else { // ELSE: NOT LOGGED IN. auto redirect to login page
		header('location:login.php');
	}
	?>

  </body>
</html>
