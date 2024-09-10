<?php
session_start();

// Check if the user is logged in as an admin
function checkAdminAccess()
{
    if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
        // Redirect to the admin login page if not logged in
        header("Location: admin_login.php");
        exit();
    }
}
