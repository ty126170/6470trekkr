<?php
session_start();

$_SESSION['uploading_status']="";

$allowedExts = array("jpg", "jpeg", "gif", "png");
$extension = end(explode(".", $_FILES["file"]["name"]));

if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/png")
|| ($_FILES["file"]["type"] == "image/pjpeg"))
&& ($_FILES["file"]["size"] < 1048576)
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    $_SESSION['uploading_status']="File Error Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      $_SESSION['uploading_status']=$_FILES["file"]["name"] . " already exists";
      }
    else
      {
	if (!file_exists("upload/" .$_SESSION['username'])) {
	   echo mkdir("upload/" .$_SESSION['username']); // make for each user a directory
	}

	// move uploaded photo from temp folder to ./upload/*user*/
	if (move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" .$_SESSION['username'] ."/" .$_FILES["file"]["name"])) {
	$_SESSION['uploading_status']=$_FILES["file"]["name"] ." successfully uploaded";
	
	// new profile pic location
	$_SESSION['new_pfpic']="http://localhost/upload/" .$_SESSION['username'] ."/" .$_FILES["file"]["name"];
	}

      }
    }
  }
else
  {
  	$_SESSION['uploading_status']=$_FILES["file"]["name"] ." is an invalid file; only gif, jpeg, png, and pjpeg allowed";
  }

	header('location:mytreks.php');
?> 
