<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messaging System</title>
    <link rel="stylesheet" href="styles33.css">
    <style>
        /* Your CSS styles here */
    </style>
</head>
<body>
<div class="header">
    <h1>Welcome, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?>!</h1>
</div>
<div class="user-selection">
    <form method="post">
        <select name="user_type" onchange="this.form.submit()">
            <option value="admin" <?php if (isset($_POST['user_type']) && $_POST['user_type'] == 'admin') echo 'selected'; ?>>Admin</option>
            <option value="teacher" <?php if (isset($_POST['user_type']) && $_POST['user_type'] == 'teacher') echo 'selected'; ?>>Teacher</option>
            <option value="parent" <?php if (isset($_POST['user_type']) && $_POST['user_type'] == 'parent') echo 'selected'; ?>>Parent</option>
            <option value="student" <?php if (isset($_POST['user_type']) && $_POST['user_type'] == 'student') echo 'selected'; ?>>Student</option>
        </select>
        <?php
        session_start();
        // Database Connection
        $conn = mysqli_connect("localhost", "root", "", "messaging_system");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Fetch usernames based on selected user type
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_type'])) {
            $user_type = $_POST['user_type'];
            $sql_users = "SELECT username FROM $user_type"; // Assuming tables are named as per user types
            $result_users = mysqli_query($conn, $sql_users);
            if ($result_users && mysqli_num_rows($result_users) > 0) {
                echo '<select name="username" onchange="this.form.submit()">';
                echo '<option value="" selected>Select a user</option>';
                while ($row = mysqli_fetch_assoc($result_users)) {
                    $username = $row['username'];
                    if ($username != $_SESSION['username']) { // Exclude current user
                        $selected = ($_SESSION['selected_username'] == $username) ? 'selected' : '';
                        echo "<option value='$username' $selected>$username</option>";
                    }
                }
                echo '</select>';
            }
        }
        ?>
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
                        <?php
                        start
                        // Display chat history
                    <div class="messaging-container">
          <div class="chat-section">
                <div class="chat-history">
                    <div class="messages">
                        <?php
                        if (isset($_SESSION['selected_username']) && !empty($_SESSION['selected_username'])) {
                            $sender_username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
                            $receiver_username = $_SESSION['selected_username'];
                            $sql_messages = "SELECT * FROM messages WHERE (sender_id = '$sender_username' AND receiver_id = '$receiver_username') OR (sender_id = '$receiver_username' AND receiver_id = '$sender_username') ORDER BY timestamp";
                            $result_messages = mysqli_query($conn, $sql_messages);

                            if ($result_messages && mysqli_num_rows($result_messages) > 0) {
                                while ($row = mysqli_fetch_assoc($result_messages)) {
                                    $message_sender = $row['sender_id'];
                                    $message_content = $row['message'];
                                    $message_timestamp = $row['timestamp'];
                                    $is_sender = $message_sender === $_SESSION['username'];
                                    
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
                       
                    </div></div>
                </div>
    </div>
                        // Code to fetch and display chat history with the selected user
                        ?>
                    </div></div>  </div></div></div>
              
        
        <div class="new-message">
            <div class="message-form">
                <form method="post">
                    <textarea name="message" rows="1" cols="40" placeholder="Type your message here"></textarea>
                    <button type="submit" name="send_custom_message">Send</button>
                </form>
            </div>
        </div>
    <?php endif; ?>

<script>
    // Your JavaScript code here
</script>
</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>
