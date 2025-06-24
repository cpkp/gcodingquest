<?php
// update_action.php

// Database connection
$conn = mysqli_connect("localhost", "root", "", "messaging_system");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if teacher_id and action parameters are set
if (isset($_GET['teacher_id']) && isset($_GET['action'])) {
    $teacherId = $_GET['teacher_id'];
    $action = $_GET['action'];

    // Update the action in the database
    $sql = "UPDATE teacher SET action = '$action' WHERE teacher_id = '$teacherId'";
    if (mysqli_query($conn, $sql)) {
        echo 'success';
    } else {
        echo 'error';
    }
}

// Close database connection
mysqli_close($conn);
?>
