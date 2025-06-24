<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST["name"];
    $description = $_POST["description"];

    // Check if file was uploaded without errors
    if (isset($_FILES["thumbnail"]) && $_FILES["thumbnail"]["error"] == 0) {
        $targetDir = "images/";
        $targetFile = $targetDir . basename($_FILES["thumbnail"]["name"]);

        // Check if file already exists
        if (file_exists($targetFile)) {
            echo "Sorry, file already exists.";
        } else {
            // Move uploaded file to target directory
            if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $targetFile)) {
                echo "The file ". basename( $_FILES["thumbnail"]["name"]). " has been uploaded.";

                // Insert course data into database
                $sql = "INSERT INTO courses (name, description, thumbnail) VALUES ('$name', '$description', '$targetFile')";
                if (mysqli_query($conn, $sql)) {
                    echo "<br>Course created successfully";
                } else {
                    echo "<br>Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "No file uploaded.";
    }
}

// Close database connection
mysqli_close($conn);
?>
