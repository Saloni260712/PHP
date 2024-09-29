<?php
session_start(); // Start the session

// Clear session data
session_destroy();

// Clear cookies if any set for "Remember Me"
if (isset($_COOKIE['remember_me'])) {
    setcookie('remember_me', '', time() - 3600, '/'); // Clear the cookie
}

// Redirect to login page
header("Location: login.html");
exit();
?>
