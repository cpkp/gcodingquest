<?php
include 'check_login.php';
?>
<!-- to remove warnings      godddddddddodododoodododogood-->
<?php
// Suppress warnings and notices
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);

// Your PHP code here
?><?php
session_start(); // Start session if not already started

// Database connection
$conn = mysqli_connect("localhost", "root", "", "messaging_system");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to fetch student details (only student ID and name)
function getStudentDetails($conn) {
    $sql = "SELECT parent_id,parent_name FROM parent ";
    $result = mysqli_query($conn, $sql);
    $students = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $students[] = $row;
    }
    return $students;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
  <style>
    
    
    /* styles.css */

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

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 8px;
    border: 1px solid #ddd;
}

th {
    background-color: #f2f2f2;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #ddd;
}

    
    </style>
    
</head>
<body>
    <div class="container">
        <h1>Parent Details</h1>
        <table>
            <tr>
                <th>Parent ID</th>
                <th>Name</th>
            </tr>
            <?php
            $students = getStudentDetails($conn);
            foreach ($students as $student) {
                echo "<tr>";
                echo "<td>" . $student['parent_id'] . "</td>";
                echo "<td>" . $student['parent_name'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>
