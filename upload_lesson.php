
<!-- to remove warnings      godddddddddodododoodododogood-->
<?php
// Suppress warnings and notices
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);

// Your PHP code here
?>
<?php
session_start();

$new_thumbnail_name = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username from session
   
  if(isset($_SESSION['teacher_username'])){
        $username = $_SESSION['teacher_username'];
        $useridd = $_SESSION['teacher_id'];
      include 'teacher/check_login.php';
    }
    else if(isset($_SESSION['username'])and isset($_SESSION['user_id'])){
        $username = $_SESSION['username'];
        $useridd = $_SESSION['user_id'];
       include 'check_login.php';
   } 
    
    else  {
        // Handle case if session username is not set (e.g., user not logged in)
        // You can redirect or show an error message
        exit("User not logged in");
    }

    // Connect to the database
    $servername = "localhost";
    $db_username = "root";
    $db_password = ""; // Replace with your actual MySQL password
    $dbname = "messaging_system"; // Update with your database name (replace "")

    // Create connection
    $conn = mysqli_connect($servername, $db_username, $db_password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get form data
    $course_id = $_POST["course"];
    $lesson_name = $_POST["lesson_name"];
    $description = $_POST["description"];
    $max_score = $_POST["max_score"];
    // New field for maximum score
 
    // Define upload directory (replace with your desired location)
    $upload_dir = "lessons/";

    // Define directory to store unzipped files
    $lesson_files_dir = $upload_dir . "lesson_files/";

    // Check if upload directory exists, create it if not
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Check if lesson_files directory exists, create it if not
    if (!is_dir($lesson_files_dir)) {
        mkdir($lesson_files_dir, 0777, true);
    }

    $allowed_extensions = array("zip"); // Only allow zip files

    $errors = []; // Array to store any errors

    // Handle lesson thumbnail upload
    if (isset($_FILES["thumbnail"]["error"]) && $_FILES["thumbnail"]["error"] === UPLOAD_ERR_OK) {
        $thumbnail_name = $_FILES["thumbnail"]["name"];
        $thumbnail_tmp = $_FILES["thumbnail"]["tmp_name"];
        $thumbnail_type = strtolower(pathinfo($thumbnail_name, PATHINFO_EXTENSION));

        // Check file extension for thumbnail
        if (!in_array($thumbnail_type, array("jpg", "jpeg", "png"))) {
            $errors[] = "Error: " . $thumbnail_name . " has an invalid extension for thumbnail. Only JPG, JPEG, and PNG files allowed.";
        } else {
            // Move uploaded thumbnail file to the designated directory
            $new_thumbnail_name = uniqid() . "." . $thumbnail_type;
            if (!move_uploaded_file($thumbnail_tmp, $upload_dir . "thumbimg/" . $new_thumbnail_name)) {
                $errors[] = "Error uploading " . $thumbnail_name . " for thumbnail. Please try again.";
            }
        }
    } else {
        $errors[] = "Error: Please select a file for lesson thumbnail.";
    }

    // Check if a file was uploaded for lesson folder
    if (isset($_FILES["lesson_folder"]["error"]) && $_FILES["lesson_folder"]["error"] === UPLOAD_ERR_OK) {
        $lesson_folder_name = $_FILES["lesson_folder"]["name"];
        $lesson_folder_tmp = $_FILES["lesson_folder"]["tmp_name"];
        $lesson_folder_type = strtolower(pathinfo($lesson_folder_name, PATHINFO_EXTENSION));

        // Check file extension for lesson folder
        if (!in_array($lesson_folder_type, $allowed_extensions)) {
            $errors[] = "Error: " . $lesson_folder_name . " has an invalid extension for lesson folder. Only ZIP files allowed.";
        } else {
            // Create a unique filename to avoid overwrites
            $new_lesson_folder_name = uniqid() . ".zip";

            // Move uploaded lesson folder (ZIP) file to the designated directory
            if (!move_uploaded_file($lesson_folder_tmp, $upload_dir . $new_lesson_folder_name)) {
                $errors[] = "Error uploading " . $lesson_folder_name . " for lesson folder. Please try again.";
            } else {
                // Extract the uploaded zip file
                $zip = new ZipArchive;
                $res = $zip->open($upload_dir . $new_lesson_folder_name);
                if ($res === TRUE) {
                    // Extract to the lesson_files directory
                    $extracted_folder_name = uniqid(); // Generate a unique name for the extracted folder
                    $extracted_folder_path = $lesson_files_dir . $extracted_folder_name . "/";

                    // Create the directory with the unique name
                    mkdir($extracted_folder_path, 0777, true);

                    // Extract the zip file into the newly created directory
                    $zip->extractTo($extracted_folder_path);
                    $zip->close();

                    // If there are no errors, insert lesson data into database
                    if (empty($errors)) {
                        // Insert lesson data into database including creator's name and max score
                       /* $sql_insert = "INSERT INTO lessons (course_id, lesson_name, description, thumbnail, lesson_folder, creator_name, max_score) VALUES ('$course_id', '$lesson_name', '$description', '$new_thumbnail_name', '$extracted_folder_path', '$username', '$max_score')";*/
                        $sql_insert = "INSERT INTO lessons (course_id, lesson_name, description, thumbnail, lesson_folder, creator_name, creator_id, max_score) VALUES ('$course_id', '$lesson_name', '$description', '$new_thumbnail_name', '$extracted_folder_path', '$username', '$useridd', '$max_score')";

                        
                        if (mysqli_query($conn, $sql_insert)) {
                            // Display success message as an alert and go back to previous page
                            echo '<script>alert("Lesson added successfully"); window.history.back();</script>';
                            exit();
                        } else {
                            $errors[] = "Error: " . $sql_insert . "<br>" . mysqli_error($conn);
                        }
                    }
                } else {
                    $errors[] = "Error: Could not extract the uploaded lesson folder ZIP file.";
                }
            }
        }
    } else {
        $errors[] = "Error: Please select a ZIP file for lesson folder.";
    }

    // If there are errors, display them
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }

    // Close database connection
    mysqli_close($conn);
}
?>
