<?php
session_start();

// Check if the user is logged in and has admin access
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../not_allowed.php'); // Redirect to the "not_allowed.php" page outside the "admin" folder
    exit();
}
include('sidebar.php');
// Include your database connection code
require_once('../function/conn.php');

// SQL query to select all student details
$sql = "SELECT 
            `student_id`, 
            `student_number`, 
            `fname`, 
            `lname`, 
            `mname`, 
            `course`, 
            `department`, 
            `year`, 
            `section`
        FROM `student_details`";

// Execute the query
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="table.css">

    <title>All Student Details</title>
</head>

<body>
    <div class="main">
        <h1>All Student Details</h1>
        <div class=button>
            <a href="add.php">Add new student/s</a>
        </div>
        <?php
        // Check if there are results
        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<tr>
                    <th>Student Number</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Middle Name</th>
                    <th>Course</th>
                    <th>Department</th>
                    <th>Year</th>
                    <th>Section</th>
                  </tr>';

            // Fetch and display each row of student details
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['student_number'] . '</td>';
                echo '<td>' . $row['fname'] . '</td>';
                echo '<td>' . $row['lname'] . '</td>';
                echo '<td>' . $row['mname'] . '</td>';
                echo '<td>' . $row['course'] . '</td>';
                echo '<td>' . $row['department'] . '</td>';
                echo '<td>' . $row['year'] . '</td>';
                echo '<td>' . $row['section'] . '</td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo 'No student details found.';
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>

</html>
