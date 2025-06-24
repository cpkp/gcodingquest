<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['parent_username'])) {
    // Redirect to the login page
    header("Location: ../index.php");
    exit;
}

// If user is logged in, continue to the main page
?>
