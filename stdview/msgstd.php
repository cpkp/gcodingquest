<?php
include 'check_login.php';
?>
<!-- to remove warnings      godddddddddodododoodododogood-->

<!-- CODE REFINE THINGS         
<?php
// Prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>
<script>
window.history.forward();
function noBack() { window.history.forward(); }
</script>

<script>
if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_RELOAD) {
    window.location.href = "logout.php"; // Redirect to logout page
}
</script>


-->
<script>
window.history.forward();
function noBack() { window.history.forward(); }
</script>

<script>
if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_RELOAD) {
    window.location.href = "logout.php"; // Redirect to logout page
}
</script>

<!-- end refine-->

<?php
// Suppress warnings and notices
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);

// Your PHP code here
?>

<?php
session_start(); // Start session if not already started

// Database Connection
$conn = mysqli_connect("localhost", "root", "", "messaging_system");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to set the selected user ID in the session
function setSelectedUser($username) {
    $_SESSION['selected_username'] = $username;
}
 
// Check if a user is selected
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
    $selected_username = $_POST['username'];
    setSelectedUser($selected_username);
}

// Check if a custom message is sent
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send_custom_message'])) {
    if (isset($_SESSION['selected_username']) && !empty($_SESSION['selected_username'])) {
        $sender_username = isset($_SESSION['student_username']) ? $_SESSION['student_username'] : '';
        $receiver_username = $_SESSION['selected_username'];
        $message_content = mysqli_real_escape_string($conn, $_POST['message']);
        
        if (empty($sender_username)) {
            echo "<script>alert('Error: Sender username is missing.');</script>";
        } else {
            $sql_insert_custom_message = "INSERT INTO messages1 (sender_id, receiver_id, message, timestamp) VALUES ('$sender_username', '$receiver_username', '$message_content', NOW())";
            if (mysqli_query($conn, $sql_insert_custom_message)) {
                // Message sent successfully
            } else {
                echo "<script>alert('Error sending message');</script>";
                echo "Error: " . $sql_insert_custom_message . "<br>" . mysqli_error($conn);
            }
        }
    } else {
        echo "<script>alert('Please select a user before sending a message');</script>";
    }
}

