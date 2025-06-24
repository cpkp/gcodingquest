<?php
include 'check_login.php';
?>
<!-- to remove warnings      godddddddddodododoodododogood-->
<?php
// Suppress warnings and notices
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);

// Your PHP code here
?>
<?php
session_start();

// Database Connection
$conn = mysqli_connect("localhost", "root", "", "messaging_system");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to select student_id from gamescore
$sql1 = "SELECT student_id FROM gamescore";
$result1 = $conn->query($sql1);
if (!$result1) {
    echo "No game participations.";
}

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
        ORDER BY course_name";

$result = $conn->query($sql);
if (!$result) {
    die("Error in SQL query: " . $conn->error);
}
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
            background-color: #f7f7f7;
        }
        h2 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
<th>Course Name</th><th>Lesson Name</th>
            <th>Student Name</th>
            
            
            <th>Score</th>
            <th>MAXscore</th>
            <th>Timestamp</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["course_name"] . "</td>";
                 echo "<td>" . $row["lesson_name"] . "</td>";
                echo "<td>" . $row["student_name"] . "</td>";
              
                
                echo "<td>" . $row["score"] . "</td>";
                echo "<td>" . $row["max_score"] . "</td>";
                echo "<td>" . $row["timestamp"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No lessons participated in yet.</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>

<?php
$conn->close();
?>
