<?php
$localhost = 'localhost';
$username = "bday";
$password = "bday";
$dbname = "ChildCareCenter";

// Create connection
$conn = mysqli_connect($localhost, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