// Fetch usernames from the database
$sql_users = "(SELECT name FROM student) UNION (SELECT name FROM teacher)";
$result_users = mysqli_query($conn, $sql_users);
if ($result_users && mysqli_num_rows($result_users) > 0) {
    $_SESSION['usernames'] = array();
    while ($row = mysqli_fetch_assoc($result_users)) {
        $_SESSION['usernames'][] = $row['name'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messaging System</title>
    <link rel="stylesheet" href="styles33.css">
<style>
    
    .mesg{
  overflow-y: scroll; /* Ensure vertical scrolling */
  scroll-behavior:smooth; /* Optional: Enable smooth scrolling */
}

/* Set the scroll position to the bottom by default */
.mesg {
  overflow-y: auto; /* Enable vertical scrollbar */
  scroll-padding-bottom: 1000px; /* Adjust this value based on your content */
}

/* Scroll to the bottom when content is loaded */
.mesg::after {
  content: "";
  display: block;
  height: 0;
  clear: both;
}

    
    .mesg {
   scroll-snap-align:end; 
    background-color: aqua;
     overflow-y: auto; 
    height: calc(100% - 210px);
}
    container {
    scroll-snap-type: end; 
    align-content: center;
    width: 600px;
    height: 400px;
    border-radius: 10px;
    position: relative;
    overflow: hidden;
}
    </style>
    </head>
    
<body>
     <div class="header">
        <h1>Welcome, <?php echo isset($_SESSION['student_username']) ? $_SESSION['student_username'] : 'Guest'; ?>!</h1>
         <button onclick="closeSessionsAndRedirect()">HOME</button>
    </div>
 <div class="user-selection">
            <form method="post">
                <select name="username" onchange="this.form.submit()">
                    <option value="" <?php if (!isset($_SESSION['selected_username']) || empty($_SESSION['selected_username'])) echo 'selected'; ?>>Select a user</option>
                    <?php
                    if (isset($_SESSION['usernames']) && !empty($_SESSION['usernames'])) {
                        foreach ($_SESSION['usernames'] as $username) {
                            if ($username != $_SESSION['username']) { //  Exclude current user
                                $selected = ($_SESSION['selected_username'] == $username) ? 'selected' : '';
                                echo "<option value='$username' $selected>$username</option>";
                            }
                        }
                    }
                    ?>
                </select>
            </form>
        </div>
<div class="container">
    
    
       

        <?php if (isset($_SESSION['selected_username']) && !empty($_SESSION['selected_username'])): ?>
          
                   <div class="selected-user">
                <h2><?php echo isset($_SESSION['selected_username']) ? $_SESSION['selected_username'] : ''; ?></h2>
            </div> 
    <div class="mesg">
       <div class="messaging-container">
          <div class="chat-section">
                <div class="chat-history">
                    <div class="messages">
                        <?php
                        if (isset($_SESSION['selected_username']) && !empty($_SESSION['selected_username'])) {
                            $sender_username = isset($_SESSION['student_username']) ? $_SESSION['student_username'] : '';
                            $receiver_username = $_SESSION['selected_username'];
                            /*$sql_messages = "(SELECT * FROM messages2 WHERE (sender_id = '$sender_username' AND receiver_id = '$receiver_username') OR (sender_id = '$receiver_username' AND receiver_id = '$sender_username') ORDER BY timestamp)UNION(SELECT * FROM messages1 WHERE (sender_id = '$sender_username' AND receiver_id = '$receiver_username') OR (sender_id = '$receiver_username' AND receiver_id = '$sender_username') ORDER BY timestamp)UNION(SELECT * FROM messages3 WHERE (sender_id = '$sender_username' AND receiver_id = '$receiver_username') OR (sender_id = '$receiver_username' AND receiver_id = '$sender_username') ORDER BY timestamp)";*/
                            $sql_messages = "(SELECT * FROM messages2 WHERE (sender_id = '$sender_username' AND receiver_id = '$receiver_username') OR (sender_id = '$receiver_username' AND receiver_id = '$sender_username'))
                UNION
                (SELECT * FROM messages1 WHERE (sender_id = '$sender_username' AND receiver_id = '$receiver_username') OR (sender_id = '$receiver_username' AND receiver_id = '$sender_username'))
                UNION
                (SELECT * FROM messages3 WHERE (sender_id = '$sender_username' AND receiver_id = '$receiver_username') OR (sender_id = '$receiver_username' AND receiver_id = '$sender_username'))
                ORDER BY timestamp DESC";
                            
                            
                            $result_messages = mysqli_query($conn, $sql_messages);

                            if ($result_messages && mysqli_num_rows($result_messages) > 0) {
                                while ($row = mysqli_fetch_assoc($result_messages)) {
                                    $message_sender = $row['sender_id'];
                                    $message_content = $row['message'];
                                    $message_timestamp = $row['timestamp'];
                                    $is_sender = $message_sender === $_SESSION['student_username'];
                                    
                                    echo "<div class='message-box " . ($is_sender ? 'sender' : 'receiver') . "'>";
                                    echo "<span class='message-sender'></span>";
                                    echo "<span class='message-content'>$message_content</span>";
                                    echo "<span class='message-timestamp'>$message_timestamp</span>";
                                    echo "</div>";
                                }
                             } else {
                                echo "<p>No messages yet</p>";
                            }
                        }
                        ?>
                    </div>
                </div>
</div></div></div>
                <div class="new-message">
          
                    <div class="message-form">
                        <form method="post">
                            <textarea name="message" rows="1" cols="40" placeholder="Type your message here"></textarea>
                            <button type="submit" name="send_custom_message">Send</button>
                        </form>
                    </div>
                   
                </div>
            
        <?php endif; ?>
    

    
    </div>



</body><!-- This is an HTML comment outside PHP tags -->
<!-- backkkk dashboard-->
<script>
// Function to close all sessions and redirect
function closeSessionsAndRedirect() {
    // Add code here to close sessions (if applicable)

    // Redirect to the specified file
    window.location.href = "std.php"; // Replace "your_file.html" with the path to your file
}
</script>

<!-- no backkkkkk or reloddddd -->
 
</html>

<?php
// Close database connection
mysqli_close($conn);
?>
