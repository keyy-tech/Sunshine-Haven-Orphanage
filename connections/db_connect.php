<?php
$localhost = 'localhost';
$username = "bday";
$password = "bday";
$dbname = "ChildCareCenter";

// Create connection
$db_connect = mysqli_connect($localhost, $username, $password, $dbname);

// Check connection
if (!$db_connect) {
    die("Connection failed: " . mysqli_connect_error());
}
