<?php
session_start();

// Check if the necessary parameters are passed in the URL
if(isset($_GET['lesson_id']) && isset($_GET['course_id']) && isset($_GET['lesson_folder'])) {
    // Update session variables with the parameters from the URL
    $_SESSION['lesson_id'] = $_GET['lesson_id'];
    $_SESSION['course_id'] = $_GET['course_id'];
    $_SESSION['lesson_folder'] = urldecode($_GET['lesson_folder']);

    // Check if the file or subfolder parameter is provided
    if(isset($_GET['file'])) {
        // Redirect to the file
        $lesson_folder = $_SESSION['lesson_folder'];
        $file = urldecode($_GET['file']);
        header("Location: $lesson_folder$file");
        exit;
    } elseif(isset($_GET['subfolder'])) {
        // Redirect to the subfolder
        $lesson_folder = $_SESSION['lesson_folder'];
        $subfolder = $_GET['subfolder'];
        header("Location: $lesson_folder$subfolder");
        exit;
    } else {
        // Handle the case when neither file nor subfolder parameter is provided
        echo "Error: File or subfolder parameter is missing.";
    }
} else {
    // Handle the case when lesson_id, course_id, or lesson_folder parameter is missing
    echo "Error: Lesson ID, Course ID, or Lesson folder parameter is missing.";
}
?>
