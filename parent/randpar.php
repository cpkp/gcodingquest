<?php
session_start(); // Start session if not already started

// Database Connection
$conn = mysqli_connect("localhost", "root", "", "messaging_system");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Assuming you have a database connection already established

// Generate parent code
$parentCode = generateParentCode();

// Get the parent ID from the session
$parentId = $_SESSION['parent_id']; // Adjust according to how you store the parent ID in the session

// Update parent code for the logged-in parent
$updateQuery = "UPDATE parent SET parent_code = '$parentCode' WHERE parent_id = '$parentId'"; // Modify parent_table, parent_code, and parent_id according to your database schema
if(mysqli_query($conn, $updateQuery)) {
    echo $parentCode; // Echo the updated parent code if update is successful
} else {
    echo "Error: " . $updateQuery . "<br>" . mysqli_error($conn); // Display error message if update fails
}


// Example function to generate parent code
// Adjusted function to generate a unique 10-character parent code
function generateParentCode() {
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
        $checkQuery = "SELECT COUNT(*) as count FROM parent WHERE parent_code = '$code'";
        $result = mysqli_query($conn, $checkQuery);
        $row = mysqli_fetch_assoc($result);
        $codeExists = $row['count'] > 0;
    } while ($codeExists);

    return $code;
}

// Close database connection
mysqli_close($conn);

?>
