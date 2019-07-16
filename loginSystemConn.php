<?php
//Connection for loginsystem database, and an extra check.
$dbUsername = "root";
$dbPassword = "";
$conn = mysqli_connect("localhost", $dbUsername, $dbPassword,"loginsystem");

if(!$conn){
	die("Connection failed: ".mysqli_connect_error());
}
?>
