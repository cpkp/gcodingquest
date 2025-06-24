<?php
session_start(); // Start session if not already started

// Database Connection
$conn = mysqli_connect("localhost", "root", "", "messaging_system");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the data from the form
    $formData = $_POST['data'];

    // Get the parent ID from session
    $parent_id = $_SESSION['parent_id'];

    // Fetch parent code
    $selectParentQuery = "SELECT parent_code FROM parent WHERE parent_id='$parent_id'";
    $parentResult = mysqli_query($conn, $selectParentQuery);

    if ($parentResult && mysqli_num_rows($parentResult) > 0) {
        $parentRow = mysqli_fetch_assoc($parentResult);
        $parent_code = $parentRow['parent_code'];

       // Fetch student ID based on child_code from the student table
$selectStudentQuery = "SELECT student_id FROM student WHERE child_code = '$formData'";
$studentResult = mysqli_query($conn, $selectStudentQuery);

if ($studentResult) {
    $studentRow = mysqli_fetch_assoc($studentResult);
    $student_id = $studentRow['student_id'];

    // Check if the combination of parent code and student ID is not already in the relation table
    $checkRelationQuery = "SELECT * FROM relation WHERE parent_id = '$parent_id' AND student_id = '$student_id'";
    $checkResult = mysqli_query($conn, $checkRelationQuery);

    if ($checkResult && mysqli_num_rows($checkResult) == 0) {
        // Insert the data into the relation table
        $insertQuery = "INSERT INTO relation (parent_id, student_id, child_code, parent_code) VALUES ('$parent_id', '$student_id', '$formData', '$parent_code')";
        if (mysqli_query($conn, $insertQuery)) {
            echo "Data inserted successfully!<br>";
        } else {
            echo "Error: " . mysqli_error($conn); // Display error message if insertion fails
        }
    } else {
        echo "This parent code is already connected to the provided student ID.";
    }
} else {
    echo "No matching student found for the provided child code.";
}}}

// Query to fetch data from the database
$selectQuery = "SELECT student.name, student.student_id FROM relation INNER JOIN student ON relation.student_id = student.student_id WHERE relation.parent_id = '$parent_id'"; // Adjust the query to match your database structure
$result = mysqli_query($conn, $selectQuery);

// Display the fetched data as a table
if ($result && mysqli_num_rows($result) > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Main Table Column</th><th>Related Table Column</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['name'] . "</td>"; // Replace "main_table_column" with the column name from the main table
        echo "<td>" . $row['student_id'] . "</td>"; // Replace "column_name" with the column name from the related table
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No data found";
}

// Close database connection
mysqli_close($conn);
?>
