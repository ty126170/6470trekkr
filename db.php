<?php
session_start();

/*
* In my setup, I have a local MySQL database, with login user:root, password:6470pw
* Database name is trekkrdb, and table name is users
* If these are not your settings or database/table names, then substitute
* the correct names in all the queries (including those in other files)
*/
$db = mysql_connect("localhost", "root", "6470pw") or die(mysql_error());

mysql_select_db("trekkrdb", $db) or die(mysql_error());
mysql_query("CREATE TABLE IF NOT EXISTS users (USERNAME VARCHAR(40) NOT NULL, PASSWORD VARCHAR(40) NOT NULL)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS photos (USERNAME VARCHAR(40) NOT NULL, TREKNAME VARCHAR(80) NOT NULL, GEOLOCATION DECIMAL(2,0) NOT NULL, PHOTO VARCHAR(80) NOT NULL)") or die(mysql_error());
?>
