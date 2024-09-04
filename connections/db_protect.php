<?php
include 'db_connect.php';
// Start session at the very beginning
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php?redirect=dashboard");
    exit;
}
