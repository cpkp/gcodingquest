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
    <title>Teacher Details</title>
    <style>
        /* styles.css */
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

        .action-button {
            padding: 5px 10px;
            cursor: pointer;
        }

        .red-button {
            background-color: #ff4d4d;
            color: white;
        }

        .green-button {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Teacher Details</h1>
        <table>
            <tr>
                <th>Teacher ID</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
            <?php
            session_start(); // Start session if not already started

            // Database connection
            $conn = mysqli_connect("localhost", "root", "", "messaging_system");
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Function to fetch teacher details (only teacher ID, name, and action)
            function getTeacherDetails($conn) {
                $sql = "SELECT teacher_id, name, action FROM teacher";
                $result = mysqli_query($conn, $sql);
                $teachers = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $teachers[] = $row;
                }
                return $teachers;
            }

            // Function to update action field in the database
            function updateAction($conn, $teacher_id, $action) {
                $sql = "UPDATE teacher SET action = '$action' WHERE teacher_id = '$teacher_id'";
                if (mysqli_query($conn, $sql)) {
                    return true;
                } else {
                    return false;
                }
            }

            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['teacher_id']) && isset($_GET['action'])) {
                $teacher_id = $_GET['teacher_id'];
                $action = $_GET['action'];
                updateAction($conn, $teacher_id, $action);
                echo '<script>window.location.href = "teacher_details.php";</script>'; // Redirect to refresh the page
            }

            $teachers = getTeacherDetails($conn);
            foreach ($teachers as $teacher) {
                echo "<tr>";
                echo "<td>" . $teacher['teacher_id'] . "</td>";
                echo "<td>" . $teacher['name'] . "</td>";
                echo "<td>";
                echo "<button id='button-{$teacher['teacher_id']}' class='action-button ";
                if ($teacher['action'] == 0) {
                    echo "red-button' data-action='0'>Deactivate";
                } else {
                    echo "green-button' data-action='1'>Activate";
                }
                echo "</button>";
                echo "</td>";
                echo "</tr>";
            }

            // Close database connection
            mysqli_close($conn);
            ?>
        </table>
    </div>
<script>
    document.querySelectorAll('.action-button').forEach(button => {
        button.addEventListener('click', function() {
            const teacherId = this.id.split('-')[1];
            const currentAction = parseInt(this.getAttribute('data-action'));

            var newAction = currentAction === 0 ? 1 : 0; // Toggle the action value

            if (confirm("Are you sure you want to perform this action?")) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if (this.responseText == 'success') {
                            // Toggle button style based on the new action
                            if (newAction === 1) {
                                button.classList.remove('red-button');
                                button.classList.add('green-button');
                                button.textContent = 'Deactivate'; // Change text content to 'Deactivate'
                            } else {
                                button.classList.remove('green-button');
                                button.classList.add('red-button');
                                button.textContent = 'Activate'; // Change text content to 'Activate'
                            }
                            button.setAttribute('data-action', newAction); // Update data-action attribute
                            
                            // Reload the page
                            location.reload();
                        } else {
                            alert('Action update failed. Please try again.');
                        }
                    }
                };
                xhttp.open("GET", "update_action.php?teacher_id=" + teacherId + "&action=" + newAction, true);
                xhttp.send();
            }
        });
    });
</script>

</body>
</html>
