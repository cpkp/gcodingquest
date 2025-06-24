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

// Fetch courses data from database
$sql = "SELECT * FROM courses";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Generate course cards
    while($row = mysqli_fetch_assoc($result)) {
        echo '<div class="course-card" style="background-image: url(\''.$row['thumbnail'].'\');">';
        echo '<h2>'.$row['name'].'</h2>';
        echo '<p>'.$row['description'].'</p>';

        // Add buttons for view and delete
        echo '<div class="button-container">';
        echo '<a href="view_lessons.php?course_id='.$row['id'].'" target="_blank" class="view-button">View Lessons</a>'; // Link to view lessons in a new window
        echo '<form action="delete_course.php" method="post">';
        echo '<input type="hidden" name="course_id" value="'.$row['id'].'">';
        echo '<input type="submit" value="Delete" class="delete-button">';
        echo '</form>';
        echo '</div>'; // Close button-container

        echo '</div>'; // Close course-card
    }
} else {
    echo "No courses found.";
}

// Close database connection
mysqli_close($conn);
?>

