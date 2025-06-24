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
session_start(); // Start session if not already started

// Database connection
$conn = mysqli_connect("localhost", "root", "", "messaging_system");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to get total number of lessons
function getTotalLessons($conn) {
    $sql = "SELECT COUNT(*) AS total_lessons FROM lessons";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total_lessons'];
}

// Function to get total number of courses
function getTotalCourses($conn) {
    $sql = "SELECT COUNT(*) AS total_courses FROM courses";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total_courses'];
}

// Function to get total number of game participations
function getTotalGameParticipations($conn) {
   $sql = "SELECT SUM(total_participations) AS total 
        FROM (SELECT COUNT(DISTINCT student_id) AS total_participations 
              FROM gamescore 
              GROUP BY student_id) AS total_participations";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}



function getTotalt($conn) {
   $sql = "SELECT COUNT(*) AS total_t FROM teacher";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total_t'];
}


function getTotals($conn) {
    $sql = "SELECT COUNT(*) AS total_s FROM student";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total_s'];
}



function getTotalp($conn) {
  $sql = "SELECT COUNT(*) AS total_p FROM parent";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total_p'];
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics</title>
    <link rel="stylesheet" href="styles.css">
    <style>
    
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 50px auto;
    text-align: center;
}

.stats {
    display: flex;
    justify-content: space-around;
}

.stat {
    margin-top:10px;
    width: 30%;
    padding: 20px;
    background-color: #f0f0f0;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.stat h2 {
    margin-top: 0;
}

.stat p {
    font-size: 24px;
    margin: 10px 0;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Statistics</h1>
        <div class="box">
            <div class="stat">
                <h2>Total Lessons</h2>
                <p><?php echo getTotalLessons($conn); ?></p>
            </div>
        </div>
        <div class="box">
            <div class="stat">
                <h2>Total Courses</h2>
                <p><?php echo getTotalCourses($conn); ?></p>
            </div>
        </div>
        <div class="box">
            <div class="stat">
                <h2>Total Game Participations</h2>
                <p><?php echo getTotalGameParticipations($conn); ?></p>
            </div>
        </div>
        
         <div class="box">
            <div class="stat">
                <h2>Total Teachers</h2>
                <p><?php echo getTotalt($conn); ?></p>
            </div>
        </div>
        
        
         <div class="box">
            <div class="stat">
                <h2>Total Students</h2>
                <p><?php echo getTotals($conn); ?></p>
            </div>
        </div>
        
        
         <div class="box">
            <div class="stat">
                <h2>Total Parents</h2>
                <p><?php echo getTotalp($conn); ?></p>
            </div>
        </div>
        
        
    </div>
</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>
