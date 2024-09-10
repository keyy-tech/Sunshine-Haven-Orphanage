<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['staff_logged_in']) || !$_SESSION['staff_logged_in']) {
    header("Location: ../login.php"); // Redirect to login page
    exit();
}
