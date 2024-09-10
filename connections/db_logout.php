<?php
// logout_handler.php

function logout()
{
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    exit();
}

// Check if logout is requested
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    logout();
}
