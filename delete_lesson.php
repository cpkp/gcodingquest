<?php
// Connect to the database
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
    // Get lesson ID from POST data
    $lesson_id = $_POST["lesson_id"];

    // Delete lesson from database
    $sql = "DELETE FROM lessons WHERE id='$lesson_id'";
    if (mysqli_query($conn, $sql)) {
        echo "Lesson deleted successfully";
    } else {
        echo "Error deleting lesson: " . mysqli_error($conn);
    }
}

// Close database connection
mysqli_close($conn);
?>
