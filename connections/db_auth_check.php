<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $_SESSION['loggedin'] = false;
} else {
    // Check if the user's session has expired
    if (isset($_SESSION['expires']) && $_SESSION['expires'] < time()) {
        $_SESSION['loggedin'] = false;
    }
}

// Function to login the user
function login($username, $password)
{
    // Connect to the database
    $conn = mysqli_connect("localhost", "username", "password", "database");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Query to check if the user exists
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    // Check if the user exists
    if (mysqli_num_rows($result) > 0) {
        // Login the user
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['expires'] = time() + 3600; // Expire the session in 1 hour
        return true;
    } else {
        return false;
    }
}

// Function to logout the user
function logout()
{
    $_SESSION['loggedin'] = false;
    unset($_SESSION['username']);
    unset($_SESSION['expires']);
    session_destroy();
}
