<?php
include 'check_login.php';
?>
<!-- to remove warnings      godddddddddodododoodododogood-->
<?php
// Suppress warnings and notices
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);

// Your PHP code here
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Code Generator</title>
    <style>
          body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .container {
            text-align: center;
        }
        #randomNumber {
            font-size: 24px;
            padding: 10px 20px;
            margin-bottom: 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        #randomNumber:hover {
            background-color: #0056b3;
        }
        form {
            margin-top: 20px;
        }
        input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        #children {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            max-width: 500px;
            overflow-y: auto;
            height: 200px;
            text-align: left;
        }
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
        <button id="randomNumber">Generate Parent Code</button>
        <!-- Add a div to display the generated parent code -->
        <div id="parentCodeDisplay">
        <?php
session_start(); // Start session if not already started

// Database Connection
$conn = mysqli_connect("localhost", "root", "", "messaging_system");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$parentid = $_SESSION['parent_id']; // Add a semicolon here

// SQL query to fetch data
$sql = "SELECT parent_code FROM parent where parent_id='$parentid'"; // Replace "your_table" with your actual table name
$result = mysqli_query($conn, $sql);

// Check if there are any records
if (mysqli_num_rows($result) > 0) {
    // Loop through each row of data
    while ($row = mysqli_fetch_assoc($result)) {
        // Start a box to display the data
        echo '<div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; border-radius: 5px; background-color: #f9f9f9;">';

        // Display data within the box
        foreach ($row as $key => $value) {
            echo "<p>{$key}: {$value}</p>"; // Displaying column name and value
        }

        // Close the box
        echo '</div>';
    }
} else {
    echo "No data found";
}

// Close database connection
mysqli_close($conn);
?>


        
        </div>
        <!-- Your existing form -->
        <form action="processrela.php" method="POST">
            <input type="text" name="data" placeholder="Enter Data">
            <input type="submit" value="Submit">
        </form>
        <!-- Your existing div to show children -->
        <div id="children">
        
        <?php
 // Start session if not already started

// Database Connection
$conn = mysqli_connect("localhost", "root", "", "messaging_system");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


  
// Query to fetch data from the database
$selectQuery = "SELECT student.name, student.student_id FROM relation INNER JOIN student ON relation.student_id = student.student_id WHERE relation.parent_id = '$parentid'"; // Adjust the query to match your database structure
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

        
        
        </div>
    </div>

    <!-- Your existing JavaScript to handle AJAX request -->
    <script>
var parentCodeSet = false; // Variable to track whether parent code is already set

document.getElementById('randomNumber').addEventListener('click', function() {
    if (parentCodeSet) {
         window.location.reload();
        alert("Parent code already set");
    } else {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'randpar.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    parentCodeSet = true; // Update the variable to indicate that parent code is set
                    // Optionally, you can display the parent code received in the response here
                } else {
                    console.error('Failed to fetch parent code');
                }
            }
        };
        xhr.send();
    }
});


    </script>
</body>
</html>
