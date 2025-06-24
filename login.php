<?php
session_start();
include('db.php'); // Assuming this file contains your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $selectedRole = $_POST['selectedRole'];

    // Validate username and password (You can add your validation logic here)

    // Check if the user is an admin
    if ($selectedRole == "Admin") {
        $check_admin_sql = "SELECT * FROM users WHERE username = '$username'";
        $result_admin = $conn->query($check_admin_sql);
        if ($result_admin->num_rows == 1) {
            $row_admin = $result_admin->fetch_assoc();
            if (password_verify($password, $row_admin['password'])) {
                  $_SESSION['username'] = $username; unset($_SESSION['student_username']);
                unset($_SESSION['student_id']);  unset($_SESSION['parent_username']);
                unset($_SESSION['parent_id']);
                
                  unset($_SESSION['teacher_username']);          
                unset($_SESSION['teacher_id']);
                 
                
                
            $_SESSION['user_id'] = $row_admin['id']; 
                
                // Assuming you have a column named 'id' in your admin table
                header("location: home.php");
                exit();
            } else {
                $_SESSION['error'] = "Incorrect password";
                header("location: index.php"); // Redirect back to login page with error message
                exit();
            }
        } else {
            $_SESSION['error'] = "Username not found";
            header("location: index.php"); // Redirect back to login page with error message
            exit();
        }
    }

    // Check if the user is a student
    if ($selectedRole == "Student") {
        $check_student_sql = "SELECT * FROM student WHERE name = '$username'";
        $result_student = $conn->query($check_student_sql);
        if ($result_student->num_rows == 1) {
            $row_student = $result_student->fetch_assoc();
            if (password_verify($password, $row_student['password'])) {
                $_SESSION['student_username'] = $username;  unset($_SESSION['parent_username']);
                unset($_SESSION['parent_id']);
                 unset($_SESSION['teacher_username']);
                unset($_SESSION['teacher_id']); unset($_SESSION['username']);unset($_SESSION['user_id']);
                $_SESSION['student_id'] = $row_student['student_id']; // Assuming you have a column named 'student_id' in your student table
                header("location:stdview/std.php");
                exit();
            } else {
                $_SESSION['error'] = "Incorrect password";
                header("location: index.php"); // Redirect back to login page with error message
                exit();
            }
        } else {
            $_SESSION['error'] = "Username not found";
            header("location: index.php"); // Redirect back to login page with error message
            exit();
        }
    }

  // Check if the user is a teacher and action field is equal to 1
if ($selectedRole == "Teacher") {
    $check_teacher_sql = "SELECT * FROM teacher WHERE name = '$username' AND action = 1"; // Including action constraint
    $result_teacher = $conn->query($check_teacher_sql);
    if ($result_teacher->num_rows == 1) {
        $row_teacher = $result_teacher->fetch_assoc();
        if (password_verify($password, $row_teacher['password'])) {
            $_SESSION['teacher_username'] = $username; unset($_SESSION['student_username']);
                unset($_SESSION['student_id']);  unset($_SESSION['parent_username']);
                unset($_SESSION['parent_id']); unset($_SESSION['username']);unset($_SESSION['user_id']);
            $_SESSION['teacher_id'] = $row_teacher['teacher_id']; // Assuming you have a column named 'teacher_id' in your teacher table
            header("location: teacher/teach1.php");
            exit();
        } else {
            $_SESSION['error'] = "Incorrect password";
            header("location: index.php"); // Redirect back to login page with error message
            exit();
        }
    } else {
        $_SESSION['error'] = "Username not found or action is not set to 1";
        header("location: index.php"); // Redirect back to login page with error message
        exit();
    }
}

    // Check if the user is a parent
    if ($selectedRole == "Parent") {
        $check_parent_sql = "SELECT * FROM parent WHERE parent_name = '$username'";
        $result_parent = $conn->query($check_parent_sql);
        if ($result_parent->num_rows == 1) {
            $row_parent = $result_parent->fetch_assoc();
            if (password_verify($password, $row_parent['password'])) {
                
                $_SESSION['parent_username'] = $username; unset($_SESSION['student_username']);unset($_SESSION['user_id']);
                unset($_SESSION['student_id']); unset($_SESSION['username']);
                
                 unset($_SESSION['teacher_username']);
                unset($_SESSION['teacher_id']);
                
                
           $_SESSION['parent_id'] = $row_parent['parent_id']; // Assuming you have a column named 'parent_id' in your parent table
                header("location: parent/parnt1.php");
                exit();
            } else {
                $_SESSION['error'] = "Incorrect password";
                header("location: index.php"); // Redirect back to login page with error message
                exit();
            }
        } else {
            $_SESSION['error'] = "Username not found";
            header("location: index.php"); // Redirect back to login page with error message
            exit();
        }
    }
}

$conn->close();
?>
