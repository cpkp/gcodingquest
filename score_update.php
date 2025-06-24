<?php
// Retrieve the game score from the POST request
$gameScore = $_POST['game_score'];

// Example: Update the database with the received game score
// Include 'db.php' to establish a database connection
include 'db.php';

// Your database update logic here
// For example:
// $sql = "UPDATE gamescore SET score = $gameScore WHERE ...";
// Execute the SQL query
// $conn->query($sql);

// Close the database connection
// $conn->close();

// Respond to the client (optional)
echo 'Score updated successfully'; // or any other response
?>
