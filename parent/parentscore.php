<?php
include 'check_login.php';
?>
<!-- to remove warnings      godddddddddodododoodododogood-->
<?php
// Suppress warnings and notices
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);

// Your PHP code here
?><?php
session_start();

// Database Connection
$conn = mysqli_connect("localhost", "root", "", "messaging_system");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if user is logged in
if (!isset($_SESSION['parent_id'])) {
    // Handle accordingly if user is not logged in
    echo "User is not logged in.";
    exit(); // Stop further execution
}

// Fetch lessons for the logged-in user
$user_id = $_SESSION['parent_id'];

// Query to fetch lessons for the logged-in user including course name and student name, ordered by student name
$sql = "SELECT DISTINCT student.name AS student_name, 
               lessons.lesson_name, 
               courses.name AS course_name, 
               gamescore.score, 
               lessons.max_score,
               gamescore.timestamp 
        FROM gamescore 
        INNER JOIN relation ON gamescore.student_id = relation.student_id  
        INNER JOIN lessons ON gamescore.lesson_id = lessons.id
        INNER JOIN courses ON gamescore.course_id = courses.id
        INNER JOIN student ON relation.student_id = student.student_id
        WHERE relation.parent_id = ?
        ORDER BY student_name";

// Prepare the statement
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error in SQL query: " . $conn->error);
}

// Bind the parameter
$stmt->bind_param("s", $user_id);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Lessons</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h2 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Lessons Participated In:</h2>

    <table>
        <tr>
            <th>Student Name</th>
            <th>Lesson Name</th>
            <th>Course Name</th>
            <th>Score</th>
            <th>MAXscore</th>
            <th>Timestamp</th>
        </tr>
        <?php
        // Check if there are any results
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["student_name"] . "</td>";
                echo "<td>" . $row["lesson_name"] . "</td>";
                echo "<td>" . $row["course_name"] . "</td>";
                echo "<td>" . $row["score"] . "</td>"; 
                echo "<td>" . $row["max_score"] . "</td>";
                echo "<td>" . $row["timestamp"] . "</td>";
                echo "</tr>";
            }
        } else {
            // No lessons participated in yet
            echo "<tr><td colspan='5'>No lessons participated in yet.</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>

<?php
// Close the statement and database connection
$stmt->close();
$conn->close();
?>
