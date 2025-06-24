<?php
include 'check_login.php';
?>
<!-- to remove warnings      godddddddddodododoodododogood-->
<?php
// Suppress warnings and notices
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);

// Your PHP code here
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course list</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your CSS file -->
</head>
<body>
    <!-- Your PHP code goes here --><?php
session_start();

// Start session to access session variables

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



// Fetch courses data from database
$sql = "SELECT * FROM courses";
$result = mysqli_query($conn, $sql);

// Check if any courses exist
if (mysqli_num_rows($result) > 0) {
    // Loop through each course
    while ($course = mysqli_fetch_assoc($result)) {
        echo '<h2>' . $course['name'] . '</h2>'; // Display course name

        // Fetch lessons data for the current course
        $course_id = $course['id'];
        $sql_lessons = "SELECT * FROM lessons WHERE course_id = $course_id";
        $result_lessons = mysqli_query($conn, $sql_lessons);

        // Check if any lessons exist for the current course
        if (mysqli_num_rows($result_lessons) > 0) {
            // Generate lesson cards for the current course
            echo '<div class="course-lessons">';
            while ($lesson = mysqli_fetch_assoc($result_lessons)) {
                echo '<div class="lesson-card" style="background-image: url(\'../lessons/thumbimg/' . $lesson['thumbnail'] . '\');">';
                echo '<h3>' . $lesson['lesson_name'] . '</h3>';
                echo '<p>' . $lesson['description'] . '</p>';
                echo '<h4>Created by: ' . $lesson['creator_name'] . '</h4>'; // Display creator name

                // Add view option
                echo '<div class="button-container">';
                // Construct view URL with session variables
                $lesson_folder = '../' . $lesson['lesson_folder'];
                if (is_dir($lesson_folder)) {
                    $contents = array_diff(scandir($lesson_folder), array('.', '..'));
                    $files = array_filter($contents, function ($item) use ($lesson_folder) {
                        return is_file($lesson_folder . '/' . $item);
                    });
                    $subfolders = array_filter($contents, function ($item) use ($lesson_folder) {
                        return is_dir($lesson_folder . '/' . $item);
                    });
                    if (count($files) == 1 && empty($subfolders)) {
                        $file = reset($files);

         
                        $view_url = 'updatelesspath.php?lesson_id=' . $lesson['id'] . '&course_id=' . $course_id . '&lesson_folder=' . urlencode($lesson_folder) . '&file=' . urlencode($file);

                    
                        // Add parameters to the view link
                        echo '<a href="' . $view_url . '" class="view-button">View</a>';

                       
                    } elseif (!empty($subfolders)) {
                        $subfolder = reset($subfolders);
                        // Construct view URL with session variables
                     
                     
                        $view_url = 'updatelesspath.php?lesson_id=' . $lesson['id'] . '&course_id=' . $course_id . '&lesson_folder=' . urlencode($lesson_folder) . '&subfolder=' . urlencode($subfolder) ;

                        
                        // Add parameters to the view link
                        echo '<a href="' . $view_url . '" class="view-button">View</a>';

                       
                    } else {
                        echo 'No suitable file found for viewing';
                    }
                } else {
                    echo 'Lesson folder not found';
                }
                echo '</div>'; // Close button-container

                echo '</div>'; // Close lesson-card
            }
            echo '</div>'; // Close course-lessons
        } else {
            // No lessons found for the current course
            echo "<p>No lessons found for this course.</p>";
        }
    }
} else {
    // No courses found
    echo "<p>No courses found.</p>";
}

// Close database connection
mysqli_close($conn);
?>


</body>
</html>
