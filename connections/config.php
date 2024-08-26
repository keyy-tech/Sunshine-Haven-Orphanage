<?php

$localhost = "localhost";
$username = "bday";
$password = "bday";
$dbname = "sunshine_haven_orphanage";

$config = mysqli_connect($localhost, $username, $password, $dbname);

if (!$config) {
    die("Connection Error: " . mysqli_connect_error($config));
}
