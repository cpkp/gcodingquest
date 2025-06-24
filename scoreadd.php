 <?php
session_start();
include 'db.php'; // Include the database connection file

// Data received from the GET request (assuming passed through the URL)
$lessonID = $_SESSION['lesson_id'] ;
$courseID = $_SESSION['course_id'];
if(isset($_GET['score'])) {
    // Retrieve the score value from the GET request
    $score = $_GET['score'];}
else{  $score=0;}
// Debugging: Print out session variables to check their values
echo "Lesson ID: $lessonID, Course ID: $courseID, Score: $score<br>";

// Check if the session contains student ID
if (isset($_SESSION['student_id'])) {
    $studentID = $_SESSION['student_id'];

    // Debugging: Print out student ID to check its value
    echo "Student ID: $studentID<br>";

     // Check if the student has already played the lesson
    $sql_check = "SELECT * FROM gamescore WHERE lesson_id = $lessonID AND student_id = '$studentID'";
    // Debugging: Print out the SQL query to check its syntax
    echo "SQL Check Query: $sql_check<br>";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        // If the student has played the lesson before, update the score
         $sql_update = "UPDATE gamescore SET score = $score, timestamp = NOW() WHERE lesson_id = $lessonID AND student_id = '$studentID'";
       
        // Debugging: Print out the SQL query to check its syntax
        echo "SQL Update Query: $sql_update<br>";
        if ($conn->query($sql_update) === TRUE) {
            echo "Score updated successfully ";
        } else {
            echo "Error updating score: " . $conn->error;
        }
    } else {
        // If the student hasn't played the lesson before, insert a new score
        $sql_insert = "INSERT INTO gamescore (lesson_id, course_id, score, student_id) VALUES ($lessonID, $courseID, $score, '$studentID')";
        // Debugging: Print out the SQL query to check its syntax
        echo "SQL Insert Query: $sql_insert<br>";
        if ($conn->query($sql_insert) === TRUE) {
            echo "Score added successfully";
        } else {
            echo "Error adding score: " . $conn->error;
        }
    }
} else {
    echo "Error: Student ID not found in session.";
}

$conn->close(); // Close the database connection
?>