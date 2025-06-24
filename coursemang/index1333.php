<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Lessons</title>
    <link rel="stylesheet" href="styles44.css">
</head>
<body>
    <div class="container">
        <h1>Course Lessons</h1>
        
        <!-- Form to create a new lesson -->
        <h2>Create New Lesson</h2>
        <form action="upload_lesson.php" method="post" enctype="multipart/form-data">
            <label for="course">Select Course:</label><br>
            <select id="course" name="course">
                <?php include 'fetch_courses_options.php'; ?>
            </select><br>
            <label for="lesson_name">Lesson Name:</label><br>
            <input type="text" id="lesson_name" name="lesson_name"><br>
            <label for="description">Description:</label><br>
            <textarea id="description" name="description"></textarea><br>
            <label for="thumbnail">Thumbnail Image:</label><br>
            <input type="file" id="thumbnail" name="thumbnail"><br><br>
            <label for="lesson_folder">Lesson Folder (ZIP):</label><br>
            <input type="file" id="lesson_folder" name="lesson_folder" accept=".zip"><br><br>
            <input type="submit" value="Create Lesson">
        </form>
        
        <!-- Display current lessons -->
        <h2>Current Lessons</h2>
        <div class="lesson-cards">
            <?php include 'fetch_lessons.php'; ?>
        </div>
    </div>
</body>
</html>
