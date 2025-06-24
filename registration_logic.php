<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $selectedRole = $_POST['selectedRole'];

    // Proceed with registration based on the selected role
    if ($selectedRole == "Student") {
        // Generate student code
        $student_code = "std00" . substr(md5(uniqid()), 0, 5);
        $insert_sql = "INSERT INTO student (name, password,student_id) VALUES ('$username', '$password', '$student_code')";
    } elseif ($selectedRole == "Teacher") {
        // Generate teacher code
        $teacher_code = "tch22" . substr(md5(uniqid()), 0, 5);
        $insert_sql = "INSERT INTO teacher (name, password, teacher_id, department, action) VALUES ('$username', '$password', '$teacher_code', 'default_department', 0)";
    } elseif ($selectedRole == "Parent") {
        // Generate parent code
        $parent_code = "par11" . substr(md5(uniqid()), 0, 5);
        $insert_sql = "INSERT INTO parent (parent_name, password, parent_id) VALUES ('$username', '$password', '$parent_code')";
    }

    // Execute the insert query
    if ($conn->query($insert_sql) === TRUE) {
        $_SESSION['message'] = "Registration successful! Please log in.";
        header("location: index.php");
    } else {
        $_SESSION['error'] = "Error: " . $insert_sql . "<br>" . $conn->error;
        header("location: index.php");
    }
}

$conn->close();
?>
