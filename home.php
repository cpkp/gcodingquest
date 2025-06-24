
<!-- user validate isnt out -->
<?php
include 'check_login.php';
?>
<!-- to remove warnings      godddddddddodododoodododogood-->
<?php
// Suppress warnings and notices
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);

// Your PHP code here
?>


<?php
// Start the session to access session variables
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website Title</title>
    <link rel="stylesheet" href="styles31.css">
    <style>
        /* Your CSS styles here */
    </style>
</head>
<body>
    <header>
        <h1>Your Website Name</h1>
        <button onclick="logout()">LOGOUT</button>
    </header>

    <nav class="navigation">
        <h2>Navigation</h2>
        <ul>
             <!-- Your navigation items here -->
            <li data-target="dashboard"><a href="progress.php">Dashboard</a></li>
            <li data-target="categories"><a href="coursemang/index.php">Courses</a></li>
            <li data-target="courses"><a href="index1.php">Lessons</a></li>
            <li data-target="students"><a href="showstud.php">Students</a></li>
            <li data-target="parents"><a href="showpart.php">Parents</a></li>
            <li data-target="teachers"><a href="showteach.php">Teachers</a></li>
            <li data-target="enrolment"><a href="adminscoreview.php">Score</a></li>
            <li data-target="message"><a href="messaging.php">Message</a></li>
        </ul>
    </nav>

   
    <footer>
        <p>&copy; 2024 Your Website Name</p>
    </footer>

    <script>
        // JavaScript to handle click events on navigation items
        document.querySelectorAll('.navigation li').forEach(item => {
            item.addEventListener('click', function() {
                // Hide all sections
                document.querySelectorAll('main section').forEach(section => {
                    section.style.display = 'none';
                });
                // Get the target section id from data-target attribute
                const targetId = this.getAttribute('data-target');
                // Display the target section
                document.getElementById(targetId).style.display = 'block';
            });
        });
    </script><script>
// Function to logout
function logout() {
    // Redirect to the logout page
    window.location.href = "logout.php";
}
</script>
</body>
</html>
