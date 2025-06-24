<?php
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your actual MySQL password
$dbname = "messaging_system"; // Update with your database name (replace "")

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST["course_id"];

    // Delete course from database
    $sql = "DELETE FROM courses WHERE id=$course_id";
    if (mysqli_query($conn, $sql)) {
        echo "Course deleted successfully";
    } else {
        echo "Delete its lessons first ";
    }
}

// Close database connection
mysqli_close($conn);
?>
