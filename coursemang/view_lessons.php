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

// Fetch course ID from the URL parameter
if(isset($_GET['course_id']) && !empty($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
    
    // Fetch lessons data associated with the given course ID
    $sql = "SELECT lessons.*, courses.name AS course_name FROM lessons INNER JOIN courses ON lessons.course_id = courses.id WHERE lessons.course_id = $course_id";
    $result = mysqli_query($conn, $sql);

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Course Lessons</title>
        <link rel="stylesheet" href="styles.css"> <!-- Include your CSS file -->
    </head>
    <body>
          <h1>Course Lessons</h1>
    <?php

    if (mysqli_num_rows($result) > 0) {
        // Generate lesson cards
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="lesson-card" style="background-image: url(\'../lessons/thumbimg/' . $row['thumbnail'] . '\');">';
            echo '<h3>' . $row['lesson_name'] . '</h3>';
            echo '<h4>Course: ' . $row['course_name'] . '</h4>'; // Display course name
            echo '<p>' . $row['description'] . '</p>';

            echo '<h4>Created by: ' . $row['creator_name'] . '<h4>'; // Display creator name
            // Add view and delete options
            echo '<div class="button-container">';
            
            // Check if the lesson folder exists and is a directory
           // Adjust lesson folder path to check one level above the current directory
            $lesson_folder = '../' . $row['lesson_folder'];
            if (is_dir($lesson_folder)) {
                // Get the list of files and directories in the lesson folder
                $contents = array_diff(scandir($lesson_folder), array('.', '..'));
                // Filter out directories from the contents
                $files = array_filter($contents, function($item) use ($lesson_folder) {
                    return is_file($lesson_folder . '/' . $item);
                });
                // Filter out subfolders from the contents
                $subfolders = array_filter($contents, function($item) use ($lesson_folder) {
                    return is_dir($lesson_folder . '/' . $item);
                });
                // If there's only one file, open it directly
                if (count($files) == 1 && empty($subfolders)) {
                    $file = reset($files);
                    echo '<a href="' . $lesson_folder . '/' . $file . '" class="view-button">View</a>';
                } elseif (!empty($subfolders)) {
                    // If there's a subfolder, open it
                    $subfolder = reset($subfolders);
                    echo '<a href="' . $lesson_folder . '/' . $subfolder . '" class="view-button">View</a>';
                } else {
                    // If there are multiple files or no files, provide an error message
                    echo 'No suitable file found for viewing';
                }
            } else {
                // If the lesson folder doesn't exist or is not a directory, provide an error message
                echo 'Lesson folder not found';
            }
            
            echo '<form action="delete_lesson.php" method="post">';
            echo '<input type="hidden" name="lesson_id" value="' . $row['id'] . '">';
            echo '<input type="submit" value="Delete" class="delete-button">';
            echo '</form>';
            echo '</div>'; // Close button-container
            echo '</div>'; // Close lesson-card
        }
    } else {
        echo "No lessons found for this course.";
    }

    ?>
    </body>
    </html>
    <?php

} else {
    echo "Invalid course ID.";
}

// Close database connection
mysqli_close($conn);
?>
