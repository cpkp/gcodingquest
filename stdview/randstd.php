<?php
session_start(); // Start session if not already started

// Database Connection
$conn = mysqli_connect("localhost", "root", "", "messaging_system");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Assuming you have a database connection already established

// Generate student code
$studentCode = generatestudentCode();

// Get the student ID from the session
$studentId = $_SESSION['student_id']; // Adjust according to how you store the student ID in the session

// Update student code for the logged-in student
$updateQuery = "UPDATE student SET child_code = '$studentCode' WHERE student_id = '$studentId'"; // Modify parent_table, parent_code, and parent_id according to your database schema
if(mysqli_query($conn, $updateQuery)) {
    echo $studentCode; // Echo the updated student code if update is successful
} else {
    echo "Error: " . $updateQuery . "<br>" . mysqli_error($conn); // Display error message if update fails
}


// Example function to generate student code
// Adjusted function to generate a unique 10-character student code
function generatestudentCode() {
    // Define characters to use for the code
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $codeLength = 10;
    $code = '';

    // Generate code until it is unique
    do {
        // Generate a random code
        $code = '';
        for ($i = 0; $i < $codeLength; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }

        // Check if the generated code already exists in the database
        // Assuming $conn is your database connection
        $checkQuery = "SELECT COUNT(*) as count FROM student WHERE student_code = '$code'";
        $result = mysqli_query($conn, $checkQuery);
        $row = mysqli_fetch_assoc($result);
        $codeExists = $row['count'] > 0;
    } while ($codeExists);

    return $code;
}

// Close database connection
mysqli_close($conn);

?>
