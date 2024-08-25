<?php

$localhost = "localhost";
$username = "keyy_tech";
$password = "";
$dbname = "sunshine_shelter";

$config = mysqli_connect($localhost, $username, $password, $dbname);

if (!$config) {
    die("Connection Error: " . mysqli_connect_error($config));
}
