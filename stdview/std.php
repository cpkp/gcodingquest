
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
<title>Personalized Greeting</title>
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #1a1a1a;
    color: #fff;
  }
  .container {
    max-width: 800px;
    margin: 50px auto;
    text-align: center;
  }
  h1 {
    font-size: 36px;
    margin-bottom: 30px;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #00aaff;
  }
  .btn {
    display: inline-block;
    padding: 15px 30px;
    margin: 10px;
    background-color: #00aaff;
    color: #fff;
    text-decoration: none;
    border: 2px solid #00aaff;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 18px;
  }
  .btn:hover {
    background-color: transparent;
    color: #00aaff;
  }
</style> 
</head>
<body>

<div class="container">
  <section id="greeting">
    <h1><span id="username">
    <?php
    // Check if username is set in session
    if (isset($_SESSION['student_username'])) {
        echo 'Welcome Student ' . $_SESSION['student_username'] . '!';
    } else {
        echo 'Welcome Guest!'; // Default to 'Guest' if username is not set in session
    }
    ?>
    </span></h1><button onclick="logout()">LOGOUT</button>
  </section>
  <a href="studentprog.php" class="btn">Progress</a>
  <a href="stdgenerate.php" class="btn">C-CODE</a>
  <a href="../stdview/viewall.php" class="btn">Games</a>
  <a href="msgstd.php" class="btn">Message</a>
</div>

</body>
</html>
<!-- fucti logout -->
<script>
// Function to logout
function logout() {
    // Redirect to the logout page
    window.location.href = "logout.php";
}
</script>