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
    <title>Course Catalog</title>
    <link rel="stylesheet" href="styles44.css">
</head>
<body>
    <div class="container">
        <h1>Course Catalog</h1>
        
        <!-- Form to create a new course -->
        <h2>Create New Course</h2>
        <form action="create_course.php" method="post" enctype="multipart/form-data">
            <label for="name">Course Name:</label><br>
            <input type="text" id="name" name="name"><br>
            <label for="description">Description:</label><br>
            <textarea id="description" name="description"></textarea><br>
            <label for="thumbnail">Thumbnail Image:</label><br>
            <input type="file" id="thumbnail" name="thumbnail"><br><br>
            <input type="submit" value="Create Course">
        </form>
        
        <!-- Display current courses -->
        <h2>Current Courses</h2>
        <div class="course-cards">
            <?php include 'fetch_courses.php'; ?>
        </div>
    </div>
</body>
</html>
