<?php
// Database connection
$conn = mysqli_connect("localhost", "username", "password", "database_name"); // Replace with your actual database connection details

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the data from the form
    $formData = $_POST['data'];

    $parent_id = $_SESSION['parent_id']; // or however you get the parent id

    // Fetch student_id based on child_code from the relation table
   
     $selectQuery1 = "SELECT parent_code from parent  where parent_id='$parent_id' ";
   
 $selectQuery = "SELECT student.student_id FROM relation INNER JOIN student ON relation.student_id = student.student_id WHERE relation.child_code = '$formData' ";
    $result = mysqli_query($conn, $selectQuery);
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $student_id = $row['student_id'];
        
        // Insert the data into the relation table
        $insertQuery = "INSERT INTO relation (parent_id, student_id, child_code,parent_code) VALUES ('$parent_id', '$student_id', '$formData','$selectQuery1')";
        if(mysqli_query($conn, $insertQuery)) {
            echo "Data inserted successfully!<br>";
        } else {
            echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn); // Display error message if insertion fails
        }
    } else {
        echo "No matching student found for the provided child code.";
    }
}
 // or however you get the parent id

// Query to fetch data from the database
$selectQuery = "SELECT student.name, student.student_id FROM relation INNER JOIN student ON relation.student_id = student.student_id WHERE relation.parent_id = $parentid";// Adjust the query to match your database structure
$result = mysqli_query($conn, $selectQuery);

// Display the fetched data as a table
if (mysqli_num_rows($result) > 0) {
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