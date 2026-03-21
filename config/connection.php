<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "movielist";

//create connection and test connection first
$connection = new mysqli($servername, $username, $password, $dbname);
if (!$connection) {
die("Connection Failed: " . mysqli_connect_error());
}
?>