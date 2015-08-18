<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$mysql_host = "localhost";
$mysql_database = "frosting"; //create the database called "comment_sys"
$mysql_user = "root";
$mysql_password = "";

mysql_connect($mysql_host,$mysql_user,$mysql_password);
mysql_select_db($mysql_database); 
?>