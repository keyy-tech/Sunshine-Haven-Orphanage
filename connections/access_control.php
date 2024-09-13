<?php
session_start();


if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    // Redirect to the admin login page if not logged in
    header("Location: ../admin_login.php");
    exit();
}
